<?php

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemeException;

class Theme {
    /** 获取专题页列表
     * @param string $ids
     * @return false|\PDOStatement|string|\think\Collection
     * @throws ThemeException
     */
    public function getSimpleList($ids = '') {
        (new IDCollection())->goCheck();
        $ids   = explode(',', $ids);
        $Theme = ThemeModel::With(['topicImg', 'headImg'])->select($ids);
        if (!$Theme) {
            throw new ThemeException();
        }
        return $Theme;
    }

    /**
     * @param $id
     */
    public function getComplexOne($id) {
        (new IDMustBePostiveInt())->goCheck();
        $themes = ThemeModel::getThemeWithProducts($id);
        if (!$themes) {
            return new ThemeException();
        }
        return $themes;
    }
}
