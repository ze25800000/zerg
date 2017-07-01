<?php

namespace app\api\model;


class User extends BaseModel {
    public static function getByOpenID($openid) {
        $result = self::where('openid', '=', $openid)
            ->find();
        return $result;
    }
}