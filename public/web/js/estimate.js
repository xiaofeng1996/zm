/**
 * Created by Administrator on 2017/1/9 0009.
 */

$(function(){
    $('.order-form .form-group .btn-upload-img img').click(function () {
        var t =  $(this).data('target');
        console.log(t);
        $(t).click();
    });
    
    $('.order-form ul.flower-list li').click(function (e) {
        $('.order-form ul.flower-list li').removeClass('checked');

        $("#star").val($(this).index() + 1);
        console.log($("#star").val());

        for(var i = 0; i < $(this).index() + 1; i++){
            $('.order-form ul.flower-list li:eq('+i+')').addClass('checked');
        }
    })
});