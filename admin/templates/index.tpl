{if $temp == 'home/sign.tpl'}
{include  file="`$tpldirect``$temp`"}
{else}
{include  file="`$tpldirect`header.tpl"}
{include file="`$tpldirect`aside.tpl"}
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
{include file="`$tpldirect`navbar.tpl"}
{include  file="`$tpldirect``$temp`"}
</main>
{include file="`$tpldirect`plugin.tpl"}
{include  file="`$tpldirect`footer.tpl"}
{/if}