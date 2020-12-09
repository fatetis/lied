<ul id="detail-content-wrap" class="nav nav-tabs" role="tablist" data-id="{{ $order_detail['id'] }}">
    <li role="presentation" class="active">
        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">基本信息</a>
    </li>

    <li role="presentation">
        <a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">支付信息</a>
    </li>

    <li role="presentation">
        <a href="#receive" aria-controls="receive" role="tab" data-toggle="tab">
            @if($order_detail['shipping_type'] != \App\Models\Order::SHIPPING_TYPE_SELF)
            收货人信息
            @else
            提货人信息
            @endif
        </a>
    </li>

    {{-- 非自提订单 --}}
    @if($order_detail['shipping_type'] != \App\Models\Order::SHIPPING_TYPE_SELF)
    @if($order_detail['order_status'] !== config('WAIT_BUYER_PAY'))
        @if($order_detail['order_type'] == \App\Models\Order::ORDERGIFT)
            @if(isset($order_detail['gift']) && !is_null($order_detail['gift']))
                @if(isset($order_detail['gift']['shipping_type']) && $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_EXPRESS)
                <li role="presentation">
                    <a href="#delivery" aria-controls="delivery" role="tab" data-toggle="tab">配送信息</a>
                </li>
                @endif
            @endif
        @else
        <li role="presentation">
            <a href="#delivery" aria-controls="delivery" role="tab" data-toggle="tab">配送信息</a>
        </li>
        @endif
    @endif
    @endif

    @if(!is_null($order_detail['refund']))
    <li role="presentation">
        <a href="#refund" aria-controls="refund" role="tab" data-toggle="tab">退款信息</a>
    </li>
    @endif
    @if($order_detail['shipping_type'] == \App\Models\Order::SHIPPING_TYPE_SELF)
    <li role="presentation">
        <a href="#visit" aria-controls="visit" role="tab" data-toggle="tab">自提详情</a>
    </li>
    @endif
</ul>

