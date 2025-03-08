<?php

ini_set('memory_limit', '-1');

header("Content-Type: text/xml");
define('ENGINE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/engine');
define('DATALIFEENGINE', true);

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
////https://remontturbin-24.ru/engine/ajax/feed.php

require_once ENGINE_DIR . '/data/config.php';
require_once ENGINE_DIR . '/classes/mysql.php';
require_once ENGINE_DIR . '/modules/functions.php';
require_once ENGINE_DIR . '/data/config.php';
require_once ENGINE_DIR . '/data/dbconfig.php';
//$sql = <<<SQL
//SELECT modelSeries.manuId,modelSeries.modelId, manufacturers.manuName, modelname,  yearOfConstrFrom as YFrom,yearOfConstrTo as YTo,modelSeries.hasKompressor
//FROM modelSeries
//LEFT JOIN manufacturers ON manufacturers.manuId=modelSeries.manuId
//WHERE  modelSeries.linkingTargetType = 'P' AND  manufacturers.linkingTargetType = 'P' AND modelSeries.hasKompressor = 1
//ORDER BY manufacturers.manuName,modelname
//SQL;
//if (!isset($db_TC) or $db_TC == null)
//    global $db_TC;
//
//global $City;
//$db_TC->connect(DBUSER_T, DBPASS_T, DBNAME_T, DBHOST_T);
//$rows = $db_TC->super_query($sql, true);

$sql = <<<SQL
SELECT mark.id as manuId,
       mark.name as manuName,
       model.id as modelId,
       model.name as modelname,
       model.`year-from` as YFrom,
       model.`year-to` as YTo
FROM mark 
JOIN model ON mark.id = model.mark_id
SQL;


$rows = $db->super_query($sql, true);

$groupByManuf = [];
foreach ($rows as $row) {
    if (!isset($groupByManuf[$row['manuName']]))
        $groupByManuf[$row['manuName']] = ['models' => [], 'manuName' => $row['manuName'], 'manuId' => $row['manuId']];
    $groupByManuf[$row['manuName']]['models'][] = $row;
}

$items = [];
$categories = [];
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


$sql = <<<SQL
SELECT mark.id as mark_id,
       mark.name as mark_name,
       model.id as model_id,
       model.name as model_name,
       generation.`year-start` as year_from,
       generation.`year-stop` as year_to,
       generation.id as generation_id,
       generation.name as generation_name,
       configuration.`id` as configuration_id, 
       configuration.`body-type` as body_type,
       configuration.`doors-count` as doors_count,
       configuration.`configuration-name` as configuration_name,
       modification.`complectation-id` as complectation_id,
       specifications.*
FROM mark 
JOIN model ON mark.id = model.mark_id
JOIN generation ON model.id = generation.model_id 
JOIN configuration ON generation.id = configuration.generation_id
JOIN modification ON configuration.id = modification.configuration_id
JOIN specifications ON modification.`complectation-id` = specifications.complectation_id
WHERE  specifications.feeding = 'турбонаддув'
SQL;
$rows = $db->super_query($sql, true);



foreach ($rows as $row) {

    if(empty($row['year_to']))
        $row['year_to']='произв.';

    $items[] = <<<XML
<offer id="{$row['complectation_id']}" available="true">
    <name>Ремонт турбин {$row['mark_name']} {$row['model_name']} ({$row['year_from']}-{$row['year_to']}) {$row['body_type']} {$row['drive']} привод {$row['engine-type']} {$row['horse-power']}л.с. ({$row['kvt-power']}кВт) от 2500 тыс. в Москве</name>
    <vendor>{$row['mark_name']}</vendor>
    <model>{$row['model_name']}</model>
    <url>https://remontturbin-24.ru/catalog_auto/{$row['mark_id']}/{$row['model_id']}/{$row['generation_id']}/{$row['configuration_id']}/{$row['complectation_id']}/</url>
    <picture>https://ee-turbosklad.ru/templates/Full/img/result-img.png</picture>
    <price>2500</price>
    <categoryId>1000{$row['model_id']}</categoryId>
    <currencyId>RUR</currencyId>
    <description>Подберите турбину, которая установлена в вашем {$row['mark_name']} {$row['model_name']} ({$row['year_from']}-{$row['year_to']}) {$row['body_type']} {$row['drive']} привод {$row['engine-type']} и запишитесь на диагностику или на ремонт турбины</description>  
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