<div class="page-header">
    <div class="container">
        <h1 class="title">
            {description}
        </h1>

    </div>
    <div class="breadcrumb-box">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breads__item"><a href="/">Главная</a></li>
                <li class="breads__item">{description}</li>
            </ul>
        </div>
    </div>
</div>

[group=13]
<section class="map-wrapp">
    <div id="map" style="height: 515px;"></div>
</section>

<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script>

<script>
    $(document).ready(function () {

        function init() {


            var myMap = new ymaps.Map("map", {
                center: [55.814259, 37.688351]
                , zoom: 16
                , controls: ['zoomControl']
            });


            myMap.behaviors.disable('multiTouch');
            myMap.behaviors.disable('scrollZoom');
            var myGeoObjects = [];
            var flag_for_center = true;


            $(".one-adr").each(function (e) {
                var latt = $(this).attr("data-lat");
                var longg = $(this).attr("data-lon");
                if (flag_for_center) {
                    myMap.setCenter([latt, longg], 16, {
                        checkZoomRange: false
                    });
                    flag_for_center = false;
                }
                myGeoObjects[e] = new ymaps.Placemark([latt, longg], {
                    clusterCaption: 'Р—Р°РіРѕР»РѕРІРѕРє'
                }, {
                    iconLayout: 'default#image'
                    , iconImageHref: '/img/mark-map.png'
                    , iconImageSize: [113, 122]
                    , iconImageOffset: [-53.5, -85]
                });
            });


            var clusterIcons = [{
                href: 'img/marker-1.png'
                , size: [76, 70]
                , offset: [0, 0]
            }];


            var clusterer = new ymaps.Clusterer({
                clusterDisableClickZoom: false
                , clusterOpenBalloonOnClick: false
                , clusterBalloonPanelMaxMapArea: 0
                , clusterBalloonContentLayoutWidth: 300
                , clusterBalloonContentLayoutHeight: 200
                , clusterBalloonPagerSize: 2
                , clusterBalloonPagerVisible: false
            });


            clusterer.add(myGeoObjects);
            myMap.geoObjects.add(clusterer);


            $('.look-at-map').click(function () {
                myMap.setCenter(
                    [parseFloat($(this).parents(".adr").attr("data-lat"))
                        , parseFloat($(this).parents(".adr").attr("data-lon"))], 16, {
                        checkZoomRange: false
                    });
            });


            $('.one-adr').click(function () {
                myMap.setCenter(
                    [parseFloat($(this).attr("data-lat"))
                        , parseFloat($(this).attr("data-lon"))], 16, {
                        checkZoomRange: false
                    });
            });


        }


        ymaps.ready(init);


    });

</script>

<section class="in-cat-main-wrapp sm-style-padd">

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="one-adr" data-lat="55.814259" data-lon="37.688351">
                    <p class="some-tt">Мы находимся по адресу:</p>
                    <p class="adr">г. Москва, ул. Краснобогатырская, дом 2, стр. 26</p>
                    <p class="metro">метро ВДНХ, Преображенская площадь и Белокаменная</p>
                </div>
            </div>
            <div class="col-md-4">
                <a href="mailto:air_turbo@mail.ru" class="mail-wr">air_turbo@mail.ru</a>
            </div>
            <div class="col-md-4">
                <div class="tel-and-modal">
                    <p>Ежедневно с 9:00 до 21:00</p>
                    <a href="tel:+7 (495) 374-90-24" data-phone="+7 (495) 374-90-24" class="hdn_ phone_alloka">+7 (495) 374-90-24
                        <span style="font-size: 20px; display: none">показать</span>
                    </a>
                    <p class="phone_city">г. Москва</p>

                </div>
            </div>

        </div>
    </div>


    <section class="form-send-wrapp sm-style-padd high_lines">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="lines">
                        <div class="line line-1"></div>
                        <div class="line line-2"></div>
                        <div class="line line-3"></div>
                        <div class="line line-4"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row flex-row-form">
                <div class="col-md-6">
                    <div class="left-side">
                        <h6>МЫ ПРОИЗВОДИМ РЕМОНТ ТУРБИН «ПОД КЛЮЧ»</h6>
                        <p class="second-text">просто пригоните нам свой автомобиль и доверьтесь профессионализму наших
                                               мастеров!</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="buy_form_wrap">
                        <script id="bx24_form_inline" data-skip-moving="true">
                            (function (w, d, u, b){w['Bitrix24FormObject']=b;w[b] = w[b] || function(){arguments[0].ref=u;
                            (w[b].forms=w[b].forms||[]).push(arguments[0])};
                                    if(w[b]['forms']) return;
                                    var s=d.createElement('script');s.async=1;s.src=u+'?'+(1*new Date());
                                    var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
                                    })(window, document, 'https://rt24.bitrix24.ru/bitrix/js/crm/form_loader.js', 'b24form');

                            b24form({"id":"14","lang":"ru","sec":"7y76vz","type":"inline"});
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

