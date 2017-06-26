<?php

namespace app\api\controller\v1;

use app\api\validate\controller\IDMustBePostiveInt;
use app\api\validate\controller\TestValidate;
use think\Validate;

class Banner {
    /**获取指定id的banner信息
     * @param $id
     * http GET方式
     * id banner的id号
     */
    public function getBanner($id) {
        $data = [
            'id' => $id
        ];
        /*$validate = new Validate([
            'id' => ''
        ]);*/
        $validate = new IDMustBePostiveInt();
        $result   = $validate->batch()->check($data);
        if ($result) {

        } else {

        }
    }
}