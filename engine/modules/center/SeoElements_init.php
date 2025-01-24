<?php


ini_set('display_errors', 0);
ini_set('error_reporting', 0);
//banner_seo_tpl_level_1
global $Title, $Description, $H1, $SeoText, $Marka, $Model, $Modification, $AutoFullInfo, $cat_info, $page_auto_type;


if ($_REQUEST['do'] == 'catalog_auto') {
    // var_dump($AutoFullInfo);
    // exit();
}

if (!$AutoFullInfo)
    $AutoFullInfo = ["manuName" => $Marka, "modelName" => $Model];


$targetBaners = [
    'makes'         => 'seo_tpl_level_1',
    'models'        => 'seo_tpl_level_2',
    'generation'    => 'seo_tpl_level_3',
    'configuration' => 'seo_tpl_level_4',
    'modification'  => 'seo_tpl_level_5',
    'auto_full'     => 'seo_tpl_level_6'
];


$banners_ = get_vars('banners');
$bannersF = [];
foreach ($banners_ as $banner)
    $bannersF[$banner['banner_tag']] = $banner;


$City = false;
$city_ = 'c_moskva';
if (isset($_REQUEST['city']))
    $city_ = $_REQUEST['city'];

$arrCity = [];
$arrCityrow_ = explode(PHP_EOL, $bannersF['seo_city']['code']);

foreach ($arrCityrow_ as $row) {
    $cityParts = explode('|', $row);
    $arrCity[$cityParts[0]]['alt'] = '';
    if ($cityParts[0] != 'moskva')
        $arrCity[$cityParts[0]]['alt'] = '' . $cityParts[0] . '/';


    $arrCity[$cityParts[0]]['I'] = $cityParts[1];
    $arrCity[$cityParts[0]]['R'] = $cityParts[2];
    $arrCity[$cityParts[0]]['D'] = $cityParts[3];
    $arrCity[$cityParts[0]]['P'] = $cityParts[4];
}

if (isset($arrCity[$city_]))
    $City = $arrCity[$city_];

$targetBaner = $targetBaners[$page_auto_type];


//if ($do_ != 'main') {
$arrParts = explode(PHP_EOL, $bannersF[$targetBaner]['code']);

$Title = str_replace('Title:', '', $arrParts[0]);
$Description = str_replace('Description:', '', $arrParts[1]);
$H1 = str_replace('H1:', '', $arrParts[2]);

//} else {
//    $Title = str_replace("&#123;", '{', str_replace("&#125;", '}', $metatags['title']));;
//    $Description = str_replace("&#123;", '{', str_replace("&#125;", '}', $metatags['description']));;
//}


foreach ($AutoFullInfo as $field => $value) {
    $Title = str_replace("{{$field}}", $value, $Title);
    $Description = str_replace("{{$field}}", $value, $Description);
    $H1 = str_replace("{{$field}}", $value, $H1);
}

foreach ($City as $suf => $val) {
    $SeoText = str_replace("{city_{$suf}}", $val, $SeoText);
    $H1 = str_replace("{city_{$suf}}", $val, $H1);
    $Title = str_replace("{city_{$suf}}", $val, $Title);
    $Description = str_replace("{city_{$suf}}", $val, $Description);
}


$Title = mb_ucfirst('' . $Title);
$Description = mb_ucfirst($Description);
$H1 = mb_ucfirst($H1) . '';


