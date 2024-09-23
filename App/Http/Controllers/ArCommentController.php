<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArCommentResource;
use App\Models\ArComment;
use Illuminate\Http\Request;

class ArCommentController extends Controller
{
    public function index($ar_object_id)
    {
        $comments = ArComment::where('ar_object_id', $ar_object_id)
            ->latest()
            ->paginate(10); // Пагинация на 10 элементов

        return ArCommentResource::collection($comments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        ArComment::create($request->all());

        return redirect()->back()->with('message', 'Комментарий успешно добавлен.');
    }
}
