<?php
/**
 * Created by PhpStorm.
 * User: ycp
 * Date: 2018/6/1
 * Time: 11:53
 */

namespace app\common\repository\eloquent;



use app\common\models\WebConfig;

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
     */
    public function getAll($fields = "*",$limit=10)
    {
        return $this->configModel->field($fields)
            ->order('id desc')
            ->paginate($limit);
    }

    /**
     * @desc 获取单条数据
     */
    public function getOne($value,$fields="*",$field = 'id')
    {
        return $this->configModel->field($fields)
            ->where(['deleted_at' => 1, $field => $value])
            ->find();
    }

    /**
     * @desc 数据添加
     */
    public function saveData($data)
    {
        return $this->configModel->save($data);
    }
    /**
     * @desc 数据更新
     */
    public function updateData($data)
    {
        return $this->configModel->where(['id'=>$data['id']])->update($data);
    }

    /**
     * @desc 删除单条数据
     */
    public function deleteData($id)
    {
        return $this->configModel->where('id',$id)->update(['deleted_at'=>9]);
    }

    /**
     * @desc 通过字段获取数据集
     */
    public function getAllByField($field,$val,$fields="*")
    {
        return $this->configModel->field($fields)
            ->where(['deleted_at'=>1,$field=>$val])
            ->select();
    }
}