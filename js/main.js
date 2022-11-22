/* common */
$(document).ready(function(){

	//스크롤 움직일때 주메뉴	
	$(window).on("scroll", function(){
		if( $(this).scrollTop() >= 10){
			$("header").addClass("on");
		}else{
			$("header").removeClass("on");
		}
	});

	//탑버튼
	$('#top').click(function(){
		$("html, body").stop().animate({scrollTop : 0},600);
	});

	//페이징
	$(".paging ul li").click(function(){
		$(".paging ul li").removeClass("on");
		$(this).addClass("on");
	});

});

/* main */
$(document).ready(function(){

	//메인비쥬얼
	$(".main_visual .mai_slide ul").slick({
		autoplay : true,
		slidesToShow: 1,
		slidesToScroll: 1,
		asNavFor: '.main_visual .slide_nav ul',
		autoplaySpeed: 5000,		
		arrows: false
	});
	$(".main_visual .slide_nav ul").slick({
		slidesToShow:3,
		slidesToScroll: 1,
		centerMode:true,
		asNavFor: '.main_visual .mai_slide ul',
		focusOnSelect: true
	});

});

/* member */
$(document).ready(function(){

	//로그인
	$(".login .con .find .btn_log").click(function(){
		$(".login .log").css("display","block");
		$(".login .find_id").css("display","none");
		$(".login .find_pw").css("display","none");
	});
	$(".login .con .find .btn_find_id").click(function(){
		$(".login .log").css("display","none");
		$(".login .find_id").css("display","block");
		$(".login .find_pw").css("display","none");
	});
	$(".login .con .find .btn_find_pw").click(function(){
		$(".login .log").css("display","none");
		$(".login .find_id").css("display","none");
		$(".login .find_pw").css("display","block");
	});

});

//------------------------------ 달력 s ------------------------------//
jQuery(function($){
$.datepicker.regional['ko'] = {
	closeText: '닫기',
	prevText: '이전',
	nextText: '다음',
	currentText: '오늘',
	monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
	monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
	dayNames: ['일','월','화','수','목','금','토'],
	dayNamesShort: ['일','월','화','수','목','금','토'],
	dayNamesMin: ['일','월','화','수','목','금','토'],
	weekHeader: 'Wk',

	showAnim: 'show', changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd',
	firstDay: 0,
	isRTL: false,
	showMonthAfterYear: true,
	yearSuffix: '',
};

$.datepicker.setDefaults($.datepicker.regional['ko']);

$('#date1').datepicker();
$('#date2').datepicker();
$('#date3').datepicker();
$('#date4').datepicker();
$('#date5').datepicker();
$('#date6').datepicker();
$('#date7').datepicker();
$('#date8').datepicker();
$('#date9').datepicker();
$('#date10').datepicker();
$('#date11').datepicker();
$('#date12').datepicker();
$('#date13').datepicker();
$('#date14').datepicker();
$('#date15').datepicker();
$('#date16').datepicker();
$('#date17').datepicker();
$('#date18').datepicker();
$('#date19').datepicker();
$('#date20').datepicker();
});
//------------------------------ 달력 e ------------------------------//





function inputHPNumber(obj) {

	if(event.keyCode != 8) {

		if(obj.value.replace(/[0-9 \-]/g, "").length == 0) {

			let number = obj.value.replace(/[^0-9]/g,"");
			let ymd = "";
	
				if(number.length < 4) {
					return number;

				} else if(number.length < 8){
					ymd += number.substr(0, 3);
					ymd += "-";
					ymd += number.substr(3, 4);

				} else {
					ymd += number.substr(0, 3);
					ymd += "-";
					ymd += number.substr(3, 4);
					ymd += "-";
					ymd += number.substr(7, 4);

				}

				obj.value = ymd;

			} else {
				alert("숫자만 입력 가능합니다.");
				obj.value = obj.value.replace(/[^0-9 ^\-]/g,"");
				return false;
			}

		} else {
			return false;
	}
}
