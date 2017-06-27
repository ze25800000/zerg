<?php

namespace app\lib\exception;


use Exception;
use think\exception\Handle;

/**自定义tp5错误处理类，重写handle
 * Class ExceptionHandler
 * @package app\lib\exception
 */
class ExceptionHandler extends Handle {
    //当controller中的异常没有处理时，错误处理会自动执行render
    public function render(Exception $e) {
        return json('~~~~');
    }
}