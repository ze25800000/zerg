<?php

namespace app\lib\exception;


class CategoryException extends BaseException {
    public $code = 404;
    public $msg = '没有列表信息';
    public $errorCode = '50000';
}