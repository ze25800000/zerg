<?php

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model {

    public function items() {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    //指定对应的数据表
    protected $table = 'banner_item';

    public static function getBannerByID($id) {
//        $result = Db::table('banner_item')
//            ->where(function ($query) use ($id) {
//                $query->where('banner_id', '=', $id);
//            })
//            ->select();
//        return $result;
    }
}