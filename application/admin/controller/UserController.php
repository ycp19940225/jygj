<?php
/**
 * Created by PhpStorm.
 * DESC:
 * User: ycp
 * Date: 2018/6/6
 * Time: 14:41
 */

namespace app\admin\controller;


use app\common\models\Admin;
use think\Request;
use think\Validate;

class UserController extends BaseController
{
    protected $user;
    protected $request;

    public function __construct(Request $request,Admin $user)
    {
        parent::__construct();
        $this->user = $user;
        $this->request =$request;
    }

    /**
     * @name 管理员列表
     * @return mixed
     */
    public function index()
    {
        $data= $this->user->getAll('*');
        return $this->fetch('index',[
            'data'=>$data,
            'title'=>'管理员'
        ]);
    }

    /**
     * @name 添加管理员
     * @return mixed
     */
    public function addOrEdit()
    {
        $id= $this->request->param('id');
        $userData =  $this->user->getAll();
        if($id){
            //修改
            $data = $this->user->getOne($id);
            if(!$data){
                $this->error('数据已被删除,请恢复后再编辑！');
            }
            $this->assign('data',$data);
            $this->assign('title','修改管理员');
        }else{
            $this->assign('title','添加管理员');
        }
        $this->assign('userData',$userData);
        return $this->fetch('edit');
    }

    /**
     * @name 添加管理员Do
     * @return mixed
     */
    public function addOrEditDo()
    {
        $validate = new Validate([
            'name'  => 'require|unique:t_admin',
            'password'  => 'require',
        ]);
        $data= $this->request->only('id,name,password');
        if (!$validate->check($data)) {
            $this->error('操作失败！'.$validate->getError());
        }
        $data['password'] = md5('JYGJ'.$data['password']);
        if(!empty($data['id'])){
            if($this->user->updateData($data)){
                $this->redirect('admin/user/index',['msg'=>'修改成功！']);
            }
        }else{
            $res=$this->user->saveData($data);
            if($res){
                $this->redirect('admin/user/index',['msg'=>'添加成功！']);
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
        if($this->user->updateData($data)){
            return API_MSG('操作成功！',true);
        }
        return API_MSG('操作失败！',false);
    }
}