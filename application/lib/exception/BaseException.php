<?php
/**
 * Created by PhpStorm.
 * User: ze258
 * Date: 2017/6/27 0027
 * Time: 15:20
 */

namespace app\lib\exception;

/**统一描述错误：错误码、错误信息、当前描述信息
 * Class BaseException
 * @package app\lib\exception
 */
class BaseException {
    //外部访问的成员变量都定义为public
    //HTTP状态码
    public $code = 400;
    //错误信息
    public $msg = '参数错误';
    //错误码
    public $errorCode = '10000';
}