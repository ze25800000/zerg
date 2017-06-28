<?php

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\controller\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;

class Banner {
    public function getBanner($id) {
        (new IDMustBePostiveInt())->goCheck();
        //返回对象而不是数组
//        $banner = BannerModel::getBannerByID($id);
        $banner = BannerModel::get($id);
//        $banner = new BannerModel();
//        $banner = $banner->get($id);
        if (!$banner) {
            throw new BannerMissException();
        }
        return $banner;
    }
}