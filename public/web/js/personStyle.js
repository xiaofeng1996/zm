function previewImage(file, target) {
    fileName = $("#img").val();
    var MAXWIDTH = 218;     //用来显示上传图片的宽度
    var MAXHEIGHT = 158;     //用来显示上传图片的高度
    var div = document.getElementById('preview');
    if (file.files && file.files[0]) {
        var img = document.getElementById(target);
        img.onload = function () {
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            img.width = rect.width;
            img.height = rect.height;
            // img.style.marginLeft = rect.left+'px';
            // img.style.marginTop = rect.top+'px';
        };
        var reader = new FileReader();
        reader.onload = function (evt) {
            img.src = evt.target.result;
        };
        reader.readAsDataURL(file.files[0]);
    }
    else {
        var sFilter = 'filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
        file.select();
        var src = document.selection.createRange().text;
        div.innerHTML = '<img id=imghead>';
        var img = document.getElementById('imghead');
        img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        status = ('rect:' + rect.top + ',' + rect.left + ',' + rect.width + ',' + rect.height);
        // div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;margin-left:"+rect.left+"px;"+sFilter+src+"\"'></div>";
        div.innerHTML = "<div id=divhead style='width:" + rect.width + "px;height:" + rect.height + "px;+" + sFilter + src + "\"'></div>";
    }
}
function clacImgZoomParam(maxWidth, maxHeight, width, height) {
    var param = {top: 0, left: 0, width: width, height: height};
    if (width > maxWidth || height > maxHeight) {
        rateWidth = width / maxWidth;
        rateHeight = height / maxHeight;
        if (rateWidth > rateHeight) {
            param.width = maxWidth;
            param.height = Math.round(height / rateWidth);
        } else {
            param.width = Math.round(width / rateHeight);
            param.height = maxHeight;
        }
    }
    param.left = Math.round((maxWidth - param.width) / 2);
    param.top = Math.round((maxHeight - param.height) / 2);
    return param;
}


$(function () {
    $('.person-nav ul li a').click(function () {
        if(!$('.person-nav').hasClass('witless')){
            $('.nav-content').hide();
            $('.person-nav ul li').removeClass('selected');
            console.log($(this).data('target'));
            $(this).parent().addClass('selected')
            $($(this).data('target')).show();
        }

    });

    //radio button
    $('.person-radio').click(function () {
        $('.person-radio').removeClass('on');
        $(this).addClass('on');
    });

    //菜单点击事件
    $('#content .catagory-con .c-wrap > ul > li').click(function () {
        var $ul = $(this).children('ul');
        if($ul.is(':visible')){
            $(this).children('ul').slideUp();
        }else{
            $(this).children('ul').slideDown();
        }
    })

    // //支付点击事件
    // $('.pay-nav ul>li').click(function(){
    //     $('.pay-nav ul>li').removeClass('selected');
    //     $(this).addClass('selected');
    //     $(this).children('pay-radio').addClass('on');
    //     $('.pay-nav-content').hide();
    //     $($(this).data('target')).show();
    // });
});