<?php

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Loader;
use think\Log;

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

    private function makeWxPreOrder($totalPrice) {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url('');
    }

    private function getPaySignature($wxOrderData) {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if (!$wxOrder['return_code'] != 'SUCCESS' || $wxOrderData['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }
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