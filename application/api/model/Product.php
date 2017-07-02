<?php

namespace app\api\model;


class Product extends BaseModel {
    protected $hidden = ['update_time', 'delete_time', 'create_time', 'category_id', 'from', 'pivot'];

    public function getMainImgUrlAttr($url, $data) {
        return $this->prefixImgUrl($url, $data);
    }

    public function imgs() {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function properties() {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public static function getMostRecent($count) {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

    public static function getProductsByCategoryID($categoryID) {
        $products = self::where('category_id', '=', $categoryID)
            ->select();
        return $products;
    }

    public static function getProductDetail($id) {
//        $products = self::with(['imgs.imgUrl', 'properties'])
//            ->find($id);
        $products = self::with([
            'imgs' => function ($query) {
                $query->with(['imgUrl'])
                    ->order('order', 'asc');
            }
        ])
            ->with(['properties'])
            ->find($id);
        return $products;
    }
}