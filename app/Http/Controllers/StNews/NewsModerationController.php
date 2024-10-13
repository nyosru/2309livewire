<?php

namespace App\Http\Controllers\StNews;

use App\Http\Controllers\Controller;
use App\Models\StNews;

class NewsModerationController extends Controller
{
    public function index()
    {
        $news = StNews::where('moderation', 'pending')->paginate(10);
        return view('moderation.index', compact('news'));
    }

    public function approve($id)
    {
        $news = StNews::findOrFail($id);
        $news->update(['moderation' => 'approved']);

        return redirect()->back()->with('status', 'Новость одобрена.');
    }

    public function reject($id)
    {
        $news = StNews::findOrFail($id);
        $news->update(['moderation' => 'rejected']);

        return redirect()->back()->with('status', 'Новость отклонена.');
    }
}
