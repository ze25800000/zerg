<?php

namespace app\api\validate\controller;

use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {
    public function goCheck() {
        $request = Request::instance();
        $params  = $request->param();
        //继承自Validate
        $result = $this->check($params);
        if (!$result) {
            //获取错误信息
            $error = $this->error;
            //抛出异常，中断执行
            throw new Exception($error);
        } else {
            return true;
        }
    }
}