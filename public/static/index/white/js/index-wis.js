var pageNum = 0;
var drawLocked = false;
var clientId = "demo";
var docObject;
/****************WIS相关*****************/
var accessId = "";
var accessKey = "";
var wisId = $("#wisId").val();
if(!wisId){
    wisId = $("#wisId").val();
}
//获取文档列表
function getList(option){
   $.ajax({
        type:"POST",
        timeout:8000,
        url:$("#interface_url").val(),
        dataType:"json",
        data:{method:'DocList',skip:option.skip,num:option.num,accessId:accessId,accessKey:accessKey},
        success: function(data){
            if(data.Flag == 100){
                //if(option.success)option.success(data.Info);
            }else{
                //if(option.failure)option.failure(data.FlagString);
            }
        },
        error:option.failure
    });
}
function loadDocList(  err ) {
}

function getQueryStr(str) {
    var LocString = String(window.document.location.href);
    var rs = new RegExp("(^|)" + str + "=([^&]*)(&|$)", "gi").exec(LocString), tmp;
   if (tmp = rs) {
       return tmp[2];
    }
    return "";
}
$(function () {

    var api = WISAPI.New($("#interface_url").val(), { accessId: accessId, accessKey: accessKey });
    WIS.Init({
        wisId: wisId,
        api: api,
        container: 'wis_context_inner',
        width: 920,
        height: 640,
        success:function(){
            var uid = $("#uid").val();
            var cid = $("#cid").val();
            if(uid !== "" && cid !== ""){
                var index = setTimeout(function(){
                    clearTimeout(index);
                    var url = $("#live_cost_url").val();
                    var chat_num = $("#chat_num").val();
                    common.ajax_post(url,{uid:uid,cid:cid,chat_num:chat_num},true,function(rt){
                        var obj = common.str2json(rt);
                        if(obj.code == -1){
                            common.post_tips(rt);
                        }else{
                            $("#chat_num").val('');
                        }
                    });
                    var index2 = setInterval(function(){
                        chat_num = $("#chat_num").val();
                        common.ajax_post(url,{uid:uid,cid:cid,chat_num:chat_num},true,function(rt){
                            var obj2 = common.str2json(rt);
                            if(obj2.code == -1){
                                common.post_tips(rt);
                            }else{
                                $("#chat_num").val('');
                            }
                        });
                    },60000);
                },10000);
            }
            WIS.AllowDraw({ballow:false});
            /*隐藏操作层*/
            $("#__wis__sm__container__").hide();
        },
        failure:function(err){

            /*todo 报错处理*/
                //var index = setTimeout(function(){
                //    clearTimeout(index);
                //    var url = $("#live_cost_url").val();
                //    var uid = $("#uid").val();
                //    var cid = $("#cid").val();
                //    alert(uid);
                //    alert(cid);
                //    common.ajax_post(url,{uid:uid,cid:cid},true,function(rt){
                //        var obj = common.str2json(rt);
                //        if(obj.code == 0){
                //            common.post_tips(rt);
                //        }
                //    });
                //    setInterval(function(){
                //        common.ajax_post(url,{uid:uid,cid:cid},true,function(rt){
                //            var obj2 = common.str2json(rt);
                //            if(obj2.code == 0){
                //                common.post_tips(rt);
                //            }
                //        });
                //    },60000);
                //},10000);
            //alert("init fail:  "+err);
        },
        updateUser:function(total){
            $(".rightLabel span").html(total);
        },
        onConnect:function(){

        },
        onReconnect:function(){

        },
        onConnectClose:function(){

        },
        onDocLoad: function (info) {
            //console.log(info);
            //docObject = info;
            //$("#docList div[docId=" + docObject["id"] + "]").addClass("selectDoc");
            //$("#docList div[docId=" + docObject["id"] + "]").siblings().removeClass("selectDoc");
        },
        onPageChange:function(page,total){
            //pageNum = total;
            //$("#pageList").html("");
            //for (var i = 1; i <= total; i++) {
            //    var option = $("<option>").val(i).text(i);
            //    $("#pageList").append(option);
            //}
            //$("#pageList").val(page);
        }
    });

    //loadDocList();
});
