<div class="page-header">
    <div class="container">
        <h1 class="title">{title}</h1>
    </div>
    <div class="breadcrumb-box">
        <div class="container">
            <ul class="breadcrumb">
                {speedbar}
            </ul>
        </div>
    </div>
</div>

<style>

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

</style>
<section class="page-section">
    <div class="container">
        <div class="row">


            <img src="[xfvalue_image_url_vakansii_bg]" alt="">

            <p>{full-story}</p>

            [group=13]


            <article class="box story[fixed] fixed_story[/fixed] fullstory" itemscope
                     itemtype="http://schema.org/Article">
                <div class="box_in">
                    [not-group=5]
                    <ul class="story_icons ignore-select">
                        <li class="fav_btn">
                            [add-favorites]<span title="Добавить в закладки"><svg class="icon icon-fav"><use
                                            xlink:href="#icon-fav"></use></svg></span>[/add-favorites]
                            [del-favorites]<span title="Убрать из закладок"><svg class="icon icon-star"><use
                                            xlink:href="#icon-star"></use></svg></span>[/del-favorites]
                        </li>
                        <li class="edit_btn">
                            [edit]<i title="Редактировать">Редактировать</i>[/edit]
                        </li>
                    </ul>
                    [/not-group]
                    <h2 class="title" itemprop="headline">{title}</h2>
                    <div class="text" itemprop="articleBody">
                        {full-story}
                        [edit-date]<p class="editdate grey">Новость отредактировал: <b>{editor}</b> - {edit-date}<br>
                            [edit-reason]Причина: {edit-reason}[/edit-reason]</p>[/edit-date]
                    </div>
                    {pages}
                    <div class="story_tools ignore-select">
                        <div class="category">
                            <svg class="icon icon-cat">
                                <use xlink:href="#icon-cat"></use>
                            </svg>
                            {link-category}
                        </div>
                        [rating]
                        <div class="rate">
                            [rating-type-1]
                            <div class="rate_stars">{rating}</div>
                            [/rating-type-1]
                            [rating-type-2]
                            <div class="rate_like">
                                [rating-plus]
                                <svg class="icon icon-love">
                                    <use xlink:href="#icon-love"></use>
                                </svg>
                                {rating}
                                [/rating-plus]
                            </div>
                            [/rating-type-2]
                            [rating-type-3]
                            <div class="rate_like-dislike">
                                [rating-plus]<span title="Нравится"><svg class="icon icon-like"><use
                                                xlink:href="#icon-like"></use></svg></span>[/rating-plus]
                                {rating}
                                [rating-minus]<span title="Не нравится"><svg class="icon icon-dislike"><use
                                                xlink:href="#icon-dislike"></use></svg></span>[/rating-minus]
                            </div>
                            [/rating-type-3]
                            [rating-type-4]
                            <div class="rate_like-dislike">
                                <span class="ratingtypeplusminus ignore-select ratingplus">{likes}</span>
                                [rating-plus]<span title="Нравится"><svg class="icon icon-like"><use
                                                xlink:href="#icon-like"></use></svg></span>[/rating-plus]
                                <span class="ratingtypeplusminus ratingminus ignore-select">{dislikes}</span>
                                [rating-minus]<span title="Не нравится"><svg class="icon icon-dislike"><use
                                                xlink:href="#icon-dislike"></use></svg></span>[/rating-minus]
                            </div>
                            [/rating-type-4]
                        </div>
                        [/rating]
                    </div>
                    [fixed]<span class="fixed_label" title="Важная новость"></span>[/fixed]
                </div>
                <div class="meta ignore-select">
                    <ul class="right">
                        <li class="complaint" title="Жалоба">[complaint]
                            <svg class="icon icon-bad">
                                <use xlink:href="#icon-bad"></use>
                            </svg>
                            <span class="title_hide">Жалоба</span>[/complaint]
                        </li>
                        <li class="grey" title="Просмотров: {views}">
                            <svg class="icon icon-views">
                                <use xlink:href="#icon-views"></use>
                            </svg> {views}</li>
                        <li title="Комментариев: {comments-num}">[com-link]
                            <svg class="icon icon-coms">
                                <use xlink:href="#icon-coms"></use>
                            </svg> {comments-num}[/com-link]
                        </li>
                    </ul>
                    <ul class="left">
                        <li class="story_date">
                            <svg class="icon icon-info">
                                <use xlink:href="#icon-info"></use>
                            </svg> {author}<span class="grey"> от </span>
                            <time datetime="{date=Y-m-d}" class="grey" itemprop="datePublished">[day-news]{date}
                                [/day-news]
                            </time>
                        </li>
                    </ul>
                </div>
                <meta itemprop="author" content="{login}">
            </article>
            <div class="rightside ignore-select">
                {include file="modules/rightside_fullstory.tpl"}
            </div>
            <div class="box next-prev ignore-select">
                [prev-url]<a href="{prev-url}" class="btn">Предыдущая публикация</a>[/prev-url]
                [next-url]<a href="{next-url}" class="btn right">Следующая публикация</a>[/next-url]
            </div>
            [banner_header]
            <div class="box banner ignore-select">
                {banner_header}
            </div>
            [/banner_header]
            <div class="comments ignore-select">
                <div class="box">
                    [comments]<h4 class="heading">Комментарии <span class="grey hnum">{comments-num}</span></h4>
                    [/comments]
                    <div class="com_list">
                        {comments}
                    </div>
                </div>
                {navigation}
                {addcomments}
            </div>

            [/group]

        </div>
    </div>
</section>