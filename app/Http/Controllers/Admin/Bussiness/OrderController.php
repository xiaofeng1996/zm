<?php

namespace App\Http\Controllers\Admin\Bussiness;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Order;
use Entities\Admin;
use Carbon\Carbon;
use Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->get('role_id') != 1) {
            $admin = Admin::with('merchant')->find($request->session()->get('admin_id'));
        }

        $merchant_id = (isset($admin) && $admin) ? $admin->merchant->id : 0;

        $orders = Order::where(function ($query) use ($request, $merchant_id) {
            if ($request->out_trade_no) {
                $query->where('out_trade_no', 'like', '%' . $request->out_trade_no . '%');
            }
            if ($request->status) {
                $query->where('status', $request->status);
            }
            if ($request->name) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            if ($request->mobile) {
                $query->where('mobile', 'like', '%' . $request->mobile . '%');
            }
            if ($request->is_lucky != -1) {
                $query->where('is_lucky', $request->is_lucky);
            }

            if ($merchant_id) {
                $query->where('merchant_id', $merchant_id);
            }
        })->paginate();
        return response()->api($orders);
    }

    public function store(Request $request)
    {
        $this->apiValidate($request, [
            'id'    => 'required|integer',
            'status'    => 'required|integer'
        ]);
        $order = Order::find($request->id);
        $order->express_name    = $request->express_name;
        $order->express_nu      = $request->express_nu;

        if ($request->status != $order->status
            && ($request->status == 1
                || $request->status > 3
                || $order->status == 1 // 未支付订单后台不能设置为已支付
                || ($order->status > 3 && ($request->status == 2 || $request->status == 3))
               )
        ) {
            throw new ApiException('不能修改为此状态');
        }

        $order->status = $request->status;

        if ($request->status == 3) {
            $order->delivered_at = Carbon::now();
        }

        $order->save();
        return response()->api();

    }
}
