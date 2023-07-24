{if $product_list|count == 0}
    Không có sản phẩm nào với từ khóa: {$keyword}
{else}
{foreach $product_list as $item}
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
				<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
				<button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
				<button class="quick-view" data-product-id="{$item.id_product}"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
			</div>
		</div>
		<div class="add-to-cart">
		<button class="add-to-cart-btn" data-product-id="{$item.id_product}" data-title="{$item.name}" data-price="{$item.price}" data-img="{$item.img[0]}" data-unquid="{if !isset($smarty.session.email) || $smarty.session.email == ''}none{else}{$smarty.session.email}{/if}"><i class="fa fa-shopping-cart"></i> add to cart</button>
		</div>
	</div>
</div>
<!-- /product -->
{/foreach}
{/if}