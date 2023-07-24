<!DOCTYPE html>
<html lang="vi" debug="true">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="keywords" content="{if isset($meta_title)}{$meta_title}{/if}" />
    <meta name="description" content="{if isset($meta_description)}{$meta_description}{/if}" />
    <title>{if isset($meta_title) && $meta_title!=''}{$meta_title}{else}{$title}{/if}</title>
    <script src="{$domain}/js/jquery.min.js?{$version}"></script>
    <link href="{$domain}/css/bootstrap/bootstrap.min.css?{$version}" rel="stylesheet" />
    <link href="{$domain}/css/bootstrap/bootstrap.css?{$version}" rel="stylesheet" />
    <link href="{$domain}/css/jquery-ui-1.10.4.custom.min.css?{$version}" rel="stylesheet" />
    <link href="{$setup.favicon}" rel="shortcut icon" />
    <link href="{$domain}/fonts/montserrat/fonts.css?{$version}" rel="stylesheet">
    <link href="{$domain}/js/owlCarousel/owl.carousel.css?{$version}" rel="stylesheet" type="text/css" />
    <link href="{$domain}/css/rangeSlider.css?{$version}" rel="stylesheet" />
    <link href="{$domain}/css/cloudzoom.css?{$version}" rel="stylesheet" />
    <link href="{$domain}/css/fancybox/jquery.fancybox.css?{$version}" rel="stylesheet" />
    <link href="{$domain}/css/main.css?{$version}" rel="stylesheet">
    <link href="{$domain}/css/{$db_pos}.css?{$version}" rel="stylesheet">
    <link href="{$domain}/fonts/font-awesome.min.css?{$version}" rel="stylesheet" />
    <script src="{$domain}/js/{$session.lang}/home.js?{$version}"></script>
    <script src="{$domain}/js/jquery-1.10.2.min.js?{$version}"></script>
    <script src="{$domain}/js/jquery-ui-1.10.4.custom.min.js?{$version}"></script>

    <meta property="og:url" content='{if isset($meta_url)}{$meta_url}{/if}' />
    <meta property="og:type" content='website' />
    <meta property="og:title" content='{if isset($meta_title)}{$meta_title}{/if}' />
    <meta property="og:description" content='{if isset($meta_description)}{$meta_description}{/if}' />
    <meta property="og:image" content='{if isset($meta_image)}{$meta_image}{/if}' />
    <meta property="og:image:alt" content='{if isset($meta_description)}{$meta_description}{/if}' />
</head>

<body>
    <div class="header">
        <div class="header-toolbar">
            <div class="container">
                <div class="support">
                    {* {$setup.info_contact} *}
                    <span><i class="fa fa-phone"></i> <a href="tel:{$setup.hotline}"
                            title="">{$setup.hotline}</a></span>
                    <span><i class="fa fa-envelope"></i> <a href="mailto:{$setup.email}"
                            title="">{$setup.email}</a></span>
                </div>
                <div class="wrap-icon">
                    <div class="login-menu">
                        {if !isset($session.fullnameClient)}
                            <span class="gradient-btn">Đăng nhập</span>
                        {else}
                            <span class="btn-key"><a href="/thong-tin"
                                    style="color: #fff;">{$session.fullnameClient}</a></span>
                            <!-- <h4><a href="/thong-tin">{$session.fullnameClient}</a> | <a href="/logout.php/?page=client">Đăng xuất</a></h4> -->
                        {/if}
                    </div>
                </div>
            </div>
        </div>
        <div class="header-main">
            <div class="container">
                <div class="relative">
                    <div class="row">

                        <div class="col-md-2 col-sm-3 col-xs-12 logo">
                            <h1 class="hide">{if isset($meta_title)}{$meta_title}{/if}</h1>
                            <a href="/" title="{if isset($meta_title)}{$meta_title}{/if}"><img
                                    src="{if isset($logo_url) && $logo_url != ''}{$logo_url}{else}{$domain}/images/logo.png{/if}"
                                    alt="{if isset($meta_title)}{$meta_title}{/if}"></a>
                            <div class="icon-cate-mobi">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </div>
                        </div>
                        <div class="col-md-10 col-sm-9 col-xs-12 wrap-menu-top">
                            <div class="icon-menu-mobi">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </div>
                            <div class="menu-top">
                                {$menu_top}
                            </div>
                            <a class="icon-cart cart-detail" href="/gio-hang"><i class="fa fa-cart-plus"
                                    aria-hidden="true"></i><span id='quantity_cart'></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="category-product category-product-mobile">
            <div class="title">
                <span><i></i><i></i><i></i></span>
                <p>Danh mục</p>
            </div>
            <ul>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon1.png" class="" />
                            <img src="{$domain}/images/icon1-h.png" class="h" />
                        </div>
                        <span>Thời trang nam</span>
                    </a>
                </li>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon2.png" class="" />
                            <img src="{$domain}/images/icon2-h.png" class="h" />
                        </div>
                        <span>Giày thời trang nữ</span>
                    </a>
                </li>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon3.png" class="" />
                            <img src="{$domain}/images/icon3-h.png" class="h" />
                        </div>
                        <span>Phụ kiện du lịch</span>
                    </a>
                </li>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon4.png" class="" />
                            <img src="{$domain}/images/icon4-h.png" class="h" />
                        </div>
                        <span>Đồ gia dụng cho em bé</span>
                    </a>
                </li>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon5.png" class="" />
                            <img src="{$domain}/images/icon5-h.png" class="h" />
                        </div>
                        <span>Phụ kiện phòng ngủ</span>
                    </a>
                </li>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon6.png" class="" />
                            <img src="{$domain}/images/icon6-h.png" class="h" />
                        </div>
                        <span>Đồ gia dụng</span>
                    </a>
                </li>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon7.png" class="" />
                            <img src="{$domain}/images/icon7-h.png" class="h" />
                        </div>
                        <span>Thực phẩm thú cưng</span>
                    </a>
                </li>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon8.png" class="" />
                            <img src="{$domain}/images/icon8-h.png" class="h" />
                        </div>
                        <span>Trái cây siêu sạch</span>
                    </a>
                </li>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon9.png" class="" />
                            <img src="{$domain}/images/icon9-h.png" class="h" />
                        </div>
                        <span>Mỹ phẩm chính sản</span>
                    </a>
                </li>
                <li>
                    <a href="?m=product&act=index" title="#">
                        <div class="icon">
                            <img src="{$domain}/images/icon10.png" class="" />
                            <img src="{$domain}/images/icon10-h.png" class="h" />
                        </div>
                        <span>Sản phẩm công nghệ</span>
                    </a>
                </li>
            </ul>
        </div>
</div>