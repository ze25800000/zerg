<?php

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use think\Controller;
use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;

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
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    public function placeOrder() {

    }
}