$(document).ready(function(){

	$('.main_add .main_add_inn ul').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		arrows: true,
		fade: false,
		dots:false,
		autoplay: true,
		autoplaySpeed: 4000,
		centerMode: true,
		centerPadding:"0px",
		speed:2000,
		infinite:true,
		variableWidth:true,
		pauseOnHover:false,
		focusOnSelect:true,
		prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Prev" tabindex="0" role="button"><i class="xi-angle-left"></i></button>',
		nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"><i class="xi-angle-right"></i></button>'
	});

});
