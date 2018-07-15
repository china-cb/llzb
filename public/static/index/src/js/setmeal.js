var submits = {
	chooses:function() {
		var temp1=$(".set_choose"),
			temp2=$(".charging_ul2s>li"),
			temp3=$(".ways>span");
		temp1.on("click",function() {
			var a = $(this).index(".set_choose");
			$(".set_choose").eq(a).addClass("set_choose_act").siblings(".set_choose").removeClass("set_choose_act set_choose2s");
			$(".basis1").eq(a).addClass("basis_act").siblings(".basis1").removeClass("basis_act");
		});

		temp1.eq(0).on("click",function() {
			$(this).eq(0).children(".arrow_down").addClass("arrow_down_act");
			$(".charging_ul2s>li").children(".arrow_down").removeClass("arrow_down_act");
			$(".payment_right").html('--');
			var price = $("#price").data('val');
			$("#price_money").val(price);
			$("#package_type").val(14);
		});

		temp1.eq(1).on("click",function() {
			$(".set_choose").eq(0).children(".arrow_down").removeClass("arrow_down_act");
			$(this).addClass("set_choose2s");
			$(".payment_right").html('--');
			$("#price_money").val('');
		});

		temp2.on("click",function() {
			var a = $(this).index(".charging_ul2s>li");
			temp2.eq(a).children(".arrow_down").addClass("arrow_down_act").parent().siblings(".charging_ul2s>li").children(".arrow_down").removeClass("arrow_down_act");
			temp2.eq(a).addClass("li_act").siblings(".charging_ul2s>li").removeClass("li_act");
			var b = $(this).data('val');
			$("#package_type").val(b);
			var url = $("#pay_url").val();
			common.ajax_post(url,{b:b}, true, function (rt) {
				var obj = common.str2json(rt);
				if(obj.code == 1){
					$(".payment_right").html(obj.ret_data['money']);
					$("#package_money").val(obj.ret_data['money']);
				}else {
					layer.msg(obj.msg,{icon:2});
				}
			})
		});

		temp3.on("click",function() {
			var a = $(this).index(".ways>span");
			temp3.eq(a).addClass("span_act").siblings(".ways>span").removeClass("span_act");
			temp3.eq(a).children(".arrow_down").addClass("arrow_down_act").parent().siblings(".ways>span").children(".arrow_down").removeClass("arrow_down_act");
			var b = $(this).data('type');
			$("#pay_type").val(b);
		})

	},
	init:function(){
		var np=init_num_picker($("#chose_money_picker")),
			pns= init_slide_ver("#chose_money_slide",
				function(dom,i){
					np.val(i,true);
				}
			);
		np.set_cb(function(){
			pns.val(np.val(),true);
		});

		/*初始化slide picker (new)*/
		function init_slide_ver(dom,onchange){
			if(typeof(dom)=="string"){
				dom=$(dom);
			}
			if(!dom||!dom.length||dom.length<=0){
				return null;
			}
			var max=parseInt(dom.data("max")),
				min=parseInt(dom.data("min")),
				slide=dom.find(".slide-btn"),
				w=dom.outerWidth(),
				fix=slide.outerWidth()/2,
				input=dom.find("input"),
				fr_block=dom.find(".slide-front"),
				x_temp,l_temp,flag;
			if(isNaN(max)||isNaN(min)){
				return null;
			}

			init_bind();
			/*初始化&绑定事件*/
			function init_bind(){
				console.log(min);
				set_get(min,1);
				fr_block.width(0);
				$(document).on({
					"mousemove":function(e){
						if(flag){
							var left=l_temp+e.pageX-x_temp;
							slide_con(left);
						}
					},
					"mouseup":function(e){
						if(flag){
							flag=0;
						}
					}
				});
				slide.on({
					"mousedown":function(e){
						x_temp=e.pageX;
						l_temp=parseInt(slide.css("left"));
						flag=1;
					}
				});
			}
			/*slide滑动控制*/
			function slide_con(left,is_simple){
				if(left<=-fix){
					left=-fix;
				}else if(left>=w-fix){
					left=w-fix
				}
				slide.css({
					"left":left
				});
				fr_block.width(left+fix);
				change_val(is_simple);
				var custom_pay = $("#package_time").val();
				var pay_amount = $("#price_money").val();
				var a = Number(custom_pay)*Number(pay_amount);
				$(".payment_right").html(a);
				$("#package_money").val(a);
			}
			/*数值改变控制*/
			function change_val(is_simple){
				var left=parseInt(slide.css("left"))  + fix,
					val=parseInt((max-min)*(left/w)+min),
					change_temp=val-parseInt(input.val());
				input.val(val);
				if(typeof(onchange)=="function"&&!is_simple){
					onchange(dom,val,change_temp);
				}
			}
			/*设置&获取*/
			function set_get(i,is_simple){
				i=parseInt(i);
				if(!isNaN(i)){
					if(i<min){
						i=min;
					}
					if(i>max){
						i=max;
					}
					var left=w*((i-min)/(max-min))-fix;
					slide_con(left,is_simple);
				}
				return input.val();
			}
			return {
				val:set_get
			}
		}

		/*初始化 numberpicker*/
		function  init_num_picker(dom){
			if(!dom.length){
				return;
			}
			var picker=dom,
				input=picker.find("input"),
				error=picker.find(".error"),
				setting=picker.data(),
				max=parseInt(setting.max),
				min=parseInt(setting.min),
				val=parseInt(setting.val),
				error_timer,
				error_max=setting.errmax,
				error_min=setting.errmin,
				cb,key_timer;
			if(!error_max){
				error_max="数值最大{0}"
			}
			if(!error_min){
				error_min="数值最小{0}"
			}
			error_max=error_max.replace("{0}",setting.max);
			error_min=error_min.replace("{0}",setting.min);
			init();
			/*初始化*/
			function init(){
				set_val();
				init_bind();
			}
			/*刷新显示*/
			function set_val(is_simple){

				if(val>=max){
					if(val>max){
						error.addClass("active").text(error_max);
						if(error_timer){
							clearTimeout(error_timer);
						}
						error_timer= setTimeout(function(){
							error.removeClass("active");
						},2000);
					}
					val=max;
				}
				if(val<=min){
					if(val<min){
						error.addClass("active").text(error_min);
						if(error_timer){
							clearTimeout(error_timer);
						}
						error_timer= setTimeout(function(){
							error.removeClass("active");
						},2000);
					}
					val=min;
				}
				console.log(val);
				input.val(val);
				if(typeof(cb)=="function"&&!is_simple){
					cb(val);
				}
			}
			function get_input(){
				var temp =parseInt(input.val());
				$("#package_time").val(temp);
				if(!isNaN(temp)){
					val=temp;
				}
				set_val();
			}
			/*事件绑定*/
			function init_bind(){
				input.on("keyup",function(e){
					if(e.keyCode>=48&&e.keyCode<=90||e.keyCode>=96&&e.keyCode<=111||e.keyCode==8){
						clearTimeout(key_timer);
						key_timer=setTimeout(function(){
							get_input();
						},300);
					}
					if(e.keyCode==32){
						get_input();
					}
				});
				input.on("blur",function(e){
					get_input();
				})
			}

			function set_get(i,is_simple){
				if(i){
					var temp =parseInt(i);
					$("#package_time").val(temp);

					if(!isNaN(temp)){
						val=temp;
					}
					set_val(is_simple);
				}
				return val;
			}
			return {
				val:set_get,
				set_cb:function(callback){
					cb=callback;
				}
			}
		}

	}
};
$(function(){
	submits.chooses();
	submits.init();
});
