<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ADMIN routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin" middleware group. Enjoy building your ADMIN!
|
*/

Route::post('/login', 'Admin\LoginController@login');
Route::get('/', 'Index\IndexController@index');
Route::get('/login/valid', 'Admin\LoginController@isLogin');
Route::get('/logout', 'Admin\LogoutController@index');

// 系统管理员可以访问的地址
Route::group(['middleware' => ['adminCheckLogin', 'adminCheckMaster']], function () {
    // banner 相关
    Route::get('/banners', 'Banner\BannerController@index');
    Route::post('/banner/create', 'Common\BannerController@create');
    Route::post('/banner/update', 'Common\BannerController@update');
    Route::post('/banner/delete', 'Common\BannerController@delete');

    Route::get('/clients', 'User\UserController@index');

    Route::get('/categories', 'Common\CategoryController@index');
    Route::post('/categories', 'Common\CategoryController@store');
    Route::post('/category/del', 'Common\CategoryController@destory');

    Route::get('/lotteries', 'Lottery\LotteryController@index');
    Route::get('/lottery/wins', 'Lottery\WinController@index');
    Route::post('/lottery/wins', 'Lottery\WinController@store');

    // 只有系统管理员可以删除商铺
    Route::post('/merchant/delete', 'Bussiness\MerchantController@delete');

});

Route::group(['middleware' => 'adminCheckLogin'], function () {

    Route::get('/navs', 'Admin\NavController@index');

    // 文件上传
    Route::post('/upload/image', 'Common\FileController@uploadImage');

    Route::get('/richtext', 'Common\RichtextController@create');
    Route::post('/richtext', 'Common\RichtextController@store');

    Route::get('/products', 'Bussiness\ProductController@index');
    Route::post('/products', 'Bussiness\ProductController@store');
    Route::post('/products/destory/{id}', 'Bussiness\ProductController@destory');
    Route::get('/product/images/{goods_id}', 'Bussiness\ProductImageController@index');
    Route::post('/product/images', 'Bussiness\ProductImageController@store');
    Route::post('/product/images/destory/{id}', 'Bussiness\ProductImageController@destory');
    Route::post('/product/images/sort', 'Bussiness\ProductImageController@updateSort');

    Route::get('/product/attrs/{goods_id}', 'Bussiness\ProductAttrController@index');

    Route::get('/role', 'User\UserController@getRole');

    Route::get('/cates/{parent_id}', 'Common\CategoryController@getCatesByParentId');

    Route::get('/attr/cates/{goods_id}', 'Bussiness\GoodsAttrCateController@index');
    Route::post('/attr/cates', 'Bussiness\GoodsAttrCateController@store');
    Route::post('/attr/cates/destory', 'Bussiness\GoodsAttrCateController@destory');

    Route::post('/attr/cates/val/destory', 'Bussiness\GoodsAttrCateController@destoryVal');

    Route::get('/attr/goods/{goods_id}', 'Bussiness\AttrGoodsController@index');
    Route::post('/attr/goods', 'Bussiness\AttrGoodsController@store');
    Route::post('/attr/goods/destory/{goods_id}', 'Bussiness\AttrGoodsController@destory');

    Route::get('/orders', 'Bussiness\OrderController@index');
    Route::post('/orders', 'Bussiness\OrderController@store');
    Route::get('/order/goods', 'Bussiness\OrderGoodsController@index');

    Route::post('/password/reset', 'Admin\ResetPasswordController@store');

    Route::get('/merchants', 'Bussiness\MerchantController@index');
    Route::get('/merchants/all', 'Bussiness\MerchantController@getMerchantsAll');
    Route::post('/merchant', 'Bussiness\MerchantController@store');

});


