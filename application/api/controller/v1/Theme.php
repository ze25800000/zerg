<?php

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeException;

class Theme {
    public function getSimpleList($ids = '') {
        (new IDCollection())->goCheck();
        $ids   = explode(',', $ids);
        $Theme = ThemeModel::With(['topicImg', 'headImg'])->select($ids);
        if (!$Theme) {
            throw new ThemeException();
        }
        return $Theme;
    }

    public function getComplexOne($id) {
        return 'success';
    }
}
