/**
 * Created by phil on 2016/5/6.
 */

var pub = {
    init: function () {

    },
    //确定提交表单,参数
    ok_submit: function (obj, param, success, fail, type) {
        type = !type ? 1 : 2;
        success = (typeof success != 'function') ? null : success;
        fail = (typeof fail != 'function') ? null : fail;

        var url = obj.data('url');
        if (!param) {
            param = obj.closest('form').serialize();
        }
        param = !param ? false : param;

        common.ajax_post(url, param, true, function (rt) {
            if (success || fail) {
                common.post_tips(rt, success, fail, type);
            }
            else {
                common.post_tips(rt);
            }
        }, true);
    },
    //根据id删除
    del_by_id: function (obj, success, fail) {
        var url = obj.data('url');
        var id = obj.data('id');
        if (!url) {
            layer.msg('删除地址错误');
            return;
        }
        if (!id) {
            layer.msg('删除条目ID不能为空');
            return;
        }
        common.ajax_post(url, {id: id}, true, function (rt) {
            common.post_tips(rt, success, fail);
        })
    },
    open_window: function (obj) {
        var url = obj.data("url");
        var title = obj.data("title");
        if (!url) {
            layer.msg('打开地址错误', {icon: 2});
            return false;
        }
        if (!title)  title = '信息';

        var index = layer.open({
            type: 2,
            content: url,
            title: title,
            maxmin: false,
            move: false
        });
        layer.full(index);
    },
    quit: function () {
        var url = $("#admin_quit").val();
        layer.msg('请稍候..', {shade: [0.1, "#444"]});
        common.ajax_post(url, false, true, function () {
            layer.closeAll();
            layer.msg('退出成功!', {shade: [0.1, "#444"],"icon": 6});
            common.delay(function(){
                window.top.location.reload()
            },1000,1,false);
        });
    }
};
//退出登录
$(document).on("click", ".admin_quit", function () {
    layer.confirm("确认退出吗?", {title: false, btn: ["确认"]}, function () {
        pub.quit();
    });

});
//弹出全屏窗口
$(document).on("click", ".open_form", function () {
    var obj = $(this);
    pub.open_window(obj);
});
//不可操作的按钮
$(document).on("click", ".disabled_btn", function () {
    layer.msg('该按钮不可操作', {"icon": 4});
});
//提交表单
$(document).on("click", ".ok_submit", function () {
    var obj = $(this);
    pub.ok_submit(obj, null, function () {
        window.parent.location.reload()
    }, null, 1);
});

//按照id删除
$(document).on("click", ".del_by_id", function () {
    var obj = $(this);
    layer.confirm('确认删除吗?', {
        btn: ["删除", "返回"],
        title: false,
        closeBtn: false
    }, function () {
        pub.del_by_id(obj, function () {
            layer.msg('删除成功', {icon: 1});
            location.reload()
        }, null, 1);
    });

});

pub.init();
