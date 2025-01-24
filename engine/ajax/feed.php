<?php
header("Content-Type: text/xml");
define('ENGINE_DIR',$_SERVER['DOCUMENT_ROOT'].'/engine');
define ( 'DATALIFEENGINE', true );

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
////https://remontturbin-24.ru/engine/ajax/feed.php

require_once ENGINE_DIR . '/classes/mysql.php';
require_once ENGINE_DIR . '/modules/functions.php';
require_once ENGINE_DIR . '/data/config.php';
require_once ENGINE_DIR . '/data/tc.dbconfig.php';
$sql = <<<SQL
SELECT modelSeries.manuId,modelSeries.modelId, manufacturers.manuName, modelname,  yearOfConstrFrom as YFrom,yearOfConstrTo as YTo,modelSeries.hasKompressor 
FROM modelSeries 
LEFT JOIN manufacturers ON manufacturers.manuId=modelSeries.manuId
WHERE  modelSeries.linkingTargetType = 'P' AND  manufacturers.linkingTargetType = 'P' AND modelSeries.hasKompressor = 1  
ORDER BY manufacturers.manuName,modelname
SQL;


if (!isset($db_TC) or $db_TC == null) {
    global $db_TC;
}

global $City;


$db_TC->connect(DBUSER_T, DBPASS_T, DBNAME_T, DBHOST_T);


$rows = $db_TC->super_query($sql, true);

$groupByManuf = [];
foreach ($rows as $row) {

    if (!isset($groupByManuf[$row['manuName']]))
        $groupByManuf[$row['manuName']] = ['models' => [], 'manuName' => $row['manuName'], 'manuId' => $row['manuId']];

    $groupByManuf[$row['manuName']]['models'][] = $row;

}

$items = [];
$categories= [];
foreach ($groupByManuf as $manuName => $Manuf) {


    $categories[] = <<<XML
<category id="1{$Manuf['manuId']}" parentId="1">{$Manuf['manuName']}</category>
XML;
    $modelsList = '';
    foreach ($Manuf['models'] as $model) {

        $YFrom = getStrDate($model['YFrom']);
        $YTo = getStrDate($model['YTo']);
        if (!$YTo)
            $YTo = 'произв.';

        $categories[] = <<<XML
<category id="1000{$model['modelId']}" parentId="1{$Manuf['manuId']}">{$model['modelname']} {$YFrom} - {$YTo}</category>
XML;
    }


}

// SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
$sql = <<<SQL

SELECT 
CAR.carId
,VD.manuName
,CAR.manuId
,CAR.modId
,CAR.hasKompressor
,VD.modelName
,VD.typeName
,VD.constructionType as bodyType
,VD.impulsionType
,VD.yearOfConstrFrom as carYFrom
,VD.yearOfConstrTo   as carYTo
,VMC.motorCode
,VD.cylinder
,VD.valves
,TRUNCATE(VD.cylinderCapacityLiter/100,2) as LV 
,VD.powerHpFrom as HP
,VD.powerKwFrom as KW
,VD.motorType
,VD.fuelTypeProcess
FROM cars CAR
LEFT JOIN modelSeries MODELS ON MODELS.modelId = CAR.modId
LEFT JOIN vehicleMotorCodes VMC ON VMC.carId = CAR.carId
LEFT JOIN vehicleDetails VD ON VD.carId = CAR.carId
WHERE CAR.carType = 'P' 
AND CAR.hasKompressor = 1  
GROUP BY CAR.carId
ORDER BY CAR.carName;
SQL;
$rows = $db_TC->super_query($sql, true);

foreach ($rows as $row) {
    $items[] = <<<XML
<offer id="{$row['carId']}" available="true">
    <name>Ремонт турбин {$row['manuName']} {$row['modelName']} {$row['typeName']} {$row['motorCode']} {$row['HP']}л.с. ({$row['KW']}кВт) от 2500 тыс. в Москве</name>
    <vendor>{$row['manuName']}</vendor>
    <model>{$row['modelName']}</model>
    <url>https://remontturbin-24.ru/turbiny/parts/{$row['carId']}/2234/</url>
    <picture>https://ee-turbosklad.ru/templates/Full/img/result-img.png</picture>
    <price>2500</price>
    <categoryId>1000{$row['modId']}</categoryId>
    <currencyId>RUR</currencyId>
    <description>Подберите турбину, которая установлена в вашем{$row['manuName']} {$row['modelName']} {$row['typeName']} {$row['motorCode']} и запишитесь на диагностику или на ремонт турбины</description>  
</offer>
XML;
}


$items = implode('
', $items);

$categories = implode('
', $categories);


echo <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog date="2022-12-22T14:37:38+03:00">
<shop>
        <name>Ремонт Турбин 24</name>
        <company>ООО «Шериф»</company>
        <url>https://remontturbin-24.ru/</url>
        <currencies>
        <currency id="RUR" rate="1"/></currencies>
<categories>
{$categories}
</categories> 
<offers>
{$items}
</offers>   
</shop>
</yml_catalog>
XML;

exit();