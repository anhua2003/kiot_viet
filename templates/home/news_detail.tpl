<section class="detail-news">
    <div class="wrap-breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
            </ul>
            {* <ul class="breadcrumb">
                <li><a href="/ck" title="Trang chủ">Trang chủ</a></li>
                <li><i class="fa fa-angle-right"></i></li>
                <li><a href="/ck/news" title="Tin tức">Tin tức</a></li>
                <li><i class="fa fa-angle-right"></i></li>
                <li><a href="/ck/news" title="Tin tức mỹ phẩm, làm đẹp">Tin tức mỹ phẩm, làm đẹp</a></li>
                <li><i class="fa fa-angle-right"></i></li>
                <li><a href="#" title="Càng làm đẹp càng xấu đi nếu bạn không biết những điều dưới đây!">Càng làm đẹp càng xấu đi nếu bạn không biết những điều dưới đây!</a></li>
            </ul> *}
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12 left">
                <div class="detail-content">
                    <h1 class="title">{$data.title}</h1>
                    <p class="info">Ngày đăng: {$data.created_at|date_format:"H:i d/m/Y"} - Lượt xem: </p>
                    <div class="detail">
                        <div class="article__body cms-body">
                            {$data.description}
                        </div>
                    </div>
                </div>
                <div class="block-news related">
                    <div class="block-title">
                        <h2 class="title"><a><img src="./public/imgs/cate.png" />Tin tức cùng danh mục</a></h2>
                        <div class="clear"></div>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            {foreach from=$lNewsByCategoryId item=item key=key}
                                <div class="col-md-12 col-sm-12 col-xs-12 wrap-item">
                                    <div class="item">
                                        <div class="img">
                                            <a href="/{$item.link_url}-dn{$item.id}" title="{$item.title}">
                                                <img src="{if $item.avatar == ''}/images/no_image.png{else}{$item.avatar}{/if}" alt="{$item.title}">
                                            {if $item.icon!=''}<i class="{$item.icon}" aria-hidden="true"></i>{/if}
                                            </a>
                                        </div>
                                        <div class="wrap-info">
                                            <h3><a href="/{$item.link_url}-dn{$item.id}" title="{$item.title}">{if $item.icon!=''}<i class="{$item.icon}" aria-hidden="true"></i>{/if}{$item.title}</a></h3>
                                            <div class="time">
                                                <span><i class="fa fa-clock-o" aria-hidden="true"></i>{$item.created_at|date_format:"H:i d/m/Y"}</span>
                                                <span><i class="fa fa-commenting-o" aria-hidden="true"></i> Lượt
                                                    xem</span>
                                            </div>
                                            <div class="info">{$item.short_description}</div>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                            {* <div class="col-md-12 col-sm-12 col-xs-12 wrap-item">
                                <div class="item">
                                    <div class="img">
                                        <a href="news-detail" title="#">
                                            <img src="public/imgs/news1.jpeg" alt="#">
                                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="wrap-info">
                                        <h3><a href="news-detail" title="#"><i class="fa fa-picture-o"
                                                    aria-hidden="true"></i>Góc nhìn kỹ thuật phiên giao dịch chứng khoán
                                                ngày 7/3: Giằng co, tích lũy chờ cơ hội bứt phá</a></h3>
                                        <div class="time">
                                            <span><i class="fa fa-clock-o" aria-hidden="true"></i>09:22 AM
                                                18/09/2017</span>
                                            <span><i class="fa fa-commenting-o" aria-hidden="true"></i> 482 Lượt
                                                xem</span>
                                        </div>
                                        <div class="info">Với việc xu hướng thị trường vẫn đang là đi ngang và nhóm
                                            ngành dẫn dắt chưa quá rõ ràng, VN-Index dự báo sẽ chưa thể vượt ngay vùng
                                            kháng cự đỉnh thời đại đã thiết lập tại 1.535 điểm.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 wrap-item">
                                <div class="item">
                                    <div class="img">
                                        <a href="news-detail" title="#">
                                            <img src="public/imgs/news2.jpeg" alt="#">
                                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="wrap-info">
                                        <h3><a href="news-detail" title="#"><i class="fa fa-video-camera"
                                                    aria-hidden="true"></i>Góc nhìn chuyên gia tuần mới: Tiếp tục đặt
                                                cược vào cổ phiếu thép, dầu khí?</a></h3>
                                        <div class="time">
                                            <span><i class="fa fa-clock-o" aria-hidden="true"></i>04:00 PM
                                                22/08/2017</span>
                                            <span><i class="fa fa-commenting-o" aria-hidden="true"></i> 645 Lượt
                                                xem</span>
                                        </div>
                                        <div class="info">Nhóm cổ phiếu hàng hóa cơ bản như thép, dầu khí, phân bón tăng
                                            mạnh và thu hút chú ý lớn của thị trường tuần qua khi giá nguyên vật liệu
                                            thế giới tăng mạnh. Liệu có nên tiếp tục đặt cược vào các nhóm cổ phiếu này?
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 wrap-item">
                                <div class="item">
                                    <div class="img">
                                        <a href="news-detail" title="#">
                                            <img src="public/imgs/news3.jpeg" alt="#">
                                        </a>
                                    </div>
                                    <div class="wrap-info">
                                        <h3><a href="news-detail"
                                                title="Nhận định thị trường phiên giao dịch chứng khoán ngày 7/3: Canh mua nhóm cổ phiếu hàng hóa cơ bản">Nhận
                                                định thị trường phiên giao dịch chứng khoán ngày 7/3: Canh mua nhóm cổ
                                                phiếu hàng hóa cơ bản</a></h3>
                                        <div class="time">
                                            <span><i class="fa fa-clock-o" aria-hidden="true"></i>04:00 PM
                                                22/08/2017</span>
                                            <span><i class="fa fa-commenting-o" aria-hidden="true"></i> 509 Lượt
                                                xem</span>
                                        </div>
                                        <div class="info">Dù chỉ số đi ngang nhưng đã có nhiều nhóm cổ phiếu đã vượt
                                            đỉnh kể từ đầu năm. Với thanh khoản đã tăng như trong tuần này, nhiều khả
                                            năng thị trường sẽ có cơ hội kiểm định lại vùng đỉnh cũ ở 1.536 điểm trong
                                            tuần sau.</div>
                                    </div>
                                </div>
                            </div> *}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 right">
                <section class="sidebar-block-right">
                    <ul class="sidebar-content">
                        {foreach from=$suggest item=item key=key}
                            <li>
                                <article>
                                    <a href="/{$item.link_url}-dn{$item.id}" title="{$item.title}" class="img">
                                        <img src="{if $item.avatar == ''}{else}{$item.avatar}{/if}" />
                                    </a>
                                    <h3><a href="/{$item.link_url}-dn{$item.id}" title="{$item.title}">{$item.title}</a>
                                    </h3>
                                </article>
                            </li>
                        {/foreach}
                    </ul>
                    <ul class="sidebar-content hide">
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news1.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn kỹ thuật phiên giao dịch chứng khoán ngày
                                        7/3: Giằng co, tích lũy chờ cơ hội bứt phá</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news2.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn chuyên gia tuần mới: Tiếp tục đặt cược vào
                                        cổ phiếu thép, dầu khí?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news3.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Nhận định thị trường phiên giao dịch chứng khoán
                                        ngày 7/3: Canh mua nhóm cổ phiếu hàng hóa cơ bản</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news4.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">SSI Research điểm tên 8 cổ phiếu đáng “xuống tiền”
                                        trong tháng 3</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news5.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thế giới nhiều biến động, cơ hội nào cho nhà đầu
                                        tư?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news6.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thị trường còn nhiều hàng tốt nhưng tạm ưu tiên quản
                                        trị rủi ro</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news1.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn kỹ thuật phiên giao dịch chứng khoán ngày
                                        7/3: Giằng co, tích lũy chờ cơ hội bứt phá</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news2.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn chuyên gia tuần mới: Tiếp tục đặt cược vào
                                        cổ phiếu thép, dầu khí?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news3.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Nhận định thị trường phiên giao dịch chứng khoán
                                        ngày 7/3: Canh mua nhóm cổ phiếu hàng hóa cơ bản</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news4.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">SSI Research điểm tên 8 cổ phiếu đáng “xuống tiền”
                                        trong tháng 3</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news5.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thế giới nhiều biến động, cơ hội nào cho nhà đầu
                                        tư?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news6.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thị trường còn nhiều hàng tốt nhưng tạm ưu tiên quản
                                        trị rủi ro</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news1.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn kỹ thuật phiên giao dịch chứng khoán ngày
                                        7/3: Giằng co, tích lũy chờ cơ hội bứt phá</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news2.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn chuyên gia tuần mới: Tiếp tục đặt cược vào
                                        cổ phiếu thép, dầu khí?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news3.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Nhận định thị trường phiên giao dịch chứng khoán
                                        ngày 7/3: Canh mua nhóm cổ phiếu hàng hóa cơ bản</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news4.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">SSI Research điểm tên 8 cổ phiếu đáng “xuống tiền”
                                        trong tháng 3</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news5.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thế giới nhiều biến động, cơ hội nào cho nhà đầu
                                        tư?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news6.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thị trường còn nhiều hàng tốt nhưng tạm ưu tiên quản
                                        trị rủi ro</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news1.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn kỹ thuật phiên giao dịch chứng khoán ngày
                                        7/3: Giằng co, tích lũy chờ cơ hội bứt phá</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news2.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn chuyên gia tuần mới: Tiếp tục đặt cược vào
                                        cổ phiếu thép, dầu khí?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news3.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Nhận định thị trường phiên giao dịch chứng khoán
                                        ngày 7/3: Canh mua nhóm cổ phiếu hàng hóa cơ bản</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news4.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">SSI Research điểm tên 8 cổ phiếu đáng “xuống tiền”
                                        trong tháng 3</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news5.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thế giới nhiều biến động, cơ hội nào cho nhà đầu
                                        tư?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news6.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thị trường còn nhiều hàng tốt nhưng tạm ưu tiên quản
                                        trị rủi ro</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news1.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn kỹ thuật phiên giao dịch chứng khoán ngày
                                        7/3: Giằng co, tích lũy chờ cơ hội bứt phá</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news2.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn chuyên gia tuần mới: Tiếp tục đặt cược vào
                                        cổ phiếu thép, dầu khí?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news3.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Nhận định thị trường phiên giao dịch chứng khoán
                                        ngày 7/3: Canh mua nhóm cổ phiếu hàng hóa cơ bản</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news4.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">SSI Research điểm tên 8 cổ phiếu đáng “xuống tiền”
                                        trong tháng 3</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news5.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thế giới nhiều biến động, cơ hội nào cho nhà đầu
                                        tư?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news6.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thị trường còn nhiều hàng tốt nhưng tạm ưu tiên quản
                                        trị rủi ro</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news1.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn kỹ thuật phiên giao dịch chứng khoán ngày
                                        7/3: Giằng co, tích lũy chờ cơ hội bứt phá</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news2.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Góc nhìn chuyên gia tuần mới: Tiếp tục đặt cược vào
                                        cổ phiếu thép, dầu khí?</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news3.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Nhận định thị trường phiên giao dịch chứng khoán
                                        ngày 7/3: Canh mua nhóm cổ phiếu hàng hóa cơ bản</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news4.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">SSI Research điểm tên 8 cổ phiếu đáng “xuống tiền”
                                        trong tháng 3</a></h3>
                            </article>
                        </li>
                        <li>
                            <article>
                                <a href="news-detail" title="#" class="img">
                                    <img src="public/imgs/news5.jpeg" />
                                </a>
                                <h3><a href="news-detail" title="#">Thế giới nhiều biến động, cơ hội nào cho nhà đầu
                                        tư?</a></h3>
                            </article>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</section>