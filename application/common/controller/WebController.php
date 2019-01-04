<?php
/**
 * Created by PhpStorm.
 * User: ycp
 * Date: 2018/6/29
 * Time: 16:53
 */

namespace app\common\controller;


use app\common\models\Article;
use app\common\models\Nav;
use app\common\models\WebConfig;
use think\Controller;

class WebController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //重定向
        /* if(request()->url(true) == 'http://jingyunguanjia.com'){
             $this->redirect('www.jingyunguanjia.com');
         }*/
        //导航
        if (cache('navList')) {
            $navList = cache('navList');
        } else {
            $navModel = new Nav();
            $navList = $navModel->getTreeAll();
        }

        //配置
        if (cache('config')) {
            $config = cache('config');
        } else {
            $configModel = new WebConfig();
            $config = $configModel->getAlls();
        }

        //获取首页文章
        if (cache('article')) {
            $config = cache('article');
        } else {
            $article = db('t_article')->where(['deleted_at' => 1, 'type' => 1, 'id' => ['not in', [27]]])->order('id desc')->paginate(4);
        }

        $this->assign('navList', $navList);
        $this->assign('config', $config);
        $this->assign('article', $article);
    }
}