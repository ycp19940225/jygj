<?php
/**
 * Created by PhpStorm.
 * User: ycp
 * Date: 2017/6/3
 * Time: 16:46
 */

namespace App\Models\Admin;



use think\Model;

class Users extends Model
{
    protected $table = 't_admin';

    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';


    protected $hidden = [
        'password', 'token',
    ];

    /**
     * 关联模型
     * 属于该用户的身份。
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Admin\Role','emerald_admin_role','admin_id','role_id');
    }


}