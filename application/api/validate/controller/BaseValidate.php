<?php

namespace app\api\validate\controller;

use app\lib\exception\ParameterException;
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
            $e = new ParameterException([
                'msg' => $this->error
            ]);
            throw $e;
        } else {
            return true;
        }
    }
}