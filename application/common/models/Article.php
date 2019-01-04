<?php
/**
 * Created by PhpStorm.
 * User: Mac
 * Date: 2018/6/1
 * Time: 11:54
 */

namespace app\common\models;


use think\Model;

class Article extends Model
{
    protected $table = "t_article";

    protected $dateFormat = 'Y/m/d';

    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    public function cat()
    {
        return $this->belongsTo('ArticleCat','cat_id');
    }

    public function nav()
    {
        return $this->belongsTo('Nav','nav_id');
    }

    /**
     * @desc 获取数据集
     */
    public function getAll($type = 1,$fields = "*",$limit=10)
    {
        return $this->field($fields)
            ->where('type',$type)
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
     * @desc 通过字段获取数据集
     */
    public function getAllByField($field,$val,$fields="*")
    {
        return $this->field($fields)
            ->where(['deleted_at'=>1,$field=>$val])
            ->select();
    }

    /**
     * @desc 获取数据集
     */
    public function getAlls($fields = "*",$limit=4)
    {
        return $this->field($fields)
            ->where('deleted_at',1)
            ->order('id desc')
            ->paginate($limit);
    }

    /**
     * 随机获取数据
     * @param string $num  抽取条数
     * @param string $table    表名
     * @param string $where    查询条件
     * @return array
     */
    function randomData($num,$where=[])
    {
        $pk = $this->getPK();//获取主键
        $countcus = $this->where($where)->field($pk)->select();//查询数据
        $con = '';
        $qu = '';
        foreach($countcus as $v=>$val){
            $con.= $val[$pk].'|';
        }
        $array = explode("|",$con);
        $countnum = count($array)-1;
        for($i = 0;$i <= $num;$i++){
            $sunum = mt_rand(0,$countnum);
            $qu.= $array[$sunum].',';
        }
        $list = $this->where($pk,'in',$qu)->select();
        return $list;
    }

    //获取文章上下篇
    public function getHandover($id,$where = [])
    {
        //选出所有符合条件的ID
        $ids = $this->field('id,title')->where($where)->select();
        $handoverArticle = [];
        foreach ($ids as $k => $v){
            if($v['id'] == $id){
                //定位当前
                //获取下一篇
                if(isset($ids[$k+1])){
                    $handoverArticle['next_id'] = $ids[$k+1]['id'];
                    $handoverArticle['next_title'] = $ids[$k+1]['title'];
                }else{
                    $handoverArticle['next'] = false;
                }
                //获取上一篇
                if(isset($ids[$k-1])){
                    $handoverArticle['previous_id'] = $ids[$k-1]['id'];
                    $handoverArticle['previous_title'] = $ids[$k-1]['title'];
                }else{
                    $handoverArticle['previous'] = false;
                }
            }
        }
        return $handoverArticle;
    }
}