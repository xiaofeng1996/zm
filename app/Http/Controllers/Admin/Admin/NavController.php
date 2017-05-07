<?php

namespace App\Http\Controllers\Admin\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Admin;
use DB;

class NavController extends Controller
{

    private $raw_navs = [];

    public function index(Request $request)
    {
        $admin_id = $request->session()->get('admin_id');
        // DB::enableQueryLog();
        $admin = Admin::with('role.nav_roles.nav')->find($admin_id);
        $this->raw_navs = $admin->role->nav_roles;
        $navs = $this->formatNavs();
        // dd(DB::getQueryLog());
        return response()->api($navs);
    }

    private function formatNavs($parent_id = 0)
    {
        $menus = [];
        foreach ($this->raw_navs as $key => $nav) {
            if ($nav->nav->parent_id == $parent_id) {
                if ($nav->nav->is_leaf == 1) {
                    $menus[] = $nav->nav;
                    unset($this->raw_navs[$key]);
                } else {
                    $nav->nav->children = $this->formatNavs($nav->nav->id);
                    $menus[] = $nav->nav;
                }
            }
        }
        return $menus;
    }
}
