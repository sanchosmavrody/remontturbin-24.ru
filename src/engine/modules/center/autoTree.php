<?php



require_once ENGINE_DIR . '/data/tc.dbconfig.php';
$sql = <<<SQL
SELECT modelSeries.manuId,modelSeries.modelId, manufacturers.manuName, modelname,  yearOfConstrFrom as YFrom,yearOfConstrTo as YTo,modelSeries.hasKompressor 
FROM modelSeries 
LEFT JOIN manufacturers ON manufacturers.manuId=modelSeries.manuId
WHERE  modelSeries.linkingTargetType = 'P' AND  manufacturers.linkingTargetType = 'P' AND modelSeries.hasKompressor = 1  
ORDER BY manufacturers.manuName,modelname
SQL;


if (!isset($db_TC) OR $db_TC == null) {
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


//sort($groupByManuf);

foreach ($groupByManuf as $manuName => $Manuf) {


    $modelsList = '';
    foreach ($Manuf['models'] as $model) {

        $colapsed = 'collapsed';
        $in = '';
        if (isset($_REQUEST['make_id']) and $_REQUEST['make_id'] == $Manuf['manuId']) {
            $colapsed = '';
            $in = 'in';
        }
        $YFrom = getStrDate($model['YFrom']);
        $YTo = getStrDate($model['YTo']);

        if (!$YTo)
            $YTo = 'произв.';

        $modelsList .= <<<HTML
<a href="/turbiny/{$Manuf['manuId']}/{$model['modelId']}/" class="list-group-item" data-parent="#manuId_{$Manuf['manuId']}"><span>{$model['modelname']}</span> <small><i>{$YFrom} - {$YTo}</i></small></a>
HTML;

    }


    echo <<<HTML
<span  data-target="#manuId_{$Manuf['manuId']}" class="list-group-item {$colapsed} atreemanuf" data-toggle="collapse" data-parent="#manuId_{$Manuf['manuId']}">
    {$Manuf['manuName']} <i class="fa fa-caret-down"></i>
    
    <a class="atreemore" href="/turbiny/{$Manuf['manuId']}/" > Показать все<i class="fa fa-caret-down"></i></a>
</span>
<div class="collapse list-group-submenu {$in}" id="manuId_{$Manuf['manuId']}" style=" border-left: 1px dashed rgb(255, 196, 0);    max-height: 450px;    overflow-x: hidden;    margin-left: 0px;    padding-left: 20px;} ">
{$modelsList}
</div>

HTML;


}


echo <<<HTML
<style>
.atreemore{
float: right;
display: none;
}
.atreemanuf:hover{
background-color: #faac3e;
    border-radius: 2px;
}
.atreemanuf:hover .atreemore{
 display: initial;
}
.atreemanuf{
cursor: pointer;

}

#demo3 .list-group-submenu .list-group-item:hover{
background-color: #faac3e;
    border-radius: 2px;
}
</style>
HTML;
