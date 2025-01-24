<?php
require_once ROOT_DIR . '/engine/modules/center/SeoElements_init.php';


if (!isset($City)) {

    global $City, $arrCity, $city_;
}


if (isset($arrCity[$city_]))
    $City = $arrCity[$city_];
foreach ($arrCity as $suf => $City_) {


    $arrByI[$City_['I']] = $City_;
}


ksort($arrByI);

$groupByFirstChar = [];
foreach ($arrByI as $I => $City_) {
    $groupByFirstChar[mb_substr($I, 0, 1)][] = $City_;
}
$s = '';
$echo = '';
foreach ($groupByFirstChar as $firstChar => $CityList) {

    $echo .= <<<HTML
<p class="cities_letter">{$firstChar}</p>
<ul class="cities_page">
HTML;
    foreach ($CityList as $City_) {
        $echo .= <<<HTML
<li><a href="/{$City_{'alt'}}" target="_blank">{$City_{'I'}}</a></li>
HTML;


        $s .= <<<XML
	<url>
		<loc>https://ee-turbosklad.ru/{$City_{'alt'}}/</loc>
		<lastmod>2021-02-10</lastmod>
		<priority>0.5</priority>
	</url>
XML;

    }

    $echo .= '</ul>';
}


echo <<<HTML


          <a id="cityModalBTN" type="button" class="" data-toggle="modal"
                   data-target="#cityModal">
                    выбрать город: <b>Москва</b> <i class="fa fa-map"></i>
                </a>
<style>

.modal-body{

}
#cityModalBTN{
cursor: pointer;
}

#cityModal a {
    color: #171717;
}

.modal-backdrop {
       z-index: 9999;}
       
       .modal.fade.in{
           z-index: 99999;
       }

    .cities_letter {
        text-align: left;
        font-size: 30px !important;
        color: #faac3d;
    }

    .cities_page {
        margin: 0 0 10px;
        padding: 0;
        list-style: none;
       column-count: 2;
    }

    @media (max-width: 767px) {
        .cities_page {
            column-count: 1;
    
        }
      #cityModalBTN{ margin-top: 15px;}
    }

</style>


<div id="cityModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Список городов</h4>
      </div>
      <div class="modal-body">
      <ul class="cities_page">
      {$echo}</ul>
    
      </div>
   
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
HTML;
