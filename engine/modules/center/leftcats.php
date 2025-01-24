<?php
$catsByParent = [];
$catsMarks = [];
$mainCats = [];
$mainCatsByAltName = [];


global $listToFilter, $subCatMarka, $subCatModel, $mainCat;

foreach ($cat_info as $catItem) {

    if ($catItem['parentid'] > 0) {
        $catsByParent[$catItem['parentid']][] = $catItem;
//        echo <<<HTML
//<option data-parentid="{$catItem['id']}" value="{$catItem['alt_name']}">{$catItem['name']}</option>
//HTML;
    }
    if ($catItem['parentid'] == 1) {
        $catsMarks[$catItem['id']] = $catItem;
    }

    if ($catItem['parentid'] == 0) {
        $mainCats[$catItem['id']] = $catItem;
        $mainCatsByAltName[$catItem['alt_name']] = $catItem;
    }


}


$mainCatReq = explode('/', $_REQUEST['category'])[0];

if ($mainCatsByAltName[$mainCatReq]) {
    $MAINCAT = $mainCatsByAltName[$mainCatReq];
}

$marksHtml = [];
foreach ($catsMarks as $markId => $catsMark) {
    $modelsHtml = [];


    foreach ($catsByParent[$markId] as $model) {
        if ($subCatModel and $subCatModel == $model['alt_name']) $modelsHtml[] = <<<HTML
            <a href="/{$MAINCAT['alt_name']}/{$catsMark['alt_name']}/{$model['alt_name']}/" class="category__sub category__sub--active">{$model['name']}</a>
HTML;
        else
            $modelsHtml[] = <<<HTML
            <a href="/{$MAINCAT['alt_name']}/{$catsMark['alt_name']}/{$model['alt_name']}/" class="category__sub">{$model['name']}</a>
HTML;
    }

    $modelsHtml = implode('', $modelsHtml);
    if ($subCatMarka and $subCatMarka == $catsMark['alt_name']) $marksHtml[] = <<<HTML
    <div class="category__list category__list--opened">
        <span class="category__cat">{$catsMark['name']}</span>
        <div class="category__subs">
        {$modelsHtml}
        </div>
    </div>
HTML;
    else
        $marksHtml[] = <<<HTML
    <div class="category__list">
        <span class="category__cat"><a  href="/{$MAINCAT['alt_name']}/{$catsMark['alt_name']}/" >{$catsMark['name']}</a></span>
        <div class="category__subs">
        {$modelsHtml}
        </div>
    </div>
HTML;


}

$marksHtml = implode('', $marksHtml);

echo <<<HTML
<div class="category__list-block">
   {$marksHtml}
</div>

<style>
.category__list .category__cat a {
    color: #000;
}
</style>

<script>
$(document).ready(function () {
    $('.category__list>.category__cat').click(function (e) {
    
        $(this).parent().toggleClass('category__list--opened');
    });
});
</script>
HTML;

$echo__ = <<<HTML
<div class="category__list-block">
    <div class="category__list">
        <span class="category__cat">Alfa Romeo</span>
    
        <div class="category__subs">
            <a href="#" class="category__sub">80</a>
            <a href="#" class="category__sub">Allroad</a>
            <a href="#" class="category__sub">A1 / S1</a>
            <a href="#" class="category__sub">A2 / S2 / RS2</a>
            <a href="#" class="category__sub">A3 / S3 / RS3</a>
            <a href="#" class="category__sub">A4 / S4 / RS4</a>
            <a href="#" class="category__sub">A5 / S5</a>
            <a href="#" class="category__sub">A6 / S6/ RS6</a>
            <a href="#" class="category__sub">A7</a>
        </div>
    </div>
    <!-- Add class "category__list--opened" to the opened block -->
    <div class="category__list category__list--opened">
        <span class="category__cat">Audi</span>
    
        <div class="category__subs">
            <a href="#" class="category__sub">80</a>
            <!-- Add class "category__sub--active" for active element like below -->
            <a href="#" class="category__sub category__sub--active">Allroad</a>
            <a href="#" class="category__sub">A1 / S1</a>
            <a href="#" class="category__sub">A2 / S2 / RS2</a>
            <a href="#" class="category__sub">A3 / S3 / RS3</a>
            <a href="#" class="category__sub">A4 / S4 / RS4</a>
            <a href="#" class="category__sub">A5 / S5</a>
            <a href="#" class="category__sub">A6 / S6/ RS6</a>
            <a href="#" class="category__sub">A7</a>
        </div>
    </div>
    <div class="category__list">
        <span class="category__cat">Bentley</span>
    
        <div class="category__subs">
            <a href="#" class="category__sub">80</a>
            <a href="#" class="category__sub">Allroad</a>
            <a href="#" class="category__sub">A1 / S1</a>
            <a href="#" class="category__sub">A2 / S2 / RS2</a>
            <a href="#" class="category__sub">A3 / S3 / RS3</a>
            <a href="#" class="category__sub">A4 / S4 / RS4</a>
            <a href="#" class="category__sub">A5 / S5</a>
            <a href="#" class="category__sub">A6 / S6/ RS6</a>
            <a href="#" class="category__sub">A7</a>
        </div>
    </div>
    <div class="category__list">
        <span class="category__cat">BMW</span>
    
        <div class="category__subs">
            <a href="#" class="category__sub">80</a>
            <a href="#" class="category__sub">Allroad</a>
            <a href="#" class="category__sub">A1 / S1</a>
            <a href="#" class="category__sub">A2 / S2 / RS2</a>
            <a href="#" class="category__sub">A3 / S3 / RS3</a>
            <a href="#" class="category__sub">A4 / S4 / RS4</a>
            <a href="#" class="category__sub">A5 / S5</a>
            <a href="#" class="category__sub">A6 / S6/ RS6</a>
            <a href="#" class="category__sub">A7</a>
        </div>
    </div>
    <div class="category__list">
        <span class="category__cat">Cadillac</span>
    
        <div class="category__subs">
            <a href="#" class="category__sub">80</a>
            <a href="#" class="category__sub">Allroad</a>
            <a href="#" class="category__sub">A1 / S1</a>
            <a href="#" class="category__sub">A2 / S2 / RS2</a>
            <a href="#" class="category__sub">A3 / S3 / RS3</a>
            <a href="#" class="category__sub">A4 / S4 / RS4</a>
            <a href="#" class="category__sub">A5 / S5</a>
            <a href="#" class="category__sub">A6 / S6/ RS6</a>
            <a href="#" class="category__sub">A7</a>
        </div>
    </div>
    <div class="category__list">
        <span class="category__cat">Case</span>
    
        <div class="category__subs">
            <a href="#" class="category__sub">80</a>
            <a href="#" class="category__sub">Allroad</a>
            <a href="#" class="category__sub">A1 / S1</a>
            <a href="#" class="category__sub">A2 / S2 / RS2</a>
            <a href="#" class="category__sub">A3 / S3 / RS3</a>
            <a href="#" class="category__sub">A4 / S4 / RS4</a>
            <a href="#" class="category__sub">A5 / S5</a>
            <a href="#" class="category__sub">A6 / S6/ RS6</a>
            <a href="#" class="category__sub">A7</a>
        </div>
    </div>
</div>
HTML;
