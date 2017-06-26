<?php

namespace app\api\validate\controller;

use think\Validate;

class TestValidate extends Validate {
    protected $rule = [
        'name'  => 'require|max:10',
        'email' => 'email'
    ];
}