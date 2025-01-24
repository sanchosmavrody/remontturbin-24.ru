<?php

//define('ZADARMA_KEY', '2ea5a97fcfd4cbb18a45');
//define('ZADARMA_SECRET', 'eab2e2bd83dc871066aa');

define('ZADARMA_KEY', '40ce4b6d34f9d77b51e8');
define('ZADARMA_SECRET', 'bfc4a079a28df272e7c0');

define('SMSER_LOGIN', 'ee.turbosklad@yandex.ru');
define('SMSER_PASSWORD', '1asdqwe435!');
define('SMSER_SENDER', 'SMSC.RU');

define('MAIN_PHONE', '+7 (495) 13-372-62');
define('MANAGER_EMAIL', 'manager@ee-turbosklad.ru');
define('INFO_EMAIL', 'manager@ee-turbosklad.ru');


define('s', 'ee');


if (true) {
    if ($_REQUEST['orderId'] == 1) {
        define('TTF_TERMINAL', '1573807500677DEMO');//1573807500677DEMO
        define('TTF_SECRET', 'ciozfrqmuq52pusu');//ciozfrqmuq52pusu
    } else {
        define('TTF_TERMINAL', '1573807500677');//1573807500677
        define('TTF_SECRET', 'khn4ky2tasktu0th');//khn4ky2tasktu0th
    }
} else {
    define('TTF_TERMINAL', '');
    define('TTF_SECRET', '');
}


define('ADMIN_SMS_PUSH', '');//79999805913,79999805913

//define('PRICE_SHEETID', '1NN-SEHaweoz9jQMZ3K6BgeW_0bQ_z9-6bfG8XSgYj_I');
const RegXPLib = ['pay_sb' => ['part' => "card|kard|сard|на карту|накарту|sber|sb|сбер|сб",
    'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'prepay' => ['part' => "prepay|предоплата",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'prepayed' => ['part' => "prepayed|внес предоплату",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'morepay' => ['part' => "morepay|доплата",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'morepayed' => ['part' => "morepayed|доплатил",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'pay_online' => ['part' => "online|rk|RK|оnline|онлайн|рк",
        'regxp' => '(\!|#)(__part__)\s?([0-9]{2,6})'],
    'remind' => ['part' => "remind|rmnd|rm|rem|напомнить",
        'regxp' => '(\!|#)(remind|rmnd|rm|rem|напомнить)\s([0-9:.,\s]{5,10})\s([0-9:\s]{5})'],
    'tag_info' => ['part' => "",
        'regxp' => ''],
    'tag_warning' => ['part' => "звонок|фото|записка:|Записка:|аноним|анононимно|инкогнито|сюрприз|Анониманая доставка|Анонимная доставка|чек|сдача",
        'regxp' => '(\!|#)(__part__)'],
    'tag_danger' => ['part' => "курьеру|флористу",
        'regxp' => '(\!|#)(__part__)'],
    'tag_default' => ['part' => "",
        'regxp' => ''],];

const TranslateEnum = ["periodFrom" => "C",
    "periodTo" => "По",
    "addProduct" => "Добавить составляющую",
    "addItem" => "Добавить товар",
    "lastDebt" => "Долг",
    "calcSum" => "Сумма",
    "FDateAdd" => "Дата",
    "correctionSum" => "Корекция",
    "correctionComment" => "Камент корекции",
    "totalDebt" => "Итого",
    "closedSum" => "Оплачено",
    "typeEnum" => "Тип",
    "responsibleUserId" => "Сотрудник",
    "Comment" => "Камент",
    "sdacha" => "Сдача",
    "costExpenses" => "c/c р. ",
    "costFact" => "c/c ф.",
    "level" => "Бал",
    "buketCount" => "Букетов",
    "Date" => "Выполнен",
    "courierName" => "Имя",
    "floristName" => "Флорист",
    "Name" => "Имя",
    "orderId" => "№",
    "paymentType" => "Оплата",
    "totalSumm" => "Сумма",
    "payedSummOnline" => "Онлайн",
    "payedSummRs" => "РС",
    "payedSummCash" => "Магазин",
    "payedSummCard" => "Сбер",
    "payedSummCourier" => "Получил",
    "costCourierFact" => "Доставка",
    "saldo" => "Расчет",
    "AdminComments" => "Каменты",
    "Status" => "Статус",
    "Amount" => "Сумма",
    "Phone" => "Телефон",
    "PaymentId" => "PaymentId",
    "pId" => "pId",
    "DateAdd" => "Дата",
    "orderId" => "Заказ",
];

const levelFreeDost = 999999;
const dostMskPrice = 400;

const deliveryPriceList = ['metro' => 400,
    'railway' => 620,
    'province' => 820];

const  AssembledList = [1 => 'Закуплен',
    /*2 => 'В сборке',*/
    3 => 'Собран',
    4 => 'Оплачен',];


const FrameList = ['faq' => '',
    'prices' => ''];


const paymentTypeLib = ['cash' => 'Магазин Нал',
    'courier' => 'Курьеру Нал',
    'online' => 'Онлайн на сайте',
    'acquire' => 'Магазин Card',
    'rs' => 'Безнал р/с',
    'sber' => 'Безнал Сбер'];


const SrcLib = ['site',
    'site1click',

    'chat',
    'phone',];


//<div class="iv-embed" style="margin:0 auto;padding:0;border:0;width:1282px;"><div class="iv-v" style="display:block;margin:0;padding:1px;border:0;background:#000;"><iframe class="iv-i" style="display:block;margin:0;padding:0;border:0;" src="https://open.ivideon.com/embed/v2/?server=100-omdK8tRVUHQDY4Tbo8gyHL&amp;camera=0&amp;width=&amp;height=&amp;lang=ru" width="1280" height="720" frameborder="0" allowfullscreen></iframe></div><div class="iv-b" style="display:block;margin:0;padding:0;border:0;"><div style="float:right;text-align:right;padding:0 0 10px;line-height:10px;"><a class="iv-a" style="font:10px Verdana,sans-serif;color:inherit;opacity:.6;" href="https://www.ivideon.com/" target="_blank">Powered by Ivideon</a></div><div style="clear:both;height:0;overflow:hidden;">&nbsp;</div><script src="https://open.ivideon.com/embed/v2/embedded.js"></script></div></div>

