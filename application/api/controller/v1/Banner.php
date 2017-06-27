<?php

namespace app\api\controller\v1;

use app\api\validate\controller\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use think\Exception;

class Banner {
    /**获取指定id的banner信息
     * @param $id
     * http GET方式
     * id banner的id号
     */
    public function getBanner($id) {
        (new IDMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        return $banner;
    }
}