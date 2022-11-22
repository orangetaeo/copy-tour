$(document).ready(function(){

		var owl = $('#slider');
		owl.owlCarousel({
			autoPlay: 3000,
			items : 4,
			itemsDesktop : [1199,4],
			itemsDesktopSmall : [950,3],
			itemsTablet: [768,2],
			itemsMobile : [640,1],

			pagination: true
			// paginationNumbers: true
		});

		$(".next").click(function(){
			owl.trigger('owl.next');
		})
		$(".prev").click(function(){
			owl.trigger('owl.prev');
		})
		$(".play").click(function(){
			owl.trigger('owl.play',1000);
		})
		$(".stop").click(function(){
			owl.trigger('owl.stop');
		})
		
});