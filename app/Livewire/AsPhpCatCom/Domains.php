<?php

namespace App\Livewire\AsPhpCatCom;

use App\Models\WhoisDomain;
use App\Models\WhoisDomains;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Domains extends Component
{

    public $domains0 = "
* 72rs.ru
* 7ремёсел.рф (xn--7-jtbaydwj1k.xn--p1ai)
* antifretting.ru
* avto-as.ru
* bbb72.ru
* borovskiy-adm.ru
* bu72.ru
* dc72.ru
* dive72.ru
* fartuk72.ru
* fastpres.ru
* fiverooms72.ru
* gantimurov.ru
* grandsever.ru
* km72.ru
* kontrazvedka.bar
* kprf72.ru
* kruto-vse.com
* my-studia.ru
* mymusic72.ru
* nevesomostmag.ru
* nktni.ru
* nogravitymag.ru
* nomtel.com
* nomtel.ru
* nyos.ru
* nyos.tk
* okzona.ru
* orangerai.ru
* paparimskiy-news.ru
* patrum.ru
* php-cat.com
* popovart-studio.ru
* poputimarket.ru
* praskovia72.ru
* prladies.ru
* putin-news.ru
* quicklyweekly.ru
* qw72.ru
* razpizdyais.ru
* razvedka.bar
* rec-time.tv
* region-mmm2011.ru
* religion-news.ru
* rizolin-72.ru
* rizolin-tyumen.ru
* rizolin72.ru
* rozaavantan.ru
* rummmparty.com
* russian-len.webtm.ru
* sale-books.ru
* sambucabar.ru
* seo-this.ru
* sibps72.ru
* simmmka.ru
* sky72.ru
* sms500.ru
* snimok-ok.ru
* snimok.tw1.ru
* soliana.ru
* spaprachka.ru
* sparelax72.ru
* sportrunews.ru
* sprint-oss.ru
* ssem-tm.ru
* ssr72.ru
* ssradar.ru
* sssms.ru
* startrack72.ru
* stomdemetra.ru
* stroy-m72.ru
* sushi-empire.com
* t-o-r.ru
* tabletka72.ru
* talking-roses.ru
* tcfs72.ru
* tefleks.ru
* tehnologiizvuka.ru
* tehnologiya72.ru
* tehopoint.ru
* tgooioz-zabota.ru
* time-mmm.com
* timupimpi.ru
* tmnhost.ru
* torsim.ru
* tortele.com
* tortelecom.com
* tortelecom.ru
* tpr72.ru
* ttt72.ru
* uggru.com
* uralweb.info
* velesmed.ru
* ytc.tw1.ru
* авто-прайс.рф (xn----7sbbg1b1aiild.xn--p1ai)
* автомастерская72.рф (xn--72-6kcaakw4bptzkche7s.xn--p1ai)
* автометрия.рф (xn--80aejmslqmd6k.xn--p1ai)
* автомир72.рф (xn--72-6kci4axnso.xn--p1ai)
* автосалон-гибрид.рф (xn----7sbafcii4abzwjc7ago.xn--p1ai)
* автосалонгибрид.рф (xn--80aadcgh0abxuic4agn.xn--p1ai)
* автосмайлгрупп.рф (xn--80aaff3amepoajglw.xn--p1ai)
* автохит72.рф (xn--72-6kci4a9a1acz.xn--p1ai)
* адвокатскийкабинет72.рф (xn--72-6kcaagepn1acjkbc5ch0dsk.xn--p1ai)
* акниги.рф (xn--80agobhs.xn--p1ai)
* античинуша.рф (xn--80aaxaxc6al7an.xn--p1ai)
* апринт.рф (xn--80aqpgfo.xn--p1ai)
* астория72.рф (xn--72-6kc6a3amfi4j.xn--p1ai)
* асфальттюмень.рф (xn--80aapxfhxkaq4gfw.xn--p1ai)
* атрактор.рф (xn--80aa4aqhdjd.xn--p1ai)
* бабарынка.рф (xn--80aaabb9cuax3h.xn--p1ai)
* базановостроек72.рф (xn--72-6kcadivn4a1alba1aoq.xn--p1ai)
* бакланов.рф (xn--80aabg2bgpi.xn--p1ai)
* банксевернаяказна.рф (xn--80aaaabhubuye4aee3bm8v.xn--p1ai)
* бросервис.рф (xn--90acin1alcge.xn--p1ai)
* бу72.рф (xn--72-9kc6e.xn--p1ai)
* бухучет72.рф (xn--72-9kcq9deapt.xn--p1ai)
* бюрометрологии.рф (xn--90aefnapfpcbqdz7n.xn--p1ai)
* велесмед.рф (xn--b1aecaa8ai3b.xn--p1ai)
* вирус-блокер.рф (xn----btbbomogyogex.xn--p1ai)
* витечка.рф (xn--80adjll0cwb.xn--p1ai)
* витоге.рф (xn--b1acgk4ax.xn--p1ai)
* витюшка.рф (xn--80adsi3bxb3b.xn--p1ai)
* вкуснецово.рф (xn--b1aaitphbtr7a.xn--p1ai)
* газета-1.рф (xn---1-6kcannn3g.xn--p1ai)
* газета1.рф (xn--1-7sbakll2f.xn--p1ai)
* газета2.рф (xn--2-7sbakll2f.xn--p1ai)
* гайдаржи.рф (xn--80aahflmd2d.xn--p1ai)
* гарантийник.рф (xn--80aahwafiuczy.xn--p1ai)
* гипнозэтоя.рф (xn--c1aicufbd1a2hwa.xn--p1ai)
* гипносоюз.рф (xn--c1aicufaes2j.xn--p1ai)
* гск-сибирь.рф (xn----btbevbi0ccc8i.xn--p1ai)
* долга-нет.рф (xn----7sbidi6ard6b.xn--p1ai)
* дуплекс72.рф (xn--72-jlceze1atn.xn--p1ai)
* дядявася.рф (xn--80adfa1e0dbd.xn--p1ai)
* евродент-тюмень.рф (xn----ctbgccb2cgddv2ab7l0a.xn--p1ai)
* единыйсервис72.рф (xn--72-dlchebucg3b9ake7k.xn--p1ai)
* земельныйкадастр.рф (xn--80aalcakqihin5bmo2koa.xn--p1ai)
* зуб32.рф (xn--32-9kcx4d.xn--p1ai)
* кск-партнер.рф (xn----8sbpraumjccq.xn--p1ai)
* маруся72.рф (xn--72-6kc1cvagn1h.xn--p1ai)
* мистер-зеленка.рф (xn----8sbnbakevhes4alo.xn--p1ai)
* мистер-зелёнка.рф (xn----8sbnbjdshdq2akn0t.xn--p1ai)
* мистерзеленка.рф (xn--80ajaaiesgeq2akn.xn--p1ai)
* мистерзелёнка.рф (xn--80ajahdpgdo0ajm4r.xn--p1ai)
* народнаяэкономика.рф (xn--80aaaovlboecchebw6s7a.xn--p1ai)
* номтел.рф (xn--e1ambdfz.xn--p1ai)
* отделка777.рф (xn--777-5cdtg9ahy4b.xn--p1ai)
* открытаяэкономика.рф (xn--80aaxgbbmhfdbtyc8k8a7a.xn--p1ai)
* поддубные.рф (xn--90afaf3bcg9a0e.xn--p1ai)
* порталинфо.рф (xn--80aqijbebjsy.xn--p1ai)
* потолкиконтинент.рф (xn--e1afagbdrbbbaeg7bhe.xn--p1ai)
* продукты72.рф (xn--72-jlcysfhth6f.xn--p1ai)
* ризолин-72.рф (xn---72-yddeburgr.xn--p1ai)
* ризолин-тюмень.рф (xn----jtbedbrjgddt5a7kya.xn--p1ai)
* ризолин72.рф (xn--72-slcdbrpfp.xn--p1ai)
* руфа.рф (xn--80a5aje.xn--p1ai)
* руфина.рф (xn--80appkpg.xn--p1ai)
* ручноймагазин.рф (xn--80aairfbvghcu0b2c.xn--p1ai)
* ручнойсайт.рф (xn--80arbnfkkkc4b.xn--p1ai)
* рынок-автономеров.рф (xn----8sbgao0ardefebcql0a0m.xn--p1ai)
* рэк-тайм.рф (xn----8sb1abntq9f.xn--p1ai)
* сергейсб.рф (xn--90adfbu3bff.xn--p1ai)
* сибирьполитрейд.рф (xn--90agckbain0ajkeew9l.xn--p1ai)
* сип.рф (xn--h1aoe.xn--p1ai)
* смскуб.рф (xn--90arftbn.xn--p1ai)
* снимок-ок.рф (xn----otbgbhejcu.xn--p1ai)
* сноукайтинг.рф (xn--80agoddredzph.xn--p1ai)
* совместнаяэкономика.рф (xn--80aaemqlbldhcfgb9aer4rlb.xn--p1ai)
* социальнаястоматология.рф (xn--80aaamverchihfcb7agrd9d1gvcl.xn--p1ai)
* союзцелитилей.рф (xn--e1aaefahkcv3aq8byg.xn--p1ai)
* спас-миг.рф (xn----7sbkttpnc.xn--p1ai)
* справедливость72.рф (xn--72-6kcialgz0a6admlkp4n.xn--p1ai)
* сравнимцены.рф (xn--80aejluedri0d1c.xn--p1ai)
* столзаказов72.рф (xn--72-6kcak1acwg3ag2an.xn--p1ai)
* стоматология-деметра.рф (xn----7sbbkggauzihpcb1bcrdk8w.xn--p1ai)
* стоматологиядеметра.рф (xn--80aaiefaswhgocb8acqdj6v.xn--p1ai)
* страховочка72.рф (xn--72-6kcaj2c0abojl2b3a.xn--p1ai)
* стройлесбанк.рф (xn--80ablpicrcrjfg.xn--p1ai)
* стройтекс72.рф (xn--72-mlcpgvnhfed.xn--p1ai)
* стройтэкс72.рф (xn--72-ylceslgeed5j.xn--p1ai)
* сухойзакон86.рф (xn--86-6kc1ajivdeywy.xn--p1ai)
* сытаятюмень.рф (xn--80akufqgb3epqj.xn--p1ai)
* сытый-город.рф (xn----ftbdr1aandj3gb.xn--p1ai)
* таблетка72.рф (xn--72-6kcaey9ag4de.xn--p1ai)
* телефония72.рф (xn--72-mlcapqph6ax8j.xn--p1ai)
* теннис72.рф (xn--72-mlcmya3ad.xn--p1ai)
* тефлекс.рф (xn--e1aapc6abp.xn--p1ai)
* технология-интернет.рф (xn----etbfcapburfbeb8aske3b2o.xn--p1ai)
* тортелеком.рф (xn--e1aapchhelqc.xn--p1ai)
* ттт72.рф (xn--72-qmcaa.xn--p1ai)
* тюменьбильярд.рф (xn--90agbnpci1al7hdqv.xn--p1ai)
* тюменьинформмедиа.рф (xn--80ahcaocxcahbm0av9a0j4a.xn--p1ai)
* тюмикс.рф (xn--h1aeewb6e.xn--p1ai)
* фастпрес.рф (xn--80ak3aedddn.xn--p1ai)
* фастпресс.рф (xn--80ak3aeddadp.xn--p1ai)
* холодов.рф (xn--b1adulbb8b.xn--p1ai)
* центр-авторазбора.рф (xn----8sbaaeesu3cndqeete4d.xn--p1ai)
* центравторазбора.рф (xn--80aaaddqr8bldpdesd1d.xn--p1ai)
* честнаяэкономика.рф (xn--80aannjbmfcjb4an1e1e5a.xn--p1ai)
* школьник2020.рф (xn--2020-94dlbgsi2i4b.xn--p1ai)
* шугарингтюмень.рф (xn--80afbinzfdvxe3d5cya.xn--p1ai)
* экономикаприроды.рф (xn--80aikbhbmhibfknb1ora.xn--p1ai)
* электросалон.рф (xn--80ajpcdmecoli2k.xn--p1ai)
";

    public $domains = [];

    public $history_whois = [];

    function __construct()
    {
        // Указываем имя подключения к базе данных
//            $connection = 'sqlite_domains'; // Замените 'mysql' на имя вашего подключения
        // Выполняем запрос с использованием указанного подключения
//            $results = WhoisDB::connection($connection)->select('select * from table_whois_domains GROUP BY domain');
//            $this->history_whois = $results;
        $h = WhoisDomain::groupBy('domain')->get();
        foreach ($h as $hh) {
            $this->history_whois[$hh['domain']] = $hh;
        }

        $e = explode("\n", $this->domains0);
        foreach ($e as $dd) {
            $d = trim(str_replace(['*', ')'], ['', ''], $dd));

            if (strpos($d, '(')) {
                $this->domains[] = explode('(', $d);
            } else {
                $this->domains[] = [$d];
            }
        }
    }

    public function render()
    {
        return view('livewire.as-php-cat-com.domains');
    }
}
