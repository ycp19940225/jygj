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

class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!session('admin')){
            $this->redirect('/index.php/Admin/login/login');
        }
    }
}