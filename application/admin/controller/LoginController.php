<?php
/**
 * Created by PhpStorm.
 * DESC:
 * User: ycp
 * Date: 2018/6/28
 * Time: 16:36
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Session;

class LoginController extends Controller
{
    public function login()
    {
        return $this->fetch();
    }

    public function loginDo(Request $request)
    {
        $data = $request->request();
        if(!$data){
            $this->error('参数缺失！');
        }
        if(!captcha_check($data['captcha'])){
            //验证失败
            $this->error('验证码错误！');
        };
        $userInfo = db('t_admin')->where(['name'=>$data['name'],'password'=>md5('JYGJ'.$data['password'])])->find();
        if($userInfo){
            session('admin',$userInfo);
            $this->redirect('/index.php/admin/index/index');
        }else{
            $this->error('登录失败！');
        }
    }

    public function logout()
    {
        Session::clear();
        $this->redirect('/index.php/admin/index/index');
    }
}