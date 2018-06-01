<?php
/**
 * Created by PhpStorm.
 * User: Mac
 * Date: 2018/6/1
 * Time: 11:54
 */

namespace app\common\models;


use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Model;

class WebConfig extends Model
{
    protected $table = "t_web_config";


    /**
     * @desc 获取数据集
     */
    public function getAll($fields = "*")
    {
        return $this->field($fields)
            ->where(['deleted_at'=>1])
            ->order('id desc')
            ->select();
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
        return $this->where(['id'=>$data['id']])->save($data);
    }

    /**
     * @desc 删除单条数据
     */
    public function deleteData($id)
    {
        return $this->where('id',$id)->update(['deleted_at'=>9]);
    }

    /**
     * @desc 通过字段获取数据集
     */
    public function getAllByField($field,$val,$fields="*")
    {
        return $this->field($fields)
            ->where(['deleted_at'=>1,$field=>$val])
            ->select();
    }
}