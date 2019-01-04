<?php
/**
 * Created by PhpStorm.
 * User: Mac
 * Date: 2018/6/1
 * Time: 11:54
 */

namespace app\common\models;


use think\Model;

class ArticleCat extends Model
{
    protected $table = "t_article_cat";

    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';


    /**
     * @desc 获取数据集
     */
    public function getAll($fields = "*",$limit=10)
    {
        return $this->field($fields)
            ->order('id desc')
            ->paginate($limit);
    }

    /**
     * @desc 获取单条数据
     */
    public function getOne($value,$fields="*",$field = 'id')
    {
        return $this->field($fields)
            ->where(['deleted_at' => 1, $field => $value])
            ->find();
    }

    /**
     * @desc 数据添加
     */
    public function saveData($data)
    {
        return $this->save($data);
    }
    /**
     * @desc 数据更新
     */
    public function updateData($data)
    {
        return $this->where(['id'=>$data['id']])->update($data);
    }

    /**
     * @desc 删除单条数据
     */
    public function deleteData($id)
    {
        return $this->where('id',$id)->update(['deleted_at'=>9]);
    }

    /**
     * @desc 获取树状分类
     */
    public function getTreeAll()
    {
        $data = $this->getAlls('id,parent_id,name');

        return $this->getTree($data);
    }

    /**
     * @desc 获取数据集(递归不分页)
     */
    public function getAlls($fields = "*")
    {
        return $this->field($fields)
            ->order('id desc')
            ->select();
    }

    /************************************* 递归相关方法 *************************************/
    public function getTree($data)
    {
        return $this->_reSort($data);
    }
    private function _reSort($data, $parent_id=0, $level=0, $isClear=TRUE)
    {
        static $ret = array();
        if($isClear)
            $ret = array();
        foreach ($data as $k => $v)
        {
            if($v['parent_id'] == $parent_id)
            {
                $v['level'] = $level;
                $ret[] = $v;
                $this->_reSort($data, $v['id'], $level+1, FALSE);
            }
        }
        return $ret;
    }
    public function getChildren($id)
    {
        $data = $this->getAll('id');
        return $this->_children($data, $id);
    }
    private function _children($data, $parent_id=0, $isClear=TRUE)
    {
        static $ret = array();
        if($isClear)
            $ret = array();
        foreach ($data as $k => $v)
        {
            if($v['parent_id'] == $parent_id)
            {
                $ret[] = $v['id'];
                $this->_children($data, $v['id'], FALSE);
            }
        }
        return $ret;
    }
}