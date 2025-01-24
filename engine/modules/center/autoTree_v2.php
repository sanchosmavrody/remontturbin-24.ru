<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);




$sql = <<<SQL
SELECT mark.id as mark_id,
       mark.name as mark_name,
       model.id as model_id,
       model.name as modle_name,
       model.`year-from` as year_from,
       model.`year-to` as year_to
FROM mark 
JOIN model ON mark.id = model.mark_id
SQL;



$rows = $db->super_query($sql, true);

$groupByManuf = [];
foreach ($rows as $row) {
    if (!isset($groupByManuf[$row['mark_name']]))
        $groupByManuf[$row['mark_name']] = ['models' => [], 'mark_name' => $row['mark_name'], 'mark_id' => $row['mark_id']];
    $groupByManuf[$row['mark_name']]['models'][] = $row;
}


//sort($groupByManuf);

foreach ($groupByManuf as $mark_name => $Item) {

    $modelsList = '';
    foreach ($Item['models'] as $model) {
        $colapsed = 'collapsed';
        $in = '';
        if (isset($_REQUEST['make_id']) and $_REQUEST['make_id'] == $Item['mark_id']) {
            $colapsed = '';
            $in = 'in';
        }

        $year_from = $model['year_from'];
        $year_to = $model['year_to'];
        if(!$year_to)
            $year_to = 'произв.';
        $modelsList .= <<<HTML
<a href="/catalog_auto/{$Item['mark_id']}/{$model['model_id']}/" class="list-group-item" data-parent="#manuId_{$Item['mark_id']}">
<span>{$model['modle_name']}</span> <small><i>{$year_from}-{$year_to}</i></small></a>
HTML;
    }


    echo <<<HTML
<span  data-target="#manuId_{$Item['mark_id']}" class="list-group-item {$colapsed} atreemanuf" data-toggle="collapse" data-parent="#manuId_{$Item['mark_id']}">
    {$Item['mark_name']} <i class="fa fa-caret-down"></i>
    <a class="atreemore" href="/catalog_auto/{$Item['mark_id']}/" > Показать все<i class="fa fa-caret-down"></i></a>
</span>
<div class="collapse list-group-submenu {$in}" id="manuId_{$Item['mark_id']}" style=" border-left: 1px dashed rgb(255, 196, 0);    max-height: 450px;    overflow-x: hidden;    margin-left: 0px;    padding-left: 20px;} ">
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
