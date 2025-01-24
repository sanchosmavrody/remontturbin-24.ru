<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once ENGINE_DIR . '/data/tc.dbconfig.php';
$sql = <<<SQL
SELECT 
	   manufacturers.manuName, 
       modelSeries.manuId,
       
       modelSeries.modelname, 
       modelSeries.modelId,   
       modelSeries.yearOfConstrFrom as YFrom,
       modelSeries.yearOfConstrTo as YTo,
       
       
       cars.carId     , 
       cars.hasKompressor
       
       ,VD.modelName as VD_modelName
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

FROM cars
JOIN modelSeries  ON cars.modId=modelSeries.modelId
JOIN manufacturers ON manufacturers.manuId=modelSeries.manuId

LEFT JOIN vehicleMotorCodes VMC ON VMC.carId = cars.carId
LEFT JOIN vehicleDetails VD ON VD.carId = cars.carId

WHERE  
      modelSeries.linkingTargetType = 'P' 
  AND manufacturers.linkingTargetType = 'P' 
  AND modelSeries.hasKompressor = 1  
GROUP BY cars.carId
ORDER BY manufacturers.manuName,modelname
-- LIMIT 100
SQL;


if (!isset($db_TC) or $db_TC == null) {
    global $db_TC;
}

global $City;


$db_TC->connect(DBUSER_T, DBPASS_T, DBNAME_T, DBHOST_T);


$rows = $db_TC->super_query($sql, true);

//print_r($rows);
//exit();
$groupByManuf = [];
foreach ($rows as $row) {

    if (!isset($groupByManuf[$row['manuName']]))
        $groupByManuf[$row['manuName']] = [
            'models' => [],
            'manuName' => $row['manuName'],
            'manuId' => $row['manuId']];


    if (!isset($groupByManuf[$row['manuName']]['models'][$row['modelname']]))
        $groupByManuf[$row['manuName']]['models'][$row['modelname']] = [
            'cars' => [],
            'modelname' => $row['modelname'],
            'YTo' => $row['YTo'],
            'YFrom' => $row['YFrom'],
            'modelId' => $row['modelId']];


    if (!isset($groupByManuf[$row['manuName']]['models'][$row['modelname']]['cars'][$row['carId']]))
        $groupByManuf[$row['manuName']]['models'][$row['modelname']]['cars'][$row['carId']] = [
            'carId' => $row['carId'],
            'bodyType' => $row['bodyType'],
            'impulsionType' => $row['impulsionType'],


            'carYFrom' => $row['carYFrom'],
            'carYTo' => $row['carYTo'],
            'motorCode' => $row['motorCode'],
            'cylinder' => $row['cylinder'],
            'valves' => $row['valves'],
            'LV' => $row['LV'],

            'HP' => $row['HP'],
            'KW' => $row['KW'],
            'motorType' => $row['motorType'],
            'fuelTypeProcess' => $row['fuelTypeProcess'],
        ];


    //  var_dump($groupByManuf);
    //  exit();

}


//sort($groupByManuf);

foreach ($groupByManuf as $manuName => $Manuf) {


    $modelsList = '';
    foreach ($Manuf['models'] as $model) {
        $carList = '';
        foreach ($model['cars'] as $car) {
            //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|___/turbiny/parts/{$car['carId']}/2234/ : {$Manuf['manuName']} {$model['modelname']} {$YFrom} - {$YTo}<br>
            $carList .= <<<HTML
https://remontturbin-24.ru/turbiny/parts/{$car['carId']}/2234/<br>
HTML;
        }

        $YFrom = getStrDate($model['YFrom']);
        $YTo = getStrDate($model['YTo']);
        if (!$YTo)
            $YTo = 'произв.';
//|___/turbiny/{$Manuf['manuId']}/{$model['modelId']}/ : {$Manuf['manuName']} {$model['modelname']} {$YFrom} - {$YTo}<br>
        $modelsList .= <<<HTML
https://remontturbin-24.ru/turbiny/{$Manuf['manuId']}/{$model['modelId']}/<br>
{$carList}
HTML;

    }

///turbiny/{$Manuf['manuId']}/ : {$Manuf['manuName']} <br>
    echo <<<HTML
https://remontturbin-24.ru/turbiny/{$Manuf['manuId']}/<br>
{$modelsList}
HTML;


}


echo <<<HTML
<style>
body{
background-color: #0a0a0a;
color: #fff;
}
a{
color: #0c2a0b;
}
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

exit();