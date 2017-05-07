
$(function(){
    var curCatagorList;
    $('#catagory-list').mouseenter(function () {
        $(curCatagorList).css('display','block');
        $('#G-catagory').show();
    });
    $('#catagory-list').mouseleave(function () {

        $(curCatagorList).css('display','none');
        $('#G-catagory').hide();
    });
    $('#catagory-list ul li').mouseenter(function(){
        $(curCatagorList).css('display','none');
        $('#G-catagory').hide();
        curCatagorList = $(this).data('target');
        $($(this).data('target')).css('display','block');
        $('#G-catagory').show();
    });
   $('#catagory-list ul li').mouseleave(function(){
       curCatagorList = $(this).data('target');
       $(target).hide();
       $('#G-catagory').hide();
   });
    $('#G-catagory').mouseenter(function(){
        $(curCatagorList).css('display','block');
        $('#G-catagory').show();
    })
    $('#G-catagory').mouseleave(function () {
        $(curCatagorList).css('display','none');
        $('#G-catagory').hide();
    });
});