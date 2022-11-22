/* main */
$(document).ready(function(){

        //탑버튼
        $('#top').click(function(){
                $("html, body").stop().animate({scrollTop : 0},600);
        });

        //header 스크롤 움직일때 이벤트 발생 (스크롤탑 값이 0일때 리무브)
        $( window ).scroll(function(){
                if($( window ).scrollTop() == 0){
                        $("header").removeClass("on");
                } else {
                        $("header").addClass("on");
                }
        });

        //시설안내 팝업
        $(".item_list .item_list_inn .sort_wrap #sortlist li").on("click", function(){
                var indexA = $(this).index();
                $(".item_popup .item_popup_inn .box").removeClass("on");
                $(".item_popup").addClass("on");
                $(".item_popup .item_popup_inn .box").eq(indexA).addClass("on");
        });
        $(".item_popup .item_popup_inn .btn_close").click(function(){
                $(".item_popup").removeClass("on");
        });

});



/* board */
$(document).ready(function(){

        //페이지버튼
        $(".page_num ul .nmb a").click(function(e){
                e.preventDefault();
                $(".page_num ul .nmb a").removeClass("on");
                $(this).addClass("on");
        });

        //비밀번호확인
        $(".key_qnaQ").click(function(e){
                e.preventDefault();
                $(".pw_check").addClass("on");
        });
        $(".pw_check .btn_close").click(function(){
                $(".pw_check").removeClass("on");
        });

        //예약확인팝업
        $(".btn_re_check").click(function(e){
                e.preventDefault();
                $(".re_check").addClass("on");
        });
        $(".re_check .btn_close").click(function(){
                $(".re_check").removeClass("on");
        });

});



/* FAQ (아코디언) */
$(document).ready(function(){

        var acodian = {
                click: function(target){
                        var _self = this,
                        $target = $(target);

                        $target.on('click', function(e){
                        e.preventDefault();

                        var $this = $(this);
                                if ($this.next('.answer').css('display') == 'none'){
                                        $('.answer').slideUp();
                                        _self.onremove($target);
                                        $this.addClass('active');
                                        $this.next().slideDown();
                                } else {
                                        $('.answer').slideUp();
                                        _self.onremove($target);
                                }
                        });
                },
                onremove: function($target){
                        $target.removeClass('active');
                }
        };
        acodian.click('.question');

});


/*이니시스 매출전표 출력 */
function go_rec(n) {
	url = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid=" + n + "&noMethod=1" ;
	window.open(url,'crec','left=100,top=100,width=415,height=700,scrollbars,resizable');
}
