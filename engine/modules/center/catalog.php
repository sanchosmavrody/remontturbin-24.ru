<?php


require_once ENGINE_DIR . '/data/tc.dbconfig.php';
require_once ENGINE_DIR . '/data/tc.config.php';


require_once(ENGINE_DIR . '/classes/tdcSql.php');


function clearToSearch($numberSTR)
{

    return preg_replace('/[^a-zа-яё\d]/ui', '', $numberSTR);

}

$T = new tdcSql($db_TC);

if (!isset($_REQUEST['fn'])) $_REQUEST['fn'] = 'getMakes';

$Marka = '';
$Model = '';
$Modification = '';


//$tplA['getModels'] = <<<HTML
///?do=tc&fn=getModifications&make_id={manuId}&model_id={modelId}
//HTML;
//$tplA['getModifications'] = <<<HTML
///?do=tc&fn=getSectionsStart&type=P&car_id={carId}
//HTML;
//$tplA['getSectionsStart'] = <<<HTML
///?do=tc&fn=getSections&section_id={assemblyGroupNodeId}&car_id={$_REQUEST['car_id']}
//HTML;
//$tplA['getSections'] = <<<HTML
///?do=tc&fn=getSectionCarParts&section_id={assemblyGroupNodeId}&car_id={$_REQUEST['car_id']}
//HTML;
//$tplA['getSectionCarParts'] = <<<HTML
///?do=tc&fn=getArticle&article_id={articleId}&car_id={$_REQUEST['car_id']}
//HTML;
//$tplA['getSectionCarPartsFilterGeneric'] = <<<HTML
///?do=tc&fn=getArticle&article_id={articleId}&car_id={$_REQUEST['car_id']}
//HTML;


if (in_array($_REQUEST['fn'], ['getModels_',
                               'getModifications_',
                               'getSections',
                               'getSectionsStart',
                               'getSectionCarParts',
                               'getSectionCarPartsFilterGeneric_',
                               'getArticle_'])) {

    $T->json = false;
    $rez = $T->getData($_REQUEST);
    $tableHead = "<tr>";
    foreach ($rez[0] as $field => $value) {
        $tableHead .= "<th>{$field}</th>";
    }
    $tableHead .= "<th>-></th>";
    $tableHead .= "</tr>";

    $tableBody = "";
    foreach ($rez as $item) {
        $linkNext = $tplA[$_REQUEST['fn']];
        $tableBody .= "<tr>";
        $tableBody .= "";
        foreach ($item as $field => $value) {
            $tableBody .= "<td>{$value}</td>";
            $linkNext = str_replace('{' . $field . '}', $value, $linkNext);
        }

        if ($_REQUEST['fn'] == 'getModifications') $linkTurbo = <<<HTML
Турбина <a target="_blank" href="/?do=tc&fn=getSectionCarPartsFilterGeneric&section_id=100391&car_id={$item['carId']}&genericArticleId=2234">-></a>
HTML;
        else
            $linkTurbo = '';


        $tableBody .= "<td> {$linkTurbo} | далее <a href='{$linkNext}'>-></a></td>";
        $tableBody .= "</tr>";
    }
    echo <<<HTML
<table class="table table-condensed ">
{$tableHead}
{$tableBody}
</table>
HTML;

}

if ($_REQUEST['catpart']) {
    $catpart = $_REQUEST['catpart'];
    $catpartPart = $catpart;
}


