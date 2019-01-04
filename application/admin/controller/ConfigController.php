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
use think\Validate;

class ConfigController extends BaseController
{
    protected $webConfig;
    protected $request;

    public function __construct(Request $request,WebConfig $webConfig)
    {
        parent::__construct();
        $this->webConfig = $webConfig;
        $this->request = $request;
    }

    /**
     * @name 配置列表
     * @return mixed
     */
    public function index()
    {
        $data= $this->webConfig->getAll('id,name,key,value,type,sort,deleted_at');
        return $this->fetch('index',[
            'data'=>$data,
            'title'=>'配置'
        ]);
    }

    /**
     * @name 添加配置
     * @return mixed
     */
    public function addOrEdit()
    {
        $id= $this->request->param('id');
        if($id){
            //修改
            $configData = $this->webConfig->getOne($id);
            if(!$configData){
                $this->error('数据已被删除,请恢复后再编辑！');
            }
            $this->assign('configData',$configData);
            $this->assign('title','修改网站配置');
        }else{
            $this->assign('title','添加网站配置');
        }
        return $this->fetch('edit');
    }

    /**
     * @name 添加配置Do
     * @return mixed
     */
    public function addOrEditDo()
    {
        $data= $this->request->only('id,name,key,value,type,pic,sort');
        //处理图片
        if( $data['type'] == 2 && $this->request->file('pic')){
            $data['value'] = upload($this->request->file('pic'));
        }
        if(!empty($data['id'])){
            $validate = new Validate([
                'name'  => 'require',
                'value' => 'require',
                'type' => 'require',
            ]);
            if (!$validate->check($data)) {
                $this->error('操作失败！'.$validate->getError());
            }
            if($this->webConfig->updateData($data)){
                $this->redirect('admin/config/index',['msg'=>'修改成功！']);
            }
        }else{
            $validate = new Validate([
                'name'  => 'require',
                'key' => 'require|unique:t_web_config',
                'value' => 'require',
                'type' => 'require',
            ]);
            if (!$validate->check($data)) {
                $this->error('操作失败！'.$validate->getError());
            }
            $res=$this->webConfig->saveData($data);
            if($res){
                $this->redirect('admin/config/index',['msg'=>'添加成功！']);
            }
        }
        $this->error('操作失败！');
    }


    /**
     * @name 删除恢复数据
     */
    public function changeStatus()
    {
        $validate = new Validate([
            'id'  => 'require',
            'deleted_at' => 'require',
        ]);
        $data = $this->request->param();;
        if (!$validate->check($data)) {
            return API_MSG('操作失败！'.$validate->getError(),false);
        }

        //更新
        if($this->webConfig->updateData($data)){
            return API_MSG('操作成功！',true);
        }
        return API_MSG('操作失败！',false);
    }
}