<?php

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

/**自定义tp5错误处理类，重写handle
 * Class ExceptionHandler
 * @package app\lib\exception
 */
class ExceptionHandler extends Handle {
    private $code;
    private $msg;
    private $errorCode;

    //当controller中的异常没有处理时，错误处理会自动执行render
    public function render(Exception $e) {
        if ($e instanceof BaseException) {
            $this->code      = $e->code;
            $this->msg       = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            $this->code      = 500;
            $this->msg       = '服务器内部错误';
            $this->errorCode = 999;
            $this->recordErrorLog($e);
        }
        $request = Request::instance();
        $result  = [
            'msg'         => $this->msg,
            'error_code'  => $this->errorCode,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(Exception $e) {
        //初始化对象
        Log::init([
            'type'  => 'File',
            'path'  => LOG_PATH,
            'level' => ['error']
        ]);
        //定义错误级别为error
        Log::record($e->getMessage(), 'error');
    }
}