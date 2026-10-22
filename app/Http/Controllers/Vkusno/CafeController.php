<?php

namespace App\Http\Controllers\Vkusno;

use App\Http\Controllers\Controller;
use App\Models\Vkusno\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CafeController extends Controller
{
    public function index()
    {
        return view('vkusno.index', [
            'cafe' => config('vkusno'),
            'frontend' => [
                'products' => config('vkusno.products'),
                'fillings' => config('vkusno.fillings'),
                'today' => now(config('vkusno.timezone'))->toDateString(),
                'cakeDate' => now(config('vkusno.timezone'))->addDays(config('vkusno.cake_lead_days'))->toDateString(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^(?=(?:\D*\d){10,15}\D*$)\+?[\d\s()\-]{10,30}$/'],
            'fulfillment' => ['required', Rule::in(['delivery', 'pickup'])],
            'address' => ['nullable', 'required_if:fulfillment,delivery', 'string', 'max:500'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'requested_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:'.now(config('vkusno.timezone'))->toDateString()],
            'consent' => ['accepted'],
            'items' => ['present', 'array', 'max:30'],
            'items.*.id' => ['required', 'string', Rule::in(array_column(config('vkusno.products'), 'id')), 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:30'],
            'cake' => ['nullable', 'array'],
            'cake.filling' => ['required_with:cake', Rule::in(config('vkusno.fillings'))],
            'cake.weight' => ['required_with:cake', 'numeric', 'min:1', 'max:15'],
            'cake.design' => ['nullable', 'string', 'max:2000'],
        ]);

        if (empty($data['items']) && empty($data['cake'])) {
            throw ValidationException::withMessages(['items' => 'Добавьте блюдо в корзину или выберите торт.']);
        }
        if (! empty($data['cake']) && (empty($data['requested_date']) || $data['requested_date'] < now(config('vkusno.timezone'))->addDays(config('vkusno.cake_lead_days'))->toDateString())) {
            throw ValidationException::withMessages(['requested_date' => 'Торт нужно заказать минимум за '.config('vkusno.cake_lead_days').' дня.']);
        }

        $catalog = collect(config('vkusno.products'))->keyBy('id');
        $items = collect($data['items'])->map(function ($item) use ($catalog) {
            $product = $catalog[$item['id']];

            return ['id' => $product['id'], 'name' => $product['name'], 'price' => $product['price'], 'quantity' => $item['quantity']];
        })->all();
        $order = Order::create([
            'reference' => (string) Str::uuid(),
            'name' => $data['name'], 'phone' => $data['phone'],
            'fulfillment' => $data['fulfillment'],
            'address' => $data['fulfillment'] === 'delivery' ? $data['address'] : null,
            'requested_date' => $data['requested_date'] ?? null,
            'comment' => $data['comment'] ?? null,
            'items' => $items,
            'cake' => isset($data['cake']) ? collect($data['cake'])->only(['filling', 'weight', 'design'])->all() : null,
            'subtotal' => collect($items)->sum(fn ($item) => $item['price'] * $item['quantity']),
            'delivery_fee' => $data['fulfillment'] === 'pickup' ? 0 : config('vkusno.delivery_fee'),
        ]);

        return response()->json(['reference' => $order->reference, 'message' => 'Заявка сохранена. Дождитесь звонка кафе: состав, время и итоговая стоимость требуют подтверждения.'], 201);
    }

    public function orders()
    {
        return view('vkusno.orders', ['orders' => Order::latest()->paginate(20)]);
    }
}
