<!-- Navbar Collapse -->
<div class="navbar-collapse collapse">
    <!-- nav -->
    <ul class="nav navbar-nav">
        <!-- Home  Mega Menu -->
        <li>
            <a href="#">Услуги</a>
            <ul class="dropdown-menu">
                {custom  category="11" template="modules/topmenu_uslugi_item" available="global" navigation="no" from="0" limit="10" fixed="yes" order="title" sort="asc" cache="no"}
            </ul>
        </li>
        <li>
            <a href="/turbiny/">Каталог турбин</a>

        </li>
        <li>
            <a href="/o-kompanii.html">О компании</a>
        </li>
        <!--
        <li>
            <a href="/sotrudnichestvo.html">Сотрудничество</a>
        </li>-->
        <li>
            <a href="/video/">Видео</a>
        </li>
        <li>
            <a href="/vakansii/">Вакансии</a>
        <li>
            <a href="/kontakty.html">Контакты</a>
        </li>

        <li class="search-dropdown phonetopmenu" style="padding: 15px 0px;">
            <strong style="font-size: 20px;    line-height: 2.0;    padding: 2px 0px; text-shadow: 1px 1px 1px #343434; color:#fff ">
                <i style="color: #fff;" class="fa fa-phone"></i>
                <a style="color: #fff;" href="tel:+7 (495) 374-90-24"
                   data-phone="+7 (495) 374-90-24" class="hdn_ phone_alloka">+7 (495) 374-90-24 <span style="font-size: 20px; display: none">показать</span>
                </a>
            </strong>
        </li>

        [group=13]
        <!-- Search Box Block -->
        <li class="search-dropdown">
            <a href="#">
               <span class="searchbox-icon">
                   <i class="fa fa-search"></i>
               </span>
            </a>
            <ul class="dropdown-menu left">
                <li>
                    <form class="navbar-form" role="search">
                        <div class="form-group">
                            <input type="text" value="" name="s" id="s" class="form-control" placeholder="search"/>
                        </div>
                    </form>
                </li>
            </ul>
        </li>
        [/group]
        <!-- Ends Search Box Block -->
    </ul>
    <!-- Right nav -->

    <style>
        .phonetopmenu {
            display: none;
            visibility: hidden;

        }

        .is-sticky .phonetopmenu {
            display: initial;
            visibility: initial;

        }
    </style>
</div>