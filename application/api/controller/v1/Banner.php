<?php

namespace app\api\controller\v1;


class Banner {
    /**获取指定id的banner信息
     * @param $id
     * http GET方式
     * id banner的id号
     */
    public function getBanner($id) {
        echo $id;
    }
}