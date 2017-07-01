<?php

namespace app\api\validate;


class TokenGet extends BaseValidate {
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];
    protected $message = [
        'code' => '请输入正确的code'
    ];
}