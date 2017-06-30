<?php

namespace app\api\model;


class Product extends BaseModel {
    protected $hidden = ['update_time', 'delete_time', 'create_time', 'id', 'category_id', 'from', 'pivot'];

}