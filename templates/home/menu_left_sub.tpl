<ul class="sub">
    {foreach from=$data item=item key=key}
        <li><a href="/{$item.link_url}-cn{$item.id}" title="{$item.meta_title}">{$item.name}</a></li>
    {/foreach}
</ul>