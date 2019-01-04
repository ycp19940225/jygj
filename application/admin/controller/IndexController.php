<?php
/**
 * Created by PhpStorm.
 * User: ycp
 * Date: 2018/5/28
 * Time: 23:49
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;

class IndexController extends BaseController
{
    /**
     * @name 后台首页
     * @desc
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * @name 后台首页面板
     * @desc
     * @return mixed
     */
    public function main()
    {
        //服务器环境信息
        $environment = cache('environment');
        if(!$environment){
            //操作系统和php版本
            $environment['system'] = PHP_OS;
            $environment['phpVersion'] = 'v'.  phpversion();
            //web服务器
            $environment['serverSoft'] = $_SERVER['SERVER_SOFTWARE'];
            //mysql版本
            $environment['dbVersion'] = Db::query('select VERSION()')[0]['VERSION()'];
            //缓存一小时
            cache('environment',$environment,3600);
        }
        $this->assign('environment',$environment);
        return $this->fetch();
    }


}