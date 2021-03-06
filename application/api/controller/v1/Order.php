<?php

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\validate\PageingParameter;
use app\lib\exception\OrderException;

class Order extends BaseController {
    //用户在选择商品后，向API提交包含它所选择商品的相关信息
    //API在接受到信息后，需要检查订单相关商品的库存量
    //有库存，把订单数据存入数据库中，等下单成功了，返回客户端消息，告诉客户端可以支付了
    //调用支付接口，进行支付
    //还需要再次进行库存量检测
    //服务器就可以调用微信的支付接口进行支付
    //微信会返回给我们一个支付的结果
    //成功：也需要进行库存量检测
    //成功：进行库存量的扣除
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope'   => ['only' => 'getSummaryByUser,getDetail']
    ];

    public function getSummaryByUser($page = 1, $size = 15) {
        (new PageingParameter())->goCheck();
        $uid          = TokenService::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if (!$pagingOrders) {
            return [
                'data'         => [],
                'current_page' => $pagingOrders->getCurrentPage(),
            ];
        }
        $data = $pagingOrders->toArray();
        return [
            'data'         => $data,
            'current_page' => $pagingOrders->getCurrentPage(),
        ];
    }

    public function getSummary($page = 1, $size = 0) {
        (new PageingParameter())->goCheck();
        $pagingOrders = OrderModel::getSummaryByPage($page, $size);
        if (!$pagingOrders) {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data'         => []
            ];
        }
        $data = $pagingOrders->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data'         => $data
        ];
    }

    public function getDetail($id) {
        (new IDMustBePostiveInt())->goCheck();
        $orderDetail = OrderModel::get($id)->hidden(['prepay_id']);
        if (!$orderDetail) {
            throw new OrderException();
        }
        return $orderDetail;
    }

    public function placeOrder() {
        (new OrderPlace())->goCheck();
        //post.products如果想获取数组，必须在后面加 /a
        $products = input('post.products/a');
        $uid      = TokenService::getCurrentUid();
        $order    = new OrderService();
        $status   = $order->place($uid, $products);
        return $status;
    }
}