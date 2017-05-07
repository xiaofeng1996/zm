<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 不需要身份验证的操作
Route::post('/init', 'Common\InitController@index');

Route::post('/banners', 'Common\BannerController@index');
Route::get('/banner/{$id}', 'Common\BannerController@getOne'); // 幸运区规则

Route::get('/guide', 'Common\WapController@guide');
Route::get('/agreement', 'Common\WapController@agreement');
Route::get('/aboutUs', 'Common\WapController@aboutUs');
Route::get('/rule', 'Common\WapController@rule'); // 幸运区规则
Route::get('/balance_refer', 'Common\WapController@balanceRefer'); // 幸运区规则

Route::post('/advice', 'Common\AdviceController@create');

Route::post('/code/send', 'Common\CodeController@send');

Route::post('/register', 'Auth\RegisterController@index')->middleware('checkCode');
Route::post('/login', 'Auth\LoginController@index');

Route::post('/registered', 'Auth\RegisteredController@index');

Route::post('/register/third', 'Auth\ThirdRegisterController@index')->middleware('checkCode');
Route::post('/login/third', 'Auth\ThirdLoginController@index');

Route::post('/password/find', 'Auth\PasswordController@index')->middleware('checkCode');

// 暂时去掉 token 刷新功能
// Route::post('/token/refresh', 'Auth\TokenController@refresh');

Route::get('/test', 'Test\TestController@index');

//---------------------------- 商品相关 --------------------------------------- start

Route::post('/category', 'Goods\CategoryController@index');

Route::post('/goods/list', 'Goods\GoodsController@index');
Route::post('/goods/one', 'Goods\GoodsController@getOne');
Route::post('/goods/attrs', 'Goods\GoodsAttrController@getAttrs');

Route::post('/comments', 'Order\CommentController@index');

//---------------------------- 商品相关 --------------------------------------- end

Route::get('/lottery/collect', 'Lottery\CollectController@collect');
Route::post('/lotteries', 'Lottery\LotteryController@lasts');
Route::post('/lottery', 'Lottery\LotteryController@getLotteryByExpect');
Route::post('/lottery/last', 'Lottery\LotteryController@last');

// 需要身份验证的操作
Route::group(['middleware' => 'apiCheckLogin'], function () {
    Route::post('/user', 'Auth\UserController@index');
    Route::post('/user/update', 'Auth\UserController@update');
    Route::post('/user/mobile', 'Auth\UserController@bindMobile')->middleware('checkCode');
    Route::post('/password/reset', 'Auth\PasswordController@reset');
    Route::post('/paypassword/reset', 'Auth\PasswordController@payPasswordReset')->middleware('checkCode');
    // Route::post('/logout', 'Auth\LoginController@logout');

    Route::post('/address/create', 'Auth\AddressController@create');
    Route::post('/address/destroy', 'Auth\AddressController@destroy');
    Route::post('/address/update', 'Auth\AddressController@update');
    Route::post('/address', 'Auth\AddressController@index');
    Route::post('/address/setDefault', 'Auth\AddressController@setDefault');

    Route::post('/file/upload', 'Common\FileController@index');

    //---------------------------- 商品相关 --------------------------------------- start

    Route::post('/goods/collect', 'Goods\CollectController@index');

    //---------------------------- 商品相关 --------------------------------------- end

    //---------------------------- 购物车相关 --------------------------------------- start 

    Route::post('/cart/create', 'Cart\CartController@create');
    Route::post('/cart/update', 'Cart\CartController@update');
    Route::post('/cart/delete', 'Cart\CartController@delete');
    Route::post('/carts', 'Cart\CartController@index');

    //---------------------------- 购物车相关 --------------------------------------- end

    //---------------------------- 订单相关 --------------------------------------- start 

    Route::post('order/create', 'Order\OrderController@create');
    Route::post('orders', 'Order\OrderController@index');
    Route::post('order', 'Order\OrderController@one');
    Route::post('order/delete', 'Order\OrderController@delete');
    Route::post('order/receipt', 'Order\OrderController@receipt');

    Route::post('service/apply', 'Order\ServiceController@apply');
    Route::post('services', 'Order\ServiceController@index');
    Route::post('service', 'Order\ServiceController@one');

    Route::post('comment/create', 'Order\CommentController@create');

    // 模拟操作
    if (env('APP_DEBUG')) {
        Route::post('order/deliver', 'Order\OrderTestController@deliverTest'); // 模拟发货
    }

    //---------------------------- 订单相关 --------------------------------------- end

    //---------------------------- 支付相关 --------------------------------------- start

    if (env('APP_DEBUG')) {
        Route::post('pay/simulate', 'Pay\SimulatePayController@pay');
    }

    Route::post('pay/test', 'Pay\PayTestController@index');
    Route::post('pay/balance', 'Pay\BalancePayController@pay');

    Route::post('pay/alipay', 'Pay\AlipayController@sign');
    Route::post('pay/alipay/notify', 'Pay\AlipayController@notify');

    //---------------------------- 支付相关 --------------------------------------- end

    
    //---------------------------- 用户相关杂项 --------------------------------------- start

    Route::post('balances', 'Balance\BalanceController@index');
    Route::post('contacts', 'Balance\ContactController@index');
    Route::post('banks', 'Balance\BankController@index');
    Route::post('cash', 'Balance\CashController@cash');

    //---------------------------- 用户相关杂项 --------------------------------------- end

    //---------------------------- 彩票相关 --------------------------------------- start

    Route::post('lottery/create', 'Lottery\OrderLotteryController@create');
    Route::post('lucky/orders', 'Lottery\OrderController@index');
    Route::post('lottery/glance', 'Lottery\OrderLotteryController@glance');

    //---------------------------- 彩票相关 --------------------------------------- end

    Route::post('notices', 'Common\NoticeController@index');
    Route::post('notice/read', 'Common\NoticeController@read');
    Route::post('notice/delete', 'Common\NoticeController@delete');

});

