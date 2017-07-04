<?php

namespace app\api\service;


use app\api\model\Product;

class Order {
    //订单的商品列表，也就是客户端传过来的products参数
    protected $oProducts;
    //数据库中的商品信息，库存量
    protected $products;
    protected $uid;

    public function place($uid, $oProducts) {
        //oProducts和products做对比
        //products从数据库中查出来
        $this->oProducts = $oProducts;
        $this->products  = $this->getProductsByOrder($oProducts);
        $this->uid       = $uid;
    }

    //根据订单信息查找真实的商品信息
    private function getProductsByOrder($oProducts) {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        //如果database中的数据集返回类型 设置为collection，则最后加上toArray()，转为数组
        $products = Product::all([$oPIDs])
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url']);
        return $products;
    }
}