<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api', function ($data = '', $success = '1', $msg = '') {
            $msg = $msg ? $msg : (($success == 1) ? '操作成功' : $data);
            $returns = [
                "success" => (string)$success,
                "infor" => $data,
                "msg" => (string)$msg
            ];

            $headers = [
                'Content-Type' => 'application/json; charset=utf-8'
            ];

            return Response::json($returns, 200, $headers, JSON_UNESCAPED_UNICODE);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
