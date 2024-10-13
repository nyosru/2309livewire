<?php

namespace App\Livewire\Uprav;

use App\Models\Uprav\Backword as BackwordAlias;
use Illuminate\Http\Request;
use Livewire\Component;

class Backword extends Component
{

//    public $loading = false;
    public $names = '';
    public $contact = '';
    public $message = '';

    public $warning = '';

    public function save(Request $r)
    {

//        $this->loading = true;
//        dd($r->all());

        $validated = $this->validate([
            'names' => 'required|min:3',
            'contact' => 'required|min:3',
            'message' => 'required|min:3',
        ]);

//        BackwordAlias::create(
//            $this->only(['name', 'contact','message'])
//        );

        BackwordAlias::create($validated);

//        return $this->redirect('/posts')
//        return $this->redirect('/')
//            ->with('status', 'Post successfully created.')
//            ;

        $this->warning = 'Сообщение отправлено, спасибо';
        $this->names = '';
        $this->contact = '';
        $this->message = '';
//        $this->loading = false;
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
             ...
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.uprav.backword');
    }
}
