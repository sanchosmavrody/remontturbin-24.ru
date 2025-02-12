<!-- Sticky Navbar -->
<div class="page-header">
    <div class="container">
        <h1 class="title">{include file="engine/modules/center/SeoElements.php?show=h1"}</h1>
    </div>
    <div class="breadcrumb-box">
        <div class="container">
            <ul class="breadcrumb">
                {include file="engine/modules/center/SeoElements.php?show=speedbar"}
            </ul>
        </div>
    </div>
</div>


<style>
    #mainLand > .section-title h2 {
        margin: 30px 0 12px;
    }

    .thumb-wrap {
        position: relative;
        padding-bottom: 56.25%; /* задаёт высоту контейнера для 16:9 (если 4:3 — поставьте 75%) */
        height: 0;
        overflow: hidden;
    }

    .thumb-wrap iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-width: 0;
        outline-width: 0;
    }

    #mainLand .ctx thead th {
        border-bottom: 2px solid #faac3d;
        color: #1e1e1e;
        font-size: 28px;
        font-weight: normal;
        line-height: 1.3;
        text-transform: uppercase;
        margin: 1px 10px 14px;

        font-family: Oswald, sans-serif;
        padding: 0px 5px 11px;
    }

    .result__table {
        position: relative;
    }

    .result__item:first-child {
        margin-top: 0;
    }

    .result__item {
        box-shadow: 0px 5px 20px rgb(0 0 0 / 5%);
        margin-top: 16px;
        display: -ms-flexbox;
        display: flex;
    }

    .result__item_n {
        box-shadow: 0px 5px 20px rgb(0 0 0 / 5%);

    }

    .result__ava {
        -ms-flex-negative: 0;
        flex-shrink: 0;
        width: 11.5%;
        display: -ms-flexbox;
        display: flex;
    }

    .result__ava a {
        display: block;
        max-width: 65px;
        margin: auto;
    }

    .result__ava a img {
        max-width: 100%;
    }

    .result__info {
        background: #F8F8F8;
        width: 23.5%;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        padding: 12px 16px;
        cursor: pointer;
    }

    .result__info_n {
        background: #F8F8F8;

        padding: 12px 16px;
        cursor: pointer;
    }

    .result__type {
        margin-top: 8px;
        font-family: "Museo Sans 500 Medium", sans-serif;
        font-size: 14px;
        line-height: 17px;
    }

    .result__type span {
        color: #FAAC3D;
        font-family: "Museo Sans 900 Black", sans-serif;
    }

    .result__mark {
        font-family: "Museo Sans 300 Light", sans-serif;
        font-size: 12px;
        line-height: 14px;
    }

    .result__name {
        font-family: "Museo Sans 700 Bold", sans-serif;
        font-size: 18px;
        line-height: 22px;
        color: black;
        transition: 0.3s;
    }

    .result__similar {
        -ms-flex-negative: 0;
        flex-shrink: 0;
        width: 29.6%;
        padding: 14px 50px 12px 65px;
        cursor: pointer;
    }

    .result__similar-list {
        list-style: none;
        margin: 3px 0 0;
        padding: 0;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }

    .result__similar-list li {
        width: 49%;
        margin-top: 5px;
        font-family: "Museo Sans 300 Light", sans-serif;
        font-size: 12px;
        line-height: 14px;
    }

    .result__price-wrap {
        width: 145px;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        display: -ms-flexbox;
        display: flex;
        align-self: center;
        position: relative;
    }

    .result__price-block {
        margin: 0px auto;
    }

    .result__price {
        margin-top: 5px;
        font-family: "Museo Sans 700 Bold", sans-serif;
        font-size: 18px;
        line-height: 22px;
    }

    .result__price-label {
        font-size: 10px;
        line-height: 12px;
    }

    .result__count {
        -ms-flex-item-align: center;
        align-self: center;
        margin-top: 4px;
    }

    .result__similar-title {
        font-family: "Museo Sans 500 Medium", sans-serif;
        font-size: 14px;
        line-height: 17px;
    }

    .result__count-price {
        display: -ms-flexbox;
        display: flex;
        border-left: 1px solid #B1B1B1;
        margin: 13px 0 10px;
    }

    .result__button {
        height: 40px;
        -ms-flex-item-align: center;
        align-self: center;
        width: 125px;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        margin: 0 16px 0 auto;
    }

    .orange-button {
        background: #FAAC3D;
        color: white;
        display: block;
        border: 0;
        text-align: center;
        line-height: 42px;
        border-radius: 40px;
        width: 185px;
        transition: 0.3s;
        font-size: 16px;
    }

