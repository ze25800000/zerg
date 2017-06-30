<?php

namespace app\api\model;


class Product extends BaseModel {
    protected $hidden = ['update_time', 'delete_time', 'create_time',  'category_id', 'from', 'pivot'];

    public function getMainImgUrlAttr($url, $data) {
        return $this->prefixImgUrl($url, $data);
    }
}