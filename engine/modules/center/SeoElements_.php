<?php
if ($show) {
    global $catsByAltName, $subCatMarka, $subCatModel, $mainCat;

    if ($cat_info[$category_id][$show] AND $show != 'h1' AND $show != 'speedbar') {
        echo $cat_info[$category_id][$show];
    }
    else if ($show == 'seotext') {
        //echo var_dump($cat_info[$category_id][$mainCat]);
        //exit();


        if ($cat_info[$category_id][$mainCat] AND !isset($_REQUEST['cstart'])) {


            echo <<<HTML
<section class="page-text ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-title hidden"></h2>
                <div class="text">
                   {$cat_info[$category_id][$mainCat]}
                </div>
            </div>
        </div>
    </div>
</section>
HTML;

        }
    }
    else if ($show == 'h1') {
        if ($subCatMarka and !$subCatModel) {
            echo <<<TEXT
{$catsByAltName[$mainCat]['name']} для всех моделей {$catsByAltName[$subCatMarka]['name']}
TEXT;
        }
        else if ($subCatMarka and $subCatModel) {
            echo <<<TEXT
{$catsByAltName[$mainCat]['name']} для {$catsByAltName[$subCatMarka]['name']} {$catsByAltName[$subCatModel]['name']}
TEXT;
        }
        else {
            echo <<<TEXT
{$cat_info[$category_id]['name']}
TEXT;
        }
    }
    else if ($show == 'speedbar') {

        global $catsByAltName, $subCatMarka, $subCatModel, $mainCat, $row;

        //  var_dump($catsByAltName[$row['catAltName']]['name'], $row);

        if (isset($_REQUEST['newsid'])) {
            //{catName} {TurbinaNumber} {autoName} {dvigNumber} {dvigPV}
            echo <<<TEXT
<li class="breads__item"><a href="/">Главная</a></li>/
<li class="breads__item"><a href="/{$catsByAltName[$row['catAltName']]['alt_name']}/">{$catsByAltName[$row['catAltName']]['name']}</a></li>/
<li class="breads__item">{$row['catName']} {$row['TurbinaNumber']} {$row['autoName']} {$row['dvigNumber']} {$row['dvigPV']}</li>/
TEXT;
        }
        else {
            if (!$subCatMarka and !$subCatModel AND $mainCat) {
                echo <<<TEXT
<li class="breads__item"><a href="/">Главная</a></li>/
<li class="breads__item">{$catsByAltName[$mainCat]['name']}</li>
TEXT;
            }
            else if ($subCatMarka and !$subCatModel) {
                echo <<<TEXT
<li class="breads__item"><a href="/">Главная</a></li>/
<li class="breads__item"><a href="/{$catsByAltName[$mainCat]['alt_name']}/">{$catsByAltName[$mainCat]['name']}</a></li>/
<li class="breads__item">{$catsByAltName[$subCatMarka]['name']}</li>
TEXT;
            }
            else if ($subCatMarka and $subCatModel) {
                echo <<<TEXT
<li class="breads__item"><a href="/">Главная</a></li>/
<li class="breads__item"><a href="/{$catsByAltName[$mainCat]['alt_name']}/">{$catsByAltName[$mainCat]['name']}</a></li>/
<li class="breads__item"><a href="/{$catsByAltName[$mainCat]['alt_name']}/{$catsByAltName[$subCatMarka]['alt_name']}/">{$catsByAltName[$subCatMarka]['name']}</a></li>/
<li class="breads__item">{$catsByAltName[$subCatModel]['name']}</li>
TEXT;
            }
            else {
                echo <<<TEXT
{$cat_info[$category_id]['name']}
TEXT;
            }
        }


    }

}
else {
    echo $cat_info[$category_id]['name'];
}