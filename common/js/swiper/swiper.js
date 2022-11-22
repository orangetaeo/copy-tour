$(document).ready(function(){
	var swiper = new Swiper('.swiper-container', {
		pagination: '.swiper-pagination',
		paginationClickable: true,
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',
			grabCursor: true,
			centeredSlides: true,
			slidesPerView: 'auto',
			//effect: 'coverflow',
			//coverflow: {
			//	rotate: 50,
			//	stretch: 0,
			//	depth: 100,
			//	modifier: 1,
			//	slideShadows : true
			//}
		autoplay: 3500,
		speed: 1500,
		autoplayDisableOnInteraction:false,
		loop: true
	});
});