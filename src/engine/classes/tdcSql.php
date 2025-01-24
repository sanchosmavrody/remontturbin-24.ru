<?php
/// * (c) AUTODATABASES.COM. 2Q2019. Support: info@autodatabases.com

/*
Dont change anything in this class. You may have troubles with updating.
Query kit will be expanded with different search queries in a few days.
*/

class tdcSql
{
    private $db;
    public $json_options = JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_BIGINT_AS_STRING;
    public $type = 'P';
    public $query;
    public $json = true;


    public $queries = ['getMakes'         => 'SELECT manuId, manuName,hasKompressor FROM manufacturers WHERE linkingTargetType = "{type}" AND hasKompressor = 1   ',
                       'getMake'          => 'SELECT manuName FROM manufacturers WHERE manuId="{make_id}" AND linkingTargetType = "{type}"  ',
                       'getModels'        => 'SELECT modelSeries.manuId,modelSeries.modelId, manufacturers.manuName, modelname,  yearOfConstrFrom as YFrom,yearOfConstrTo as YTo,modelSeries.hasKompressor FROM modelSeries 
 LEFT JOIN manufacturers ON manufacturers.manuId=modelSeries.manuId
 WHERE modelSeries.manuId="{make_id}" AND  modelSeries.linkingTargetType = "{type}" AND  manufacturers.linkingTargetType = "{type}" AND modelSeries.hasKompressor = 1   ',

                       'getModifications' => <<<SQL
SELECT 
CAR.carId
,VD.manuName
,CAR.manuId
,CAR.modId 

-- ,MODELS.yearOfConstrFrom as modelYFrom
-- ,MODELS.yearOfConstrTo as modelYTo




-- ,CAR.carId
-- ,CAR.manuId
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
-- LEFT JOIN manufacturers MANUF ON MANUF.manuId = CAR.manuId
LEFT JOIN vehicleMotorCodes VMC ON VMC.carId = CAR.carId
LEFT JOIN vehicleDetails VD ON VD.carId = CAR.carId

WHERE CAR.carType = '{type}' AND  CAR.modId = '{model_id}' AND CAR.manuId = '{make_id}' 
AND CAR.hasKompressor = 1  
GROUP BY CAR.carId
ORDER BY CAR.carName
SQL
                       ,
                       'getModification' => <<<SQL
SELECT 
CAR.carId
,CAR.manuId
,CAR.modId 
,VD.manuName
,VD.modelName
,VD.typeName
,VD.constructionType as bodyType
,VD.impulsionType
-- ,MODELS.yearOfConstrFrom as modelYFrom
-- ,MODELS.yearOfConstrTo as modelYTo

,VD.yearOfConstrFrom as carYFrom
,VD.yearOfConstrTo   as carYTo


-- ,CAR.carId
-- ,CAR.manuId
,CAR.hasKompressor

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
-- LEFT JOIN manufacturers MANUF ON MANUF.manuId = CAR.manuId
LEFT JOIN vehicleMotorCodes VMC ON VMC.carId = CAR.carId
LEFT JOIN vehicleDetails VD ON VD.carId = CAR.carId

WHERE CAR.carType = '{type}' AND CAR.carId = '{car_id}' 
AND CAR.hasKompressor = 1  
GROUP BY CAR.carId
ORDER BY CAR.carName
SQL
                       ,

                       'getSectionsAll'   => 'SELECT assemblyGroupNodeId,assemblyGroupName,hasChilds,parentNodeId FROM assemblyGroupNodes WHERE linkingTargetType = "{type}" ',

                       'getSectionsStart' => 'SELECT assemblyGroupNodeId,assemblyGroupName,hasChilds,parentNodeId FROM assemblyGroupNodes WHERE linkingTargetType = "{type}" ',

                       'getSections' => 'SELECT assemblyGroupNodeId,assemblyGroupName,hasChilds,parentNodeId FROM assemblyGroupNodes WHERE  assemblyGroupNodeId={section_id} AND linkingTargetType = "{type}" ',

                       'getSectionParts' => 'SELECT * FROM articles  a LEFT JOIN  assemblyGroupNodes n ON 
                a.assemblyGroupNodeId=n.assemblyGroupNodeId  WHERE 
                a.assemblyGroupNodeId={section_id} AND N.linkingTargetType="{type}" ',

                       'getSectionCarParts'              => <<<SQL
SELECT 
v.articleId
,A.articleNumber
,A.mfrName
,A.additionalDescription
,A.articleStatusDescription
,A.genericArticleDescription
FROM articlesVehicleTrees v
LEFT JOIN articles A ON A.legacyArticleId = v.articleId
WHERE v.linkingTargetId = {car_id} 
AND v.assemblyGroupNodeId = {section_id} 
AND v.linkingTargetType="{type}"  
GROUP BY v.articleId
ORDER BY v.sortNo ASC
SQL
                       ,
                       'getSectionCarPartsFilterGeneric' => <<<SQL
SELECT 
v.articleId
,A.articleNumber
,A.dataSupplierId
,A.mfrName
,A.additionalDescription
,A.articleStatusDescription
,A.genericArticleDescription
FROM articlesVehicleTrees v
LEFT JOIN articles A ON A.legacyArticleId = v.articleId
WHERE v.linkingTargetId = {car_id} 
AND v.assemblyGroupNodeId = {section_id} 
AND v.linkingTargetType="{type}"  
AND v.genericArticleId = {genericArticleId}
GROUP BY v.articleId
ORDER BY v.sortNo ASC
SQL
                       ,
                       'search_no_cross' => <<<SQL
SELECT 
v.articleId
,A.articleNumber
,A.dataSupplierId
,A.mfrName
,A.additionalDescription
,A.articleStatusDescription
,A.genericArticleDescription
FROM articlesVehicleTrees v
LEFT JOIN articles A ON A.legacyArticleId = v.articleId
WHERE A.articleNumber = "{n}"
AND v.assemblyGroupNodeId = 100391
AND v.linkingTargetType="P"  
AND v.genericArticleId = 2234
GROUP BY v.articleId
ORDER BY v.sortNo ASC
SQL
                       ,
                       'search' => <<<SQL
SELECT 
v.articleId
,A.articleNumber
,A.dataSupplierId
,A.mfrName
,A.additionalDescription
,A.articleStatusDescription
,A.genericArticleDescription
FROM articlesVehicleTrees v
LEFT JOIN articles A ON A.legacyArticleId = v.articleId

WHERE (A.articleNumber = "{n}" OR A.articleNumber IN (
SELECT AC.articleNumber  FROM articleCrosses as AC WHERE REPLACE(REPLACE(AC.oemNumber, '.', ''), '-', '') = "{n}" AND  A.dataSupplierId = AC.dataSupplierId
   
))
AND v.assemblyGroupNodeId = 100391
AND v.linkingTargetType = "P"  
AND v.genericArticleId = 2234
GROUP BY v.articleId
ORDER BY v.sortNo ASC
SQL
                       ,
                       // modified 18.09.2019

                       'getArticle' => 'SELECT * FROM `articles` WHERE `legacyArticleId` = {article_id} ',

                       'getArticleCross' => <<<SQL
SELECT DISTINCT  manufacturers.manuName, articleCrosses.oemNumber  FROM articleCrosses
LEFT JOIN manufacturers ON manufacturers.manuId = articleCrosses.mfrId
WHERE articleNumber = '{articleNumber}' AND dataSupplierId = '{dataSupplierId}' 
SQL
 ,

    ];

