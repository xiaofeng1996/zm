<?php

namespace App\Http\Controllers\Api\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Order\OrderServiceRepository as Service;

class ServiceController extends Controller
{
    public function apply(Request $request, Service $service)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer',
            'service_type' => 'required|integer',
            'applied_reason' => 'required|max:120'
        ]);
        $service_id = $service->apply($request->userId, $request->all());
        return response()->api(['service_id' => $service_id]);
    }

    public function index(Request $request, Service $service) 
    {
        $this->apiValidate($request, [
            'service_status' => 'required|integer|min:0',
            'service_type' => 'required|integer|min:0'
        ]);
        $list = $service->getList($request->userId, $request->input('service_status'), $request->input('service_type'));
        return response()->api($list);
    }

    public function one(Request $request, Service $service)
    {
        $this->apiValidate($request, [
            'service_id' => 'required|integer|min:1'
        ]);
        $data = $service->getOne($request->userId, $request->input('service_id'));
        return response()->api($data);
    }
    
}
