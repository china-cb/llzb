 // (function($){
 //      $(document).ready(function(){
 //          $(".industry_ul,.addres_ul1s,.years_list").mCustomScrollbar();
 //      });
 //  })(jQuery);
    var countdown=60;
	function settime(obj) {
	    if (countdown == 0) {
	        obj.removeAttribute("disabled");
	        obj.value="免费获取验证码";
	        countdown = 60;
	        return;
	    } else {
	        obj.setAttribute("disabled", true);
	        obj.value="重新发送(" + countdown + ")";
	        countdown--;
	    }
	setTimeout(function() {
	    settime(obj) }
	    ,1000)
	}
  var account_index = {
  	companys:function () {
  		$(document).on("click",".industrys,.industry_ul li",function() {
		  $(".industry_ul").toggleClass("industry_ul_act");
		});
		$(document).on("click",".vocation",function() {
			var a = $(this).index();
			var industry_text = $(".vocation").eq(a).text();
			$(".industry_inner").text(industry_text);
		});
  	},
  	industry:function() {
		$(".local_input1,.addres_li").click(function(){
		  $(".addres_ul1").toggleClass("addres_u_act");
		});
		$(".l_write1s").click(function(){
		  $(".l_write2s").css("display","block");
		});
		
		$(document).on("click",".addres_li",function() {
			var a = $(this).index();
			var addres_text = $(".addres_li").eq(a).text();
			$(".local_input1").val(addres_text);
			$(".addres_ul2s").eq(a).addClass("addres_u_act").siblings(".addres_ul2s").removeClass("addres_u_act");
		});

		$(".addres_li2").on("click",function() {
			var aa = $(this).index(".addres_li2");
			var addres_text = $(".addres_li2").eq(aa).text();

			$(".local_input2").val(addres_text);
			$(".addres_ul2s").removeClass("addres_u_act");
		});

		$(".local_input3,.addres_li3").click(function(){
		  $(".addres_ul3s").toggleClass("addres_u_act");
		});
		$(".addres_li3").on("click",function() {
			var a = $(this).index();
			var addres_text = $(".addres_li3").eq(a).text();
			$(".local_input3").val(addres_text);
		});
  	},
  	modify:function () {
  		$(document).on("click",".modify",function() {
		  $(".basic_info").toggleClass("basic_info_act");
		  $(".modify").toggleClass("modify_act");
		  $(".industry_ul").removeClass("industry_ul_act");
		});
  	},
  	blocks:function() {
  		$(".ig-item").on("click",function() {
  			var a = $(this).index(".ig-item");
  			$(".block1s").removeClass("block_act");
  			$(".block2s").eq(a).addClass("block_act").siblings(".block2s").removeClass("block_act");
  		});
  		$(".menu-item").on("click",function() {
  			var a = $(this).index();
  			$(".content").eq(a).addClass("content_act").siblings(".content").removeClass("content_act");
			var b = $(this).data('val');
			$("#bill_list").val(b);
  		});
  		$(".mi-text").on("click",function() {
  			$(".block1s").addClass("block_act");
  			$(".block2s").removeClass("block_act");

  		})
  	},
  	file_upload:function() {
  		$(".file_upload").change(function() {
			var $file = $(this); var $file_indx = $(this).index(".file_upload");var fileObj = $file[0];var windowURL = window.URL || window.webkitURL;var dataURL;var $img = $(".preview").eq($file_indx);
			if(fileObj && fileObj.files && fileObj.files[0]){
				dataURL = windowURL.createObjectURL(fileObj.files[0]);
				$img.attr('src',dataURL);
			}else{dataURL = $file.val();var imgObj = $(".preview").eq($file_indx);}});
	  	},
	  statistics:function () {
	  	$(".li_text1").click(function(){
		  $(".years_list1").toggleClass("years_list_act");
		  $(".icon1").toggleClass("i_act");
		});
		$(".years_li").on("click",function() {
			var a = $(this).index();
		    var years_li_text = $(".years_li").eq(a).text();
			// $(".li_text1s").text(years_li_text);
			$(".icon1").toggleClass("i_act");
			$(".years_list1").toggleClass("years_list_act");
		});



		$(".li_text2").click(function(){
		  $(".years_list2").toggleClass("years_list_act");
		  $(".icon2").toggleClass("i_act");
		});
		$(".years_li2").on("click",function() {
			var a = $(this).index();
		    var years_li_text = $(".years_li2").eq(a).text();
			// $(".li_text2s").text(years_li_text);
			$(".icon2").toggleClass("i_act");
			$(".years_list2").toggleClass("years_list_act");
		});


	  },
	  amount_money:function() {
	  	$(".labels").on("click",function() {
			var a = $(this).index();
			$(".labels").eq(a).addClass("labels_act").siblings(".labels").removeClass("labels_act");
		});
	  },

	  laydates:function() {
	 //  	$("td").on("click",function() {
		// 	// var a = $(this).index();
		// 	// $(".date_span1").removeClass("date_span1_act");
		// 	console.log('123');
		// });

	  	// $(".laydate_box").prepend("123");
	  },
	  pages:function() {
	  	$(".pagination li").first().children("span").html('前页');
        $(".pagination li").first().children("a").html('前页');
        $(".pagination li").last().children("span").html('后页');
        $(".pagination li").last().children("a").html('后页');
	  },
	  records:function () {
	  	$(".records>a").on("click",function() {
			var a = $(this).index(".records>a");
			$(".records>a").eq(a).addClass("active").siblings(".records>a").removeClass("active");
			var bill = $(this).data('bill');
			$("#bill_list").val(bill);
		});
		var adds = '<i class="iconfont">&#xe649;</i>增加时长（分钟）',
		    reduces = '<i class="iconfont">&#xe65e;</i>减少时长（分钟）';
		$(".records>a").eq(0).on("click",function() {
			$(".adds_or_reduces").html(adds);
		});
		$(".records>a").eq(1).on("click",function() {
			$(".adds_or_reduces").html(reduces);
		});
	  }
  };

