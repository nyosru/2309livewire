<?php

namespace App\Livewire\Phpcat;

use App\Models\VkFileHistory;
use Livewire\Component;
use Livewire\WithPagination;

class Files extends Component
{

    use WithPagination;

    public $count = 0;
    public $results = [];
    #[Url]
    public $filterBig = 0;
//    #[Url(as:'search',keep: true,history: true)]
    #[Url(history: true)]
    public $searchTxt = '';

    public function refresh()
    {
        $this->getSearch($this->searchTxt);
    }

    public function getSearch($str, $count = 120, $offset = 0)
    {
        $res2 = \http_build_query(//'https://api.vk.com/method/docs.search',
            [
                'q' => $str,
                'count' => $count,
                'offset' => $offset,
                'access_token' => "bffa2309366c61386640da74e3eeb489acae5ee7dc815bb832f49caae67956d6e5920f0c15605e8464830",
                'v' => '5.154']);

        $res = file_get_contents('https://api.vk.com/method/docs.search?' . $res2);
//        $res70 = json_decode($res, true);
        $res70 = json_decode($res);
//        dd($res70);

        try {
            $in = [];
            foreach ($res70->response->items as $ii) {
                $f = [
                    'vk_id' => $ii->id,
                    'vk_owner_id' => $ii->owner_id,
                    'title' => $ii->title,
                    'ext' => $ii->ext,
                    'url' => $ii->url,
                    'size' => $ii->size,
                    'json' => json_encode($ii)];
                $in[] = $f;
            }
            VkFileHistory::insert($in);
        } catch (\Exception $ex) {
        }

        return $res70;

    }

    public function getFullResult()
    {

        $searchNow = $this->searchTxt;
//        $res = [];
        $this->results =
        $res = $this->getSearch($searchNow);
        if ($res->response->count > 360) {
            $res2 = $this->getSearch($searchNow, 120, 120);
            $res3 = $this->getSearch($searchNow, 120, 240);
            $res4 = $this->getSearch($searchNow, 120, 360);
            $res = array_merge($res->response->items, $res2->response->items, $res3->response->items, $res4->response->items);
        } else if ($res->response->count > 240) {
            $res2 = $this->getSearch($searchNow, 120, 120);
            $res3 = $this->getSearch($searchNow, 120, 240);
            $res = array_merge($res->response->items, $res2->response->items, $res3->response->items);
        } elseif ($res->response->count > 120) {
            $res2 = $this->getSearch($searchNow, 120, 120);
            $res = array_merge($res->response->items, $res2->response->items);
        } else {
            $res = $res->response->items;
        }

        $col = collect($res);

        return $this->filterCollection($col);

    }

    public function filterCollection($collection)
    {
        if ($this->filterBig > 0) {
            $filtered = $collection->filter(function ($value, $key) {
                return $value->size > $this->filterBig * 1024 * 1024;
            });
            return $filtered->all();
        }

        return $collection;
    }

    public function render()
    {
//        $res = [];
//        $res = $this->getSearch($this->search);
//        $res2 = collect()

        if (!empty($this->searchTxt))
            $resShow = $this->getFullResult($this->searchTxt);//->paginate(50)

        return view('livewire.phpcat.files',
            [
//                'search2' => $this->search,
//                'resultsSearch' => $res
//                'resultsSearch' => $this->getSearch($this->search)
                'resultsSearch' => $resShow ?? [],
//                'searchTxt2' => $this->searchTxt
            ]
        );
    }
}
