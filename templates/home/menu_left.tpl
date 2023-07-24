{foreach from=$data item=item key=key}
    <li>
        <a href="/{$item.link_url}-cn{$item.id}" title="{$item.meta_title}">{$item.name}</a>
        {if isset($item.subItems) && $item.subItems!=''}
            {include "`$tpldirect`home/menu_left_sub.tpl" data=$item.subItems}
        {/if}
    </li>
{/foreach}