</style>

<script>
    // отрабатывает при загрузке страницы
    dataLayer.push({
        "ecommerce": {
            "currencyCode": "RUB",
            "detail": {
                "products": [
                    {
                        "id": "{car_id}",
                        "name" : "Ремонт турбин  {manuName} {modelName} {typeName} {motorCode} {HP}л.с.({KW}кВт)",
                        "price": "2500",
                        "brand": "{manuName}",
                        "category": "Ремонт турбин/{manuName}/{modelName} {carYFrom} {carYTo} - произв."
                    }
                ]
            }
        }
    });

    //ждём загрузки документа
    $( document ).ready(function() {
//слушатель на нанажатие кнопки
        $( ".result__button " ).click(function() {

//#############
            dataLayer.push({
                "ecommerce": {
                    "currencyCode": "RUB",
                    "add": {
                        "products": [
                            {
                                "id": "{car_id}",
                                "name" : "Ремонт турбин  {manuName} {modelName} {typeName} {motorCode} {HP}л.с.({KW}кВт)",
                                "price": "2500",
                                "brand": "{manuName}",
                                "category": "Ремонт турбин/{manuName}/{modelName} {carYFrom} {carYTo} - произв."
                            }
                        ]
                    }
                }
            });
//#############

        });

    });
</script>


