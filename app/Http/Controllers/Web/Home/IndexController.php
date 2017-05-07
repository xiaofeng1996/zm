<?php

namespace App\Http\Controllers\Web\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Web\BannerRepository as Banner;
use Repositories\Web\Goods\CategoryRepository as Category;
use Entities\Goods;
use Entities\Lottery;
use Entities\OrderLottery;
use Entities\Notice;

class IndexController extends Controller
{
    public function index(Request $request, Banner $banner, Category $category)
    {
        $user_id = $request->session()->get('user_id', 0);
        $banners = $banner->getBanners();
        $categorys = $category->getCascadeList();
        $lucky_goods = Goods::where('is_lucky', 1)
                            ->withCount(['collects' => function ($query) use ($user_id) {
                                $query->where('user_id', $user_id);
                            }])
                            ->reviewed()
                            ->recommend()
                            ->has('attrs')
                            ->orderBy('sort')
                            ->limit(4)
                            ->get();
        $member_goods = Goods::where('is_lucky', 0)
                            ->withCount(['collects' => function ($query) use ($user_id) {
                                $query->where('user_id', $user_id);
                            }])
                            ->reviewed()
                            ->recommend()
                            ->has('attrs')
                            ->orderBy('sort')
                            ->limit(8)
                            ->get();
        $last_lottery = Lottery::orderBy('opentimestamp', 'desc')->first();
        $order_lotteries = OrderLottery::where('status', 1)->orderBy('updated_at', 'desc')->limit(20)->get();
        $last_activity_notice = Notice::where('keytype', 5)->orderBy('created_at', 'desc')->first();

        $sina_code_url = $this->initSinaLogin();
        return view('web.home.index')
                ->with('code_url', $sina_code_url)
                ->with('banners', $banners)
                ->with('categorys', $categorys)
                ->with('lucky_goods', $lucky_goods)
                ->with('member_goods', $member_goods)
                ->with('last_lottery', $last_lottery)
                ->with('order_lotteries', $order_lotteries)
                ->with('last_activity_notice', $last_activity_notice);
    }

    /*
     * 初始化新浪
     */
    public function initSinaLogin(){
        //新浪第三方登录
        require_once(public_path().'/oath/sina/config.php');
        require_once(public_path().'/oath/sina/saetv2.ex.class.php');
        $o = new \SaeTOAuthV2( WB_AKEY , WB_SKEY );
        $code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
        return $code_url;
    }

    /*
     * QQ登录
     */
    public function qqLogin(){
        require_once(public_path().'/oath/qq/QC.class.php');
        $qc = new \QC();
        $qc->qq_login();
    }
}
