/**
 * Created by Administrator on 2017/1/3 0003.
 */
$(function () {

    $('#pay').click(function () {
        $('#payDialog').modal();
    });

    $('.pay-radio').click(function(){
        $('.pay-radio').removeClass("on");
        $(this).addClass('on');
    });
});