<section class="section gray-bg" id="blog">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="text-center">
                        <div class="section-title">
                            <h2>Technology news</h2>
                            <p>I design and develop services for customers of all sizes, specializing in creating stylish, modern websites</p>
                        </div>
                    </div>
                </div>
                <div class="row" id="show_news">
                    {foreach $list_news as $item}
                    <div class="col-lg-4">
                        <div class="blog-grid">
                            <div class="blog-img">
                                <div class="date">{$item._date} - {$item.views} views</div>
                                <a href="/news-detail&id={$item.id}">
                                    <img src="{$domain}/public/img/news/{$item.id}/{$item._img}" height="300px" title="" alt="">
                                </a>
                            </div>
                            <div class="blog-info">
                                <h5><a href="/news-detail&id={$item.id}">{$item.title}</a></h5>
                                <p>{if strlen($item.long_title) > 40}{$item.long_title|substr:0:200}...{else}{$item.long_title}{/if}</p>
                                <div class="btn-bar">
                                    <a href="/news-detail&id={$item.id}" class="px-btn-arrow">
                                        <span>Read More</span>
                                        <i class="arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {/foreach}
                </div>
                <div style="text-align: center; width: 100%;">
                    <button class="btn btn-primary" id="see_more" style="border-radius: 0px;">See More</button>
                </div>
            </div>
        </section>