<div class="tab-content">
    {{-- 基本信息开始 --}}
    <div role="tabpanel" class="tab-pane fade in active" id="home">
        <div class="content-wrap">
            <div class="div-out-height">
                <div class="false_table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product_thumb">商品图片</th>
                                <th>商品编号</th>
                                <th>商家名称</th>
                                <th class="product_name">商品名称</th>
                                <th>SKU</th>
                                <th>数量</th>
                                <th>单价</th>
                                <th>优惠金额</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="out_scoll">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product_thumb">商品图片</th>
                                <th>商品编号</th>
                                <th>商家名称</th>
                                <th class="product_name">商品名称</th>
                                <th>SKU</th>
                                <th>数量</th>
                                <th>单价</th>
                                <th>优惠金额</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($seller_order as $seller)
                            @forelse($seller['child_order'] as $child_order)
                            <tr>
                                <td class="product_thumb">
                                    <img src="{{ URL::image($child_order['product']['product_thumb']) }}">
                                </td>
                                <td>{{ $child_order['product_id'] }}</td>
                                <td>{{ $seller['seller']['seller_name'] }}</td>
                                <td>{{ $child_order['product']['product_name'] }}</td>
                                <td>{{ $child_order['sku']['sku_val'] }}</td>
                                <td>{{ $child_order['product_number'] }}</td>
                                <td>¥{{ $child_order['product_price'] }}</td>
                                <td>{{ $child_order['coupon_price'] }}</td>
                            </tr>
                            @empty
                            @endforelse
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="width: 50%; float: left;">
                <dl class="dl-horizontal">
                    <dt>订单ID</dt>
                    <dd>
                        {{ $order_detail['id'] }}
                        @if($order_detail['order_type'] == \App\Models\Order::ORDER_SUNING)
                        【苏宁：{{$order_detail['suning']['suning_order_id'] ?? '暂无'}}】
                        @endif
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>订单编号</dt>
                    <dd>{{ $order_detail['order_id'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>订单类型</dt>
                    <dd>{{ array_key_exists($order_detail['order_type'], \App\Models\Order::ORDER_TYPE_LIST) ? \App\Models\Order::ORDER_TYPE_LIST[$order_detail['order_type']] : '普通'}}
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>订单状态</dt>
                    <dd>
                        @if(array_key_exists($order_detail['order_status'], \App\Models\Order::ORDER_STATUS_DESC_LIST))
                        {{\App\Models\Order::ORDER_STATUS_DESC_LIST[$order_detail['order_status']]}}
                        @else
                        {{$order_detail['order_status']}}
                        @endif
                        @if($order_detail['order_type'] == \App\Models\Order::ORDER_SUNING)
                        【苏宁：@if(!is_null($order_detail['suning']) && array_key_exists($order_detail['suning']['order_status'], \App\Models\OrderSuning::STATUS_LIST))
                            {{\App\Models\OrderSuning::STATUS_LIST[$order_detail['suning']['order_status']]}}
                            @else 
                            未知
                            @endif】
                        @endif
                    </dd>
                </dl>
            </div>
            <div style="width: 50%;float: right;">
                <dl class="dl-horizontal">
                    <dt>订单金额</dt>
                    <dd>￥{{ $order_detail['total_price'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>订单优惠</dt>
                    <dd>{{ $order_detail['coupons_name'] or '未使用优惠券' }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>订单备注</dt>
                    <dd>{{ $order_detail['order_remark'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>下单时间</dt>
                    <dd>{{ $order_detail['buy_time'] }}</dd>
                </dl>
            </div>
        </div>
    </div>
    {{-- 基本信息结束 --}}

    {{-- 支付开始 --}}
    <div role="tabpanel" class="tab-pane fade" id="payment">
        <div class="content-wrap">
            <dl class="dl-horizontal">
                <dt>支付状态</dt>
                <dd>
                    @if ($order_detail['pay_status'] == config('PAY'))
                    已支付
                    @else
                    未支付
                    @endif
                </dd>
            </dl>
            @if ($order_detail['pay_status'] === config('PAY') && !is_null($order_detail['pay_type']))
                <dl class="dl-horizontal">
                    <dt>支付方式</dt>
                    <dd>{{ $order_detail['pay_type']['pay_name'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>支付金额</dt>
                    <dd>￥{{ $order_detail['pay_money'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>支付流水号</dt>
                    <dd>{{ $order_detail['order_num'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>支付时间</dt>
                    <dd>{{ $order_detail['pay_time'] }}</dd>
                </dl>
            @endif
        </div>
    </div>
    {{-- 支付结束 --}}

    {{-- 收货开始 --}}
    <div role="tabpanel" class="tab-pane fade" id="receive">
        <div class="content-wrap">
            @if($order_detail['shipping_type'] == \App\Models\Order::SHIPPING_TYPE_SELF)
                <dl class="dl-horizontal">
                    <dt>提货人</dt>
                    <dd>{{ $order_detail['address_name'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>手机号码</dt>
                    <dd>{{ $order_detail['order_mobile'] }}
                    </dd>
                </dl>
            @else
            @if($order_detail['order_type'] != \App\Models\Order::ORDERGIFT && $order_detail['order_type'] != 7)
                <dl class="dl-horizontal">
                    <dt>收货方式</dt>
                    <dd>邮寄到家</dd>
                </dl>
                @if($order_detail['order_status'] === config('WAIT_SELLER_SEND_GOODS') || $order_detail['order_status'] === config('WAIT_BUYER_PAY'))
                <form class="form-horizontal form-receiver" onsubmit="return false;">
                    <div class="form-group">
                        <label for="inputReceiver" class="col-sm-2 control-label"><i class="text-danger">*</i>收货人</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputReceiver" placeholder="收货人" name="name" value="{{ $order_detail['address_name'] }}" required @if($order_detail['order_type'] == \App\Models\Order::ORDER_SUNING) disabled @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputReceiveMobile" class="col-sm-2 control-label"><i class="text-danger">*</i>手机号码</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputReceiveMobile" placeholder="手机号码" name="mobile" value="{{ $order_detail['order_mobile'] }}" required @if($order_detail['order_type'] == \App\Models\Order::ORDER_SUNING) disabled @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputReceiveAddress" class="col-sm-2 control-label"><i class="text-danger">*</i>收货地址</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputReceiveAddress" placeholder="收货地址" name="address" value="{{ $order_detail['order_address'] }}" required  @if($order_detail['order_type'] == \App\Models\Order::ORDER_SUNING) disabled @endif>
                        </div>
                    </div>
                    @if($order_detail['order_type'] != \App\Models\Order::ORDER_SUNING)
                    <div class="form-group">
                        <div class="col-sm-2 control-label"></div>
                        <div class="col-sm-10">
                          <button type="submit" class="btn btn-primary" onclick="save_event_listener('receiver')">保存</button>
                        </div>
                    </div>
                    @endif
                </form>
                @else
                <dl class="dl-horizontal">
                    <dt>收货人</dt>
                    <dd>{{ $order_detail['address_name'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>手机号码</dt>
                    <dd>{{ $order_detail['order_mobile'] }}
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>收货地址</dt>
                    <dd>{{ $order_detail['order_address'] }}</dd>
                </dl>
                @endif
            @elseif($order_detail['order_type'] == \App\Models\Order::ORDERGIFT)
                <dl class="dl-horizontal">
                <dt>收货方式</dt>
                @if(isset($order_detail['gift']) && !is_null($order_detail['gift']))
                    @if(isset($order_detail['gift']['shipping_type']))
                        <dd>
                        @if(array_key_exists((string)$order_detail['gift']['shipping_type'], \App\Models\OrderGift::SHIPPING_TYPE))
                            {{\App\Models\OrderGift::SHIPPING_TYPE[(string)$order_detail['gift']['shipping_type']]}}
                        @endif
                        </dd>
                        </dl>
                        @if( $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_SELF)
                            @foreach($seller_order as $seller)
                            <dl class="dl-horizontal">
                                <dt>自提地址</dt>
                                <dd>{{ $seller['seller']['delivery_address'] }}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>联系电话</dt>
                                <dd>{{ $seller['seller']['delivery'] }}</dd>
                            </dl>
                            @endforeach
                            @if(!is_null($order_detail['gift']['remark']))
                            <dl class="dl-horizontal">
                                <dt>其他备注</dt>
                                <dd>{{ $order_detail['gift']['remark'] }}</dd>
                            </dl>
                            @endif
                        @elseif( $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_EXPRESS || $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_SEND)
                            <dl class="dl-horizontal">
                                <dt>收货人</dt>
                                <dd>{{ $order_detail['address_name'] }}</dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>手机号码</dt>
                                <dd>{{ $order_detail['order_mobile'] }}
                                </dd>
                            </dl>
                            <dl class="dl-horizontal">
                                <dt>收货地址</dt>
                                <dd>{{ $order_detail['order_address'] }}</dd>
                            </dl>
                            @if(!is_null($order_detail['gift']['remark']))
                            <dl class="dl-horizontal">
                                <dt>其他备注</dt>
                                <dd>{{ $order_detail['gift']['remark'] }}</dd>
                            </dl>
                            @endif
                        @else
                        <dl class="dl-horizontal">
                            <dt>其他备注</dt>
                            <dd>{{ $order_detail['gift']['remark'] }}</dd>
                        </dl>
                        @endif
                        @if($order_detail['order_status'] === config('WAIT_BUYER_CONFIRM_GOODS'))
                        <form class="form-horizontal form-confirm" onsubmit="return false;">
                            <input type="hidden" name="uid" value="{{$order_detail['user_id']}}">
                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-12">
                                  <button type="submit" class="btn btn-primary" onclick="save_event_listener('confirm')">确认收货</button>
                                </div>
                            </div>
                        </form>
                        @endif
                    @endif
                    @endif
                @endif
            @endif
        </div>
    </div>
    {{-- 收货结束 --}}

    {{-- 物流开始 --}}
    <div role="tabpanel" class="tab-pane fade" id="delivery">
        <div class="content-wrap">
            @if($order_detail['order_type'] != \App\Models\Order::ORDERGIFT)
                @if($order_detail['order_status'] === config('WAIT_SELLER_SEND_GOODS'))
                <form class="form-horizontal form-delivery" onsubmit="return false;">
                    <div class="form-group">
                        <label for="inputDeliveryName" class="col-sm-2 control-label"><i class="text-danger">*</i>物流名称</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputDeliveryName" placeholder="物流名称" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDeliveryNum" class="col-sm-2 control-label"><i class="text-danger">*</i>发货单号</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputDeliveryNum" placeholder="发货单号" name="num" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 control-label"></div>
                        <div class="col-sm-10">
                          <button type="submit" class="btn btn-primary" onclick="save_event_listener('delivery')">保存</button>
                        </div>
                    </div>
                </form>
                @else
                <dl class="dl-horizontal">
                    <dt>物流名称</dt>
                    <dd>
                        {{$order_detail['delivery']['express_name'] ?? ''}}
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>发货单号</dt>
                    <dd>
                        {{$order_detail['delivery']['delivery_num'] ?? ''}}
                    </dd>
                </dl>
                @endif
            @else
                @if(isset($order_detail['gift']) && !is_null($order_detail['gift']))
                    @if($order_detail['order_status'] == config('WAIT_SELLER_SEND_GOODS'))
                    <div class="alert alert-warning" role="alert">
                        礼品订单出库管理由业务系统控制
                    </div>
                    @else
                        @if(isset($order_detail['gift']['shipping_type']))
                            @if( $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_SELF)
                                <dl class="dl-horizontal">
                                    <dt>取件人</dt>
                                    <dd>{{ $order_detail['user']['user_name'] }}</dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>联系电话</dt>
                                    <dd>{{ $order_detail['user']['user_mobile'] }}</dd>
                                </dl>
                            @elseif( $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_EXPRESS)
                                <dl class="dl-horizontal">
                                    <dt>物流名称</dt>
                                    <dd>
                                        {{$order_detail['delivery']['express_name'] ?? ''}}
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>发货单号</dt>
                                    <dd>
                                        {{$order_detail['delivery']['delivery_num'] ?? ''}}
                                    </dd>
                                </dl>
                            @else
                            @endif
                        @endif
                    @endif

                @endif
            @endif
        </div>
    </div>
    {{-- 物流结束 --}}

    {{-- 退款开始 --}}
    <div role="tabpanel" class="tab-pane fade" id="refund">
        <div class="content-wrap">
            @if(!is_null($order_detail['refund']))
                <dl class="dl-horizontal">
                    <dt>退款类型</dt>
                    <dd>
                        @if(array_key_exists($order_detail['refund']['refund_type'], \App\Models\OrderRefund::REFUND_TYPE))
                            {{\App\Models\OrderRefund::REFUND_TYPE[$order_detail['refund']['refund_type']]}}
                        @endif
                    </dd>
                </dl>
                @if(!is_null($order_detail['refund']['reason']))
                <dl class="dl-horizontal">
                    <dt>退款原因</dt>
                    <dd>{{ $order_detail['refund']['reason']['msg'] }}</dd>
                </dl>
                @endif
                <dl class="dl-horizontal">
                    <dt>申请理由</dt>
                    <dd>{{ $order_detail['refund']['demand_reason'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>申请金额</dt>
                    <dd>￥{{ $order_detail['refund']['demand_money'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>申请时间</dt>
                    <dd>{{ $order_detail['refund']['demand_time'] }}</dd>
                </dl>
                @if(($order_detail['refund']['is_refund'] == \App\Models\OrderRefund::REFUND_STATUS_APPLY))
                    <form class="form-horizontal form-refund" onsubmit="return false;">
                        <div class="form-group">
                            <label for="inputDeliveryNum" class="col-sm-2 control-label">
                                <i class="text-danger">*</i>
                                <span>处理退款</span>
                            </label>
                            <div class="col-sm-10">
                                <label class="radio-inline">
                                    <input type="radio" id="inlineRadio1" name="type" onchange="set_refund_require_style()" value="1" required> 同意
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" id="inlineRadio2" name="type" onchange="set_refund_require_style()" value="2" required> 驳回
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDeliveryNum" class="col-sm-2 control-label">
                                <span>退款金额</span>
                            </label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" id="inputDeliveryNum" placeholder="退款金额，同意退款时必填" name="money">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDeliveryNum" class="col-sm-2 control-label">
                                <span>答复内容</span>
                            </label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="inputDeliveryNum" placeholder="答复内容，驳回退款时必填" name="reply">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 control-label"></div>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary" onclick="save_event_listener('refund')">保存</button>
                            </div>
                        </div>
                    </form>
                @else
                <dl class="dl-horizontal">
                    <dt>处理状态</dt>
                    <dd>
                        @if(array_key_exists($order_detail['refund']['is_refund'], \App\Models\OrderRefund::REFUND_STATUS))
                            {{\App\Models\OrderRefund::REFUND_STATUS[$order_detail['refund']['is_refund']]}}
                        @endif
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>退款金额</dt>
                    <dd>{{ $order_detail['refund']['refund_money'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>答复内容</dt>
                    <dd>{{ $order_detail['refund']['action_reason'] }}</dd>
                </dl>
                @endif
            @endif
        </div>
    </div>
    {{-- 退款结束 --}}

    {{-- 自提开始 --}}
    <div role="tabpanel" class="tab-pane fade" id="visit">
        <div class="content-wrap">
            @if(isset($order_detail['order_visit']['status']) && $order_detail['order_visit']['status'] === true)
            <dl class="dl-horizontal">
                <dt>提货商家</dt>
                <dd>
                    {{$seller_order[0]['seller']['seller_name'] ?? ''}}
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>核销人</dt>
                <dd>
                    {{$order_detail['order_visit']['uname'] ?? ''}}
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>提货码</dt>
                <dd>
                    {{$order_detail['order_visit']['code'] ?? ''}}
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>提货时间</dt>
                <dd>
                    {{$order_detail['order_visit']['time'] ?? ''}}
                </dd>
            </dl>
            <dl class="dl-horizontal">
                <dt>备注</dt>
                <dd>
                    {{$order_detail['order_visit']['remark'] ?? ''}}
                </dd>
            </dl>
            @endif
        </div>
    </div>
    {{-- 自提结束 --}}

{{-- tab结束 --}}
</div>
<style>
    #orderInfoModal .tab-content {
        display: block;
        @if(count($seller_order[0]['child_order'])>3)
        height: 659px;
        @else height: {{38+(count($seller_order[0]['child_order']) * 137)+160+20 * 2}}px;
        @endif
    }

    #orderInfoModal .tab-content .out_scoll {
        display: block;
        @if(count($seller_order[0]['child_order'])>3)
        height: 410px;
        @else height: {{count($seller_order[0]['child_order']) * 137+38}}px;
        @endif
    }
</style>