[/group]
<section id="contact-us" class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 contact-info">
                <div class="row text-center">

                    <address class="col-sm-4 col-md-4">
                        <i class="fa fa-microphone i-9x icons-circle text-color light-bg hover-black"
                           style="color: #ffc400;"></i>
                        <div class="title">Ежедневно с 9:00 до 21:00</div>
                        <div>

                            <a href="tel:+7 (495) 374-90-24" data-phone="+7 (495) 374-90-24" class="hdn_ phone_alloka">+7 (495) 374-90-24
                                <span style="font-size: 20px; display: none">показать</span>
                            </a>
                        </div>
                    </address>
                    <address class="col-sm-4 col-md-4">
                        <i class="fa fa-map-marker i-9x icons-circle text-color light-bg hover-black"
                           style="color: #ffc400;"></i>
                        <div class="title">Мы находимся по адресу:</div>
                        <div class="one-adr" data-lat="55.814259" data-lon="37.688351">

                            <p class="adr">г. Москва, ул. Краснобогатырская, дом 2, стр. 26</p>

                        </div>
                    </address>
                    <address class="col-sm-4 col-md-4">
                        <i class="fa fa-envelope i-9x icons-circle text-color light-bg hover-black"
                           style="color: #ffc400;"></i>
                        <div class="title">Email:</div>
                        <div><a href="mailto:air_turbo@mail.ru" class="mail-wr">air_turbo@mail.ru</a></div>
                    </address>
                </div>
            </div>
        </div>
        <hr class="pad-10">
        <div class="row">
            <div class="col-md-4">
                <h6>МЫ ПРОИЗВОДИМ РЕМОНТ ТУРБИН «ПОД КЛЮЧ»</h6>
                <p class="second-text">просто пригоните нам свой автомобиль и доверьтесь профессионализму наших
                                       мастеров!</p>

                <p class="form-message" style="display: none;"></p>
                <div class="contact-form">
                    <script id="bx24_form_inline" data-skip-moving="true">
                        (function (w, d, u, b){w['Bitrix24FormObject']=b;w[b] = w[b] || function(){arguments[0].ref=u;
                        (w[b].forms=w[b].forms||[]).push(arguments[0])};
                                if(w[b]['forms']) return;
                                var s=d.createElement('script');s.async=1;s.src=u+'?'+(1*new Date());
                                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
                                })(window, document, 'https://rt24.bitrix24.ru/bitrix/js/crm/form_loader.js', 'b24form');

                        b24form({"id":"14","lang":"ru","sec":"7y76vz","type":"inline"});
                    </script>
                </div>
            </div>
            <div class="col-md-8">
                <div class="map-section">
                    <section class="map-wrapp">
                        <div id="map" style="height: 515px;"></div>
                    </section>

                    <script src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script>

                    <script>
                        $(document).ready(function () {
                            function init() {


                                var myMap = new ymaps.Map("map", {
                                    center: [55.814259, 37.688351]
                                    , zoom: 18
                                    , controls: ['zoomControl']
                                });


                                myMap.behaviors.disable('multiTouch');
                                myMap.behaviors.disable('scrollZoom');
                                var myGeoObjects = [];
                                var flag_for_center = true;


                                $(".one-adr").each(function (e) {
                                    var latt = $(this).attr("data-lat");
                                    var longg = $(this).attr("data-lon");
                                    if (flag_for_center) {
                                        myMap.setCenter([latt, longg], 18, {
                                            checkZoomRange: false
                                        });
                                        flag_for_center = false;
                                    }
                                    myGeoObjects[e] = new ymaps.Placemark([latt, longg], {
                                        clusterCaption: 'Р—Р°РіРѕР»РѕРІРѕРє'
                                    }, {
                                        iconLayout: 'default#image'
                                        , iconImageHref: '/img/mark-map.png'
                                        , iconImageSize: [113, 122]
                                        , iconImageOffset: [-53.5, -85]
                                    });
                                });


                                var clusterIcons = [{
                                    href: 'img/marker-1.png'
                                    , size: [76, 70]
                                    , offset: [0, 0]
                                }];


                                var clusterer = new ymaps.Clusterer({
                                    clusterDisableClickZoom: false
                                    , clusterOpenBalloonOnClick: false
                                    , clusterBalloonPanelMaxMapArea: 0
                                    , clusterBalloonContentLayoutWidth: 300
                                    , clusterBalloonContentLayoutHeight: 200
                                    , clusterBalloonPagerSize: 2
                                    , clusterBalloonPagerVisible: false
                                });


                                clusterer.add(myGeoObjects);
                                myMap.geoObjects.add(clusterer);


                                $('.look-at-map').click(function () {
                                    myMap.setCenter(
                                        [parseFloat($(this).parents(".adr").attr("data-lat"))
                                            , parseFloat($(this).parents(".adr").attr("data-lon"))], 16, {
                                            checkZoomRange: false
                                        });
                                });


                                $('.one-adr').click(function () {
                                    myMap.setCenter(
                                        [parseFloat($(this).attr("data-lat"))
                                            , parseFloat($(this).attr("data-lon"))], 16, {
                                            checkZoomRange: false
                                        });
                                });


                            }

                            ymaps.ready(init);
                        });

                    </script>

                </div>
            </div><!-- map -->
        </div>
    </div>
