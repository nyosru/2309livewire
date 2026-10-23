<?php

namespace Tests\Feature\Vkusno;

use App\Models\User;
use App\Models\Vkusno\Administrator;
use App\Models\Vkusno\MenuCategory;
use App\Models\Vkusno\MenuSection;
use App\Models\Vkusno\Order;
use App\Models\Vkusno\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    private string $host = 'http://vkusno.local';

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'vkusno.super_admin_vk_id' => '5903492',
            'services.vk.client_id' => '12345',
            'services.vk.client_secret' => 'test-secret',
        ]);
        foreach ([
            '2014_10_12_000000_create_users_table.php',
            '2025_09_18_131036_add_vk_token_to_user_table.php',
            '2025_09_19_063324_create_permission_tables.php',
            '2026_10_22_000001_create_vkusno_orders_table.php',
            '2026_10_22_000002_create_vkusno_products_table.php',
            '2026_10_22_000003_create_vkusno_menu_catalogs.php',
            '2026_10_22_000004_create_vkusno_administrators_table.php',
            '2026_10_22_000005_create_max_auth_tables.php',
            '2026_10_23_000006_create_application_settings_table.php',
        ] as $file) {
            (require database_path('migrations/'.$file))->up();
        }
        Storage::fake('vkusno');
    }

    private function user(string $vkId): User
    {
        return User::create(['name' => 'VK '.$vkId, 'email' => 'vk-'.$vkId.'@example.test', 'password' => 'test-password', 'vk_id' => $vkId]);
    }

    private function productPayload(array $overrides = []): array
    {
        return array_replace([
            'name' => 'Новая булочка', 'description' => 'Булочка из панели управления',
            'menu_category_id' => MenuCategory::firstOrFail()->id,
            'price' => 125, 'weight' => '1 шт.', 'badge' => 'Новинка',
            'sort_order' => 0, 'is_active' => 1, 'price_is_estimate' => 0,
        ], $overrides);
    }

    private function orderPayload(string $id): array
    {
        return ['name' => 'Клиент', 'phone' => '+7 (912) 123-45-67', 'fulfillment' => 'pickup', 'consent' => true, 'items' => [['id' => $id, 'quantity' => 2, 'price' => 1]]];
    }

    public function test_guests_are_sent_to_vk_login_and_cannot_mutate_catalog(): void
    {
        foreach (['', '/products', '/categories', '/sections', '/access', '/orders'] as $path) {
            $this->get($this->host.'/admin'.$path)->assertRedirect($this->host.'/admin/login');
        }
        $this->get($this->host.'/admin/login')->assertOk()->assertSee('Войти через ВКонтакте');
        $this->post($this->host.'/admin/products', $this->productPayload())->assertRedirect($this->host.'/admin/login');
        $this->assertDatabaseMissing('vkusno_products', ['name' => 'Новая булочка']);
    }

    public function test_unapproved_vk_accounts_and_legacy_admin_email_have_no_access(): void
    {
        $user = $this->user('111111');
        $user->update(['email' => '1@php-cat.com']);
        $this->actingAs($user);
        foreach (['/products', '/categories', '/sections', '/access', '/orders'] as $path) {
            $this->get($this->host.'/admin'.$path)->assertForbidden();
        }
        $this->post($this->host.'/admin/access', ['vk_id' => '111111'])->assertForbidden();
        $this->assertSame(0, Administrator::count());
        config(['vkusno.super_admin_vk_id' => '']);
        $this->get($this->host.'/admin/products')->assertForbidden();
    }

    public function test_super_admin_can_grant_and_revoke_access_but_delegates_cannot(): void
    {
        $super = $this->user('5903492');
        $delegate = $this->user('222222');
        $this->actingAs($super)->get($this->host.'/admin/access')->assertOk()->assertSee('5903492');
        $this->post($this->host.'/admin/access', ['vk_id' => '222222', 'name' => 'Менеджер'])->assertRedirect('/admin/access');
        $administrator = Administrator::firstOrFail();
        $this->assertSame('5903492', $administrator->granted_by_vk_id);
        $this->actingAs($delegate)->get($this->host.'/admin/products')->assertOk()->assertDontSee('href="/admin/access"', false);
        $this->get($this->host.'/admin/orders')->assertOk();
        $this->get($this->host.'/admin/access')->assertForbidden();
        $this->post($this->host.'/admin/access', ['vk_id' => '333333'])->assertForbidden();
        $this->delete($this->host.'/admin/access/'.$administrator->id)->assertForbidden();
        $this->assertSame(1, Administrator::count());
        $this->actingAs($super)->delete($this->host.'/admin/access/'.$administrator->id)->assertRedirect('/admin/access');
        $this->actingAs($delegate)->get($this->host.'/admin/products')->assertForbidden();
        $this->get($this->host.'/admin/orders')->assertForbidden();
    }

    public function test_access_validation_rejects_duplicates_and_super_admin_entry(): void
    {
        $this->actingAs($this->user('5903492'));
        foreach (['5903492', 'https://vk.com/id123', '-123', '000123', 'abc'] as $id) {
            $this->post($this->host.'/admin/access', ['vk_id' => $id])->assertSessionHasErrors('vk_id');
        }
        $this->post($this->host.'/admin/access', ['vk_id' => '222222'])->assertSessionHasNoErrors();
        $this->post($this->host.'/admin/access', ['vk_id' => '222222'])->assertSessionHasErrors('vk_id');
        $this->assertSame(1, Administrator::count());
    }

    public function test_global_permissions_cannot_bypass_vk_administrator_list(): void
    {
        $user = $this->user('444444');
        foreach (['manage-vkusno', 'manage-vkusno-access', 'Полный//доступ'] as $name) {
            $user->givePermissionTo(\Spatie\Permission\Models\Permission::create(['name' => $name, 'guard_name' => 'web']));
        }
        $this->actingAs($user)->get($this->host.'/admin/products')->assertForbidden();
        $this->post($this->host.'/admin/access', ['vk_id' => '555555'])->assertForbidden();
        Administrator::create(['vk_id' => '444444', 'granted_by_vk_id' => '5903492']);
        $this->get($this->host.'/admin/products')->assertOk()->assertDontSee('href="/admin/access"', false);
        $this->post($this->host.'/admin/access', ['vk_id' => '555555'])->assertForbidden();
        $this->assertDatabaseMissing('vkusno_administrators', ['vk_id' => '555555']);
    }

    public function test_product_create_update_upload_delete_and_historical_order(): void
    {
        $this->actingAs($this->user('5903492'));
        $this->get($this->host.'/admin/products/create')->assertOk()->assertSee('Фотография товара');
        $this->post($this->host.'/admin/products', $this->productPayload(['photo' => UploadedFile::fake()->image('bun.jpg')]))
            ->assertSessionHasNoErrors()->assertRedirect('/admin/products');
        $product = Product::where('name', 'Новая булочка')->firstOrFail();
        Storage::disk('vkusno')->assertExists(basename($product->image));
        $this->get($this->host.'/admin/products/'.$product->id.'/edit')->assertOk()->assertSee('Новая булочка');
        $this->get($this->host.'/')->assertOk()->assertSee('Новая булочка');
        $this->postJson($this->host.'/orders', $this->orderPayload($product->id))->assertCreated();
        $order = Order::firstOrFail();
        $this->assertSame(250, $order->subtotal);
        $this->put($this->host.'/admin/products/'.$product->id, $this->productPayload(['name' => 'Булочка обновлённая', 'price' => 200, 'is_active' => 0]))
            ->assertSessionHasNoErrors()->assertRedirect('/admin/products');
        $this->get($this->host.'/')->assertOk()->assertDontSee('Булочка обновлённая');
        $this->postJson($this->host.'/orders', $this->orderPayload($product->id))->assertUnprocessable();
        $this->delete($this->host.'/admin/products/'.$product->id)->assertRedirect('/admin/products');
        $this->assertSame('Новая булочка', $order->fresh()->items[0]['name']);
        $this->assertSame(125, $order->fresh()->items[0]['price']);
    }

    public function test_invalid_product_fields_and_svg_upload_are_rejected(): void
    {
        $this->actingAs($this->user('5903492'));
        $this->post($this->host.'/admin/products', $this->productPayload([
            'price' => -1, 'menu_category_id' => 999999,
            'photo' => UploadedFile::fake()->createWithContent('bad.svg', '<svg xmlns="http://www.w3.org/2000/svg"></svg>'),
        ]))->assertSessionHasErrors(['price', 'menu_category_id', 'photo']);
        $this->assertDatabaseMissing('vkusno_products', ['name' => 'Новая булочка']);
        $this->assertSame([], Storage::disk('vkusno')->allFiles());
    }

    public function test_section_category_crud_and_visibility_control_the_public_menu(): void
    {
        $this->actingAs($this->user('5903492'));
        $this->post($this->host.'/admin/sections', ['title' => 'Сезонное меню', 'sort_order' => 1, 'is_active' => 1])->assertSessionHasNoErrors();
        $section = MenuSection::where('title', 'Сезонное меню')->firstOrFail();
        $this->post($this->host.'/admin/categories', ['name' => 'Осенние блюда', 'section_id' => $section->id, 'sort_order' => 1, 'is_active' => 1])->assertSessionHasNoErrors();
        $category = MenuCategory::where('name', 'Осенние блюда')->firstOrFail();
        $product = Product::findOrFail('pasta');
        $this->put($this->host.'/admin/products/'.$product->id, $this->productPayload(['name' => 'Осенняя паста', 'menu_category_id' => $category->id]))->assertSessionHasNoErrors();
        $this->get($this->host.'/')->assertOk()->assertSee('Сезонное меню')->assertSee('Осенние блюда')->assertSee('Осенняя паста');
        $this->put($this->host.'/admin/categories/'.$category->id, ['name' => 'Обеды осенью', 'section_id' => $section->id, 'sort_order' => 0, 'is_active' => 0])->assertSessionHasNoErrors();
        $this->get($this->host.'/')->assertOk()->assertDontSee('Осенняя паста')->assertDontSee('Обеды осенью');
        $this->postJson($this->host.'/orders', $this->orderPayload($product->id))->assertUnprocessable();
        $this->put($this->host.'/admin/categories/'.$category->id, ['name' => 'Обеды осенью', 'section_id' => $section->id, 'sort_order' => 0, 'is_active' => 1])->assertSessionHasNoErrors();
        $this->get($this->host.'/')->assertOk()->assertSee('Обеды осенью')->assertSee('Осенняя паста');
        $this->put($this->host.'/admin/sections/'.$section->id, ['title' => 'Сезонное меню', 'sort_order' => 1, 'is_active' => 0])->assertSessionHasNoErrors();
        $this->get($this->host.'/')->assertOk()->assertDontSee('Сезонное меню')->assertDontSee('Осенняя паста');
        $this->postJson($this->host.'/orders', $this->orderPayload($product->id))->assertUnprocessable();
        $this->get($this->host.'/admin/sections')->assertOk();
        $this->get($this->host.'/admin/categories')->assertOk();
        $this->delete($this->host.'/admin/categories/'.$category->id)->assertSessionHasErrors('category');
        $this->delete($this->host.'/admin/sections/'.$section->id)->assertSessionHasErrors('section');
        $this->delete($this->host.'/admin/products/'.$product->id)->assertRedirect('/admin/products');
        $this->delete($this->host.'/admin/categories/'.$category->id)->assertSessionHasNoErrors();
        $this->delete($this->host.'/admin/sections/'.$section->id)->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('vkusno_menu_sections', ['id' => $section->id]);
    }

    public function test_long_catalog_names_fit_existing_product_identifiers(): void
    {
        $this->actingAs($this->user('5903492'));
        $title = str_repeat('Название раздела ', 10);
        $this->post($this->host.'/admin/sections', ['title' => trim($title), 'sort_order' => 0, 'is_active' => 1])->assertSessionHasNoErrors();
        $section = MenuSection::where('title', trim($title))->firstOrFail();
        $this->assertLessThanOrEqual(30, strlen($section->id));
        $name = str_repeat('Категория блюда ', 10);
        $this->post($this->host.'/admin/categories', ['name' => trim($name), 'section_id' => $section->id, 'sort_order' => 0, 'is_active' => 1])->assertSessionHasNoErrors();
        $category = MenuCategory::where('name', trim($name))->firstOrFail();
        $this->assertLessThanOrEqual(50, strlen($category->slug));
    }

    public function test_oauth_reuses_existing_vk_login_and_returns_to_admin(): void
    {
        $super = $this->user('5903492');
        $response = $this->get($this->host.'/admin/auth/vk');
        parse_str(parse_url($response->headers->get('Location'), PHP_URL_QUERY), $query);
        $this->assertSame('12345', $query['client_id']);
        $this->assertSame($this->host.'/admin/auth/vk/callback', $query['redirect_uri']);
        $this->assertSame(session('vk_oauth_state'), $query['state']);
        Http::fake([
            'oauth.vk.com/access_token' => Http::response(['access_token' => 'fake-token', 'user_id' => 5903492]),
            'api.vk.com/method/users.get*' => Http::response(['response' => [['id' => 5903492, 'first_name' => 'Админ', 'last_name' => 'VK']]]),
        ]);
        $this->get($this->host.'/admin/auth/vk/callback?'.http_build_query(['code' => 'test-code', 'state' => $query['state']]))->assertRedirect('/admin');
        $this->assertAuthenticatedAs($super);
        $this->assertSame('fake-token', $super->fresh()->vk_token);
        $this->assertNull(session('vk_oauth_state'));
        Http::assertSent(fn ($request) => $request->url() === 'https://oauth.vk.com/access_token' && $request['redirect_uri'] === $this->host.'/admin/auth/vk/callback');
        $this->post($this->host.'/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    public function test_oauth_rejects_invalid_state_without_contacting_vk(): void
    {
        Http::fake();
        $this->withSession(['vk_oauth_state' => 'correct-state'])->get($this->host.'/admin/auth/vk/callback?code=bad&state=wrong')
            ->assertRedirect('/admin/login')->assertSessionHas('error');
        $this->assertGuest();
        Http::assertNothingSent();
    }
}
