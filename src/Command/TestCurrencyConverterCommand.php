<?php

declare(strict_types=1);

namespace App\Command;

use App\Providers\BinanceProvider;
use App\Providers\MonobankProvider;
use App\Providers\NBUProvider;
use App\Providers\PrivatBankProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test-currency-converter',
    description: 'Add a short description for your command',
)]
class TestCurrencyConverterCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


//        $json = '{"symbol":"BTCUSDT","price":"83168.32000000"}';
//        $binanceProvider = new BinanceProvider();
//        $r = $binanceProvider->makeApiRequest();
//        echo $r . PHP_EOL;

        $json = '[
{ 
"r030":36,"txt":"Австралійський долар","rate":26.2975,"cc":"AUD","exchangedate":"18.03.2025"
 }
,{ 
"r030":124,"txt":"Канадський долар","rate":28.8968,"cc":"CAD","exchangedate":"18.03.2025"
 }
,{ 
"r030":156,"txt":"Юань Женьміньбі","rate":5.7288,"cc":"CNY","exchangedate":"18.03.2025"
 }
,{ 
"r030":203,"txt":"Чеська крона","rate":1.8043,"cc":"CZK","exchangedate":"18.03.2025"
 }
,{ 
"r030":208,"txt":"Данська крона","rate":6.054,"cc":"DKK","exchangedate":"18.03.2025"
 }
,{ 
"r030":344,"txt":"Гонконгівський долар","rate":5.3331,"cc":"HKD","exchangedate":"18.03.2025"
 }
,{ 
"r030":348,"txt":"Форинт","rate":0.113115,"cc":"HUF","exchangedate":"18.03.2025"
 }
,{ 
"r030":356,"txt":"Індійська рупія","rate":0.47743,"cc":"INR","exchangedate":"18.03.2025"
 }
,{ 
"r030":360,"txt":"Рупія","rate":0.0025266,"cc":"IDR","exchangedate":"18.03.2025"
 }
,{ 
"r030":376,"txt":"Новий ізраїльський шекель","rate":11.3555,"cc":"ILS","exchangedate":"18.03.2025"
 }
,{ 
"r030":392,"txt":"Єна","rate":0.2784,"cc":"JPY","exchangedate":"18.03.2025"
 }
,{ 
"r030":398,"txt":"Теньге","rate":0.083117,"cc":"KZT","exchangedate":"18.03.2025"
 }
,{ 
"r030":410,"txt":"Вона","rate":0.028605,"cc":"KRW","exchangedate":"18.03.2025"
 }
,{ 
"r030":484,"txt":"Мексиканське песо","rate":2.0814,"cc":"MXN","exchangedate":"18.03.2025"
 }
,{ 
"r030":498,"txt":"Молдовський лей","rate":2.3086,"cc":"MDL","exchangedate":"18.03.2025"
 }
,{ 
"r030":554,"txt":"Новозеландський долар","rate":23.9769,"cc":"NZD","exchangedate":"18.03.2025"
 }
,{ 
"r030":578,"txt":"Норвезька крона","rate":3.9155,"cc":"NOK","exchangedate":"18.03.2025"
 }
,{ 
"r030":643,"txt":"Російський рубль","rate":0.49328,"cc":"RUB","exchangedate":"18.03.2025"
 }
,{ 
"r030":702,"txt":"Сінгапурський долар","rate":31.1014,"cc":"SGD","exchangedate":"18.03.2025"
 }
,{ 
"r030":710,"txt":"Ренд","rate":2.2829,"cc":"ZAR","exchangedate":"18.03.2025"
 }
,{ 
"r030":752,"txt":"Шведська крона","rate":4.0962,"cc":"SEK","exchangedate":"18.03.2025"
 }
,{ 
"r030":756,"txt":"Швейцарський франк","rate":46.9596,"cc":"CHF","exchangedate":"18.03.2025"
 }
,{ 
"r030":818,"txt":"Єгипетський фунт","rate":0.8204,"cc":"EGP","exchangedate":"18.03.2025"
 }
,{ 
"r030":826,"txt":"Фунт стерлінгів","rate":53.7512,"cc":"GBP","exchangedate":"18.03.2025"
 }
,{ 
"r030":840,"txt":"Долар США","rate":41.4395,"cc":"USD","exchangedate":"18.03.2025"
 }
,{ 
"r030":933,"txt":"Білоруський рубль","rate":15.0623,"cc":"BYN","exchangedate":"18.03.2025"
 }
,{ 
"r030":944,"txt":"Азербайджанський манат","rate":24.3719,"cc":"AZN","exchangedate":"18.03.2025"
 }
,{ 
"r030":946,"txt":"Румунський лей","rate":9.0741,"cc":"RON","exchangedate":"18.03.2025"
 }
,{ 
"r030":949,"txt":"Турецька ліра","rate":1.1303,"cc":"TRY","exchangedate":"18.03.2025"
 }
,{ 
"r030":960,"txt":"СПЗ (спеціальні права запозичення)","rate":55.2292,"cc":"XDR","exchangedate":"18.03.2025"
 }
,{ 
"r030":975,"txt":"Болгарський лев","rate":23.0938,"cc":"BGN","exchangedate":"18.03.2025"
 }
,{ 
"r030":978,"txt":"Євро","rate":45.1649,"cc":"EUR","exchangedate":"18.03.2025"
 }
