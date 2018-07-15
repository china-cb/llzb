/**
 * Created by phil on 2016/5/6.
 */
$(function () {
    var func = {
        init: function () {
            func.init_upload();
        },

        //保存内容
        submit: function () {
            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            common.ajax_post(url, param, true, function (rt) {
                common.post_tips(rt, function () {
                    common.delay(function(){
                        location.href = $("#root_url").val();
                    },1000,1)
                });
            }, true);
        },
        admin_submit : function() {
            var  treeObj = $.fn.zTree.getZTreeObj("treeDemo");

            var select_nodes = treeObj.getCheckedNodes(true);

            var select_length = select_nodes.length;

            var role_list = '';

            if(select_length > 0) {
                for (var i=0; i < select_length; i++) {
                    role_list += select_nodes[i].id+',';
                }
                role_list = role_list.substring(0,role_list.length-1);
            }

            var url = $("#submit_url").val();
            var param = $("#form_content").serialize();
            param = param+'&role_list='+role_list;

            common.ajax_post(url,param, true, function (rt) {
                common.post_tips(rt, function () {
                    common.delay(function(){
                        location.href = $("#root_url").val();
                    },1000,1)
                });
            }, true);
        },


        //初始化上传按钮
        init_upload:function(){
            var uploader = WebUploader.create({
                auto: true,
                duplicate: true,
                // swf文件路径
                swf: $("#swf_path").val(),
                // 文件接收服务端。
                server: $("#server_path").val(),
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: {
                    id: '#picker',
                    multiple: false
                },
                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,png',
                    mimeTypes: 'image/*'
                }
            });


            // 当有文件添加进来的时候
            uploader.on( 'fileQueued', function( file ) {

                var $li = $(
                        '<div id="' + file.id + '" class="file-item thumbnail">' +
                        '<img>' +
                        '<div class="info">' + file.name + '</div>' +
                        '</div>'
                    ),
                    $img = $li.find('img');


                // $list为容器jQuery实例
                $(".uploader-list").html( $li );

                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                uploader.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr( 'src', src );
                }, 100, 100 );
            });
            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on( 'uploadSuccess', function( file ) {
                $( '#'+file.id ).addClass('upload-state-done');
            });
            // 文件上传失败，显示上传出错。
            uploader.on( 'uploadError', function( file ) {
                var $li = $( '#'+file.id ),
                    $error = $li.find('div.error');
                // 避免重复创建
                if ( !$error.length ) {
                    $error = $('<div class="error"></div>').appendTo( $li );
                }

                $error.text('上传失败');
            });

            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {
                $( '#'+file.id ).find('.progress').remove();
            });
            //每个文件 上传完毕 的时候触发
            uploader.onUploadSuccess = function (file,response) {
                $("#img_path").val(response.img_path);
            };
        }
    };

    $(document).on("click", ".submit_btn", function () {
        func.submit();
    });

    $(document).on("click", ".admin_submit_btn", function () {
        func.admin_submit();
    });

    func.init();


    $(".upload").click(function (ev) {
        ev.preventDefault();
        var upload_url = $('#upload_img_url_system').val();
        var index = layer.open({
            id:'up_img_iframe',
            type: 2,
            area: ['700px', '530px'],
            fix: false, //不固定
            btn:["确定",'取消'],
            content: upload_url,
            yes:function() {
                var name=$("#up_img_iframe").find('iframe').attr('name');
                var content = window.frames[name].document.getElementById('return_list').value;
                if(content != '') {
                    console.log(content);
                    var pic_info = $.parseJSON(content);
                    var pic_img = $('.pic_img');
                    $('.pic_id').val(pic_info[0]['id']);

                    if(pic_img.is(":hidden")) {
                        pic_img.show();
                    }
                    pic_img.attr('src',pic_info[0]['path']);
                    layer.close(index);
                }

            },
            btn2:function(){
                layer.close(index);
            }
            //cancel : function () {
            //    var name=$("#up_img_iframe").find('iframe').attr('name');
            //    var content = window.frames[name].document.getElementById('return_list').value;
            //    if(content != '') {
            //        console.log(content);
            //        var pic_info = $.parseJSON(content);
            //        var pic_img = $('.pic_img');
            //        $('.pic_id').val(pic_info[0]['id']);
            //
            //        if(pic_img.is(":hidden")) {
            //            pic_img.show();
            //        }
            //        pic_img.attr('src',pic_info[0]['path']);
            //    }
            //
            //
            //}
        });
    })






});