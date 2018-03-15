$(function(){

    $(document).ready(function(){
        //menubar:マウスが載ったらサブメニューを表示
        $("ul.ddmenu li").mouseenter(function(){
            $(this).siblings().find("ul").hide();  // 兄弟要素に含まれるサブメニューを全部消す。
            $(this).children().fadeIn(150);     // 自分のサブメニューを表示する。
        //menubar:どこかがクリックされたらサブメニューを消す
        });
        $("[id^=topmenu]").mouseleave(function(){
                $('ul.ddmenu ul').fadeOut(150);
        });
        $('html').click(function() {
            // $('ul.ddmenu ul').slideUp(150);
            $('ul.ddmenu ul').fadeOut(150);
        });  
        //ナビバーのスクロールトップ
        var nav = $('.nav');
        var navTop = nav.offset().top;
        $(window).scroll(function(){
            var winTop = $(this).scrollTop();
            if(winTop >= navTop){
                nav.addClass('fixed-top')
            } else {
                nav.removeClass('fixed-top')
            }
        });
    });//$(document).ready function
});//function