    public function __construct($db_TC)
    {
        if (!$this->db) {
            $this->connect($db_TC);
        }
        $this->type = 'P';
        $this->json = false;
    }

    public function connect($db_TC)
    {

        $this->db = $db_TC;
        $this->db->connect(DBUSER_T, DBPASS_T, DBNAME_T, DBHOST_T);
        return;
//        $this->db=new PDO(
//            'mysql:host='.$config['host'].';dbname='.$config['dbname'].';port='.$config['port'].';',
//            $config['user'],
//            $config['password']
//        );
    }

    public function fillQuery($req)
    {

        $fn = $req['fn'] ?? false;
        $query = $this->queries[$fn] ?? false;


        $req['type'] = $req['type'] ?? $this->type;

        if ($query) {
            foreach ($req as $key => $value) {

                $query = str_replace('{' . $key . '}', $value, $query);
            }
        }
        return $query;
    }

    public function getData($req = ['fn' => false])
    {
        $query = $this->fillQuery($req);
        $this->query = $query;



        if ($query) {
            $rows = $this->db->super_query($query, true);
            $rows = $rows ? $rows : [];
            return $this->json ? json_encode($rows, $this->json_options) : $rows;
        }
    }


    function convert(){

        $sql =<<<SQL
UPDATE cars CAR
JOIN articlesVehicleTrees T ON CAR.carId = T.linkingTargetId 
	AND CAR.carType = T.linkingTargetType AND T.genericArticleId=2234
    AND T.assemblyGroupNodeId = 100391
SET hasKompressor = 1
WHERE  CAR.carId= 13043

UPDATE modelSeries T
 JOIN modelSeries T ON T.manuId = M.manuId AND T.linkingTargetType = M.linkingTargetType AND T.hasKompressor = 1 SET M.hasKompressor = 1

UPDATE manufacturers M LEFT
 JOIN modelSeries T ON T.manuId = M.manuId AND T.linkingTargetType = M.linkingTargetType AND T.hasKompressor = 1 SET M.hasKompressor = 1
SQL;


    }


}

/// * (c) AUTODATABASES.COM. 2Q2019. Support: info@autodatabases.com
?>
