<?php
global $listToFilter, $catsByAltName, $subCatMarka, $subCatModel, $mainCat;
if (!function_exists('array_sort')) {
    function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = [];
        $sortable_array = [];

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                }
                else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
}


$cat_info = array_sort($cat_info, 'name', SORT_ASC);

foreach ($cat_info as $catItem) {
    if ($subCatMarka and $catsByAltName[$subCatMarka]['id'] == $catItem['id']) $selected = ' selected ="selected" ';
    else
        $selected = '';

    if ($catItem['parentid'] == 1) {
        $marks .= <<<HTML
<option {$selected} data-parentid="{$catItem['id']}" value="{$catItem['alt_name']}">{$catItem['name']}</option>
HTML;
    }

    if ($subCatMarka AND $catItem['parentid'] == $catsByAltName[$subCatMarka]['id']) {
        if ($subCatModel and $catsByAltName[$subCatModel]['id'] == $catItem['id']) $selected = ' selected ="selected" ';
        else $selected = '';
        $models .= <<<HTML
<option {$selected} data-parentid="{$catItem['id']}" value="{$catItem['alt_name']}">{$catItem['name']}</option>
HTML;

        $modelsTopFilterIMG .= <<<HTML
<div class="cars__item">
    <div class="cars__cover" style="background-image:url(/uploads/cats_img/{$catItem['id']}.svg)"></div>
    <a title="{$catItem['id']} {$catItem['name']}" href="/{$mainCat}/{$subCatMarka}/{$catItem['alt_name']}/" class="cars__link">{$catItem['name']}</a>
</div>
HTML;

    }


}

$formUrl = '';
if ($subCatMarka) $formUrl = '/' . $mainCat . '/' . $subCatMarka . '/';
if ($subCatModel) $formUrl = '/' . $mainCat . '/' . $subCatMarka . '/' . $subCatModel . '/';

if ($_REQUEST['actF']) {
    //modif dvigNumber dvigPV  marka

    if ($_REQUEST['modif']) $whereSubCat = "AND  A.aId IN ({$_REQUEST['modif']})";
    if ($_REQUEST['dvigNumber']) $whereSubCat = "AND  A.dvigNumber = '{$_REQUEST['dvigNumber']}'";
    if ($_REQUEST['dvigPV']) $whereSubCat = "AND  A.dvigPV = '{$_REQUEST['dvigPV']}'";

}


foreach ($listToFilter['autoName'] as $value => $aIdList) {
    $selected = '';
    $aIdList = implode(',', $aIdList);
    if ($_REQUEST['modif'] and $_REQUEST['modif'] == $aIdList) $selected = ' selected ="selected" ';

    $modif .= <<<HTML
<option {$selected} data-aid="{$aIdList}" value="{$aIdList}">{$value}</option>
HTML;
}

foreach ($listToFilter['dvigNumber'] as $value => $aIdList) {
    $selected = '';
    if ($_REQUEST['dvigNumber'] and $_REQUEST['dvigNumber'] == $value) $selected = ' selected ="selected" ';
    $aIdList = implode(',', $aIdList);
    $dvigNumber .= <<<HTML
<option {$selected} data-aid="{$aIdList}" value="{$value}">{$value}</option>
HTML;
}

foreach ($listToFilter['dvigPV'] as $value => $aIdList) {
    $selected = '';
    if ($_REQUEST['dvigPV'] and $_REQUEST['dvigPV'] == $value) $selected = ' selected ="selected" ';
    $aIdList = implode(',', $aIdList);
    $dvigPV .= <<<HTML
<option {$selected} data-aid="{$aIdList}" value="{$value}">{$value}</option>
HTML;
}


if (!$show) echo <<<HTML

<form data-maincat="{$mainCat}" id="topFormSearch" method="post" action="{$formUrl}" >
<div class="category__top-filter">
    
    <select name="marka" id="marka" class="category__select">
        <option value="0">Марка автомобиля</option>
        {$marks}
    </select>

    <select id="modelA"  class="category__select">
        <option value="0">Модель авто</option>
        {$models}
    </select>

    <select name="modif" id="modif"  class="category__select">
        <option value="0">Модификация авто</option>
        {$modif}
    </select>

    <select name="dvigNumber" id="dvigNumber" class="category__select">
        <option value="0">Модель двигателя</option>
        {$dvigNumber}
    </select>

    <select name="dvigPV" id="dvigPV" class="category__select ">
        <option value="0">Объём/мощность двигателя</option>
    {$dvigPV}
    </select>


    <div class="category__button-wrap">
      <button type="submit" name="actF"   value="0"  class="grey-button" >Сбросить</button>
      <button type="submit" name="actF" value="1" class="orange-button" >Применить</button>
   </div>
</div>
</form>

<script>
$(document).ready(function () {
    $('#marka').change(function (e) {
            if($('#marka').val()!='0')
        $('#topFormSearch').attr('action','/'+ $('#topFormSearch').data('maincat')+'/'+$('#marka').val()+'/');
                      if($('#marka').val()=='0' && $('#modelA').val()=='0')
        $('#topFormSearch').attr('action','/'+ $('#topFormSearch').data('maincat')+'/');
    });
     $('#modelA').change(function (e) {
           if($('#marka').val()!='0' && $('#modelA').val()!='0')
        $('#topFormSearch').attr('action','/'+ $('#topFormSearch').data('maincat')+'/'+$('#marka').val()+'/'+$('#modelA').val()+'/');
           
              if($('#marka').val()!='0' && $('#modelA').val()=='0')
        $('#topFormSearch').attr('action','/'+ $('#topFormSearch').data('maincat')+'/'+$('#marka').val()+'/');
              
               if($('#marka').val()=='0' && $('#modelA').val()=='0')
        $('#topFormSearch').attr('action','/'+ $('#topFormSearch').data('maincat')+'/');
    });
});
</script>
HTML;
else if ($show == 'models' AND $subCatMarka and !$subCatModel) {
    echo <<<HTML
<section id="s2" class="page-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cars">
                {$modelsTopFilterIMG}
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    #s1 {
       background: #fff;
    }
</style>

HTML;


}
else if ($show == 'models' AND ($subCatMarka and $subCatModel)) {

    echo <<<HTML
    <style>
    .category__top-filter {
        margin-top: 0px;

    }
</style>
HTML;

}