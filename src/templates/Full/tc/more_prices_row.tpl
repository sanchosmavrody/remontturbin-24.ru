<div class="result__item">
    <div class="result__ava open-photo">
        <a href="/{partId}-{SALEnumber_alt}_{partType_alt}/">
            <img src="/templates/Full/img/catalog{catId}.png" alt="">
        </a>
    </div>
    <div class="result__info">

        <a href="/{partId}-{SALEnumber_alt}_{partType_alt}/" class="result__name">{partType}</a>

        <p class="result__type">{SALEbrand}: <span>{SALEnumber}</span></p>

        <p class="result__mark" style="padding: 7px 0px 0px;"><b>Модель турбины:</b>
            {Модель турбины} {Бренд турбины}
        </p>

    </div>
    <div class="result__similar" style="padding: 14px 10px 12px 25px;">
        <p class="result__similar-title">Аналоги</p>

        <ul class="result__similar-list">
            {analogs_more}

        </ul>
    </div>
    <div class="result__count-price">
        <div class="result__price-wrap" style="align-self: center;position: relative;">
            <div class="result__price-block" style="    margin: 0px auto;">
                <p class="result__price-label">Цена</p>
                <p class="result__price"> {price} руб.</p>
            </div>
            [leftCount]
            <div style="     position: absolute;    white-space: nowrap;    bottom: -25px;   left: 47px;    color: #d9534f;"><i class="fa fa-info-circle"></i>
                Уточняйте наличие, возможно товар в пути
            </div>
            [/leftCount]
        </div>
        <div class="result__count">
            <p class="result__price-label">Количество</p>
            <div class="result__count-wrap">
                <div class="result__count-block">
                    <button data-itemid="{partId}" class="result__but result-minus">-</button>
                    <span data-itemid="{partId}" class="result__amount">1</span>
                    <button data-itemid="{partId}" class="result__but result-plus">+</button>
                </div>
            </div>
        </div>
    </div>
    <button class="orange-button result__button add-to-cart" data-price="{price}" data-count="1" data-itemid="{partId}"
            data-aid="{aId}" data-maincat="{catNameAltName}">
        <span class="in">В корзину</span><span class="out">Убрать</span>
    </button>
</div>

