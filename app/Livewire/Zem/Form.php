<?php

namespace App\Livewire\Zem;

use App\Models\zemOrder;
use Illuminate\Http\Request;
use Livewire\Component;
use Nyos\Msg as MsgAlias;

class Form extends Component {

    public $show_form = false;
    public $show_res_ok = false;

    public $polya = [
        'phone' => [
            'name' => 'Телефон',
            'required'=> true,
//            'placeholder' => 'Укажите Ваш телефон',
//            'type' => 'string'
        ],
        'name' => [
            'name' => 'Как Вас зовут',
//            'placeholder' => 'Укажите Ваш телефон',
//            'type' => 'string'
        ],
        'city' => [
            'name' => 'Город',
            'required'=> true,
//            'placeholder' => 'Укажите Ваш телефон',
//            'type' => 'string'
        ],
        'kooperativ' => [
            'name' => 'Название гаражного кооператива',
//            'placeholder' => 'Укажите Ваш телефон',
//            'type' => 'string'
        ],
        'nomer' => [
            'name' => 'Номер гаража(ей)',
            'required'=> true,
//            'placeholder' => 'Укажите Ваш телефон',
            'comment' => 'Можно запускать сразу несколько гаражей на одного владельца, нормально проходит',
//            'type' => 'string'
        ],
        'promo_code' => [
            'name' => 'Промо код',
            'comment' => 'Укажите промо код, если есть',
        ]

    ];

    public $phone = '';
    public $name = '';
    public $city = '';
    public $promo_code = '';
    public $kooperativ = '';
    public $nomer = '';
    public $lich = '';

//    public function changeShow()
//    {
//        $this->show_form = !$this->show_form;
//    }

    public function save(Request $r) {
        zemOrder::create($this->all());
//        dd($this);

        $str = 'заказ на приватизацию гаража' . PHP_EOL;
        foreach($this->polya as $k => $v) {
            if(!empty($this->$k))
                $str .= $k . ' :' . $this->$k . PHP_EOL;
        }

//            'контакт: ' . ($backword->contact ?? 'x') . PHP_EOL .
//            'мсдж: ' . ($backword->message ?? 'x');
//        MsgAlias::sendTelegramm($str, null, 1);

        // serhio на тиньков
        // '5960307100:AAHshaEf6WXw4rKbDg-JCeAyOEsFoHqZmNA' //bot OrderUraBot
        MsgAlias::sendTelegramm($str, 5152088168, null, '5960307100:AAHshaEf6WXw4rKbDg-JCeAyOEsFoHqZmNA');

        $this->show_res_ok = true;
    }

    public function render() {
        return view('livewire.zem.form');
    }

}
