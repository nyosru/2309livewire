<?php

namespace App\Http\Controllers\StNews;

use App\Http\Controllers\Controller;
use App\Models\NewsStorageNews;

class NewsModerationController extends Controller
{
    public function index()
    {
        $news = NewsStorageNews::stn()->where('moderation_required', true)->whereNull('moderation')->paginate(10);

        return view('moderation.index', compact('news'));
    }

    public function approve($id)
    {
        $news = NewsStorageNews::resolveLegacyOrCurrent($id);
        $news->update(['moderation' => 'approved']);

        return redirect()->back()->with('status', 'Новость одобрена.');
    }

    public function reject($id)
    {
        $news = NewsStorageNews::resolveLegacyOrCurrent($id);
        $news->update(['moderation' => 'rejected']);

        return redirect()->back()->with('status', 'Новость отклонена.');
    }
}