<!-- page-header -->
<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-9 pull-right product-page" id="mainLand">


                Подберите турбину, которая установлена в вашем {manuName} {modelName} {typeName} и запишитесь на
                диагностику или
                на ремонт турбины.
                Стоимость ремонта уточните у нашего менеджера по телефону
                <b> <a style="" href="tel:+7 (495) 374-90-24" data-phone="+7 (495) 374-90-24" class="hdn">
                        +7 (495) 374
                        <span style="">показать</span>
                    </a>
                </b>
                или можете самостоятельно ознакомиться с ценами
                <b> <a href="#accordion">тут</a></b>.
                <br><br><br>

                [group=13]

                <div class="result__table" style="display: block">
                    <div class="result__item">
                        <div class="result__ava open-photo">
                            <a>
                                <img src="https://ee-turbosklad.ru/templates/Full/img/result-img.png" alt="">
                            </a>
                        </div>
                        <div class="result__info">

                            <a href="/1233-k03-015_kartridzh-turbiny/" class="result__name">Картридж турбины</a>

                            <p class="result__type">E&amp;E Turbos:
                                <span>K03-015</span>
                            </p>

                            <p class="result__mark" style="padding: 7px 0px 0px;"><b>Модель турбины:</b>
                                K03
                            </p>

                        </div>
                        <div class="result__similar" style="padding: 14px 10px 12px 25px;">
                            <p class="result__similar-title">Аналоги</p>

                            <ul class="result__similar-list">
                                <li><strong>AM:</strong> AM.K03-14</li>
                                <li><strong>CHRA:</strong> 070-130-029</li>
                                <li><strong>JRONE:</strong> 1000-030-144,</li>
                                <li><strong>Krauf:</strong> MCT0245BE, MCT0245TC</li>
                                <li><strong>Mellet:</strong> 1302003915</li>
                                <li><strong>KKK:</strong> 53037100515</li>
                                <li><strong>Powertec:</strong> 703245-0001</li>
                                <li><strong>SL Turbo:</strong> 738123-0003</li>
                                <li><strong>KD:</strong> KD 0245</li>
                                <li><strong>Meat&amp;Doria:</strong> 60040</li>

                            </ul>
                        </div>

                        <button class="orange-button result__button add-to-cart" data-price="5412" data-count="1"
                                data-itemid="1233" data-aid="{aId}" data-maincat="{catNameAltName}">
                            <span class="in">Записаться</span>
                        </button>
                    </div>


                </div>
                <div class="row result__table_n">
                    <div class="col-md-12  result__item_n">
                        <div class="row">
                            <div class="col-md-1 hidden-sm">
                                <img style="width: 100%"
                                     src="https://ee-turbosklad.ru/templates/Full/img/result-img.png"
                                     alt=""></div>
                            <div class="col-md-3">
                                <div class="result__info_n">
                                    <a href="" class="result__name">Картридж турбины</a>
                                    <p class="result__type">E&amp;E Turbos:
                                        <span>K03-015</span>
                                    </p>
                                    <p class="result__mark" style="padding: 7px 0px 0px;"><b>Модель турбины:</b>
                                        K03
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-5 result__similar_n">
                                <p class="result__similar-title">Аналоги</p>

                                <ul class="result__similar-list">
                                    <li><strong>AM:</strong> AM.K03-14</li>
                                    <li><strong>CHRA:</strong> 070-130-029</li>
                                    <li><strong>JRONE:</strong> 1000-030-144,</li>
                                    <li><strong>Krauf:</strong> MCT0245BE, MCT0245TC</li>
                                    <li><strong>Mellet:</strong> 1302003915</li>
                                    <li><strong>KKK:</strong> 53037100515</li>
                                    <li><strong>Powertec:</strong> 703245-0001</li>
                                    <li><strong>SL Turbo:</strong> 738123-0003</li>
                                    <li><strong>KD:</strong> KD 0245</li>
                                    <li><strong>Meat&amp;Doria:</strong> 60040</li>

                                </ul>
                            </div>
                            <div class="col-md-3">
                                <button class="orange-button result__button add-to-cart" data-price="5412"
                                        data-count="1"
                                        data-itemid="1233" data-aid="{aId}" data-maincat="{catNameAltName}">
                                    <span class="in">Записаться</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                [/group]


                [tc_catalog]


                <div class="row result__table_n">
                    {rows}

                </div>


                [/tc_catalog]


                {include file="modules/content_main_block_1.tpl"}
                {include file="modules/content_main_block_2.tpl"}
                {include file="modules/content_main_block_3.tpl"}
                {include file="modules/content_main_block_4.tpl"}
                {include file="modules/content_main_block_5.tpl"}
                {include file="modules/content_main_block_6.tpl"}
                {include file="modules/content_main_block_7.tpl"}
                {include file="modules/content_main_block_8.tpl"}
                {include file="modules/content_main_block_9.tpl"}
                {include file="modules/content_main_block_10.tpl"}
                {include file="modules/content_main_block_11.tpl"}
                {include file="modules/content_main_block_12.tpl"}
                {include file="modules/content_main_block_13.tpl"}
                {include file="modules/content_main_block_14.tpl"}
                {include file="modules/content_main_block_15.tpl"}


            </div>
            <div id="sidebarCars" style="float: left" class="sidebar col-sm-12 col-md-3">

                <div class="widget">
                    <div class="widget-title" style="border-bottom: 2px solid #faac3d;">
                        <h3 class="title" style="font-size: 28px;">Марка и модель авто</h3>
                    </div>
                    <div id="MainMenu2">
                        <div class="list-group panel">
                            <div class="collapse in" id="demo3">
                                {include file="/engine/modules/center/autoTree_v2.php"}
                            </div>
                        </div>
                    </div>
                    <style>
                        .list-group-item span {
                            width: 100%;
                            display: inline-block;
                        }

                        .list-group-item {
                            line-height: 1;
                        }
                    </style>
                    <!-- category-list -->
                </div>

            </div>
        </div>

    </div>
</section>


<style>

    @media screen and (max-width: 575px) {
        .fl_c {
            flex-direction: column;
        }

        .fl_2 {
            flex: initial;
        }
    }

    .fl_c {

        display: flex; /* flex || inline-flex */
        flex-wrap: unset;
    }

    .fl_1 {
        flex: 0 0 80px;
    }

    .fl_2 {
        flex: 0 0 220px;
    }

    .fl_3 {
        flex-grow: 1;
    }

    .fl_4 {
        flex-grow: 1;
    }


</style>



