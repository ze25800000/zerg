<?php

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Loader;

//            文件夹.文件名前半部分  extend文件夹目录      文件名后半部分
Loader::import('WxPay.Wxpay', EXTEND_PATH, '.Api.php');

class Pay {
    private $orderID;
    private $orderNO;

    function __construct($orderID) {
        if (!$orderID) {
            throw new Exception('订单号不许为空');
        }
        $this->orderID = $orderID;
    }

    public function pay() {
        //订单号可能根本不存在
        //订单号确实存在，但是，订单号和当前用户不匹配
        //订单有可能已经支付过
        //进行库存量检测
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status       = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']) {
            //如果没有通过，返回状态信息，后面的代码不再执行
            return $status;
        }

    }

    private function makeWxPreOrder() {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
    }

    private function checkOrderValid() {
        $order = OrderModel::where('id', '=', $this->orderID)
            ->find();
        if (!$order) {
            throw new OrderException();
        }
        if (!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
                'msg'       => '订 单与用户不匹配',
                'errorCode' => 10003
            ]);
        }
        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException([
                'msg'       => '订单已经支付了',
                'errorCode' => 80003,
                'code'      => 400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }
}