,{ 
"r030":985,"txt":"Злотий","rate":10.7848,"cc":"PLN","exchangedate":"18.03.2025"
 }
,{ 
"r030":12,"txt":"Алжирський динар","rate":0.30678,"cc":"DZD","exchangedate":"18.03.2025"
 }
,{ 
"r030":50,"txt":"Така","rate":0.3396,"cc":"BDT","exchangedate":"18.03.2025"
 }
,{ 
"r030":51,"txt":"Вірменський драм","rate":0.105329,"cc":"AMD","exchangedate":"18.03.2025"
 }
,{ 
"r030":214,"txt":"Домініканське песо","rate":0.66703,"cc":"DOP","exchangedate":"18.03.2025"
 }
,{ 
"r030":364,"txt":"Іранський ріал","rate":0.00007112,"cc":"IRR","exchangedate":"18.03.2025"
 }
,{ 
"r030":368,"txt":"Іракський динар","rate":0.031627,"cc":"IQD","exchangedate":"18.03.2025"
 }
,{ 
"r030":417,"txt":"Сом","rate":0.47378,"cc":"KGS","exchangedate":"18.03.2025"
 }
,{ 
"r030":422,"txt":"Ліванський фунт","rate":0.00042,"cc":"LBP","exchangedate":"18.03.2025"
 }
,{ 
"r030":434,"txt":"Лівійський динар","rate":8.476,"cc":"LYD","exchangedate":"18.03.2025"
 }
,{ 
"r030":458,"txt":"Малайзійський ринггіт","rate":9.2849,"cc":"MYR","exchangedate":"18.03.2025"
 }
,{ 
"r030":504,"txt":"Марокканський дирхам","rate":4.1619,"cc":"MAD","exchangedate":"18.03.2025"
 }
,{ 
"r030":586,"txt":"Пакистанська рупія","rate":0.1482,"cc":"PKR","exchangedate":"18.03.2025"
 }
,{ 
"r030":682,"txt":"Саудівський ріял","rate":11.0469,"cc":"SAR","exchangedate":"18.03.2025"
 }
,{ 
"r030":704,"txt":"Донг","rate":0.0016211,"cc":"VND","exchangedate":"18.03.2025"
 }
,{ 
"r030":764,"txt":"Бат","rate":1.21254,"cc":"THB","exchangedate":"18.03.2025"
 }
,{ 
"r030":784,"txt":"Дирхам ОАЕ","rate":11.2812,"cc":"AED","exchangedate":"18.03.2025"
 }
,{ 
"r030":788,"txt":"Туніський динар","rate":13.0501,"cc":"TND","exchangedate":"18.03.2025"
 }
,{ 
"r030":860,"txt":"Узбецький сум","rate":0.0032174,"cc":"UZS","exchangedate":"18.03.2025"
 }
,{ 
"r030":901,"txt":"Новий тайванський долар","rate":1.25939,"cc":"TWD","exchangedate":"18.03.2025"
 }
,{ 
"r030":934,"txt":"Туркменський новий манат","rate":11.8375,"cc":"TMT","exchangedate":"18.03.2025"
 }
,{ 
"r030":941,"txt":"Сербський динар","rate":0.36798,"cc":"RSD","exchangedate":"18.03.2025"
 }
,{ 
"r030":972,"txt":"Сомоні","rate":3.7938,"cc":"TJS","exchangedate":"18.03.2025"
 }
,{ 
"r030":981,"txt":"Ларі","rate":14.8366,"cc":"GEL","exchangedate":"18.03.2025"
 }
,{ 
"r030":986,"txt":"Бразильський реал","rate":7.0922,"cc":"BRL","exchangedate":"18.03.2025"
 }
,{ 
"r030":959,"txt":"Золото","rate":123782.27,"cc":"XAU","exchangedate":"18.03.2025"
 }
,{ 
"r030":961,"txt":"Срібло","rate":1390.69,"cc":"XAG","exchangedate":"18.03.2025"
 }
,{ 
"r030":962,"txt":"Платина","rate":41186.3,"cc":"XPT","exchangedate":"18.03.2025"
 }
,{ 
"r030":964,"txt":"Паладій","rate":39937.32,"cc":"XPD","exchangedate":"18.03.2025"
 }
]';
        $nbuProvider = new NBUProvider();
        $r = $nbuProvider->parsingResponse($json);
        var_dump($r);


//        $monobankProvider = new MonobankProvider();
//        $monobankProvider->getPrice();

//        $json = '[{"ccy":"EUR","base_ccy":"UAH","buy":"44.40000","sale":"45.40000"},{"ccy":"USD","base_ccy":"UAH","buy":"41.00000","sale":"41.60000"}]';

//        $rates = json_decode($json, true);
//
//        foreach ($rates as $rate) {
//            echo '-----------------------' . PHP_EOL;
//            echo $rate['ccy'] . PHP_EOL;
//            echo $rate['base_ccy'] . PHP_EOL;
//            echo $rate['buy'] . PHP_EOL;
//            echo $rate['sale'] . PHP_EOL;
//        }

//        $privatBankProvider = new PrivatBankProvider();
//        $r = $privatBankProvider->parsingResponse($json);
//        var_dump($r);

        return Command::SUCCESS;
    }
}
