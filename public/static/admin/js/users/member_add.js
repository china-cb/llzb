/**
 * Created by phil on 2016/5/6.
 */
$(function () {
    var func = {
        init: function () {

        },
        //保存内容
        submit: function () {

            var url = $("#submit_url").val();
            var param = $(".form-horizontal").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.post_tips(rt, function () {
                    common.delay(function(){

                        location.href = $("#submit_url").val();
                    },1000,1)
                });
            }, true);
        },

    };

    $(document).on("click", ".submit_btn", function () {
        func.submit();
    });






});