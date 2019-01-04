<?php
/**
 * Created by PhpStorm.
 * User: ycp
 * Date: 2018/5/28
 * Time: 23:34
 */

/**
 *
 */
if ( ! function_exists('dd'))
{
    function dd($data)
    {
        dump($data);exit();
    }
}
/**
 * ajax API 返回格式
 */
if ( ! function_exists('API_MSG'))
{
    function API_MSG($msg,$status = true,$data=[])
    {
        return json(['status'=>$status,'data'=>$data,'msg'=>$msg]);
    }
}


/**
 * 显示图片
 * @param $url
 * @param string $width
 * @param string $height
 */
if ( ! function_exists('showImage')) {
    function showImage($url, $width = '', $height = '', $style = '', $title = '')
    {
        if ($width)
            $width = "width='$width'";
        if ($height)
            $height = "height='$height'";
        if ($style)
            $style = "class='$style'";
        if ($title) {
            $title = "title='$title'";
        }
        echo "<img $width $height $style $title src='$url' />";
    }
}
/**
 * 制作下拉框
 * @param $tableName
 * @param $selectname
 * @param $valueFieldName
 * @param $textFieldName
 * @param string $selectValue  <?php buildSelect('course','course_id','id','course_name'); ?>
 */
if ( ! function_exists('buildSelect')) {
    function buildSelect($data, $selectname, $valueFieldName, $textFieldName, $selectValue = '',$exclude='')
        {   //表名，下拉选框的名字，循环的Id，循环的名称，要选择的字段的值
            $select = "<select class=\"form-control \"  name ='$selectname'> <option value=''>请选择&nbsp;&nbsp;&nbsp;</option>";
            foreach ($data as $k => $v) {
                if($exclude == $v['id']){
                    continue;
                }
                $value = $v[$valueFieldName];   //id循环的id
                $text = $v[$textFieldName];    //id对应的名称
                //无限极分类
                $level = "";
                if(isset($v['level'])){
                    $level = str_repeat('&nbsp',$v['level']*3);
                }
                if ($selectValue && $selectValue == $value) {   //$selectValue为商品Id
                    $selected = 'selected ="selected"';
                } else {
                    $selected = '';
                }
                $select .= '<option ' . $selected . 'value="' . $value . '">' . $level.$text . '</option>';
            }
            $select .= '</select>';
            echo $select;
        }
}
/**
 * 上传图片
 */
if ( ! function_exists('upload')) {
    function upload($file){
        // 获取表单上传文件 例如上传了001.jpg
        $savePath = ROOT_PATH . 'public' . DS . 'uploads';
        $showPath =   DS . 'uploads'. DS;
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['ext'=>'jpeg,jpg,png,gif'])->move($savePath);
        if($info){
            return $showPath . $info->getSaveName();
        }else{
            // 上传失败获取错误信息
            return $file->getError();
        }
    }
}
/**
 * 获取文章
 */
if ( ! function_exists('getArticle')) {
    function getArticle($id){
       return db('t_article')->find($id);
    }
}

