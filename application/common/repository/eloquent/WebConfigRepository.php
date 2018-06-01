<?php
/**
 * Created by PhpStorm.
 * User: ycp
 * Date: 2018/6/1
 * Time: 11:53
 */

namespace app\common\repository\eloquent;


use app\common\models\WebConfig;
use think\exception\DbException;

class WebConfigRepository
{
    /**
     * 注入 User model
     */
    protected $configModel;

    /**
     * @param WebConfig $webConfig
     */
    public function __construct(WebConfig $webConfig)
    {
        $this->configModel = $webConfig;
    }

    /**
     * @desc 获取数据集
     * @param string $fields
     * @return \Exception|false|\PDOStatement|string|\think\Collection|DbException
     */
    public function getAll($fields = "*")
    {
        return $this->configModel->field($fields)
            ->where(['deleted_at'=>0])
            ->order('id desc')
            ->select();
    }

    /**
     * @desc 获取单条数据
     * @param $value
     * @param string $fields
     * @param string $field
     * @return \Exception|false|\PDOStatement|string|\think\Collection|DbException
     */
    public function getOne($value,$fields="*",$field = 'id')
    {
        try {
            return $this->configModel->field($fields)
                ->where(['deleted_at'=>0,$field=>$value])
                ->find();
        }  catch (DbException $e) {
            return $e;
        }
    }

    /**
     * @desc 数据添加
     * @param $data
     * @return \Exception|false|\PDOStatement|string|\think\Collection|DbException
     */
    public function save($data)
    {
        try {
            return $this->configModel->save($data);
        }  catch (DbException $e) {
            return $e;
        }
    }
    /**
     * @desc 数据更新
     * @param $data
     * @return \Exception|false|\PDOStatement|string|\think\Collection|DbException
     */
    public function update($data)
    {
        try {
            return $this->configModel->where(['id'=>$data['id']])->save($data);
        }  catch (DbException $e) {
            return $e;
        }
    }

    /**
     * @desc 删除单条数据
     */
    public function delete($id)
    {
       return $this->configModel->where('id',$id)->update(['deleted_at'=>9]);
    }

    /**
     * @desc 通过字段获取数据集
     * @param $field
     * @param $val
     * @param string $fields
     * @return \Exception|false|\PDOStatement|string|\think\Collection|DbException
     */
    public function getAllByField($field,$val,$fields="*")
    {
        try {
            return $this->configModel->field($fields)
                ->where($field,$val)
                ->update(['deleted_at'=>1])
                ->select();
        }  catch (DbException $e) {
            return $e;
        }
    }
}