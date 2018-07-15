
/************界面相关的脚本*************/
function switchView() {
    var video=$("#displayBox"),
        video_inner=$("#playerView"),
        wb=$("#wis_context"),
        wb_inner=$("#wis_context_inner");
    if (!!document.createElement('canvas').getContext) {
        if (!$(".pv-object").hasClass("switch")) {
            WIS.Resize(278, 180);
            WIS.AllowDraw({ ballow: false });
            video_inner.find("object").css({"width":920,"height":640});
            video.append(wb_inner);
            wb.append(video_inner);
            $(".pv-object").addClass("switch");
        } else {
            WIS.Resize(920, 640);
            video_inner.find("object").css({"width":278,"height":180});
            WIS.AllowDraw({ ballow: false });
            video.append(video_inner);
            wb.append(wb_inner);
            $(".pv-object").removeClass("switch");
        }
    }
    else {
        if (!$(".pv-object").hasClass("switch")) {
            WIS.Resize(278, 180);
            WIS.AllowDraw({ ballow: false });

            video.append(wb_inner);
            wb.append(video_inner);
            $(".pv-object").addClass("switch");
        } else {
            WIS.Resize(920, 640);
            WIS.AllowDraw({ ballow: false });
            video.append(video_inner);
            wb.append(wb_inner);
            $(".pv-object").removeClass("switch");
        }
    }
}

$(function () {
    $(document).on(".click", ".toolItem", function () {
        if (!$(this).attr("data-cmd")) {
            $(this).addClass("selectItem");
            $(this).siblings(".toolItem").removeClass("selectItem");
        }
    });
    $(document).on(".click", "#lockTool", function () {
        if ($(this).hasClass("selectItem")) {
            $(this).removeClass("selectItem");
        } else {
            $(this).addClass("selectItem");
        }
    });
});
