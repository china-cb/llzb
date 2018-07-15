
$(function(){
	applications.swipers()
	applications.cilck_animate();
	applications.hiddens();
	applications.scrolls();
	applications.analysis();
})
var applications = {
	swipers:function () {
		$(".Pagination_list").on("mouseenter",function(){
		 	var a = $(this).index(".Pagination_list");
		 	i=a;
		 	$(".Pagination_list").eq(a).addClass("active").siblings().removeClass("active");
		 	$(".swiper-slide").eq(a).stop().fadeIn(1000).siblings().stop().fadeOut(1000)
		 });
		var i=0;
		var t=setInterval(move,2000);
		function move(){
			i++;
			if(i==4){
				i=0;	
			}			
			$(".Pagination_list").eq(i).addClass("active").siblings().removeClass("active");
		 	$(".swiper-slide").eq(i).fadeIn(1000).siblings().fadeOut(1000)
		}
		$(".banners_slide").on("mouseenter",function(){
			clearInterval(t);
		})
		$(".banners_slide").on("mouseleave",function(){
			t=setInterval(move,2000);
		})
	},
	cilck_animate:function () {
		 $(".nav li").on("click",function(){
		 	var a = $(this).index(".nav li");
		 	$(".nav li").eq(a).addClass("active").siblings().removeClass("active");
		 	$(".list_table").eq(a).addClass("active").siblings().removeClass("active");
		 })
	},
	hiddens:function() {
		$(".img_h2").each(function(i){
		    var divH = $(this).height();
		    var $p = $(".h2_inner", $(this)).eq(0);
		    while ($p.outerHeight() > divH) {
		        $p.text($p.text().replace(/(\s)*([a-zA-Z0-9]+|\W)(\.\.\.)?$/, "..."));
		    };
		})
	},
	scrolls:function() {
		  $(window).scroll(function () {
	        var a = $(window).scrollTop();
	        if (a > 200) {
	            $(".fhdb").fadeIn(1000);
	        } else {
	            $(".fhdb").fadeOut(1000);
	        }
	    });
	    $(".fhdb").on("click", function () {
	        $("body,html").animate({scrollTop: 0}, 300);
	        return false;
	    });
	},
	analysis:function() {
		 $(".cont_ul li").on("mouseenter",function(){
		 	var a = $(this).index(".cont_ul li");
		 	$(".cont_ul li").eq(a).addClass("active").siblings().removeClass("active");
		 	$(".cont_img_ul>li").eq(a).stop().fadeIn(800).siblings().stop().fadeOut(800)
		 })
		var i=0;
		var t=setInterval(move2,2000);
		function move2(){
			i++;
			if(i==4){
				i=0;	
			}			
			$(".cont_ul li").eq(i).addClass("active").siblings().removeClass("active");
		 	$(".cont_img_ul>li").eq(i).fadeIn(800).siblings().fadeOut(800)
		}
			$(".cont_ul li,.cont_img_ul>li").on("mouseenter",function(){
				clearInterval(t);
			})
			$(".cont_ul li,.cont_img_ul>li").on("mouseleave",function(){
				t=setInterval(move2,2000);
			})
	}
}