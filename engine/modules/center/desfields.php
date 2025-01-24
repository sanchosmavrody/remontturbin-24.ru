<?php


global $row;

if (false) {

    if ($act AND $act = 'zap') {

        $fieldsJ = json_decode($row['JSON'], true);

        if ($fieldsJ['Автомобиль:']) {

            $fieldsJ['Автомобиль:'] = explode('<span class="tn_usage">', $fieldsJ['Автомобиль:'])[1];
            $fieldsJ['Автомобиль:'] = str_replace('</span>', '', $fieldsJ['Автомобиль:']);

            if ($fieldsJ['Автомобиль:']) echo <<<HTML
<p><strong>ПРИМЕНЯЕТСЯ В АВТОМОБИЛЯХ:</strong> {$fieldsJ['Автомобиль:']}</p>
HTML;

        }

        $fieldsAreDes = ['turbinNumbers' => 'ПРИМЕНЯЕТСЯ В ТУРБИНАХ',
            'CHRA' => 'CHRA №',
            'usedAuto' => 'ПРИМЕНЯЕТСЯ В АВТОМОБИЛЯХ',
            'Auto' => 'АВТОМОБИЛЬ',
            'tth' => 'ХАРАКТЕРИСТИКИ',
            'analogs' => 'АНАЛОГИ',
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'E' => 'E',
            'F' => 'F',
            'G' => 'G',
            'H' => 'H',


            'CHRA' => 'CHRA №',
            'brand' => 'БРЕНД',
            'dvigNumber' => 'НОМЕР ДВИГАТЕЛЯ',
            'dvigV' => 'Объём/Мощность',
            'year' => 'Год',
            'origNumbers' => 'ОРИГИНАЛЬНЫЙ НОМЕР ТУРБИНЫ',
            'manufNumbers' => 'ЗАВОДСКОЙ НОМЕР ТУРБИНЫ',];
//dvigNumber dvigV dvigP year origNumbers manufNumbers  TurbinaNumber


        //  $fields = explode('|', $row['title_o']);

        if ($row['analogs']) {
            $row['analogs'] = str_replace('Аналоги:', '', $row['analogs']);
        }


        foreach ($fieldsAreDes as $f => $v) {


            if ($row[$f]) echo <<<HTML
<p><strong>{$v}:</strong> {$row[$f]}</p>
HTML;


        }
    } else {

        $fieldsAreDes = ['TurbinaNumber' => 'Номер турбины',
            'brand' => 'БРЕНД',
            'dvigNumber' => 'НОМЕР ДВИГАТЕЛЯ',
            'dvigV' => 'Объём/Мощность',
            'year' => 'Год',
            'origNumbers' => 'ОРИГИНАЛЬНЫЙ НОМЕР ТУРБИНЫ',
            'manufNumbers' => 'ЗАВОДСКОЙ НОМЕР ТУРБИНЫ',];
//dvigNumber dvigV dvigP year origNumbers manufNumbers  TurbinaNumber


        $fields = explode('|', $row['title_o']);


        foreach ($fieldsAreDes as $f => $v) {


            if (in_array($f, ['dvigNumber',
                'dvigV',
                'dvigP',
                'year'])) {
                echo <<<HTML
<p><strong>{$v}:</strong> {$row[$f]}</p>
HTML;
            } else {
                echo <<<HTML
<p><strong>{$v}:</strong> {$row[$f]}</p>
HTML;
            }


        }


    }
}

if ($row['fields']) {


    $fields = explode('||', $row['fields']);


    foreach ($fields as $strField) {


        $part = explode('|', $strField);
        if ($part[0] AND $part[1])

            $items[] = <<<HTML
<tr>
<td class="item-block__td-caption">{$part[0]}</td>
<td>{$part[1]}</td>
</tr>
HTML;


    }


    $Analogs_ = explode('||', $row['Analogs']);

    $Analogs = [];
    foreach ($Analogs_ as $strAnalog) {
        $part = explode('|', $strAnalog);
        if ($part[0] AND $part[1] AND $part[1] != $itemPr['SALEnumber'] AND !in_array($part[0], ['price', 'amount', 'priceUSD',])) {

            if ($search AND $search == $part[1]) {
                $part[1] = '<span class="label label-danger">' . $part[1] . '</span>';
            }
            $Analogs[] = <<<HTML
<li><strong>{$part[0]}</strong> {$part[1]}</li>
HTML;

        }
    }

    if (count($Analogs) > 0) {
        $Analogs = implode('', $Analogs);
        $items[] = <<<HTML
<tr>
<td class="item-block__td-caption">Аналоги</td>
<td><ul class="result__similar-list">{$Analogs}</ul></td>
</tr>
HTML;

    }


    $items = implode('', $items);


    echo <<<HTML
<table class="item-block__table">
{$items}
</table>
HTML;

} else {


    $fieldsAreDes = ["AMnumber" => "Номер по AM",
        "EEnumber" => "E&E Turbos №",
        "Jnumber" => "Jrone №",
        "partType" => "Тип запчасти",

        "origNumber" => "Тип турбины",
        "origBrand" => "Производитель турбины",
        "origManufNumber" => "Заводской номер",
        "origOemNumber" => "OEM номер",

        "comment" => "Комментарий",
        "lopatok" => "Лопаток",
        "A" => "A",
        "B" => "B",
        "C" => "C",
        "D" => "D",
        "E" => "E",
        "F" => "F",
        "G" => "G",
        "H" => "H",
        "searchNumbers" => "Крос номера",];


    foreach ($fieldsAreDes AS $Field => $label) {
        if ($row[$Field] != '') $items[] = <<<HTML
<tr>
 <td class="item-block__td-caption">{$label}</td>
 <td>{$row[$Field]}</td>
</tr>
HTML;

    }

    $items = implode('', $items);


    echo <<<HTML
<table class="item-block__table">
{$items}
</table>
HTML;

    $echo = <<<HTML
<table class="item-block__table">
    <tr>
        <td class="item-block__td-caption">Двигатель</td>
        <td>BJL, BJM</td>
    </tr>
    <tr>
        <td class="item-block__td-caption">Объем двигателя</td>
        <td>2,5</td>
    </tr>
    <tr>
        <td class="item-block__td-caption">Мощность</td>
        <td>109, 136</td>
    </tr>
    <tr>
        <td class="item-block__td-caption">Тип топлива</td>
        <td>Дизель</td>
    </tr>
    <tr>
        <td class="item-block__td-caption">Гарантия</td>
        <td>12 месяцев</td>
    </tr>
    <tr>
        <td class="item-block__td-caption">Модель турбины</td>
        <td>TD04</td>
    </tr>
    <tr>
        <td class="item-block__td-caption">Марка</td>
        <td>Volkswagen</td>
    </tr>
    <tr>
        <td class="item-block__td-caption">Модель авто</td>
        <td>Crafter</td>
    </tr>
    <tr>
        <td class="item-block__td-caption">Вес</td>
        <td>2 kg</td>
    </tr>
    <tr>
        <td class="item-block__td-caption">Габариты</td>
        <td>15 x 14 x 14 cm</td>
    </tr>
</table>
HTML;

}
?>

