var thePage = {}
var limit = 4;
thePage.user_id = $("#user_id");

$(document).on('click', '#submit_comment', function(e) {
    e.preventDefault();
    let user_id = thePage.user_id.val();
    let id_post = $(this).data("id-post")
    if(user_id == 'none') {
        swal({
            title: "Warning",
            text: "Need Login",
            icon: "warning"
        })
    } else {
        let message = $("#message_comment").val();
        if(message == '')
        {
            swal({
                title: "Warning",
                text: "Please do not leave it blank",
                icon: "warning"
            })
        } else {
            let formData = new FormData();
            formData.append('limit', limit);
            formData.append('id_post', id_post);
            formData.append('message', message);
            _doAjaxNod("POST", formData, "home", "news-detail", "comment", true, (res) => {
                if(res.status == 200) {
                    let list_comment = res.data;
                    thePage.render(list_comment);
                }
            })
        }
    }
})

$(document).on('click', '#see_more', function() {
    limit += 4;
    let id_post = $(this).data("id-post");
    let formData = new FormData();
    formData.append("id_post", id_post);
    formData.append("limit", limit);
    _doAjaxNod("POST", formData, "home", "news-detail", "see-more", true, (res) => {
        if(res.status == 200) {
            let list_comment = res.data[0];
            let countAll_comment = res.data[1];
            thePage.render(list_comment);
            if(countAll_comment <= limit) {
                $("#see_more").hide();
            }
        }
    })
})

thePage.render = (list_comment) => {
    let content = '';
    list_comment.forEach(function(item) {
        if(item.avatar != '') {
            img = '<img class="media-object" src="./public/img/user/'+item.user_id+'/'+item.avatar+'" width="80px" height="80px" style="border-radius: 90px;" alt="">'
        } else {
            img = '<img class="media-object" src="./public/img/user/user.jpg" width="80px" height="80px" style="border-radius: 90px;" alt="">'
        }
        content += `<!-- COMMENT - START -->
        <div class="media" style="padding-bottom: 10px;">
            <a class="pull-left">${img}</a>
            <div class="media-body" style="padding-left: 10px;">
                <h5 class="media-heading">${item.user_name}</h5>
                <p>${item.content}</p>
                <ul class="list-unstyled list-inline media-detail pull-left">
                    <li><i class="fa fa-calendar"></i> ${item.formatTime}</li>
                    <li><i class="fa fa-thumbs-up"></i> ${item.num_like}</li>
                </ul>
                <ul class="list-unstyled list-inline media-detail pull-right">
                    <li class=""><a href="">Like</a></li>
                    <li class=""><a href="">Reply</a></li>
                </ul>
            </div>
        </div>
        <!-- COMMENT - END -->`;
    })

    $("#show_post_comment").html(content);
}