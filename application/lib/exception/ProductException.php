<?php

namespace app\lib\exception;


use think\Exception;

class ProductException extends Exception {
    public $code = 404;
    public $msg = '指定商品不存在，请检查参数';
    public $errorCode = 20000;
}