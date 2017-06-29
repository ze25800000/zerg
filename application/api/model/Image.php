<?php

namespace app\api\model;

use think\Model;

class Image extends Model {
    protected $hidden = ['update_time', 'delete_time', 'from'];

}
