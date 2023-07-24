    <div class="menu-top-bottom">
        <ul>
            {$menu_suggest}
        </ul>
    </div>
    <footer>
        <div class="container">
            {if isset($setup.menu_bottom) && $setup.menu_bottom!='' && $setup.menu_bottom!='null'}
                <div class="menu-bottom">
                    <div class="row">
                        {$setup.menu_bottom}
                    </div>
                </div>
            {/if}
            {if isset($setup.info_footer) && $setup.info_footer!='' && $setup.info_footer!='null'}
                <div class="footer">
                    {$setup.info_footer}
                </div>
            {/if}
        </div>
    </footer>

    <div id="modal_alert_dialog" class="modal fade modalAlert" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="close" data-dismiss="modal" aria-label="Close">x</span>
                    <h3>Thông báo</h3>
                    <p id="message_alert"></p>
                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">OK</button>
                </div>
            </div>
        </div>
    </div>

    {* <div id="loading_bar"><i class="fa fa-spinner fa-spin fa-5x fa-fw margin-bottom"></i></div> *}
    
    <script type="text/javascript" src="{$domain}/js/bootstrap.js?{$version}"></script>
	<script type="text/javascript" src="{$domain}/js/bootstrap-dialog.js?{$version}"></script>
	<script type="text/javascript" src="{$domain}/js/jquery.bootstrap-touchspin.js?{$version}"></script>
    <script type="text/javascript" src="{$domain}/js/owlCarousel/owl.carousel.js"></script>
    <script type="text/javascript" src="{$domain}/js/jquery.flexslider.js"></script>
    <script type="text/javascript" src="{$domain}/js/rangeSlider.js"></script>
    <script type="text/javascript" src="{$domain}/js/cloudzoom.js"></script>
    <script type="text/javascript" src="{$domain}/js/fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="{$domain}/js/jquery-ui.min.js?{$version}"></script>
    <script type="text/javascript" src="{$domain}/js/jquery.nicescroll.min.js?{$version}"></script>
    <script type="text/javascript" src="{$domain}/js/main.js?{$version}"></script>
    <script type="text/javascript" src="{$domain}/js/js_act/{$m}_{$act}.js?{$version}"></script>
    <script type="text/javascript" src="{$domain}/js/global.js?{$version}"></script>
</body>
</html>