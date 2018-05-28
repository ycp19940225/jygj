<?php
/**
 * Created by PhpStorm.
 * User: ycp
 * Date: 2018/5/28
 * Time: 23:34
 */

use think\Request;

/**
 * 加载静态资源
 *
 * @param string $file 所要加载的资源
 */
if ( ! function_exists('loadStatic'))
{
    function loadStatic($file)
    {
        if( ! $file) return Request::instance()->root().'/static/';
        $realFile = ROOT_PATH.'/static/'.$file;
        if( ! file_exists($realFile)) return '';
        $filemtime = filemtime($realFile);
        return Request::instance()->root().'/static/'.$file.'?v='.$filemtime;
    }
}