<?php

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {
    public function goCheck() {
        $request = Request::instance();
        $params  = $request->param();
        //继承自Validate
        $result = $this->batch()->check($params);
        if (!$result) {
            //获取错误信息
            throw new ParameterException([
                'msg' => $this->error
            ]);
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '') {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }

    }

    protected function isNotEmpty($value, $rule = '', $data = '', $field = '') {
        if (empty($value)) {
            return false;
        } else {
            return true;
        }
    }
}