<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// 文档
if (env('APP_DEBUG')) {
    Route::get('/document', function () {
        return view('doc');
    });
}

Route::get('/', 'Home\IndexController@index');
Route::get('/sina', 'Home\loginCallbackController@sinaCallback');
Route::get('/wx', 'Home\loginCallbackController@wxCallback');
Route::get('/qqLogin', 'Home\IndexController@qqLogin');
Route::get('/qqCallback', 'Home\loginCallbackController@qqCallback');


// 不需要登录
Route::get('/guide', 'Common\GuideControler@index');
Route::get('/agreement', 'Common\AgreementControler@index');
Route::get('/test', 'Test\TestController@index');
Route::get('/lottery/generate', 'Common\LotteryTestController@index');

Route::get('/goods/member', 'Goods\MemberGoodsController@index');
Route::get('/goods/lucky', 'Goods\LuckyGoodsController@index');

Route::get('/goods/{id}', 'Goods\MemberGoodsController@detail');
Route::get('/goods/attrs', 'Goods\MemberGoodsController@getAttrs');

Route::get('/merchant/{id}', 'Goods\MerchantController@getDetail');

Route::get('/code/send', 'Common\CodeController@send');

Route::get('/register', 'Auth\RegisterController@create');
Route::post('/register', 'Auth\RegisterController@post');

Route::get('/forgot/password', 'Auth\ForgotPasswordController@create');
Route::post('/forgot/password', 'Auth\ForgotPasswordController@post');

Route::post('/login', 'Auth\LoginController@login');

Route::get('/logout', 'Auth\LogoutController@index');

Route::get('/lotteries', 'Lottery\LotteryController@index');
Route::get('/lottery/{expect}', 'Lottery\LotteryController@detail');

// 支付宝异步回调
Route::any('/alipay/notify', 'Pay\AlipayController@notify');

// 图文详情
Route::get('/richtext/{id?}', 'Common\RichtextController@show');

Route::group(['middleware' => 'webCheckLogin'], function () {
    Route::get('/user', 'User\IndexController@detail');
    Route::post('/user/save', 'User\IndexController@save');
    Route::post('/password/reset', 'Auth\ResetPasswordController@save');

    Route::get('/notices', 'User\NoticeController@index');
    Route::get('/notice/delete/{id}', 'User\NoticeController@delete');

    Route::get('/addrs', 'User\AddressController@index');
    Route::get('/addr/create', 'User\AddressController@create');
    Route::post('/addr/save', 'User\AddressController@save');
    Route::post('/addr/delete', 'User\AddressController@delete');
    Route::post('/addr/set_default', 'User\AddressController@setDefault');

    Route::get('/collects/member', 'Goods\CollectController@member');
    Route::get('/collects/lucky', 'Goods\CollectController@lucky');

    Route::get('/account', 'User\AccountController@index');

    // 支付相关
    Route::post('/sumilate', 'Pay\SimulatePayController@pay');
    Route::post('/alipay/sign', 'Pay\AlipayController@sign'); // 申请支付
    Route::get('/order/pay_succ', 'Order\PaySuccController@show'); // 同步回调

    // 账户相关
    Route::get('/cash', 'User\CashController@create');
    Route::post('/cash', 'User\CashController@cash');

    Route::get('/union/create', 'User\UnionController@create');
    Route::get('pay_password/create', 'Auth\PayPasswordController@create');
    Route::post('pay_password/save', 'Auth\PayPasswordController@save');

    Route::post('/cart/add', 'Order\CartController@add');
    Route::get('/carts', 'Order\CartController@index');
    Route::post('/cart/delete', 'Order\CartController@delete');
    Route::post('/cart/update', 'Order\CartController@update');
    Route::post('/cart/create_order', 'Order\CartController@createOrder');

    Route::get('/order/create', 'Order\OrderController@create');
    Route::post('/order', 'Order\OrderController@store');
    Route::get('/orders', 'Order\OrderController@index');
    Route::get('/order/{id}', 'Order\OrderController@show');
    Route::get('/order/delete/{id}', 'Order\OrderController@destory');

    Route::post('/lottery', 'Order\LotteryController@store');

    Route::get('/comments/create/{id}', 'Order\CommentController@create');
    Route::post('/comments', 'Order\CommentController@store');

    Route::get('/services', 'Order\ServiceController@index');
    Route::get('/services/{id}', 'Order\ServiceController@show');
    Route::get('/services/create/{id}', 'Order\ServiceController@create');
    Route::post('/services', 'Order\ServiceController@store');

    Route::post('/simulate/pay', 'Pay\SimulatePayController@pay');


});

Route::group(['middleware' => 'ajaxCheckLogin'], function () {
    Route::post('/collect', 'Goods\CollectController@update');
});