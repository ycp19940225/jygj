<?php
/**
 * Created by PhpStorm.
 * User: Mac
 * Date: 2018/6/1
 * Time: 11:54
 */

namespace app\common\models;


use think\Model;

class Admin extends Model
{
    protected $table = "t_admin";

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


}