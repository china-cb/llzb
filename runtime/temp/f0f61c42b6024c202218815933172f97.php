<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"../tpl/index/admin\upload_html.html";i:1486541781;}*/ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <title>DVR上传</title>

    <link rel="stylesheet" href="http://cdn.aodianyun.com/static/jqueryui/1.8.9/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="http://cdn.aodianyun.com/static/plupload/js/jquery.simple.ui.plupload/css/jquery.simple.ui.plupload.css" type="text/css" />
</head>
<body style="font: 13px Verdana; background: #eee; color: #333">

<div id="uploader">

</div>
<br />
<input type="hidden" id="upload" value="<?php echo url('index/admin/upload_do'); ?>">
<script type="text/javascript">
    // Initialize the widget when the DOM is ready
    $(function(){
        $("#uploader").plupload({
            // General settings
            runtimes: 'html5,flash,silverlight,html4',
            url: $("#upload").val(),

            // User can upload no more then 20 files in one go (sets multiple_queues to false)
            max_file_count: 20,

            // Part file size
            chunk_size: '1mb',

            max_retries: 3,

            filters: {
                // Maximum file size
                max_file_size : '4096mb',

                // Select the duplicate files are not allowed
                prevent_duplicates : true
            },

            //post params
            multipart_params: {

            },

            // Rename files by clicking on their titles
            rename: false,

            // Sort files
            sortable: false,

            // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
            dragdrop: false,

            // Views to activate
            views: {
                list: true,
                thumbs: false, // Show thumbs
                active: 'list'
            },

            // Flash settings
            flash_swf_url: 'js/Moxie.swf',

            // Silverlight settings
            silverlight_xap_url: 'js/Moxie.xap',

            init: {
                FileFiltered: function(uploader,file){
                    var ext = ['.avi','.f4v','.mpg','.mp4','.flv','.wmv','.mov','.3gp','.rmvb','.rm','.mkv','.asf','.ts','.mts','.dat','.vob','.mp3','.wav','.m4v','.webm'];
                    var type = file['name'].substr(file['name'].lastIndexOf('.')).toLowerCase();
                    if(ext.indexOf(type) == -1){
                        $('#uploader').plupload('notify', 'error', "错误：无效的文件扩展名:" + file['name']);
                        uploader.removeFile(file);
                    }
                },
                UploadProgress: function(uploader,file){
                    //开始上传时触发
                },
                QueueChanged: function(uploader,file){
                    //当视频文件加载进来时触发
                },
                FileUploaded: function(uploader){
                    //当视频文件成功上传后触发
                    var url = $("#get_video_url").val();
                    common.ajax_post(url,false,true,function(rt){
                        var obj = common.str2json(rt);
                        if(obj.code == 1){
                            $(".vc-block.active .warp").append(obj.html);
                        }else if(obj.code == 2){
                            $(".vc-block.active").html(obj.html);
                        }else{
                            common.post_tips(rt);
                        }
                        $(".layui-layer-close").trigger("click");
                    });
                },
                ChunkUploaded: function(uploader,file,responseObject){
                    console.log(responseObject);
                    if(responseObject.status != 200){
                        var errorMsg = "文件" + file['name'] + "在上传过程中遇到问题，请稍后重试";
                        $('#uploader').plupload('notify', 'error', errorMsg);
                        uploader.removeFile(file);
                        return;
                    }
                    var rst = $.parseJSON(responseObject.response);
                    if(rst.Flag != 100){
                        var errorMsg = "文件" + file['name'] + "上传失败，原因：" + rst.FlagString;
                        $('#uploader').plupload('notify', 'error', errorMsg);
                        uploader.removeFile(file);
                        return;
                    }
                }
            }
        });
    });
</script>
<div style="color:#df6400;"><strong>玲珑提示:</strong> 上传未完成请勿进行关闭或返回操作，上传完成后会自动关闭该弹窗！</div>
</body>
</html>