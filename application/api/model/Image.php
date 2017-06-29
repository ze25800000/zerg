<?php

namespace app\api\model;

class Image extends BaseModel {
    protected $hidden = ['update_time', 'delete_time', 'from', 'id'];

    public function getUrlAttr($value, $data) {
        return $this->prefixImgUrl($value, $data);
    }

}
