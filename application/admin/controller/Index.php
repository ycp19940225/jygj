<?php
/**
 * Created by PhpStorm.
 * User: ycp
 * Date: 2018/5/28
 * Time: 23:49
 */

namespace app\admin\controller;


use think\Controller;

class Index extends Controller
{
    /**
     * @name 后台首页
     * @desc
     * @author ycp
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * @name 后台首页面板
     * @desc
     * @author ycp
     * @return mixed
     */
    public function main()
    {
        return $this->fetch();
    }
}