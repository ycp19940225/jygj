<?php
/**
 * Created by PhpStorm.
 * DESC: 文章
 * User: ycp
 * Date: 2018/6/4
 * Time: 15:46
 */

namespace app\admin\controller;


use app\common\models\ArticleCat;
use app\common\models\Article as ArModel;
use app\common\models\Nav;
use think\Controller;
use think\Request;
use think\Validate;

class ArticleController extends BaseController
{
    protected $article;
    protected $request;

    public function __construct(Request $request,ArModel $article)
    {
        parent::__construct();
        $this->article = $article;
        $this->request =$request;
    }

    /**
     * @name 文章列表
     * @return mixed
     */
    public function index()
    {
        $data= $this->article->getAll();
        return $this->fetch('index',[
            'data'=>$data,
            'title'=>"文章列表",
            'type'=>1
        ]);
    }
    /**
     * @name 案例列表
     * @return mixed
     */
    public function cases()
    {
        $data= $this->article->getAll(2);
        return $this->fetch('index',[
            'data'=>$data,
            'title'=>"案例列表",
            'type'=>2
        ]);
    }

    /**
     * @name 添加文章
     * @return mixed
     */
    public function addOrEdit(ArticleCat $articleCat,Nav $nav)
    {
        $id= $this->request->param('id');
        $type= $this->request->param('type');
        $catData = $articleCat->getTreeAll();
        $navData = $nav->getTreeAll();
        $type == 1 ? $title='文章': $title='案例';
        if($id){
            //修改
            $data = $this->article->getOne($id);
            if(!$data){
                $this->error('数据已被删除,请恢复后再编辑！');
            }
            $this->assign('data',$data);
            $this->assign('title','修改网站'.$title);
        }else{
            $this->assign('title','添加网站'.$title);
        }
        $this->assign('catData',$catData);
        $this->assign('navData',$navData);
        $this->assign('type',$type);
        return $this->fetch('edit');
    }

    /**
     * @name 添加文章Do
     * @return mixed
     */
    public function addOrEditDo()
    {
        $validate = new Validate([
            'title'  => 'require',
            'cat_id' => 'require',
            'nav_id' => 'require',
            'description' => 'require',
            'content' => 'require',
        ]);
        $data= $this->request->only('id,title,pic,cat_id,nav_id,sort,description,content,type,remark1,remark2,remark3');
        if (!$validate->check($data)) {
            $this->error('操作失败！'.$validate->getError());
        }
        //图片
        if($this->request->file('pic')){
            $data['img'] = upload($this->request->file('pic'));
        }
        $data['description'] = nl2br($data['description']);  //或者换成换行函数
        if(!empty($data['id'])){
            if($this->article->updateData($data)){
                if($data['type'] ==1 ){
                    $this->redirect('admin/article/index',['msg'=>'修改成功！']);
                }else{
                    $this->redirect('admin/article/cases',['msg'=>'修改成功！']);
                }
            }
        }else{
            $res=$this->article->saveData($data);
            if($res){
                if($data['type'] ==1  ){
                    $this->redirect('admin/article/index',['msg'=>'添加成功！']);
                }else{
                    $this->redirect('admin/article/cases',['msg'=>'添加成功！']);
                }
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
        if($this->article->updateData($data)){
            return API_MSG('操作成功！',true);
        }
        return API_MSG('操作失败！',false);
    }
}