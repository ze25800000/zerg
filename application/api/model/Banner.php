<?php

namespace app\api\model;


use think\Db;

class Banner {
    public static function getBannerByID($id) {
//        $result = Db::query('select * from banner_item where banner_id=?', [$id]);
//        $result = Db::table('banner_item')
//            ->where('banner_id', '=', $id)
//            ->select();
        $result = Db::table('banner_item')
//            ->fetchSql()
            ->where(function ($query) use ($id) {
                $query->where('banner_id', '=', $id);
            })
            ->select();
        return $result;
    }
}