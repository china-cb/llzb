
$(function () {
    var func = {

        //保存内容
        submit: function () {

            var url = $("#submit_url").val();
            var param = $(".form-horizontal").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.post_tips(rt, function (tt) {
                   layer.msg(tt.msg)
                    location.replace(location.href);
                });
            }, true);
        },
    };

    $(document).on("click", ".submit_btn", function () {
        func.submit();
    });

});