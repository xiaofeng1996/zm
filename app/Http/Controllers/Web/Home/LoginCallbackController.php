<?php

namespace App\Http\Controllers\Web\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Repositories\Web\BannerRepository as Banner;
use Repositories\Web\Goods\CategoryRepository as Category;
use Entities\Goods;
use Entities\Lottery;
use Entities\OrderLottery;
use Entities\Notice;
use DB;

class LoginCallbackController extends Controller
{

    /*
     * 新浪
     */
    public function sinaCallback(Request $request)
    {
        require_once(public_path() . '/Oath/sina/config.php');
        require_once(public_path() . '/oath/sina/saetv2.ex.class.php');
        $o = new \SaeTOAuthV2(WB_AKEY, WB_SKEY);
        $keys = array();
        $keys['code'] = $_REQUEST['code'];
        $keys['redirect_uri'] = WB_CALLBACK_URL;
        $token = $o->getAccessToken('code', $keys);
        $c = new \SaeTClientV2(WB_AKEY, WB_SKEY, $token["access_token"]);
        $ms = $c->home_timeline(); // done
        $uid_get = $c->get_uid();
        $uid = $token['uid'];
        $user_message = $c->show_user_by_id($token['uid']);//根据ID获取用户等基本信息
        $location = explode(' ', $user_message['location']);
        $date = date('Y-m-d H:i:s', time());
        //查询是否已经绑定该用户
        $resInfo = DB::table('users')->where(['name' => $user_message['screen_name']])->first();        //绑定用户信息
        if (empty($resInfo)) {
            $userInfo = [
                'name' => $user_message['screen_name'],
                'province' => $location[0],
                'city' => $location[1],
                'avatar' => $user_message['profile_image_url'],
                'created_at' => $date,
                'updated_at' => $date,
                'mobile' => '',
                'password' => '',
                'pay_password' => ''
            ];
            $insertId = DB::table('users')->insertGetId($userInfo);
        } else {
            $insertId = $resInfo->id;
        }
        $request->session()->put('user_id', $insertId);
        return redirect('/');
    }

    /*
     * 微信
     */
    public function wxCallback(Request $request)
    {
        $code = Input::get('code');
        $state = Input::get('state');
        //换成自己的接口信息
        $appid = 'wx5a0feb9538019d3f';
        $appsecret = '2ca7f8b3c7c68cd7886f8278abf22195';
        if (empty($code)) $this->error('授权失败');
        $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$code.'&grant_type=authorization_code';
        $token = json_decode(file_get_contents($token_url));
        $access_token_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$appid.'&grant_type=refresh_token&refresh_token='.$token->refresh_token;
        //转成对象
        $access_token = json_decode(file_get_contents($access_token_url));
        $user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token->access_token.'&openid='.$access_token->openid.'&lang=zh_CN';
        //转成对象
        $user_info = json_decode(file_get_contents($user_info_url));
        $user_message =  json_decode(json_encode($user_info),true);//返回的json数组转换成array数组
        $date = date('Y-m-d H:i:s', time());
        //查询是否已经绑定该用户
        $resInfo = DB::table('users')->where(['name' => $user_message['nickname']])->first();        //绑定用户信息
        if (empty($resInfo)) {
            $userInfo = [
                'name' => $user_message['nickname'],
                'openid' => $user_message['openid'],
                'province' => $user_message['province'],
                'city' => $user_message['city'],
                'avatar' => $user_message['headimgurl'],
                'created_at' => $date,
                'updated_at' => $date,
                'mobile' => '',
                'password' => '',
                'pay_password' => ''
            ];
            $insertId = DB::table('users')->insertGetId($userInfo);
        } else {
            $insertId = $resInfo->id;
        }
        $request->session()->put('user_id', $insertId);
        return redirect('/');
    }

    /*
     * QQ
     */
    public function qqCallback(Request $request){
        require_once(public_path().'/oath/qq/QC.class.php');
        $qc = new \QC();
        $access_token = $qc->qq_callback();
        $open_id = $qc->get_openid();
        //获取用户信息
        $user_info_url = "https://graph.qq.com/user/get_user_info?access_token=$access_token&oauth_consumer_key=YOUR_APP_ID&openid=$open_id";
        //转成对象
        $user_info = json_decode(file_get_contents($user_info_url));
        $user_message =  json_decode(json_encode($user_info),true);//返回的json数组转换成array数组
        $date = date('Y-m-d H:i:s', time());
        //查询是否已经绑定该用户
        $resInfo = DB::table('users')->where(['name' => $user_message['nickname']])->first();        //绑定用户信息
        if (empty($resInfo)) {
            $userInfo = [
                'name' => $user_message['nickname'],
                'openid' => $open_id,
                'province' => '',
                'city' => '',
                'avatar' => $user_message['figureurl'],
                'created_at' => $date,
                'updated_at' => $date,
                'mobile' => '',
                'password' => '',
                'pay_password' => ''
            ];
            $insertId = DB::table('users')->insertGetId($userInfo);
        } else {
            $insertId = $resInfo->id;
        }
        $request->session()->put('user_id', $insertId);
        return redirect('/');
    }

}