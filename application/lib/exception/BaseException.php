<?php

namespace app\lib\exception;

use think\Exception;

/**统一描述错误：错误码、错误信息、当前描述信息
 * Class BaseException
 * @package app\lib\exception
 */
class BaseException extends Exception {
    //外部访问的成员变量都定义为public
    //HTTP状态码
    public $code = 400;
    //错误信息
    public $msg = '参数错误';
    //错误码
    public $errorCode = '10000';

    public function __construct($params = []) {
        if (!is_array($params)) {
            return;
            //  throw new Exception('参数必须是数组');
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}