<?php

namespace app\api\model;


use think\Exception;

class Banner {
    public static function getBannerByID($id) {
        //TODO  根据id号获取banner信息
        try {
            1 / 0;
        } catch (Exception $ex) {
            throw $ex;
        }
        return 'this is banner info ' . $id;

    }
}