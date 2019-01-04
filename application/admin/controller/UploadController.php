<?php
/**
 * Created by PhpStorm.
 * DESC:
 * User: ycp
 * Date: 2018/6/6
 * Time: 14:41
 */

namespace app\admin\controller;



use think\Request;

class UploadController extends BaseController
{
    public function uploadImg(Request $request)
    {
        $files = $request->file('imgFile');
        $url = $request->domain().upload($files);
        if($url){
            return json(['error'=>0,'url'=>$url]);
        }
        return json(['error'=>1,'url'=>$url]);
    }
}