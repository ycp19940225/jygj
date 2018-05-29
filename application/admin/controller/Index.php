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
    public function index()
    {
        return $this->fetch();
    }

    public function main()
    {
        return $this->fetch();
    }
}