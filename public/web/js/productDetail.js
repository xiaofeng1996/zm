$(function(){

    $('.d-nav ul li').click(function(){
        $('.d-nav ul li').removeClass('selected');
        $(this).addClass('selected');
        $('#product-description').hide();
        $('#product-review').hide();
        $($(this).data('target')).fadeIn(30);
    });

    $('#product-info #collection-product').click(function(){
        $('#colletSuccess').modal();
    });

});