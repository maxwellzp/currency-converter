<?php

declare(strict_types=1);

namespace App\Tests\Unit\Providers;

class ProviderResponse
{
    public const BINANCE = '{"symbol":"BTCUSDT","price":"83168.32000000"}';
    public const PRIVATBANK = '[
   {
      "ccy":"EUR",
      "base_ccy":"UAH",
      "buy":"44.40000",
      "sale":"45.40000"
   },
   {
      "ccy":"USD",
      "base_ccy":"UAH",
      "buy":"41.00000",
      "sale":"41.60000"
   }
]';
    public const MONOBANK = '[
   {
      "currencyCodeA":840,
      "currencyCodeB":980,
      "date":1742421673,
      "rateBuy":41.33,
      "rateSell":41.8305
   },
   {
      "currencyCodeA":978,
      "currencyCodeB":980,
      "date":1742457373,
      "rateBuy":44.95,
      "rateSell":45.6496
   },
   {
      "currencyCodeA":978,
      "currencyCodeB":840,
      "date":1742457373,
      "rateBuy":1.084,
      "rateSell":1.095
   },
   {
      "currencyCodeA":826,
      "currencyCodeB":980,
      "date":1742460149,
      "rateCross":54.4559
   },
   {
      "currencyCodeA":392,
      "currencyCodeB":980,
      "date":1742459959,
      "rateCross":0.2814
   },
   {
      "currencyCodeA":756,
      "currencyCodeB":980,
      "date":1742460131,
      "rateCross":47.7307
   },
   {
      "currencyCodeA":156,
      "currencyCodeB":980,
      "date":1742460162,
      "rateCross":5.7835
   },
   {
      "currencyCodeA":784,
      "currencyCodeB":980,
      "date":1742460165,
      "rateCross":11.3852
   },
   {
      "currencyCodeA":971,
      "currencyCodeB":980,
      "date":1703852583,
      "rateCross":0.5417
   },
   {
      "currencyCodeA":8,
      "currencyCodeB":980,
      "date":1742460005,
      "rateCross":0.4607
   },
   {
      "currencyCodeA":51,
      "currencyCodeB":980,
      "date":1742459681,
      "rateCross":0.107
   },
   {
      "currencyCodeA":973,
      "currencyCodeB":980,
      "date":1742123451,
      "rateCross":0.0458
   },
   {
      "currencyCodeA":32,
      "currencyCodeB":980,
      "date":1742454043,
      "rateCross":0.0345
   },
   {
      "currencyCodeA":36,
      "currencyCodeB":980,
      "date":1742460057,
      "rateCross":26.644
   },
   {
      "currencyCodeA":944,
      "currencyCodeB":980,
      "date":1742459643,
      "rateCross":24.6333
   },
   {
      "currencyCodeA":50,
      "currencyCodeB":980,
      "date":1742460056,
      "rateCross":0.3457
   },
   {
      "currencyCodeA":975,
      "currencyCodeB":980,
      "date":1742460118,
      "rateCross":23.425
   },
   {
      "currencyCodeA":48,
      "currencyCodeB":980,
      "date":1742459091,
      "rateCross":111.0188
   },
   {
      "currencyCodeA":108,
      "currencyCodeB":980,
      "date":1715679129,
      "rateCross":0.014
   },
   {
      "currencyCodeA":96,
      "currencyCodeB":980,
      "date":1741450081,
      "rateCross":31.3741
   },
   {
      "currencyCodeA":68,
      "currencyCodeB":980,
      "date":1742011771,
      "rateCross":6.0973
   },
   {
      "currencyCodeA":986,
      "currencyCodeB":980,
      "date":1742459333,
      "rateCross":7.4281
   },
   {
      "currencyCodeA":72,
      "currencyCodeB":980,
      "date":1741070695,
      "rateCross":3.0407
   },
   {
      "currencyCodeA":933,
      "currencyCodeB":980,
      "date":1742411752,
      "rateCross":13.6898
   },
   {
      "currencyCodeA":124,
      "currencyCodeB":980,
      "date":1742460152,
      "rateCross":29.2755
   },
   {
      "currencyCodeA":976,
      "currencyCodeB":980,
      "date":1742025280,
      "rateCross":0.0146
   },
   {
      "currencyCodeA":152,
      "currencyCodeB":980,
      "date":1742440660,
      "rateCross":0.0456
   },
   {
      "currencyCodeA":170,
      "currencyCodeB":980,
      "date":1742449485,
      "rateCross":0.0101
   },
   {
      "currencyCodeA":188,
      "currencyCodeB":980,
      "date":1742435004,
      "rateCross":0.0844
   },
   {
      "currencyCodeA":192,
      "currencyCodeB":980,
      "date":1687102850,
      "rateCross":1.5599
   },
   {
      "currencyCodeA":203,
      "currencyCodeB":980,
      "date":1742460166,
      "rateCross":1.8312
   },
   {
      "currencyCodeA":262,
      "currencyCodeB":980,
      "date":1740819204,
      "rateCross":0.2355
   },
   {
      "currencyCodeA":208,
      "currencyCodeB":980,
      "date":1742460041,
      "rateCross":6.1351
   },
   {
      "currencyCodeA":12,
      "currencyCodeB":980,
      "date":1742459778,
      "rateCross":0.3136
   },
   {
      "currencyCodeA":818,
      "currencyCodeB":980,
      "date":1742459967,
      "rateCross":0.8266
   },
   {
      "currencyCodeA":230,
      "currencyCodeB":980,
      "date":1742404176,
      "rateCross":0.3237
   },
   {
      "currencyCodeA":981,
      "currencyCodeB":980,
      "date":1742460153,
      "rateCross":15.2345
   },
   {
      "currencyCodeA":936,
      "currencyCodeB":980,
      "date":1742457884,
      "rateCross":2.7076
   },
   {
      "currencyCodeA":270,
      "currencyCodeB":980,
      "date":1740679974,
      "rateCross":0.5929
   },
   {
      "currencyCodeA":324,
      "currencyCodeB":980,
      "date":1741123006,
      "rateCross":0.0048
   },
   {
      "currencyCodeA":344,
      "currencyCodeB":980,
      "date":1742460143,
      "rateCross":5.3841
   },
   {
      "currencyCodeA":191,
      "currencyCodeB":980,
      "date":1680625280,
      "rateCross":5.4258
   },
   {
      "currencyCodeA":348,
      "currencyCodeB":980,
      "date":1742460166,
      "rateCross":0.1153
   },
   {
      "currencyCodeA":360,
      "currencyCodeB":980,
      "date":1742460159,
      "rateCross":0.0025
   },
   {
      "currencyCodeA":376,
      "currencyCodeB":980,
      "date":1742460125,
      "rateCross":11.4932
   },
   {
      "currencyCodeA":356,
      "currencyCodeB":980,
      "date":1742459744,
      "rateCross":0.4835
   },
   {
      "currencyCodeA":368,
      "currencyCodeB":980,
      "date":1742460034,
      "rateCross":0.0319
   },
   {
      "currencyCodeA":352,
      "currencyCodeB":980,
      "date":1742459880,
      "rateCross":0.3139
   },
   {
      "currencyCodeA":400,
      "currencyCodeB":980,
      "date":1742453994,
      "rateCross":59.0929
   },
   {
      "currencyCodeA":404,
      "currencyCodeB":980,
      "date":1742456296,
      "rateCross":0.3239
   },
   {
      "currencyCodeA":417,
      "currencyCodeB":980,
      "date":1742459439,
      "rateCross":0.4806
   },
   {
      "currencyCodeA":116,
      "currencyCodeB":980,
      "date":1742459741,
      "rateCross":0.0104
   },
   {
      "currencyCodeA":410,
      "currencyCodeB":980,
      "date":1742460008,
      "rateCross":0.0288
   },
   {
      "currencyCodeA":414,
      "currencyCodeB":980,
      "date":1742427182,
      "rateCross":135.907
   },
   {
      "currencyCodeA":398,
      "currencyCodeB":980,
      "date":1742460057,
      "rateCross":0.083
   },
   {
      "currencyCodeA":418,
      "currencyCodeB":980,
      "date":1742397432,
      "rateCross":0.0019
   },
   {
      "currencyCodeA":422,
      "currencyCodeB":980,
      "date":1742289315,
      "rateCross":0.0004
   },
   {
      "currencyCodeA":144,
      "currencyCodeB":980,
      "date":1742459898,
      "rateCross":0.1413
   },
   {
      "currencyCodeA":434,
      "currencyCodeB":980,
      "date":1721290238,
      "rateCross":8.65
   },
   {
      "currencyCodeA":504,
      "currencyCodeB":980,
      "date":1742458560,
      "rateCross":4.3465
   },
   {
      "currencyCodeA":498,
      "currencyCodeB":980,
      "date":1742460165,
      "rateCross":2.3456
   },
   {
      "currencyCodeA":969,
      "currencyCodeB":980,
      "date":1742378925,
      "rateCross":0.0089
   },
   {
      "currencyCodeA":807,
      "currencyCodeB":980,
      "date":1742459999,
      "rateCross":0.7388
   },
   {
      "currencyCodeA":496,
      "currencyCodeB":980,
      "date":1742368615,
      "rateCross":0.012
   },
   {
      "currencyCodeA":480,
      "currencyCodeB":980,
      "date":1742459491,
      "rateCross":0.9254
   },
   {
      "currencyCodeA":454,
      "currencyCodeB":980,
      "date":1742451048,
      "rateCross":0.0243
   },
   {
      "currencyCodeA":484,
      "currencyCodeB":980,
      "date":1742455712,
      "rateCross":2.1027
   },
   {
      "currencyCodeA":458,
      "currencyCodeB":980,
      "date":1742460153,
      "rateCross":9.4519
   },
   {
      "currencyCodeA":943,
      "currencyCodeB":980,
      "date":1742395752,
      "rateCross":0.6611
   },
   {
      "currencyCodeA":516,
      "currencyCodeB":980,
      "date":1742453341,
      "rateCross":2.3187
   },
   {
      "currencyCodeA":566,
      "currencyCodeB":980,
      "date":1742429243,
      "rateCross":0.0269
   },
   {
      "currencyCodeA":558,
      "currencyCodeB":980,
      "date":1742256526,
      "rateCross":1.142
   },
   {
      "currencyCodeA":578,
      "currencyCodeB":980,
      "date":1742460113,
      "rateCross":3.9802
   },
   {
      "currencyCodeA":524,
      "currencyCodeB":980,
      "date":1742460107,
      "rateCross":0.3025
   },
   {
      "currencyCodeA":554,
      "currencyCodeB":980,
      "date":1742455797,
      "rateCross":24.3668
   },
   {
      "currencyCodeA":512,
      "currencyCodeB":980,
      "date":1742453324,
      "rateCross":108.6512
   },
   {
      "currencyCodeA":604,
      "currencyCodeB":980,
      "date":1742451031,
      "rateCross":11.5669
   },
   {
      "currencyCodeA":608,
      "currencyCodeB":980,
      "date":1742459897,
      "rateCross":0.7317
   },
   {
      "currencyCodeA":586,
      "currencyCodeB":980,
      "date":1742419367,
      "rateCross":0.1492
   },
   {
      "currencyCodeA":985,
      "currencyCodeB":980,
      "date":1742460168,
      "rateCross":10.9732
   },
   {
      "currencyCodeA":600,
      "currencyCodeB":980,
      "date":1742457430,
      "rateCross":0.0052
   },
   {
      "currencyCodeA":634,
      "currencyCodeB":980,
      "date":1742457051,
      "rateCross":11.5041
   },
   {
      "currencyCodeA":946,
      "currencyCodeB":980,
      "date":1742460168,
      "rateCross":9.225
   },
   {
      "currencyCodeA":941,
      "currencyCodeB":980,
      "date":1742460083,
      "rateCross":0.3884
   },
   {
      "currencyCodeA":682,
      "currencyCodeB":980,
      "date":1742460010,
      "rateCross":11.1598
   },
   {
      "currencyCodeA":690,
      "currencyCodeB":980,
      "date":1742459022,
      "rateCross":2.8742
   },
   {
      "currencyCodeA":938,
      "currencyCodeB":980,
      "date":1680961561,
      "rateCross":0.0627
   },
   {
      "currencyCodeA":752,
      "currencyCodeB":980,
      "date":1742460076,
      "rateCross":4.1715
   },
   {
      "currencyCodeA":702,
      "currencyCodeB":980,
      "date":1742459925,
      "rateCross":31.4677
   },
   {
      "currencyCodeA":694,
      "currencyCodeB":980,
      "date":1664217991,
      "rateCross":0.0024
   },
   {
      "currencyCodeA":706,
      "currencyCodeB":980,
      "date":1683386099,
      "rateCross":0.0659
   },
   {
      "currencyCodeA":968,
      "currencyCodeB":980,
      "date":1719532361,
      "rateCross":1.3118
   },
   {
      "currencyCodeA":748,
      "currencyCodeB":980,
      "date":1706459505,
      "rateCross":2.0391
   },
   {
      "currencyCodeA":764,
      "currencyCodeB":980,
      "date":1742460101,
      "rateCross":1.2465
   },
   {
      "currencyCodeA":972,
      "currencyCodeB":980,
      "date":1742402022,
      "rateCross":3.8298
   },
   {
      "currencyCodeA":788,
      "currencyCodeB":980,
      "date":1742388932,
      "rateCross":13.6069
   },
   {
      "currencyCodeA":949,
      "currencyCodeB":980,
      "date":1742460164,
      "rateCross":1.0839
   },
   {
      "currencyCodeA":901,
      "currencyCodeB":980,
      "date":1742459704,
      "rateCross":1.2667
   },
   {
      "currencyCodeA":834,
      "currencyCodeB":980,
      "date":1742459197,
      "rateCross":0.0159
   },
   {
      "currencyCodeA":800,
      "currencyCodeB":980,
      "date":1742405333,
      "rateCross":0.0114
   },
   {
      "currencyCodeA":858,
      "currencyCodeB":980,
      "date":1742421040,
      "rateCross":0.9899
   },
   {
      "currencyCodeA":860,
      "currencyCodeB":980,
      "date":1742460160,
      "rateCross":0.0032
   },
   {
      "currencyCodeA":704,
      "currencyCodeB":980,
      "date":1742460129,
      "rateCross":0.0016
   },
   {
      "currencyCodeA":950,
      "currencyCodeB":980,
      "date":1742459077,
      "rateCross":0.0698
   },
   {
      "currencyCodeA":952,
      "currencyCodeB":980,
      "date":1742458498,
      "rateCross":0.0698
   },
   {
      "currencyCodeA":886,
      "currencyCodeB":980,
      "date":1702176265,
      "rateCross":0.1496
   },
   {
      "currencyCodeA":710,
      "currencyCodeB":980,
      "date":1742459886,
      "rateCross":2.3187
   }
]';
    public const NBU = '[
   {
      "r030":36,
      "txt":"Австралійський долар",
      "rate":26.2975,
      "cc":"AUD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":124,
      "txt":"Канадський долар",
      "rate":28.8968,
      "cc":"CAD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":156,
      "txt":"Юань Женьміньбі",
      "rate":5.7288,
      "cc":"CNY",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":203,
      "txt":"Чеська крона",
      "rate":1.8043,
      "cc":"CZK",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":208,
      "txt":"Данська крона",
      "rate":6.054,
      "cc":"DKK",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":344,
      "txt":"Гонконгівський долар",
      "rate":5.3331,
      "cc":"HKD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":348,
      "txt":"Форинт",
      "rate":0.113115,
      "cc":"HUF",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":356,
      "txt":"Індійська рупія",
      "rate":0.47743,
      "cc":"INR",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":360,
      "txt":"Рупія",
      "rate":0.0025266,
      "cc":"IDR",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":376,
      "txt":"Новий ізраїльський шекель",
      "rate":11.3555,
      "cc":"ILS",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":392,
      "txt":"Єна",
      "rate":0.2784,
      "cc":"JPY",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":398,
      "txt":"Теньге",
      "rate":0.083117,
      "cc":"KZT",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":410,
      "txt":"Вона",
      "rate":0.028605,
      "cc":"KRW",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":484,
      "txt":"Мексиканське песо",
      "rate":2.0814,
      "cc":"MXN",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":498,
      "txt":"Молдовський лей",
      "rate":2.3086,
      "cc":"MDL",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":554,
      "txt":"Новозеландський долар",
      "rate":23.9769,
      "cc":"NZD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":578,
      "txt":"Норвезька крона",
      "rate":3.9155,
      "cc":"NOK",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":643,
      "txt":"Російський рубль",
      "rate":0.49328,
      "cc":"RUB",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":702,
      "txt":"Сінгапурський долар",
      "rate":31.1014,
      "cc":"SGD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":710,
      "txt":"Ренд",
      "rate":2.2829,
      "cc":"ZAR",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":752,
      "txt":"Шведська крона",
      "rate":4.0962,
      "cc":"SEK",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":756,
      "txt":"Швейцарський франк",
      "rate":46.9596,
      "cc":"CHF",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":818,
      "txt":"Єгипетський фунт",
      "rate":0.8204,
      "cc":"EGP",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":826,
      "txt":"Фунт стерлінгів",
      "rate":53.7512,
      "cc":"GBP",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":840,
      "txt":"Долар США",
      "rate":41.4395,
      "cc":"USD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":933,
      "txt":"Білоруський рубль",
      "rate":15.0623,
      "cc":"BYN",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":944,
      "txt":"Азербайджанський манат",
      "rate":24.3719,
      "cc":"AZN",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":946,
      "txt":"Румунський лей",
      "rate":9.0741,
      "cc":"RON",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":949,
      "txt":"Турецька ліра",
      "rate":1.1303,
      "cc":"TRY",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":960,
      "txt":"СПЗ (спеціальні права запозичення)",
      "rate":55.2292,
      "cc":"XDR",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":975,
      "txt":"Болгарський лев",
      "rate":23.0938,
      "cc":"BGN",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":978,
      "txt":"Євро",
      "rate":45.1649,
      "cc":"EUR",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":985,
      "txt":"Злотий",
      "rate":10.7848,
      "cc":"PLN",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":12,
      "txt":"Алжирський динар",
      "rate":0.30678,
      "cc":"DZD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":50,
      "txt":"Така",
      "rate":0.3396,
      "cc":"BDT",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":51,
      "txt":"Вірменський драм",
      "rate":0.105329,
      "cc":"AMD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":214,
      "txt":"Домініканське песо",
      "rate":0.66703,
      "cc":"DOP",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":364,
      "txt":"Іранський ріал",
      "rate":0.00007112,
      "cc":"IRR",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":368,
      "txt":"Іракський динар",
      "rate":0.031627,
      "cc":"IQD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":417,
      "txt":"Сом",
      "rate":0.47378,
      "cc":"KGS",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":422,
      "txt":"Ліванський фунт",
      "rate":0.00042,
      "cc":"LBP",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":434,
      "txt":"Лівійський динар",
      "rate":8.476,
      "cc":"LYD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":458,
      "txt":"Малайзійський ринггіт",
      "rate":9.2849,
      "cc":"MYR",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":504,
      "txt":"Марокканський дирхам",
      "rate":4.1619,
      "cc":"MAD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":586,
      "txt":"Пакистанська рупія",
      "rate":0.1482,
      "cc":"PKR",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":682,
      "txt":"Саудівський ріял",
      "rate":11.0469,
      "cc":"SAR",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":704,
      "txt":"Донг",
      "rate":0.0016211,
      "cc":"VND",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":764,
      "txt":"Бат",
      "rate":1.21254,
      "cc":"THB",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":784,
      "txt":"Дирхам ОАЕ",
      "rate":11.2812,
      "cc":"AED",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":788,
      "txt":"Туніський динар",
      "rate":13.0501,
      "cc":"TND",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":860,
      "txt":"Узбецький сум",
      "rate":0.0032174,
      "cc":"UZS",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":901,
      "txt":"Новий тайванський долар",
      "rate":1.25939,
      "cc":"TWD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":934,
      "txt":"Туркменський новий манат",
      "rate":11.8375,
      "cc":"TMT",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":941,
      "txt":"Сербський динар",
      "rate":0.36798,
      "cc":"RSD",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":972,
      "txt":"Сомоні",
      "rate":3.7938,
      "cc":"TJS",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":981,
      "txt":"Ларі",
      "rate":14.8366,
      "cc":"GEL",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":986,
      "txt":"Бразильський реал",
      "rate":7.0922,
      "cc":"BRL",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":959,
      "txt":"Золото",
      "rate":123782.27,
      "cc":"XAU",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":961,
      "txt":"Срібло",
      "rate":1390.69,
      "cc":"XAG",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":962,
      "txt":"Платина",
      "rate":41186.3,
      "cc":"XPT",
      "exchangedate":"18.03.2025"
   },
   {
      "r030":964,
      "txt":"Паладій",
      "rate":39937.32,
      "cc":"XPD",
      "exchangedate":"18.03.2025"
   }
]';
}