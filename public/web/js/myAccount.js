/**
 * Created by Administrator on 2017/1/17.
 */

$(function () {
    //购物金充值
    $('#recharge').click(function () {
        $('#ruleModal').modal();
    });

    //去支付
    $('#goPay').click(function () {
        $('#ruleModal').modal('hide');
        $('#payDialog').modal();
    });

    $('#payDialog .pay-item').click(function(){
        $('#payDialog .pay-item').removeClass('selected');
        $(this).addClass('selected');
        $('#payDialog .pay-item>.pay-radio').removeClass('on');
        $(this).find('.pay-radio').addClass('on');
    });

    //联系人
    $('#contact').click(function(){
        $('#contactDialog').modal();
    });

    $('#contactDialog ul li').click(function(){
        $('#contactDialog ul li').removeClass('selected');
        $(this).addClass('selected');
        $('#contactDialog ul li>.pay-radio').removeClass('on');
        $(this).find('.pay-radio').addClass('on');
    });
});