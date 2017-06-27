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
        try {
            $banner = BannerModel::getBannerByID($id);
        } catch (Exception $ex) {
            $err = [
                'error_code' => 10001,
                'msg'        => $ex->getMessage(),
            ];
            //使用tp5的json吧数组转换为json，第二个参数为返回错误码，默认为200
            return json($err,400);
        }
        return $banner;
    }
}