<?php

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\controller\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;
use think\Exception;

class Banner {
    public function getBanner($id) {
        (new IDMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        if (!$banner) {
            throw new Exception('内部错误');
        }
        return $banner;
    }
}