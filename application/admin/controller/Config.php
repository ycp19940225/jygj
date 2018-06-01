<?php
/**
 * Created by PhpStorm.
 *  配置
 * User: ycp
 * Date: 2018/6/1
 * Time: 11:49
 */

namespace app\admin\controller;


use app\common\models\WebConfig;
use think\Controller;
use think\Request;

class Config extends Controller
{
    protected $webConfig;
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->webConfig = new  WebConfig;
        $this->request =$request;
    }

    /**
     * @name 配置列表
     * @desc
     * @return mixed
     */
    public function index()
    {
        $data= $this->webConfig->getAll();
        return $this->fetch('index',[
            'data'=>$data,
            'title'=>'配置列表'
        ]);
    }

    /**
     * @name 添加配置
     * @desc
     * @return mixed
     */
    public function addOrEdit()
    {
        $id= $this->request->param('id');
        if($id){
            //修改
            $configData = $this->webConfig->getOne($id);
            $this->assign('configData',$configData);
            $this->assign('title','修改网站配置');
        }else{
            $this->assign('title','添加网站配置');
        }
        return $this->fetch('edit');
    }

    /**
     * @name 添加配置Do
     * @desc
     * @return mixed
     */
    public function addOrEditDo()
    {
        $data= $this->request->input();
        return $this->fetch('edit',[
            'title'=>'添加配置'
        ]);
    }
}