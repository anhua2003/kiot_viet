var thePage = {}

$(document).on('submit', '#search', function(e) {
    e.preventDefault();
    let keyword = $("#keyword").val();
    let formData = new FormData();
    formData.append('keyword', keyword);
    if(keyword == '')
    {
        alert("Nhập vào đuy");
    } else {
        location.href = "/tim-kiem/"+keyword;
        // _doAjaxNod('POST', formData, 'search', 'save', 'save', true, (res)=>{
        //     if(res.status == 200)
        //     {
        //         setTimeout(function() {
        //             if(res.data.length == 0)
        //         {
        //             $("#show-search").html("adu");
        //         } else {
        //             $("#show-search").html("HAY")
        //         }
        //         }, 1000);
                
        //     }
        // })
    }
})