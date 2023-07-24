var thePage = {};

thePage.lWallet = $("#wallet_list");
thePage.page = 1;

$(function() {
    thePage.filter();
    $("#wallet_btn_view").click(function() {
        thePage.filter();
    })
})

function paging_this(_page) {
    thePage.page = _page;
    thePage.filter();
}

thePage.filter = () => {

    var _keyword = $("#wallet_keyword");
    var _wallet_id = $("#wallet_id");

    var data = new FormData();
    data.append('keyword', _keyword.val());
    data.append('wallet_id', _wallet_id.val());
    data.append('page', thePage.page);

    _doAjaxNod('POST', data, 'user_wallet', 'idx', 'filter', true, (res) => {
        thePage.lWallet.html(thePage.render(res.data.l, res.data.client_id));
        $("#page_html").html(res.data.page_html);
    })

}

thePage.render = (l, client_id) => {
        let h = '';
        let i = 1;
        l.forEach(function(item) {
                    h += `<tr>
                <td class="text-center">${i++}</td>
                <td class="text-center">${item.id}</td>
                <td>${date_format("d/m/Y H:i", item.created_at)}</td>
                <td>${item.wallet_name}</td>
                <td>${item.from_client == client_id? item.to_fullname:item.from_fullname}</td>
                <td>${item.from_client == client_id? item.to_mobile:item.from_mobile}</td>
                <td class="text-right">
                    ${item.from_client == client_id?`<b class="color-red">`:`<b class="color-green">`}${number_format_replace_cog(item.amount)}</b>
                </td>
                <td>${item.note}</td>
            </tr>`;
    })
    return h;
}