if ($_REQUEST['fn'] == 'getMakes') {

    $T->json = false;
    $rez = $T->getData($_REQUEST);
    require_once ROOT_DIR . '/engine/modules/center/SeoElements_init.php';


    if (count($rez) > 0) {
        $tpl->load_template('/tc/makes_row.tpl');
        foreach ($rez as $item) {
            foreach ($item as $field => $value) $tpl->set('{' . $field . '}', $value);

            foreach ($City as $suf => $val) {
                $tpl->set("{city_{$suf}}", $val);
            }

            $tpl->compile('rows');
        }
        $tpl->clear();
        $tpl->load_template('/tc/makes.tpl');
        $tpl->set('{rows}', $tpl->result['rows']);
    } else {
        $tpl->load_template('/info_closed.tpl');
    }

    $tpl->compile('content');
}
if ($_REQUEST['fn'] == 'getModels') {

    $T->json = false;
    $rez = $T->getData($_REQUEST);

    if (count($rez) > 0) {
        $Marka = $rez[0]['manuName'];
        $MarkaId = $rez[0]['manuId'];
        require_once ROOT_DIR . '/engine/modules/center/SeoElements_init.php';

        $tpl->load_template('/tc/models_row.tpl');
        $i = 0;
        foreach ($rez as $item) {
            $i++;


            if ($i > 10)
                $tpl->set("{hidemoreclass}", 'hidemoreclass off');
            else
                $tpl->set("{hidemoreclass}", '');


            $item['YFrom'] = getStrDate($item['YFrom']);
            if (!$item['YTo'])
                $item['YTo'] = 'произв.';
            else
                $item['YTo'] = getStrDate($item['YTo']);//   {YFrom}-{YTo}

            foreach ($item as $field => $value) $tpl->set('{' . $field . '}', $value);


            foreach ($City as $suf => $val) {
                $tpl->set("{city_{$suf}}", $val);
            }
            $tpl->compile('rows');
        }
        $tpl->clear();
        $tpl->load_template('/tc/models.tpl');
        $tpl->set('{rows}', $tpl->result['rows']);

        $tpl->set('{manuName}', " {$Marka} ");


    } else {
        $tpl->load_template('/info_closed.tpl');
    }

    $tpl->compile('content');


}
if ($_REQUEST['fn'] == 'getModifications') {
    $T->json = false;
    $rez = $T->getData($_REQUEST);

    if (count($rez) > 0) {
        $Marka = $rez[0]['manuName'];
        $MarkaId = $rez[0]['manuId'];
        $Model = $rez[0]['modelName'];
        $ModelId = $rez[0]['modelId'];
        require_once ROOT_DIR . '/engine/modules/center/SeoElements_init.php';

        $tpl->load_template('/tc/modifications_row.tpl');
        foreach ($rez as $item) {
            $item['carYFrom'] = getStrDate($item['carYFrom']);
            if (!$item['carYTo'])
                $item['carYTo'] = 'произв.';
            else
                $item['carYTo'] = getStrDate($item['carYTo']);//   {YFrom}-{YTo}
            foreach ($item as $field => $value) $tpl->set('{' . $field . '}', $value);
            foreach ($City as $suf => $val) {
                $tpl->set("{city_{$suf}}", $val);
            }
            $tpl->compile('rows');
        }
        $tpl->clear();
        $tpl->load_template('/tc/modifications.tpl');
        $tpl->set('{rows}', $tpl->result['rows']);

        $tpl->set('{manuName}', " {$Marka} ");
        $tpl->set('{modelName}', " {$Model} ");


    } else {
        $tpl->load_template('/info_closed.tpl');
    }


    $tpl->compile('content');

}

function cmp($a, $b)
{
    $res = false;

    if (count($a['priceList']) < count($b['priceList'])) {
        $res = true;
    } else if (count($a['priceList']) == count($b['priceList'])) {
        $res1 = 0;
        $res2 = 0;
        foreach ($a['priceList'] as $item) {
            $res1 += $item['price'];
        }

        foreach ($b['priceList'] as $item) {
            $res2 += $item['price'];
        }

        $res = $res1 < $res2;

    }

    return $res;
}

function cmp2($a, $b)
{
    return ($a['price']) < ($b['price']);
}


