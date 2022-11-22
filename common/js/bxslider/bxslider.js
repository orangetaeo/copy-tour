$(document).ready(function(){

	/* main_visual1 */
	Mainslider = $(".main_slide").bxSlider({
		auto:true,
		mode:'fade',
		pause:5000,
		pager:true,
		controls:false,
		onSlideBefore: function(){
			$('.main_visual .slide01 > a').hide().stop().animate({opacity:'0',marginTop:100})
			$('.main_visual .slide02 > a').hide().stop().animate({opacity:'0',marginTop:100}) 
			$('.main_visual .slide03 > a').hide().stop().animate({opacity:'0',marginTop:100})
		},
	    onSliderLoad: function(){
			$('.main_visual .slide01 > a').show().stop().animate({opacity:'1',marginTop:0},1500)
			$('.main_visual .slide02 > a').show().stop().animate({opacity:'1',marginTop:0},1500)
			$('.main_visual .slide03 > a').show().stop().animate({opacity:'1',marginTop:0},1500)
		},
	    onSlideAfter: function(){
			$('.main_visual .slide01 > a').show().stop().animate({opacity:'1',marginTop:0},1500)
			$('.main_visual .slide02 > a').show().stop().animate({opacity:'1',marginTop:0},1500)
			$('.main_visual .slide03 > a').show().stop().animate({opacity:'1',marginTop:0},1500)
		}
	});

});