var thePage = {};

$(function() {

})

function paging_fund(_page) {
    let url = window.location.href;
    let cat_id = url.split('-');
    let cat = cat_id[cat_id.length - 1].split('/');
    cat = cat[0];

    let link = url.slice(0, url.lastIndexOf("-"));

    if (cat.startsWith("c")) {
        window.location = link + '-' + cat + '/' + _page;
    } else {
        window.location = url_domain + '/san-pham/' + _page;
    }

}