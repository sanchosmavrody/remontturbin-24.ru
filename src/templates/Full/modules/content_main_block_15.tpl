<div class="row">
    <div class="col-md-4 opacity animated fadeInLeft visible" data-animation="fadeInLeft">
        <h4>МЫ ПРОИЗВОДИМ РЕМОНТ ТУРБИН «ПОД КЛЮЧ»</h4>
        <img src="/templates/Full/images/office.jpg" width="500" alt="">
        <p>Просто пригоните нам свой автомобиль и доверьтесь профессионализму наших мастеров!</p>
    </div>
    <div class="col-md-4 animated fadeInUp visible" data-animation="fadeInUp">
        <p class="form-message" style="display: none;"></p>
        <div class="contact-form">
            <!--
            <form role="form" name="contactform" id="contactform" method="post"
                  action="php/contact-form.php" novalidate="novalidate" class="bv-form">
                <button type="submit" class="bv-hidden-submit"
                        style="display: none; width: 0px; height: 0px;"></button>

                <div class="input-text form-group has-feedback">
                    <input type="text" name="contact_name" class="input-name form-control"
                           placeholder="Имя" data-bv-field="contact_name"><i
                            class="form-control-feedback bv-no-label" data-bv-icon-for="contact_name"
                            style="display: none;"></i>
                    <small class="help-block" data-bv-validator="notEmpty" data-bv-for="contact_name"
                           data-bv-result="NOT_VALIDATED" style="display: none;">Please enter a value
                    </small>
                </div>

                <div class="input-email form-group has-feedback">
                    <input type="email" name="contact_email" class="input-email form-control"
                           placeholder="Email" data-bv-field="contact_email"><i
                            class="form-control-feedback bv-no-label" data-bv-icon-for="contact_email"
                            style="display: none;"></i>
                    <small class="help-block" data-bv-validator="notEmpty" data-bv-for="contact_email"
                           data-bv-result="NOT_VALIDATED" style="display: none;">Please enter a value
                    </small>
                    <small class="help-block" data-bv-validator="emailAddress"
                           data-bv-for="contact_email" data-bv-result="NOT_VALIDATED"
                           style="display: none;">Please enter a valid email address
                    </small>
                </div>

                <div class="input-email form-group has-feedback">
                    <input type="text" name="contact_phone" class="input-phone form-control"
                           placeholder="Телефон" data-bv-field="contact_phone"><i
                            class="form-control-feedback bv-no-label" data-bv-icon-for="contact_phone"
                            style="display: none;"></i>
                    <small class="help-block" data-bv-validator="notEmpty" data-bv-for="contact_phone"
                           data-bv-result="NOT_VALIDATED" style="display: none;">Please enter a value
                    </small>
                </div>

                <div class="textarea-message form-group has-feedback">
                                    <textarea name="contact_message" class="textarea-message hight-82 form-control"
                                              placeholder="Комментарий" rows="2"
                                              data-bv-field="contact_message"></textarea><i
                            class="form-control-feedback bv-no-label" data-bv-icon-for="contact_message"
                            style="display: none;"></i>
                    <small class="help-block" data-bv-validator="notEmpty" data-bv-for="contact_message"
                           data-bv-result="NOT_VALIDATED" style="display: none;">Please enter a value
                    </small>
                </div>

                <button class="btn btn-default btn-block" type="submit">Отправить
                    <i class="icon-paper-plane"></i></button>
            </form>
             -->


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
    <div class="col-md-4 animated fadeInRight visible" data-animation="fadeInRight">
        <div class="map-section">

            <section class="map-wrapp">
                <div id="map" style="height: 330px;"></div>
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

        </div>
    </div>
    <!-- map -->
</div>