</section>


<!-- Scripts -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<!-- Menu jQuery plugin -->

<script type="text/javascript" src="/js/hover-dropdown-menu.js"></script>
<!-- Menu jQuery Bootstrap Addon -->
<script type="text/javascript" src="/js/jquery.hover-dropdown-menu-addon.js"></script>
<!-- Scroll Top Menu -->

<script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
<!-- Sticky Menu -->
<script type="text/javascript" src="/js/jquery.sticky.js"></script>
<!-- Bootstrap Validation -->

<script type="text/javascript" src="/js/bootstrapValidator.min.js"></script>
<!-- Animations -->

<script type="text/javascript" src="/js/jquery.appear.js"></script>
<script type="text/javascript" src="/js/effect.js"></script>
<!-- Owl Carousel Slider -->

<script type="text/javascript" src="/js/owl.carousel.min.js"></script>
<!-- Price Filter -->

<script type="text/javascript" src="/js/price-filter.js"></script>
<!-- Pretty Photo Popup -->

<script type="text/javascript" src="/js/jquery.prettyPhoto.js"></script>
<!-- Parallax BG -->

<script type="text/javascript" src="/js/jquery.parallax-1.1.3.js"></script>
<!-- Fun Factor / Counter -->

<script type="text/javascript" src="/js/jquery.countTo.js"></script>
<!-- Custom Js Code -->

<script type="text/javascript" src="/js/jquery.mb.YTPlayer.js"></script>
<!-- Ticker Slider -->

<script type="text/javascript" src="/js/jquery.easy-ticker.min.js"></script>

<script type="text/javascript" src="/js/custom.js"></script>