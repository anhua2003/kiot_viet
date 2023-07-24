<div class="blog-single">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-8 m-15px-tb">
                    <article class="article">
                        <div class="article-img">
                            <img src="{$domain}/public/img/news/{$news_detail.id}/{$news_detail._img}" width="100%" title="" alt="">
                        </div>
                        <div class="article-title">
                            <h6><a href="#">Lifestyle</a></h6>
                            <h2>{$news_detail.title}</h2>
                            <div class="media">
                                <div class="media-body">
                                    <span>{$news_detail._date}</span>
                                </div>
                            </div>
                        </div>
                        <div class="article-content">
                            {$news_detail.long_title}
                            {$news_detail.description}
                        </div>
                        <div class="nav tag-cloud">
                            <a href="#">Design</a>
                            <a href="#">Development</a>
                            <a href="#">Travel</a>
                            <a href="#">Web Design</a>
                            <a href="#">Marketing</a>
                            <a href="#">Research</a>
                            <a href="#">Managment</a>
                        </div>
                    </article>
                    <div class="contact-form article-comment">
                        <h4>Leave a comment</h4>
                        <form id="contact-form" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" id="message_comment" placeholder="Your message *" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="send">
                                        <button class="px-btn theme" id="submit_comment" data-id-post="{$news_detail.id}"><span>Submit</span> <i class="arrow"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="contact-form article-comment" style="margin-top: 10px;">
                        <h4>Comment</h4>
                        <div id="show_post_comment">
                        {if $post_comment|count == 0}
                        <p>No comments yet</p>
                        {else}
                        {foreach $post_comment as $item}
                        <!-- COMMENT - START -->
                        <div class="media" style="padding-bottom: 10px;">
                            {if $item.avatar == ''}
                            <a class="pull-left"><img class="media-object" src="{$domain}/public/img/user/user.jpg" width="80px" height="80px" style="border-radius: 90px;" alt=""></a>
                            {else}
                            <a class="pull-left"><img class="media-object" src="{$domain}/public/img/user/{$item.user_id}/{$item.avatar}" width="80px" height="80px" style="border-radius: 90px;" alt=""></a>
                            {/if}
                            <div class="media-body" style="padding-left: 10px;">
                                <h5 class="media-heading">{$item.user_name}</h5>
                                <p>{$item.content}</p>
                                <ul class="list-unstyled list-inline media-detail pull-left">
                                    <li><i class="fa fa-calendar"></i> {$item.formatTime}</li>
                                    <li><i class="fa fa-thumbs-up"></i> {$item.num_like}</li>
                                </ul>
                                <ul class="list-unstyled list-inline media-detail pull-right">
                                    <li class=""><a href="">Like</a></li>
                                    <li class=""><a href="">Reply</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- COMMENT - END -->
                        {/foreach}
                        {/if}
                        </div>
                        <div style="text-align: center;">
                            <button class="btn btn-success" id="see_more" data-id-post="{$news_detail.id}" style="border: 0px; border-radius: 0px; background-color: #D10024;">See more</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 m-15px-tb blog-aside">
                    <!-- Latest Post -->
                    <div class="widget widget-latest-post">
                        <div class="widget-title">
                            <h3>Latest Post</h3>
                        </div>
                        <div class="widget-body">
                            {foreach $other_news as $item}
                            <div class="latest-post-aside media">
                                <div class="lpa-left media-body">
                                    <div class="lpa-title">
                                        <h5><a href="/news-detail&id={$item.id}">{$item.title}</a></h5>
                                    </div>
                                    <div class="lpa-meta">
                                        <a class="date" href="#">
                                            {$item._date}
                                        </a>
                                    </div>
                                </div>
                                <div class="lpa-right">
                                    <a href="#">
                                        <img src="{$domain}/public/img/news/{$item.id}/{$item._img}" title="" alt="">
                                    </a>
                                </div>
                            </div>
                            {/foreach}
                        </div>
                    </div>
                    <!-- End Latest Post -->
                    <!-- widget Tags -->
                    <div class="widget widget-tags">
                        <div class="widget-title">
                            <h3>Latest Tags</h3>
                        </div>
                        <div class="widget-body">
                            <div class="nav tag-cloud">
                                <a href="#">Design</a>
                                <a href="#">Development</a>
                                <a href="#">Travel</a>
                                <a href="#">Web Design</a>
                                <a href="#">Marketing</a>
                                <a href="#">Research</a>
                                <a href="#">Managment</a>
                            </div>
                        </div>
                    </div>
                    <!-- End widget Tags -->
                </div>
            </div>
        </div>
    </div>


    <style>
        .blog-listing {
            padding-top: 30px;
            padding-bottom: 30px;
        }
        .gray-bg {
            background-color: #f5f5f5;
        }
        /* Blog 
        ---------------------*/
        .blog-grid {
        box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
        border-radius: 5px;
        overflow: hidden;
        background: #ffffff;
        margin-top: 15px;
        margin-bottom: 15px;
        }
        .blog-grid .blog-img {
        position: relative;
        }
        .blog-grid .blog-img .date {
        position: absolute;
        background: #D10024;
        color: #ffffff;
        padding: 8px 15px;
        left: 10px;
        top: 10px;
        border-radius: 4px;
        }
        .blog-grid .blog-img .date span {
        font-size: 22px;
        display: block;
        line-height: 22px;
        font-weight: 700;
        }
        .blog-grid .blog-img .date label {
        font-size: 14px;
        margin: 0;
        }
        .blog-grid .blog-info {
        padding: 20px;
        }
        .blog-grid .blog-info h5 {
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 10px;
        }
        .blog-grid .blog-info h5 a {
        color: #333;
        }
        .blog-grid .blog-info p {
        margin: 0;
        }
        .blog-grid .blog-info .btn-bar {
        margin-top: 20px;
        }
        
        
        /* Blog Sidebar
        -------------------*/
        .blog-aside .widget {
        box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
        border-radius: 5px;
        overflow: hidden;
        background: #ffffff;
        margin-top: 15px;
        margin-bottom: 15px;
        width: 100%;
        display: inline-block;
        vertical-align: top;
        }
        .blog-aside .widget-body {
        padding: 15px;
        }
        .blog-aside .widget-title {
        padding: 15px;
        border-bottom: 1px solid #eee;
        }
        .blog-aside .widget-title h3 {
        font-size: 20px;
        font-weight: 700;
        color: #D10024;
        margin: 0;
        }
        .blog-aside .widget-author .media {
        margin-bottom: 15px;
        }
        .blog-aside .widget-author p {
        font-size: 16px;
        margin: 0;
        }
        .blog-aside .widget-author .avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        overflow: hidden;
        }
        .blog-aside .widget-author h6 {
        font-weight: 600;
        color: #333;
        font-size: 22px;
        margin: 0;
        padding-left: 20px;
        }
        .blog-aside .post-aside {
        margin-bottom: 15px;
        }
        .blog-aside .post-aside .post-aside-title h5 {
        margin: 0;
        }
        .blog-aside .post-aside .post-aside-title a {
        font-size: 18px;
        color: #333;
        font-weight: 600;
        }
        .blog-aside .post-aside .post-aside-meta {
        padding-bottom: 10px;
        }
        .blog-aside .post-aside .post-aside-meta a {
        color: #6F8BA4;
        font-size: 12px;
        text-transform: uppercase;
        display: inline-block;
        margin-right: 10px;
        }
        .blog-aside .latest-post-aside + .latest-post-aside {
        border-top: 1px solid #eee;
        padding-top: 15px;
        margin-top: 15px;
        }
        .blog-aside .latest-post-aside .lpa-right {
        width: 90px;
        }
        .blog-aside .latest-post-aside .lpa-right img {
        border-radius: 3px;
        }
        .blog-aside .latest-post-aside .lpa-left {
        padding-right: 15px;
        }
        .blog-aside .latest-post-aside .lpa-title h5 {
        margin: 0;
        font-size: 15px;
        }
        .blog-aside .latest-post-aside .lpa-title a {
        color: #333;
        font-weight: 600;
        }
        .blog-aside .latest-post-aside .lpa-meta a {
        color: #6F8BA4;
        font-size: 12px;
        text-transform: uppercase;
        display: inline-block;
        margin-right: 10px;
        }
        
        .tag-cloud a {
        padding: 4px 15px;
        font-size: 13px;
        color: #ffffff;
        background: #333;
        border-radius: 3px;
        margin-right: 4px;
        margin-bottom: 4px;
        }
        .tag-cloud a:hover {
        background: #D10024;
        }
        
        .blog-single {
        padding-top: 30px;
        padding-bottom: 30px;
        }
        
        .article {
        box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
        border-radius: 5px;
        overflow: hidden;
        background: #ffffff;
        padding: 15px;
        margin: 15px 0 30px;
        }
        .article .article-title {
        padding: 15px 0 20px;
        }
        .article .article-title h6 {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 20px;
        }
        .article .article-title h6 a {
        text-transform: uppercase;
        color: #D10024;
        border-bottom: 1px solid #D10024;
        }
        .article .article-title h2 {
        color: #333;
        font-weight: 600;
        }
        .article .article-title .media {
        padding-top: 15px;
        border-bottom: 1px dashed #ddd;
        padding-bottom: 20px;
        }
        .article .article-title .media .avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        overflow: hidden;
        }
        .article .article-title .media .media-body {
        padding-left: 8px;
        }
        .article .article-title .media .media-body label {
        font-weight: 600;
        color: #D10024;
        margin: 0;
        }
        .article .article-title .media .media-body span {
        display: block;
        font-size: 12px;
        }
        .article .article-content h1,
        .article .article-content h2,
        .article .article-content h3,
        .article .article-content h4,
        .article .article-content h5,
        .article .article-content h6 {
        color: #333;
        font-weight: 600;
        margin-bottom: 15px;
        }
        .article .article-content blockquote {
        max-width: 600px;
        padding: 15px 0 30px 0;
        margin: 0;
        }
        .article .article-content blockquote p {
        font-size: 20px;
        font-weight: 500;
        color: #D10024;
        margin: 0;
        }
        .article .article-content blockquote .blockquote-footer {
        color: #333;
        font-size: 16px;
        }
        .article .article-content blockquote .blockquote-footer cite {
        font-weight: 600;
        }
        .article .tag-cloud {
        padding-top: 10px;
        }
        
        .article-comment {
        box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
        border-radius: 5px;
        overflow: hidden;
        background: #ffffff;
        padding: 20px;
        }
        .article-comment h4 {
        color: #333;
        font-weight: 700;
        margin-bottom: 25px;
        font-size: 22px;
        }
        img {
            max-width: 100%;
        }
        img {
            vertical-align: middle;
            border-style: none;
        }
        
        /* Contact Us
        ---------------------*/
        .contact-name {
        margin-bottom: 30px;
        }
        .contact-name h5 {
        font-size: 22px;
        color: #333;
        margin-bottom: 5px;
        font-weight: 600;
        }
        .contact-name p {
        font-size: 18px;
        margin: 0;
        }
        
        .social-share a {
        width: 40px;
        height: 40px;
        line-height: 40px;
        border-radius: 50%;
        color: #ffffff;
        text-align: center;
        margin-right: 10px;
        }
        .social-share .dribbble {
        box-shadow: 0 8px 30px -4px rgba(234, 76, 137, 0.5);
        background-color: #ea4c89;
        }
        .social-share .behance {
        box-shadow: 0 8px 30px -4px rgba(0, 103, 255, 0.5);
        background-color: #0067ff;
        }
        .social-share .linkedin {
        box-shadow: 0 8px 30px -4px rgba(1, 119, 172, 0.5);
        background-color: #0177ac;
        }
        
        .contact-form .form-control {
        border: none;
        border-bottom: 1px solid #333;
        background: transparent;
        border-radius: 0;
        padding-left: 0;
        box-shadow: none !important;
        }
        .contact-form .form-control:focus {
        border-bottom: 1px solid #D10024;
        }
        .contact-form .form-control.invalid {
        border-bottom: 1px solid #ff0000;
        }
        .contact-form .send {
        margin-top: 20px;
        }
        @media (max-width: 767px) {
        .contact-form .send {
            margin-bottom: 20px;
        }
        }
        
        .section-title h2 {
            font-weight: 700;
            color: #333;
            font-size: 45px;
            margin: 0 0 15px;
            border-left: 5px solid #D10024;
            padding-left: 15px;
        }
        .section-title {
            padding-bottom: 45px;
        }
        .contact-form .send {
            margin-top: 20px;
        }
        .px-btn {
            padding: 0 50px 0 20px;
            line-height: 60px;
            position: relative;
            display: inline-block;
            color: #333;
            background: none;
            border: none;
        }
        .px-btn:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            border-radius: 30px;
            background: transparent;
            border: 1px solid rgba(252, 83, 86, 0.6);
            border-right: 1px solid transparent;
            -moz-transition: ease all 0.35s;
            -o-transition: ease all 0.35s;
            -webkit-transition: ease all 0.35s;
            transition: ease all 0.35s;
            width: 60px;
            height: 60px;
        }
        .px-btn .arrow {
            width: 13px;
            height: 2px;
            background: currentColor;
            display: inline-block;
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto;
            right: 25px;
        }
        .px-btn .arrow:after {
            width: 8px;
            height: 8px;
            border-right: 2px solid currentColor;
            border-top: 2px solid currentColor;
            content: "";
            position: absolute;
            top: -3px;
            right: 0;
            display: inline-block;
            -moz-transform: rotate(45deg);
            -o-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .content-item {
    padding:30px 0;
	background-color:#FFFFFF;
}

        .content-item.grey {
            background-color:#F0F0F0;
            padding:50px 0;
            height:100%;
        }

        .content-item h2 {
            font-weight:700;
            font-size:35px;
            line-height:45px;
            text-transform:uppercase;
            margin:20px 0;
        }

        .content-item h3 {
            font-weight:400;
            font-size:20px;
            color:#555555;
            margin:10px 0 15px;
            padding:0;
        }

        .content-headline {
            height:1px;
            text-align:center;
            margin:20px 0 70px;
        }

        .content-headline h2 {
            background-color:#FFFFFF;
            display:inline-block;
            margin:-20px auto 0;
            padding:0 20px;
        }

        .grey .content-headline h2 {
            background-color:#F0F0F0;
        }

        .content-headline h3 {
            font-size:14px;
            color:#AAAAAA;
            display:block;
        }


        #comments {
            box-shadow: 0 -1px 6px 1px rgba(0,0,0,0.1);
            background-color:#FFFFFF;
        }

        #comments form {
            margin-bottom:30px;
        }

        #comments .btn {
            margin-top:7px;
        }

        #comments form fieldset {
            clear:both;
        }

        #comments form textarea {
            height:100px;
        }

        #comments .media {
            border-top:1px dashed #DDDDDD;
            padding:20px 0;
            margin:0;
        }

        #comments .media > .pull-left {
            margin-right:20px;
        }

        #comments .media img {
            max-width:100px;
        }

        #comments .media h4 {
            margin:0 0 10px;
        }

        #comments .media h4 span {
            font-size:14px;
            float:right;
            color:#999999;
        }

        #comments .media p {
            margin-bottom:15px;
            text-align:justify;
        }

        #comments .media-detail {
            margin:0;
        }

        #comments .media-detail li {
            color:#AAAAAA;
            font-size:12px;
            padding-right: 10px;
            font-weight:600;
        }

        #comments .media-detail a:hover {
            text-decoration:underline;
        }

        #comments .media-detail li:last-child {
            padding-right:0;
        }

        #comments .media-detail li i {
            color:#666666;
            font-size:15px;
            margin-right:10px;
        }
    </style>