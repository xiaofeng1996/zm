<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Auth\AddressRepository as Address;

class AddressController extends Controller
{
    // 列表
    public function index(Request $request, Address $address)
    {
        $addresses = $address->getAddresses($request->userId);
        return response()->api($addresses);
    }

    public function create(Request $request, Address $address)
    {
        $this->apiValidate($request, [
            'name' => 'required|max:40',
            'mobile' => 'required|max:20',
            'province' => 'required|max:40',
            'city' => 'required|max:40',
            'district' => 'required|max:40',
            'address' => 'required|max:255',
        ]);
        $address->create($request->all(), $request->userId);
        return response()->api();
    }

    public function update(Request $request, Address $address)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer',
            'name' => 'required|max:40',
            'mobile' => 'required|max:20',
            'province' => 'required|max:40',
            'city' => 'required|max:40',
            'district' => 'required|max:40',
            'address' => 'required|max:255',
        ]);
        $address->update($request->all(), $request->userId);
        return response()->api();
    }

    public function destroy(Request $request, Address $address)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer'
        ]);
        $address->destroy($request->id, $request->userId);
        return response()->api();
    }

    public function setDefault(Request $request, Address $address)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer'
        ]);
        $address->setDefault($request->id, $request->userId);
        return response()->api();
    }

}
