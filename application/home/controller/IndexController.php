<?php

namespace app\home\controller;

use app\common\controller\WebController;
use app\common\models\Article;
use think\Request;

class IndexController extends WebController
{

    public function index()
    {
        if (strtolower($_SERVER['QUERY_STRING']) == 'jingyunguanjia.com'){
            header('Location:https://www.jingyunguanjia.com');exit;
        }
        $casesList = db('t_article')->where(['deleted_at' => 1, 'type' => 2])->paginate(10);
        $this->assign('casesList', $casesList);
//        $this->assign('pageTitle', '智慧旅游_为景区提供语音导览,地图导览,景区营销,解决方案-景运管家');
//        $this->assign('pageDesc', '景运管家智慧旅游为景区提供智慧景区整体解决方案+运营维护，建立景区与游客的互动渠道,为景区推广,服务,管理提供平台与数据支撑');
//        $this->assign('pageKeyWords', '智慧旅游,智慧景区,智慧旅游解决方案,智慧景区解决方案');
        return $this->fetch();
    }

    /**
     * @desc 关于我们
     */
    public function about()
    {
        $this->assign('pageTitle', '景运管家公司简介-景运管家智慧旅游');
        return $this->fetch();
    }

    //行业动态
    public function news(Request $request, Article $article)
    {
        if ($request->param('id')) {
            $id = $request->param('id');
            $data = $article->getOne($id);
            //当前文章的栏目和内容分类
            $currentBelong['cat'] = $data->cat->id;
            $currentBelong['nav'] = $data->nav->id;
            $currentBelong['cat_name'] = $data->nav->name;
            if (empty($data)) {
                abort(404, '页面不存在');
            }
            $model = db('t_article');
            //点击次数
            $model->where('id', $id)->setInc('hints');

            $fields['id'] = ['neq', $id];
            $fields['deleted_at'] = 1;
            $fields['cat_id'] = $currentBelong['cat'];
            $fields['nav_id'] = $currentBelong['nav'];
            $recommendedReading[] = $article->randomData(4, $fields);
            $recommendedReading[] = $article->randomData(4, $fields);
            unset($fields['id']);
            $similarArticles = $article->getHandover($id,$fields);

            $this->assign('data', $data);
            $this->assign('recommendedReading', $recommendedReading);
            $this->assign('similarArticles', $similarArticles);
            $this->assign('id', $data['id']);
            $this->assign('pageTitle', $data['title'] . '-景运管家智慧旅游');
            $this->assign('articleBelongName', $currentBelong['cat_name']);
            return $this->fetch('detail');
        } else {
            //行业动态栏目18,内容10
            $data = db('t_article')->where(['deleted_at' => 1, 'cat_id' => 10, 'nav_id' => 18, 'type' => 1, 'id' => ['not in', [27]]])->order('id desc')->paginate(10, false, ['path' => '/news.html']);
            $this->assign('data', $data);
            $this->assign('pageTitle', '智慧旅游行业发展动态-景运管家智慧旅游');
            return $this->fetch();
        }
    }

    /**
     * @desc 定制官网
     */
    public function product1()
    {
        $this->assign('pageTitle', '景区网站开发_景区网站建设-景运管家智慧旅游');
        return $this->fetch();
    }

    /**
     * @desc 公众号+小程序
     */
    public function product2()
    {
        $this->assign('pageTitle', '景区微信系统-景运管家智慧旅游');
        $this->assign('pageDesc', '景运管家智慧旅游为景区提供景区微信系统,支持二维码订票,为游客提供智能化的自助服务');
        $this->assign('pageKeyWords', '景区微信,景区微信系统');
        return $this->fetch();
    }

    /**
     * @desc 经典案例
     */
    public function cases()
    {
        $this->assign('pageTitle', '智慧旅游景区经典案例-景运管家智慧旅游');
        return $this->fetch();
    }

    /**
     * @desc 人才招聘
     */
    public function recruit()
    {
        $data = db('t_article')->where(['deleted_at'=>1,'cat_id'=>14,'nav_id'=>16])->select();
        $this->assign('data', $data);
        $this->assign('pageTitle', '人才招聘-景运管家智慧旅游');
        return $this->fetch();
    }

    /**
     * @desc 博物馆
     */
    public function application()
    {
        $this->assign('pageTitle', '博物馆-应用场景-景运管家智慧旅游');
        return $this->fetch();
    }

    /**
     * @desc 全域旅游
     */
    public function application_tourism()
    {
        $this->assign('pageTitle', '全域旅游-应用场景-景运管家智慧旅游');
        return $this->fetch();
    }

    /**
     * @desc 智慧景区
     */
    public function application_wisdom()
    {
        $this->assign('pageTitle', '智慧景区-应用场景-景运管家智慧旅游');
        return $this->fetch();
    }

    /**
     * @desc 主题乐园
     */
    public function application_theme()
    {
        $this->assign('pageTitle', '主题乐园-应用场景-景运管家智慧旅游');
        return $this->fetch();
    }
    /**
     * @desc 渠道合作
     */
    public function cooperate()
    {
        $this->assign('pageTitle', '渠道合作-渠道合作-景运管家智慧旅游');
        return $this->fetch();
    }

    //解决方案
    public function solution(Request $request,Article $article)
    {
        if ($request->param('id')) {
            $id = $request->param('id');
            $data = $article->getOne($id);
            //当前文章的栏目和内容分类
            $currentBelong['cat'] = $data->cat->id;
            $currentBelong['nav'] = $data->nav->id;
            $currentBelong['cat_name'] = $data->nav->name;
            if (empty($data)) {
                abort(404, '页面不存在');
            }
            $model = db('t_article');
            //点击次数
            $model->where('id', $id)->setInc('hints');

            $fields['id'] = ['neq', $id];
            $fields['deleted_at'] = 1;
            $fields['cat_id'] = $currentBelong['cat'];
            $fields['nav_id'] = $currentBelong['nav'];
            $recommendedReading[] = $article->randomData(4, $fields);
            $recommendedReading[] = $article->randomData(4, $fields);
            unset($fields['id']);
            $similarArticles = $article->getHandover($id,$fields);

            $this->assign('data', $data);
            $this->assign('recommendedReading', $recommendedReading);
            $this->assign('similarArticles', $similarArticles);
            $this->assign('id', $data['id']);
            $this->assign('pageTitle', $data['title'] . '-景运管家智慧旅游');
            $this->assign('articleBelongName', $currentBelong['cat_name']);
            return $this->fetch('detail');
        } else {
            //解决方案栏目17,内容13
            $data = db('t_article')->where(['deleted_at' => 1, 'cat_id' => 13, 'nav_id' => 17, 'type' => 1, 'id' => ['not in', [27]]])->order('id desc')->paginate(10, false, ['path' => '/solution.html']);
            $this->assign('data', $data);
            $this->assign('pageTitle', '智慧旅游解决方案-景运管家智慧旅游');
            $this->assign('pageDesc', '促进我国智慧旅游产业持续发展,提升景区品牌形象.消费多元化,一体化,人性化,以及服务增值化,专注景区现代信息化建设');
            $this->assign('pageKeyWords', '智慧旅游解决方案,智慧旅游,智慧旅游建设');
            return $this->fetch();
        }

    }
}
