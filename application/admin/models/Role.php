<?php
/**
 * Created by PhpStorm.
 * User: ycp
 * Date: 2017/6/3
 * Time: 16:46
 */

namespace App\Models\Admin;



use think\Model;

class Role extends Model
{
    protected $table = 't_role';

    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    /**
     * 关联模型
     * 属于该用户的权限。
     */
    public function pris()
    {
        return $this->belongsToMany('App\Models\Admin\Users','emerald_role_pri','role_id','pri_id');
    }


}