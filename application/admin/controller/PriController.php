<?php
/**
 * Created by PhpStorm.
 * DESC: 权限
 * User: ycp
 * Date: 2018/6/8
 * Time: 17:42
 */

namespace app\admin\controller;


use App\Models\Admin\Pri;
use think\Request;

class PriController extends BaseController
{
    protected $pri;
    protected $request;

    public function __construct(Request $request,Pri $pri)
    {
        parent::__construct();
        $this->pri = $pri;
        $this->request =$request;
    }

    /**
     * @name 权限列表
     * @return mixed
     */
    public function index()
    {
        $data= $this->pri->getAll('id,pri_name,module_name,controller,action_name,created_at');
        return $this->fetch('index',[
            'data'=>$data,
            'title'=>'权限'
        ]);
    }

    /**
     * @name 添加权限
     * @return mixed
     */
    public function addOrEdit()
    {
        $id= $this->request->param('id');
        $priData =  $this->pri->getTreeAll();
        if($id){
            //修改
            $data = $this->pri->getOne($id);
            if(!$data){
                $this->error('数据已被删除,请恢复后再编辑！');
            }
            $this->assign('data',$data);
            $this->assign('title,修改权限');
        }else{
            $this->assign('title,添加权限');
        }
        $this->assign('priData',$priData);
        return $this->fetch('edit');
    }

    /**
     * @name 添加权限Do
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
            if($this->pri->updateData($data)){
                $this->redirect('admin/pri/index',['msg'=>'修改成功！']);
            }
        }else{
            $res=$this->pri->saveData($data);
            if($res){
                $this->redirect('admin/pri/index',['msg'=>'添加成功！']);
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
        if($this->pri->updateData($data)){
            return API_MSG('操作成功！',true);
        }
        return API_MSG('操作失败！',false);
    }
}