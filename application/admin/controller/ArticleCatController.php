<?php
/**
 * Created by PhpStorm.
 * DESC: 文章分类
 * User: ycp
 * Date: 2018/6/4
 * Time: 15:46
 */

namespace app\admin\controller;

use app\common\models\ArticleCat as ARModel;
use think\Request;
use think\Validate;

/**
 * @name 文章分类
 * @return mixed
 */
class ArticleCatController extends BaseController
{
    protected $articleCat;
    protected $request;

    public function __construct(Request $request,ARModel $articleCat)
    {
        parent::__construct();
        $this->articleCat = $articleCat;
        $this->request =$request;
    }

    /**
     * @name 文章分类列表
     * @return mixed
     */
    public function index()
    {
        $data= $this->articleCat->getAll('id,name,deleted_at,created_at,parent_id');
        return $this->fetch('index',[
            'data'=>$data,
            'title'=>'文章分类'
        ]);
    }

    /**
     * @name 添加文章分类
     * @return mixed
     */
    public function addOrEdit()
    {
        $id= $this->request->param('id');
        $catData =  $this->articleCat->getTreeAll();
        if($id){
            //修改
            $data = $this->articleCat->getOne($id);
            if(!$data){
                $this->error('数据已被删除,请恢复后再编辑！');
            }
            $this->assign('data',$data);
            $this->assign('title','修改文章分类');
        }else{
            $this->assign('title','添加文章分类');
        }
        $this->assign('catData',$catData);
        return $this->fetch('edit');
    }

    /**
     * @name 添加文章分类Do
     * @return mixed
     */
    public function addOrEditDo()
    {
        $validate = new Validate([
            'name'  => 'require',
            'parent_id'  => 'require',
        ]);
        $data= $this->request->except('repass');
        if (!$validate->check($data)) {
            $this->error('操作失败！'.$validate->getError());
        }
        if(!empty($data['id'])){
            if($this->articleCat->updateData($data)){
                $this->redirect('admin/article_cat/index',['msg'=>'修改成功！']);
            }
        }else{
            $res=$this->articleCat->saveData($data);
            if($res){
                $this->redirect('admin/article_cat/index',['msg'=>'添加成功！']);
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
        if($this->articleCat->updateData($data)){
            return API_MSG('操作成功！',true);
        }
        return API_MSG('操作失败！',false);
    }
}