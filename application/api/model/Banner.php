<?php

namespace app\api\model;


use think\Model;


class Banner extends Model {
    protected $hidden = ['update_time', 'delete_time'];
    public function items() {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerByID($id) {
        return self::with(['items', 'items.img'])->find($id);
    }
}