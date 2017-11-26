/**
 * Created by apple on 11/4/17.
 */

$('.season a').on('click',function(){
    var index=$(this).attr('data-index');
    $(window).scrollTop(0);
    $('.table').eq(index).show().siblings('.table').hide();
    if(index==4){
        $('.season>ul>li').eq(0).addClass('on').siblings().removeClass('on');
  }
//  else if(index!=0){
//      $('.header').addClass('different');
//  }else if(index==0){
//      $('.header').removeClass('different');
//  }

    $('.season>ul>li').eq(index).addClass('on').siblings().removeClass('on');



});











