<?php

namespace App\Http\Controllers\Hleb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LandingController extends Controller
{
    public function index()
    {
        return view('hleb.index', ['products' => config('hleb.products')]);
    }

    public function store(Request $request)
    {
        if (is_string($request->input('phone'))) {
            $request->merge(['phone' => preg_replace('/[\s()\-]/', '', $request->input('phone'))]);
        }

        $data = $request->validate([
            'type' => ['required', Rule::in(['order', 'franchise'])],
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/'],
            'city' => ['required', 'string', 'max:100'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
            'items' => ['required_if:type,order', 'array', 'max:30'],
            'items.*.id' => ['required', 'distinct', Rule::in(array_column(config('hleb.products'), 'id'))],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);
        $items = [];
        $catalog = collect(config('hleb.products'))->keyBy('id');
        if ($data['type'] === 'order') {
            foreach ($data['items'] as $item) {
                $product = $catalog[$item['id']];
                $items[] = ['id' => $product['id'], 'name' => $product['name'], 'price' => $product['price'], 'quantity' => $item['quantity']];
            }
        }
        $reference = (string) Str::uuid();
        DB::table('hleb_requests')->insert([
            'reference' => $reference, 'type' => $data['type'],
            'contact' => encrypt(json_encode(collect($data)->only(['name', 'phone', 'city', 'comment'])->all(), JSON_UNESCAPED_UNICODE)),
            'items' => json_encode($items, JSON_UNESCAPED_UNICODE),
            'total' => array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $items)),
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return response()->json(['reference' => $reference, 'message' => 'Заявка сохранена. Стоимость, наличие и условия подтвердит пекарня.'], 201);
    }
}