// 日期选择
var start = {
  elem: '#start',
  format: 'YYYY/MM/DD',
  min: '0000-06-16 23:59:59', //设定最小日期为当前日期
  max: '2099-06-16 23:59:59', //最大日期
  istime: false,
  istoday: false,
  isclear: false,
  issure: false,
  choose: function(datas){
     end.min = datas; //开始日选好后，重置结束日的最小日期
     end.start = datas; //将结束日的初始值设定为开始日
	 $("#start_date").val(end.min);
	  var end_date = $("#end_date").val();
	  var sta_date = end.min;
	  var url = $("#recharge_ajx").val();
	  common.ajax_post(url, {sta_date:sta_date,end_date:end_date}, true, function (rt) {
		  var obj = common.str2json(rt);
		  if(obj.code == 1){
			  $(".rechage").html(obj.html);
		  }else {
			  layer.msg(obj.msg,{icon:1});
		  }
	  })
  }
};
var end = {
  elem: '#end',
  format: 'YYYY/MM/DD',
  min:  '0000-06-16 23:59:59',
  max: '2099-06-16 23:59:59',
  istime: false,
  istoday: false,
  isclear: false,
  issure: false,
  choose: function(datas){
    start.max = datas; //结束日选好后，重置开始日的最大日期
	  $("#end_date").val(start.max);
	  var sta_date = $("#start_date").val();
	var end_date = start.max;
	var url = $("#recharge_ajx").val();
	  common.ajax_post(url, {sta_date:sta_date,end_date:end_date}, true, function (rt) {
		  var obj = common.str2json(rt);
		  if(obj.code == 1){
			  $(".rechage").html(obj.html);
		  }else {
			  layer.msg(obj.msg,{icon:1});
		  }
	  })
  }
};

$(function() {
		// 下拉框
	account_index.industry();
	account_index.companys();
	// 修改信息
	account_index.modify();
	// 右边选项卡
	account_index.blocks();
	// 实名认证上传图片
	account_index.file_upload();
	// 消费总计
	account_index.statistics();

	account_index.amount_money();

	account_index.laydates();
	// TP分页
	account_index.pages();
	// 日期选择
	account_index.records();
	laydate(start);
	laydate(end);

});
