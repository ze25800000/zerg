<?php

namespace app\api\controller\v1;


use app\api\validate\TokenGet;

class Token {
    public function getToken($code) {
        (new TokenGet())->goCheck();
    }
}