<?php

namespace app\api\model;


class Category extends BaseModel {
    public $hidden = ['id', 'delete_time', 'update_time'];

    public function Img() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}