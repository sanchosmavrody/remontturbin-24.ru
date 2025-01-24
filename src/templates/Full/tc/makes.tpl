<!-- Sticky Navbar -->
<div class="page-header">
    <div class="container">
        <h1 class="title">Марки авто</h1>
    </div>
    <div class="breadcrumb-box">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breads__item"><a href="/">Главная</a></li>
                <li class="breads__item">Марки авто</li>
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

    }

    .ctx {
        margin-bottom: 35px;
    }

</style>


<section class="page-section">
    <div class="container shop">
        <div class="row">
            <div class="col-sm-12 col-md-12 ">


                <div class="section-title animated fadeInUp visible" data-animation="fadeInUp">
                    <h2 class="title" style="    margin: 0px;    padding: 0px 0px 12px;">Ремонт турбин</h2>
                </div>

                <div class="row" style="      padding-bottom: 20px;">
                    <div class="col-md-12">
                        <div data-animation="fadeInDown" class="animated fadeInDown visible">
                            <p> Автомобильной технике свойственно иногда выходить из строя. К сожалению,
                                этому подвержены даже самые уважаемые и надежные марки машин. Причины
                                могут быть различны: чрезмерные нагрузки во время эксплуатации, вовремя
                                не сделанное ТО и просто долгий срок службы. Не исключением в этом
                                является и такая важная часть двигателя Вашего автомобиля, как
                                турбокомпрессор.
                            </p>


                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-condensed ctx ">
                        <thead>
                        <tr>

                            <th>
                                Марка
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        {rows}
                        </tbody>
                    </table>
                </div>


            </div>

        </div>
    </div>
</section>


<section class="index-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {include file="engine/modules/center/SeoElements.php?show=seotext"}
            </div>
        </div>
    </div>
</section>