if ($_REQUEST['fn'] == 'getSectionCarPartsFilterGeneric' or $_REQUEST['fn'] == 'search') {

    $search = $_REQUEST['n'];
    $_REQUEST['n'] = preg_replace('/[^a-zа-яё\d]/ui', '', $_REQUEST['n']);


    $T->json = false;
    $rez = $T->getData($_REQUEST);

    $AutoFullInfo = $T->getData(['fn'     => 'getModification',
                                 'car_id' => $_REQUEST['car_id']])[0];

    if (!$AutoFullInfo['carYTo']) $AutoFullInfo['carYTo'] = 'произв';

    $Marka = $AutoFullInfo['manuName'];
    $Model = $AutoFullInfo['modelName'];
    $Modification = $AutoFullInfo['typeName'];
    require_once ROOT_DIR . '/engine/modules/center/SeoElements_init.php';

    $tpl2 = new dle_template();
    $tpl2->dir = $tpl->dir;
    $tpl->load_template('tc/parts_row.tpl');


    if ($_REQUEST['catpart'] and $_REQUEST['catpart'] != 'turbiny' and $catByAlt[$_REQUEST['catpart']]) {
        $CatId = $catByAlt[$_REQUEST['catpart']]['id'];

        $partTypeSQL = ' AND PRICE.catId IN (' . $CatId . ')';
    } else {
        $partTypeSQL = '';
    }


    $ResWisCros = [];
    $manuNameByCros = [];
    foreach ($rez as $item) {
        $i = 0;


        $item['crosesList'] = $T->getData(['fn'             => 'getArticleCross',
                                           'dataSupplierId' => $item['dataSupplierId'],
                                           'articleNumber'  => $item['articleNumber']]);


        if ($item['crosesList'] == null) {
            $item['crosesList'] = [['oemNumber' => $item['articleNumber'], 'manuName' => $item['manuName']]];


        }


        $item['coresesNumbers'] = [];
        foreach ($item['crosesList'] as $itemC) {
            if (!in_array($itemC['oemNumber'], $item['coresesNumbers'])) $item['coresesNumbers'][] = $itemC['oemNumber'];

            $manuNameByCros[$itemC['oemNumber']] = $itemC['manuName'];

        }

        $item['crosesList'] = $item['coresesNumbers'];

        $price = [];
        if (count($item['coresesNumbers']) > 0) {
            $coresesNumbers_ = implode('|', $item['coresesNumbers']);
            $coresesNumbers__ = implode("', '", $item['coresesNumbers']);

            $sql = <<<SQL
SELECT DISTINCT 

PRICE.partId,PRICE.catId, PRICE.artId, PRICE.SALEnumber, PRICE.SALEbrand, PRICE.partType, PRICE.price, PRICE.Comment, PRICE.fields as Analogs,
CATALOG.fields FROM 

center_price2 PRICE
LEFT JOIN center_price2_catalog CATALOG ON CATALOG.SALEnumber = PRICE.SALEnumber AND CATALOG.SALEbrand = PRICE.SALEbrand  AND CATALOG.partType = PRICE.partType
JOIN center_price2_search SEARCH  ON SEARCH.partId = PRICE.partId

WHERE SEARCH.searchNumber IN ('{$coresesNumbers__}') {$partTypeSQL}
SQL;

            // $item['priceList'] = $db->super_query($sql, true);
        }


        if (count($item['crosesList']) > 0) {
            $ResWisCros[] = $item;
        }

        $i++;


    }

    unset($rez);


    usort($ResWisCros, "cmp");


    foreach ($ResWisCros as $item) {


        $tpl2->load_template('tc/article_croses_row.tpl');
        foreach ($item['crosesList'] as $itemC) {


            if ($search and $search == $itemC) {
                $itemC = '<span class="label label-danger">' . $itemC . '</span>';
            }


            $tpl2->set('{oemNumber}', $itemC);
            if ($manuNameByCros[$itemC])
                $tpl2->set('{manuName}', '<strong>' . $manuNameByCros[$itemC] . ': </strong>');
            else  $tpl2->set('{manuName}', '');


            $tpl2->compile('croses');
        }
        $tpl->set('{croses}', $tpl2->result['croses']);
        $tpl2->clear();
        $tpl2->result['croses'] = '';


        if (count($item['priceList']) > 0) {
            $tpl2->load_template('tc/prices_row.tpl');
            $listPriceItemsId = [];

            usort($item['priceList'], "cmp2");


            foreach ($item['priceList'] as $itemP) {

                $fields = explode('||', $itemP['fields']);

                //Analogs

                foreach ($fields as $strField) {
                    $part = explode('|', $strField);
                    if ($part[0] and $part[1] and !in_array($part[0], ['price',
                                                                       'amount',
                                                                       'priceUSD'])) $itemP[$part[0]] = $part[1];
                }

                $Analogs_ = explode('||', $itemP['Analogs']);

                $Analogs = [];
                foreach ($Analogs_ as $strAnalog) {
                    $part = explode('|', $strAnalog);
                    if ($part[0] and $part[1] and $part[1] != $itemP['SALEnumber'] and !in_array($part[0], ['price',
                                                                                                            'amount',
                                                                                                            'priceUSD'])) {

                        if ($search and trim($search) == $part[1]) {
                            $part[1] = '<span class="label label-danger">' . $part[1] . '</span>';
                        }

                        $Analogs[] = <<<HTML
<li><strong>{$part[0]}</strong> {$part[1]}</li>
HTML;


                    }
                }
                if (count($Analogs)) {
                    $tpl2->set('{analogs}', implode('', $Analogs));
                } else {
                    $tpl2->set('{analogs}', '<li>нет</li>');
                }

                $tpl2->set('{Бренд турбины}', '');

                $tpl2->set('{Модель турбины}', '-');

                foreach ($itemP as $field => $value) {
                    if (gettype($value) != 'array') $tpl2->set('{' . $field . '}', $value);
                }

                $tpl2->set('{SALEnumber_alt}', totranslit(str_replace('.', '', $itemP['SALEnumber'])), true);
                $tpl2->set('{partType_alt}', totranslit($itemP['partType']), true);
                $tpl2->set('{partCat}', $libCatByName[$itemP['partType']]);
                $listPriceItemsId[] = $itemP['partId'];


                if ($itemP['price'] == 0) {

                    $tpl2->set_block("'\\[not-leftCount\\](.*?)\\[/not-leftCount\\]'si", "");

                    $tpl2->copy_template = str_replace("[leftCount]", "", $tpl2->copy_template);
                    $tpl2->copy_template = str_replace("[/leftCount]", "", $tpl2->copy_template);
                } else {
                    $tpl2->set_block("'\\[leftCount\\](.*?)\\[/leftCount\\]'si", "");

                    $tpl2->copy_template = str_replace("[not-leftCount]", "", $tpl2->copy_template);
                    $tpl2->copy_template = str_replace("[/not-leftCount]", "", $tpl2->copy_template);

                }


                $tpl2->compile('price');
            }
        }

        $tpl->set('{price}', $tpl2->result['price']);
        $tpl2->clear();
        $tpl2->result['price'] = '';


        foreach ($item as $field => $value) {
            if (gettype($value) != 'array') $tpl->set('{' . $field . '}', $value);
        }
        $tpl->set('{car_id}', $_REQUEST['car_id']);
        $tpl->compile('rows');

    }

    $tpl->set('{car_id}', $_REQUEST['car_id']);
    $tpl->clear();
    $tpl->load_template('/tc/parts.tpl');
    $tpl->set('{rows}', $tpl->result['rows']);

    $tpl->set('{car_id}', $_REQUEST['car_id']);
    $tpl->set('{manuName}', " {$Marka} ");
    $tpl->set('{modelName}', " {$Model} ");
    $tpl->set('{typeName}', " {$Modification} ");

    $tpl->set('{carYFrom}', $AutoFullInfo['carYFrom']);
    $tpl->set('{carYTo}', $AutoFullInfo['carYTo']);
    $tpl->set('{HP}', $AutoFullInfo['HP']);
    $tpl->set('{KW}', $AutoFullInfo['KW']);
    $tpl->set('{motorCode}', $AutoFullInfo['motorCode']);

    $mainResCount = count($ResWisCros) > 0 ? count($ResWisCros) : 0;

    if (count($ResWisCros) > 0) {
        $tpl->set('[tc_catalog]', '');
        $tpl->set('[/tc_catalog]', '');
    } else {
        $tpl->set_block("'\\[tc_catalog\\](.*?)\\[/tc_catalog\\]'si", '');

    }

    if ($_REQUEST['fn'] == 'search') {

        $_REQUEST['n'] = trim($_REQUEST['n']);

        $listPriceItemsId = implode(',', $listPriceItemsId);

        if ($listPriceItemsId) $listPriceItemsId = " AND PRICE.partId NOT IN ({$listPriceItemsId})";
        else $listPriceItemsId = '';

        $sql = <<<SQL
SELECT DISTINCT 

PRICE.partId,PRICE.catId, PRICE.artId, PRICE.SALEnumber, PRICE.SALEbrand, PRICE.partType, PRICE.price, PRICE.Comment, PRICE.fields as Analogs,
CATALOG.catalogId,CATALOG.fields
FROM center_price2 PRICE
LEFT JOIN center_price2_catalog CATALOG ON CATALOG.SALEnumber = PRICE.SALEnumber AND CATALOG.SALEbrand = PRICE.SALEbrand AND CATALOG.partType = PRICE.partType
LEFT JOIN center_price2_search SEARCH  ON SEARCH.partId = PRICE.partId
WHERE 	( 
 '{$_REQUEST['n']}' = REPLACE(REPLACE(PRICE.SALEnumber, '.', ''), '-', '')
OR  REPLACE(REPLACE(PRICE.fields, '.', ''), '-', '') LIKE '%{$_REQUEST['n']}%' 
OR SEARCH.searchNumber = '{$_REQUEST['n']}'
) AND PRICE.SALEnumber !='' AND PRICE.SALEnumber IS NOT NULL
{$listPriceItemsId}
SQL;
        //     $MorePriceList = $db->super_query($sql, true);

        $MorePriceListCount = count($MorePriceList) > 0 ? count($MorePriceList) : 0;


        usort($MorePriceList, "cmp2");

        if (count($MorePriceList) > 0) {
            $tpl2->load_template('tc/more_prices_row.tpl');

            foreach ($MorePriceList as $itemPr) {


                $fields = explode('||', $itemPr['fields']);

                //Analogs

                foreach ($fields as $strField) {
                    $part = explode('|', $strField);
                    if ($part[0] and $part[1]) $itemPr[$part[0]] = $part[1];
                }

                $Analogs_ = explode('||', $itemPr['Analogs']);

                $Analogs = [];
                foreach ($Analogs_ as $strAnalog) {
                    $part = explode('|', $strAnalog);
                    if ($part[0] and $part[1] and $part[1] != $itemPr['SALEnumber'] and !in_array($part[0], ['price',
                                                                                                             'amount',
                                                                                                             'priceUSD'])) {


                        if ($search and clearToSearch($search) == clearToSearch($part[1])) {
                            $part[1] = '<span class="label label-danger">' . $part[1] . '</span>';
                        }
                        $Analogs[] = <<<HTML
<li><strong>{$part[0]}</strong> {$part[1]}</li>
HTML;

                    }
                }


                if (count($Analogs)) {
                    $tpl2->set('{analogs_more}', implode(' ', $Analogs) . '');
                } else {
                    $tpl2->set('{analogs_more}', 'нет');
                }

                $tpl2->set('{Бренд турбины}', '');

                $tpl2->set('{Модель турбины}', '-');


                $tpl2->set('{partType_alt}', totranslit($itemPr['partType']), true);
                $tpl2->set('{SALEnumber_alt}', totranslit(str_replace('.', '', $itemPr['SALEnumber'])), true);


                foreach ($itemPr as $field => $value) {

                    if (in_array($field, ['SALEnumber'])) {
                        if ($search and $search == $value) {
                            $value = '<span class="label label-danger">' . $value . '</span>';
                        }
                    }

                    if (gettype($value) != 'array') $tpl2->set('{' . $field . '}', $value);
                }

                if ($itemPr['price'] == 0) {

                    $tpl2->copy_template = str_replace("[leftCount]", "", $tpl2->copy_template);
                    $tpl2->copy_template = str_replace("[/leftCount]", "", $tpl2->copy_template);

                    $tpl2->set_block("'\\[not-leftCount\\](.*?)\\[/not-leftCount\\]'si", "");
                } else {
                    $tpl2->set_block("'\\[leftCount\\](.*?)\\[/leftCount\\]'si", "");

                    $tpl2->copy_template = str_replace("[not-leftCount]", "", $tpl2->copy_template);
                    $tpl2->copy_template = str_replace("[/not-leftCount]", "", $tpl2->copy_template);
                }

                $tpl2->compile('more_prices_row');
            }

            $tpl->set('{more_prices_row}', $tpl2->result['more_prices_row']);
            $tpl2->clear();
            $tpl2->result['more_prices_row'] = '';


            $tpl->set('[more_prices]', '');
            $tpl->set('[/more_prices]', '');
        } else {
            $tpl->set_block("'\\[more_prices\\](.*?)\\[/more_prices\\]'si", '');
        }

    } else {
        $tpl->set_block("'\\[more_prices\\](.*?)\\[/more_prices\\]'si", '');
    }


    if ($mainResCount == 0 and $MorePriceList == 0) {
        $tpl->clear();

        $tpl->load_template('/info_closed.tpl');
    }


    $tpl->compile('content');


}

if ($_REQUEST['fn'] == 'getArticle') {
    $T->json = false;


    $rez = $T->getData($_REQUEST);
    $Article = $rez[0];


    $tpl->load_template('tc/article_croses_row.tpl');
    $croses = $T->getData(['fn'             => 'getArticleCross',
                           'dataSupplierId' => $Article['dataSupplierId'],
                           'articleNumber'  => $Article['articleNumber']]);
    foreach ($croses as $item) {
        foreach ($item as $field => $value) $tpl->set('{' . $field . '}', $value);
        $tpl->compile('croses');
    }
    $tpl->clear();


    $tpl->load_template('/tc/article.tpl');
    foreach ($Article as $field => $value) $tpl->set('{' . $field . '}', $value);
    $tpl->set('{croses}', $tpl->result['croses']);

    $tpl->compile('content');


}


$tpl->result['content'] = str_replace("{catpart}", $catpartPart, $tpl->result['content']);
//echo $tpl->result['content'];
//$tpl->clear();


?>