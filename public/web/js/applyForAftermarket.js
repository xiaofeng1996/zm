/**
 * Created by Administrator on 2017/1/9.
 */


$(function () {
    $('.order-form .form-group .btn-upload-img img').click(function () {
        var t =  $(this).data('target');
        console.log(t);
        $(t).click();
    });
});
