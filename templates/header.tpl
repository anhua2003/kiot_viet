<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>{if !isset($title) || $title == ''} Electro Shop {else} {$title} {/if} </title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="{$domain}/public/css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="{$domain}/public/css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="{$domain}/public/css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="{$domain}/public/css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="{$domain}/public/css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="{$domain}/public/css/style.css"/>
		<link type="text/css" rel="stylesheet" href="{$domain}/js/jquery.rateyo.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="{$domain}/js/jquery.min.js"></script>
		<script src="{$domain}/js/jquery-1.10.2.min.js"></script>
    </head>
	<body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
					</ul>
					<ul class="header-links pull-right">
						<li><a href="#"><i class="fa fa-dollar"></i> VND</a></li>
						{if !isset($smarty.session.email) || $smarty.session.email == ''}
						<li><a href="/dang-nhap"><i class="fa fa-user-o"></i>Login</a></li>
						<input type="hidden" id="user_id" value="none">
						{else}
						<li><a href="/tai-khoan"><i class="fa fa-user-o"></i>hello {$smarty.session.email} !</a></li>
						<input type="hidden" id="user_id" value="{$smarty.session.id}">
						<li><a href="logout.php">Logout</a></li>
						{/if}
					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="#" class="logo">
									<img src="{$domain}/public/img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form id="search">
									<select class="input-select">
										<option value="0">All Categories</option>
										{foreach $category as $item}
										<option value="{$item.id}">{$item.category_name}</option>
										{/foreach}
									</select>
									<input class="input" id="keyword" placeholder="Search here">
									<button class="search-btn" type="submit">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" id="m_cart" aria-expanded="true">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<div class="qty" id="qty_wishlist">{$myWishlist|count}</div>
									</a>
									<div class="cart-dropdown">
										<div class="cart-list" id="m_wishlist">
											{if !isset($smarty.session.id) || $smarty.session.id == ''}
											Bạn chưa đăng nhập mà
											{else}
											{if $myWishlist|count == 0}
											Không có sản phẩm nào
											{else}
											{foreach $myWishlist as $item}
											<div class="product-widget">
												<div class="product-img">
													<img src="{$item.img[0]}" alt="">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="/detail/{$item.id_product}/{$item.name}">{$item.name}</a></h3>
													<h4 class="product-price">{number_format($item.price)}đ</h4>
												</div>
												<button class="delete" id="del_wishlist" data-product-id="{$item.id_product}">x</button>
											</div>
											{/foreach}
											{/if}
											{/if}
										</div>
									</div>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" id="m_cart" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
										<div class="qty" id="quantity_cart"></div>
									</a>
									<div class="cart-dropdown">
										<div class="cart-list" id="product_list">
											
										</div>
										<div class="cart-summary">
											<small id="select_product"></small>
											<h5>Total: <span id="total"> </span>đ</h5>
										</div>
										
										
										<div class="cart-btns">
											<a href="/cart">View Cart</a>
											<a style="cursor: pointer;" id="place_order">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
										
									</div>
								</div>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->
	
		