<?php
/**
 * Created by PhpStorm.
 * DESC:
 * User: ycp
 * Date: 2018/6/6
 * Time: 14:41
 */

namespace app\admin\controller;


use app\common\models\Nav;
use think\Controller;
use think\Request;
use think\Validate;

class NavController extends BaseController
{
    protected $nav;
    protected $request;

    public function __construct(Request $request,Nav $nav)
    {
        parent::__construct();
        $this->nav = $nav;
        $this->request =$request;
    }

    /**
     * @name 栏目列表
     * @return mixed
     */
    public function index()
    {
        $data= $this->nav->getAll('id,name,url,parent_id,sort,deleted_at,created_at,parent_id');
        return $this->fetch('index',[
            'data'=>$data,
            'title'=>'栏目'
        ]);
    }

    /**
     * @name 添加栏目
     * @return mixed
     */
    public function addOrEdit()
    {
        $id= $this->request->param('id');
        $navData =  $this->nav->getTreeAll();
        if($id){
            //修改
            $data = $this->nav->getOne($id);
            if(!$data){
                $this->error('数据已被删除,请恢复后再编辑！');
            }
            $this->assign('data',$data);
            $this->assign('title','修改栏目');
        }else{
            $this->assign('title','添加栏目');
        }
        $this->assign('navData',$navData);
        return $this->fetch('edit');
    }

    /**
     * @name 添加栏目Do
     * @return mixed
     */
    public function addOrEditDo()
    {
        $validate = new Validate([
            'name'  => 'require',
            'parent_id'  => 'require',
            'url'  => 'require',
        ]);
        $data= $this->request->only('id,name,sort,parent_id,url');
        if (!$validate->check($data)) {
            $this->error('操作失败！'.$validate->getError());
        }
        if(!empty($data['id'])){
            if($this->nav->updateData($data)){
                $this->redirect('admin/nav/index',['msg'=>'修改成功！']);
            }
        }else{
            $res=$this->nav->saveData($data);
            if($res){
                $this->redirect('admin/nav/index',['msg'=>'添加成功！']);
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
        if($this->nav->updateData($data)){
            return API_MSG('操作成功！',true);
        }
        return API_MSG('操作失败！',false);
    }
}