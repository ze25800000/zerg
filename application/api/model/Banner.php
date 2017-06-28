<?php

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model {
    //指定对应的数据表
    protected $table = 'banner_item';
//    public static function getBannerByID($id) {
////        $result = Db::query('select * from banner_item where banner_id=?', [$id]);
////        $result = Db::table('banner_item')
////            ->where('banner_id', '=', $id)
////            ->select();
//        $result = Db::table('banner_item')
//            ->where(function ($query) use ($id) {
//                $query->where('banner_id', '=', $id);
//            })
//            ->select();
//        return $result;
//    }
}