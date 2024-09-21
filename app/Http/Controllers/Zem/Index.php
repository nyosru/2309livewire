<?php

namespace App\Http\Controllers\Zem;

use App\Http\Controllers\Controller;
use App\Models\Cooperative;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function show(Request $request)
    {
        $in = [
            'cooperatives' => Cooperative::where('is_visible', '=', true)->get()
        ];

        return view('zem.index', $in);
    }
}
