<ul>
    {foreach from=$data item=item key=key}
        <li><a href="{$item.link}" title="{$item.name}">{$item.name}</a></li>
    {/foreach}
    {* <li><a href="/" title="#">Sản phẩm</a></li>
    <li><a href="/tin-tuc" title="#">Hoạt Động</a> </li>
    <li><a href="/tuyen-dung" title="#">Tuyển dụng</a></li>
    <li><a href="/lien-he" title="#">Liên hệ</a></li> *}
</ul>