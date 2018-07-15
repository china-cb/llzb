$(function () {
    var func = {
        init: function () {

        },
        save: function (obj) {
            var name = obj.attr('name');
            var val = obj.val();
            var url = $("#save_url").val();
            var img_loading = $('#img_loading').val();
            var img_ok = $('#img_ok').val();
            var img_times = $('#img_times').val();
            obj.closest('.config_one').find('.status_img').attr('src', img_loading).show();
            common.ajax_post(url, {code: name, value: val}, true, function (rt) {
                common.post_tips(rt, function (o) {
                    if (o.code && o.code == '1') {
                        obj.closest('.config_one').find('.status_img').attr('src', img_ok);
                    }
                    else {
                        obj.closest('.config_one').find('.status_img').attr('src', img_times);
                    }
                    obj.time_clock = window.setInterval(function () {
                        obj.closest('.config_one').find('.status_img').hide(200);
                        window.clearInterval(obj.time_clock);
                    }, 1000);
                })
            })
        },
        refresh_config: function () {
            var force =1;
            var url = $("#refresh_config").val();
            common.ajax_post(url,{force:force},true,function(rt){
                common.post_tips(rt);
            });
        }
    };
    //配置单个
    $(document).on('change', '.conf_one', function () {
        var obj = $(this);
        func.save(obj);
    });
    //更新配置缓存
    $(document).on('click', '.refresh_config', function () {
        var obj = $(this);
        func.refresh_config(obj);
    });
    func.init();
});