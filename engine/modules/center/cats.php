<?php


foreach ($cat_info as $catItem) {

    if ($catItem['parentid'] == 1) {

        echo <<<HTML
<option data-parentid="{$catItem['id']}" value="{$catItem['alt_name']}">{$catItem['name']}</option>
HTML;


    }

}
