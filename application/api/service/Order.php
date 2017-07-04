<?php

namespace app\api\service;


use app\api\model\Product;
use app\api\model\UserAddress;
use app\api\validate\UserException;
use app\lib\exception\OrderException;

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
        $status          = $this->getOrderStatus();
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }
        //开始创建订单
        $orderSnap = $this->snapOrder($status);
    }

    //生成订单快照
    private function snapOrder($status) {
        $snap                = [
            'orderPrice'  => 0,
            'totalCount'  => 0,
            'pStatus'     => [],
            'snapAddress' => null,
            'snapName'    => '',
            'snapImg'     => ''
        ];
        $snap['orderPrice']  = $status['orderPrice'];
        $snap['totalCount']  = $status['totalCount'];
        $snap['pStatus']     = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName']    = $this->products[0]['name'];
        $snap['snapImg']     = $this->products[0]['main_img_url'];
        if (count($this->products) > 1) {
            $snap['name'] .= '等';
        }
    }

    private function getUserAddress() {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)
            ->find();
        if (!$userAddress) {
            throw new UserException([
                'msg'       => '用户收获地址不存在，下单失败',
                'errorCode' => 60001
            ]);
        }
        return $userAddress->toArray();
    }

    private function getOrderStatus() {
        $status = [
            'pass'         => true,
            'orderPrice'   => 0,
            'totalCount'   => 0,
            'pStatusArray' => []
        ];
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus(
                $oProduct['product_id'],
                $oProduct['count'],
                $this->products
            );
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['Count'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products) {
        $pIndex  = -1;
        $pStatus = [
            'id'         => null,
            'haveStock'  => false,
            'count'      => 0,
            'name'       => '',
            'totalPrice' => 0
        ];
        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }
        if ($pIndex == -1) {
            throw new OrderException([
                'msg' => 'id为' . $oPID . '的商品不存在，创建订单失败'
            ]);
        } else {
            $product               = $products[$pIndex];
            $pStatus['id']         = $product['id'];
            $pStatus['name']       = $product['name'];
            $pStatus['count']      = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;
            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
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