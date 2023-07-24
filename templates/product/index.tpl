<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- ASIDE -->
					<div id="aside" class="col-md-3">
						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Categories</h3>
							<div class="checkbox-filter">
								{foreach $category as $item}
								<div class="input-checkbox">
									<input type="checkbox" class="filter_category" name="filter_category[]" id="{$item.category_name}-{$item.id}" value="{$item.id}">
									<label for="{$item.category_name}-{$item.id}">
										<span></span>
										{$item.category_name}
										<small>(578)</small>
									</label>
								</div>
								{/foreach}
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Price</h3>
							<div class="price-filter">
								<div id="price-slider"></div>
								<div class="input-number price-min">
									<input id="price-min" min="0" type="number">
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
								<span>-</span>
								<div class="input-number price-max">
									<input id="price-max" max="80000000" type="number">
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
							</div>
						</div>
						<button class="btn btn-primary" style="width: 100%; margin-top: 10px;" id="filter-btn"><i class="fa fa-filter"></i></button>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						<div class="aside">
							<h3 class="aside-title">Top selling</h3>
							{foreach $list_product1 as $item}
							<div class="product-widget">
								<div class="product-img">
									<img src="{$item.img[0]}" alt="">
								</div>
								<div class="product-body">
									<p class="product-category">{$item.category_name}</p>
									<h3 class="product-name"><a href="#">{$item.name}</a></h3>
									{if $item.sale != 0}
									<h4 class="product-price">{number_format($item.price*(100-$item.sale)/100)}đ <del class="product-old-price">{number_format($item.price)}đ</del></h4>
									{else}
									<h4 class="product-price">{number_format($item.price)}đ</h4>
									{/if}
								</div>
							</div>
							{/foreach}
						</div>
						<!-- /aside Widget -->
					</div>
					<!-- /ASIDE -->

					<!-- STORE -->
					<div id="store" class="col-md-9">
						<!-- store top filter -->
						<div class="store-filter clearfix">
							
							<ul class="store-grid">
								<li class="active"><a data-toggle="tab" href="#tab1"><i class="fa fa-th"></i></a></li>
								<li><a data-toggle="tab" href="#tab2"><i class="fa fa-th-list"></i></a></li>
							</ul>
						</div>
						<!-- /store top filter -->
						<div class="products-tabs">
							<div id="tab1" class="tab-pane active list_product1">
								<div id="show_product_list">
									{if $list_product|count == 0}
										Không có sản phẩm
									{else}
									{foreach $list_product as $item}
									<!-- product -->
									<div class="col-md-4 col-xs-6">
										<div class="product">
											<div class="product-img">
												<img src="{$item.img[0]}" alt="">
												<div class="product-label">
													{if $item.sale != 0}
													<span class="sale">-{$item.sale}%</span>
													{/if}
													<span class="new">NEW</span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category">{$item.category_name}</p>
												<h3 class="product-name"><a href="/detail/{$item.id_product}/{$item.name}">{if strlen($item.name) > 10}{$item.name|substr:0:18}...{else}{$item.name}{/if}</a></h3>
												{if $item.sale != 0}
												<h4 class="product-price">{number_format($item.price*(100-$item.sale)/100)}đ <del class="product-old-price">{number_format($item.price)}đ</del></h4>
												{else}
												<h4 class="product-price">{number_format($item.price)}đ</h4>
												{/if}
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
													{if in_array($item.id_product, array_column($wishlist, 'id_product'))}
													<button class="remove-to-wishlist" data-product-id="{$item.id_product}"><i class="fa fa-heart"></i><span class="tooltipp">remove to wishlist</span></button>
													{else}
													<button class="add-to-wishlist" data-product-id="{$item.id_product}"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
													{/if}
													<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
													<button class="quick-view" data-product-id="{$item.id_product}"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
												</div>
											</div>
										</div>
									</div>
									<!-- /product -->
									<div class="clearfix visible-sm visible-xs"></div>
									{/foreach}
									{/if}
								</div>
							</div>
							<div id="tab2" class="tab-pane list_product2" style="overflow: auto; max-height: 1000px;">
								{if $list_product|count == 0}
									Không có sản phẩm
								{else}
								{foreach $list_product as $item}
								<div class="product-widget">
									<div class="product-img">
										<img src="{$item.img[0]}" alt="">
									</div>
									<div class="product-body">
										<p class="product-category">{$item.category_name}</p>
										<h3 class="product-name"><a href="/detail/{$item.id_product}/{$item.name}">{$item.name}</a></h3>
										{if $item.sale != 0}
										<h4 class="product-price">{number_format($item.price*(100-$item.sale)/100)}đ <del class="product-old-price">{number_format($item.price)}đ</del></h4>
										{else}
										<h4 class="product-price">{number_format($item.price)}đ </h4>
										{/if}
									</div>
								</div>
								{/foreach}
								{/if}
							</div>
						</div>
						
								<!-- store bottom filter -->
									<div class="store-filter clearfix" style="padding-top: 20px;">
										
										{$pagination}
									</div>
								<!-- /store bottom filter -->
					</div>
					<!-- /STORE -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<input type="hidden" id="key" value="{$key}">
		{$myWishlist = implode(",", array_column($wishlist,'id_product'))}
		<input type="hidden" id="wishlist_arr" value="{$myWishlist}">
		<!-- /SECTION -->
		<script src="{$domain}/js/js_act/product_detail.js"></script>