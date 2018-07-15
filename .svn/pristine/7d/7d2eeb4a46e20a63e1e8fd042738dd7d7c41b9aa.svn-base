var faceMap = {
    "[微笑]": "1",
    "[撇嘴]": "2",
    "[色]": "3",
    "[发呆]": "4",
    "[流泪]": "5",
    "[害羞]": "6",
    "[闭嘴]": "7",
    "[睡]": "8",
    "[大哭]": "9",
    "[尴尬]": "10",
    "[发怒]": "11",
    "[调皮]": "12",
    "[呲牙]": "13",
    "[惊讶]": "14",
    "[难过]": "15",
    "[冷汗]": "16",
    "[抓狂]": "17",
    "[吐]": "18",
    "[偷笑]": "19",
    "[愉快]": "20",
    "[白眼]": "21",
    "[傲慢]": "22",
    "[饥饿]": "23",
    "[困]": "24",
    "[惊恐]": "25",
    "[流汗]": "26",
    "[憨笑]": "27",
    "[悠闲]": "28",
    "[奋斗]": "29",
    "[咒骂]": "30",
    "[疑问]": "31",
    "[嘘]": "32",
    "[晕]": "33",
    "[折磨]": "34",
    "[衰]": "35",
    "[敲打]": "36",
    "[再见]": "37",
    "[流汗]": "38",
    "[抠鼻]": "39",
    "[出糗]": "40",
    "[坏笑]": "41",
    "[左哼哼]": "42",
    "[右哼哼]": "43",
    "[哈欠]": "44",
    "[鄙视]": "45",
    "[委屈]": "46",
    "[快哭了]": "47",
    "[阴险]": "48",
    "[亲亲]": "49",
    "[吓]": "50",
    "[可怜]": "51",
    "[抱抱]": "52",
    "[月亮]": "53",
    "[太阳]": "54",
    "[炸弹]": "55",
    "[骷髅]": "56",
    "[刀]": "57",
    "[猪头]": "58",
    "[西瓜]": "59",
    "[咖啡]": "60",
    "[米饭]": "61",
    "[爱心]": "62",
    "[棒]": "63",
    "[弱]": "64",
    "[握手]": "65",
    "[胜利]": "66",
    "[抱拳]": "67",
    "[勾引]": "68",
    "[好的]": "69",
    "[不]": "70",
    "[玫瑰]": "71",
    "[凋谢]": "72",
    "[嘴唇]": "73",
    "[相爱]": "74",
    "[飞吻]": "75"
};
/************界面相关的脚本*************/
function switchTab(tab, tabBody) {
    $(tabBody).show();
    $(tabBody).siblings().hide();
    $(tab).addClass("selectTab");
    $(tab).siblings().removeClass("selectTab");
}
function switchView() {
    /*
    if ($("#videoView").children("div").size() > 0) {
        //切换回正常状态
        var _tmp1 = $("#displayBox").children("div").remove();
        var _tmp2 = $("#videoView").children("div").remove();
        $("#boardBox").children("div").remove();
        $("#boardBox").append(_tmp1);
        $("#videoView").hide();
        $("#boardView").show();
        $("#displayBox").append(_tmp2);
        WIS.Resize(784, 550);
        WIS.AllowDraw({ballow:!drawLocked});
        $("#vvMedia1").width(278).height(180);
        $("#hlsMedia1").width(278).height(180);
        $("#html5Media1").width(278).height(180).css("margin-top", "-180px");
    } else {
        //切换
        var _tmp1 = $("#displayBox").children("div").remove();
        var _tmp2 = $("#boardBox").children("div").remove();
        $("#videoView").children("div").remove();
        $("#videoView").append(_tmp1);
        $("#boardView").hide();
        $("#videoView").show();
        $("#displayBox").append(_tmp2);
        WIS.Resize(278, 180);
        WIS.AllowDraw({ballow:false});
        $("#vvMedia1").width(861).height(608);
        $("#hlsMedia1").width(861).height(608);
        $("#html5Media1").width(861).height(608).css("margin-top", "-608px");
    }*/
    /*
    if ($("#wis_context").hasClass("wis_context_small")) {
        WIS.Resize(784, 550);
        WIS.AllowDraw({ ballow: !drawLocked });
        $("#vvMedia1").width(278).height(180);
        $("#hlsMedia1").width(278).height(180);
        $("#html5Media1").width(278).height(180).css("margin-top", "-180px");
        $("#wis_context").removeClass("wis_context_small");
        $("#playerView").removeClass("playerView_big");
        $(".toolsBar").css("visibility", "visible");
        $(".boardBottom").css("visibility", "visible");
    } else {
        WIS.Resize(278, 180);
        WIS.AllowDraw({ ballow: false });
        $("#vvMedia1").width(861).height(608);
        $("#hlsMedia1").width(861).height(608);
        $("#html5Media1").width(861).height(608).css("margin-top", "-150px");
        $("#wis_context").addClass("wis_context_small");
        $("#playerView").addClass("playerView_big");
        $(".toolsBar").css("visibility", "hidden");
        $(".boardBottom").css("visibility", "hidden");
    }*/
    if (!!document.createElement('canvas').getContext) {
        if ($("#playerView").hasClass("playerView_big")) {
            WIS.Resize(784, 550);
            WIS.AllowDraw({ ballow: false });
            $("#vvMedia1").width(278).height(180);
            $("#hlsMedia1").width(278).height(180);
            $("#html5Media1").width(278).height(180).css("margin-top", "-180px");
            $(".leftBox").css("background-color", "inherit");
            $(".boardView").css("border-radius", "5px 0px 0px 5px");
            var _tmp = $("#displayBox").children("#wis_context").remove();
            _tmp.css("margin-top", "0px");
            $("#boardBox").append(_tmp);
            $("#playerView").removeClass("playerView_big");
            $(".toolsBar").css("visibility", "visible");
            $(".boardBottom").css("visibility", "visible");
        } else {
            WIS.Resize(278, 180);
            WIS.AllowDraw({ ballow: false });
            $("#vvMedia1").width(861).height(608);
            $("#hlsMedia1").width(861).height(608);
            $("#html5Media1").width(861).height(608).css("margin-top", "-180px");
            $(".leftBox").css("background-color", "black");
            $(".boardView").css("border-radius", "0px");
            var _tmp = $("#boardBox").children("#wis_context").remove();
            _tmp.css("margin-top", "-180px");
            $("#displayBox").append(_tmp);
            $("#playerView").addClass("playerView_big");
            $(".toolsBar").css("visibility", "hidden");
            $(".boardBottom").css("visibility", "hidden");
        }
    } else {
        if ($("#wis_context").hasClass("wis_context_small")) {
            WIS.Resize(784, 550);
            WIS.AllowDraw({ ballow: !drawLocked });
            $("#vvMedia1").width(278).height(180);
            $("#hlsMedia1").width(278).height(180);
            $("#html5Media1").width(278).height(180).css("margin-top", "-180px");
            $(".boardView").css("overflow", "hidden");
            $("#wis_context").removeClass("wis_context_small");
            $("#playerView").removeClass("playerView_big");
            $(".toolsBar").css("visibility", "visible");
            $(".boardBottom").css("visibility", "visible");
        } else {
            WIS.Resize(278, 180);
            WIS.AllowDraw({ ballow: false });
            $("#vvMedia1").width(861).height(608);
            $("#hlsMedia1").width(861).height(608);
            $("#html5Media1").width(861).height(608).css("margin-top", "-150px");
            $(".boardView").css("overflow", "visible");
            $("#wis_context").addClass("wis_context_small");
            $("#playerView").addClass("playerView_big");
            $(".toolsBar").css("visibility", "hidden");
            $(".boardBottom").css("visibility", "hidden");
        }
    }
}
var currentFacePage = 0;
var enableScroll = true;
function facePageSelect(index) {
    currentFacePage = index;
    enableScroll = false;
    $("#faceList").animate({ "margin-left": -currentFacePage * $(".facePage").width() }, 200, function () {
        enableScroll = true;
        $(".pageholder div:eq(" + currentFacePage + ")").css("background-color", "#808080");
        $(".pageholder div:eq(" + currentFacePage + ")").siblings().css("background-color", "#FFFFFF");
    });
};
function showFaceList() {
    $('#faceBox').toggle();
    currentFacePage = 0;
    $("#faceList").css("margin-left", "0px");
    $(".pageholder div:eq(0)").css("background-color", "#808080");
    $(".pageholder div:eq(0)").siblings().css("background-color", "#FFFFFF");
}
function faceSelect(index) {
    for (var item in faceMap) {
        var value = faceMap[item];
        if (index == parseInt(value)) {
            $("#msgSendTxt").val($("#msgSendTxt").val()+item);
            break;
        }
    }
}
$(function () {
    $(".toolItem").live("click", function () {
        if (!$(this).attr("data-cmd")) {
            $(this).addClass("selectItem");
            $(this).siblings(".toolItem").removeClass("selectItem");
        }
    });
    $("#lockTool").live("click", function (e) {
        if ($(this).hasClass("selectItem")) {
            $(this).removeClass("selectItem");
        } else {
            $(this).addClass("selectItem");
        }
    });
    var facePageNum = 3;
    for (var i = 1, j = 1; i <= 75; i++) {
        $("#facePage" + j).append($("<a>").css("background-image", "url(images/faces/" + i + ".gif)").attr("onclick", "faceSelect(" + i + ");"));
        j = parseInt((i + 28) / 28);
    }
    $("#facePage3").append($("<a class='noneFace'>"));
    $("#facePage3").append($("<a class='noneFace'>"));
    wheel(document.getElementById("faceList"), function (e) {
        var marginLeft = $("#faceList").css("margin-left");
        marginLeft = parseInt(marginLeft.substring(0, marginLeft.length - 2));
        if (!enableScroll) return;
        if (e.delta > 0) {
            if (currentFacePage > 0) {
                currentFacePage--;
            }
        } else {
            if (currentFacePage < (facePageNum - 1)) {
                currentFacePage++;
            }
        }
        enableScroll = false;
        $("#faceList").animate({ "margin-left": -currentFacePage * $(".facePage").width() }, 200, function () {
            enableScroll = true;
            $(".pageholder div:eq(" + currentFacePage + ")").css("background-color", "#808080");
            $(".pageholder div:eq(" + currentFacePage + ")").siblings().css("background-color", "#FFFFFF");
        });
        preventDefault(e);
    });
});