var thePage = {};

$(function() {
    
})

var limit = 3;
$(document).on('click', '#see_more', function() {
    limit += 3;
    let formData = new FormData();
    formData.append('limit', limit);
    _doAjaxNod("POST", formData, "home", "news", "see-more", true, (res) => {
        if(res.status == 200) {
            console.log(res.data[1]);
            let news = res.data[0];
            let content = '';
            news.forEach(function(item) {
                if(item.long_title.length > 40)
                {
                    long_title = item.long_title.substr(0,200)+'...';
                } else {
                    long_title = item.long_title
                }
                content += `<div class="col-lg-4">
                <div class="blog-grid">
                    <div class="blog-img">
                        <div class="date">${item._date} - ${item.views} views</div>
                        <a href="/news-detail&id=${item.id}">
                            <img src="./public/img/news/${item.id}/${item._img}" height="300px" title="" alt="">
                        </a>
                    </div>
                    <div class="blog-info">
                        <h5><a href="/news-detail&id=${item.id}">${item.title}</a></h5>
                        <p>${long_title}</p>
                        <div class="btn-bar">
                            <a href="/news-detail&id=${item.id}" class="px-btn-arrow">
                                <span>Read More</span>
                                <i class="arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>`
            });

            $("#show_news").html(content);
            if(res.data[1] <= limit)
            {
                $("#see_more").hide();
            }
        }
    })
})