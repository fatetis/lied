<ul id="detail-content-wrap" class="nav nav-tabs" role="tablist" data-id="{{ $data['orderno'] }}">
    <li role="presentation" class="active">
        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">基本信息</a>
    </li>

    <li role="presentation">
        <a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">支付信息</a>
    </li>

    <li role="presentation">
        <a href="#receive" aria-controls="receive" role="tab" data-toggle="tab">
            收货人信息
        </a>
    </li>

    <li role="presentation">
        <a href="#delivery" aria-controls="delivery" role="tab" data-toggle="tab">配送信息</a>
    </li>

    <li role="presentation">
        <a href="#refund" aria-controls="refund" role="tab" data-toggle="tab">退款信息</a>
    </li>

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
                                <th class="product_name">商品名称</th>
                                <th>SKU</th>
                                <th>数量</th>
                                <th>单价</th>
                                {{--<th>优惠金额</th>--}}
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="out_scoll">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product_thumb">商品图片</th>
                                <th>商品id</th>
                                <th class="product_name">商品名称</th>
                                <th>SKU</th>
                                <th>数量</th>
                                <th>单价</th>
                                {{--<th>优惠金额</th>--}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['product'] as $value)
                            <tr>
                                <td class="product_thumb">
                                    <img src="{{ $value['sku_media'] ?? '' }}">
                                </td>
                                <td>{{ $value['product_id'] ?? '' }}</td>
                                <td>{{ $value['product_name'] ?? '' }}</td>
                                <td>{{ $value['sku'] ?? '' }}</td>
                                <td>{{ $value['number'] }}</td>
                                <td>¥{{ $value['product_price'] }}</td>
                                {{--<td>{{ $child_order['coupon_price'] }}</td>--}}
                            </tr>
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
                        {{ $data['id'] }}
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>订单编号</dt>
                    <dd>{{ $data['orderno'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>订单类型</dt>
                    <dd>{{ $data['order_type'] }}
                    </dd>
                </dl>

            </div>
            <div style="width: 50%;float: right;">
                <dl class="dl-horizontal">
                    <dt>订单金额</dt>
                    <dd>￥{{ $data['price'] }}</dd>
                </dl>
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>订单优惠</dt>--}}
                    {{--<dd>{{ $order_detail['coupons_name'] or '未使用优惠券' }}</dd>--}}
                {{--</dl>--}}
                <dl class="dl-horizontal">
                    <dt>下单时间</dt>
                    <dd>{{ $data['order_time'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>订单状态</dt>
                    <dd>
                        {{ $data['order_status'] }}
                    </dd>
                </dl>
            </div>
            <div style="clear: both"></div>
            <div style="width: 100%;">
                <dl class="dl-horizontal">
                    <dt>订单备注</dt>
                    <dd>{{ $data['message'] }}</dd>
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
                    {{ $data['pay_status'] }}
                </dd>
            </dl>
            @if (!empty($data['pay_log']) && $data['pay_log']['is_pay'] === 1)
                <dl class="dl-horizontal">
                    <dt>支付流水号</dt>
                    <dd>{{ $data['pay_log']['outside_orderno'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>支付金额</dt>
                    <dd><span style="color: red">￥{{ $data['pay_log']['pay_price'] }}</span></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>支付方式</dt>
                    <dd>{{ $data['pay_log']['pay_name'] }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>支付时间</dt>
                    <dd>{{ $data['pay_log']['created_at'] }}</dd>
                </dl>
            @endif
        </div>
    </div>
    {{-- 支付结束 --}}

    {{-- 收货开始 --}}
    {{--<div role="tabpanel" class="tab-pane fade" id="receive">--}}
        {{--<div class="content-wrap">--}}
            {{--@if($order_detail['shipping_type'] == \App\Models\Order::SHIPPING_TYPE_SELF)--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>提货人</dt>--}}
                    {{--<dd>{{ $order_detail['address_name'] }}</dd>--}}
                {{--</dl>--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>手机号码</dt>--}}
                    {{--<dd>{{ $order_detail['order_mobile'] }}--}}
                    {{--</dd>--}}
                {{--</dl>--}}
            {{--@else--}}
            {{--@if($order_detail['order_type'] != \App\Models\Order::ORDERGIFT && $order_detail['order_type'] != 7)--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>收货方式</dt>--}}
                    {{--<dd>邮寄到家</dd>--}}
                {{--</dl>--}}
                {{--@if($order_detail['order_status'] === config('WAIT_SELLER_SEND_GOODS') || $order_detail['order_status'] === config('WAIT_BUYER_PAY'))--}}
                {{--<form class="form-horizontal form-receiver" onsubmit="return false;">--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="inputReceiver" class="col-sm-2 control-label"><i class="text-danger">*</i>收货人</label>--}}
                        {{--<div class="col-sm-10">--}}
                          {{--<input type="text" class="form-control" id="inputReceiver" placeholder="收货人" name="name" value="{{ $order_detail['address_name'] }}" required @if($order_detail['order_type'] == \App\Models\Order::ORDER_SUNING) disabled @endif>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="inputReceiveMobile" class="col-sm-2 control-label"><i class="text-danger">*</i>手机号码</label>--}}
                        {{--<div class="col-sm-10">--}}
                          {{--<input type="text" class="form-control" id="inputReceiveMobile" placeholder="手机号码" name="mobile" value="{{ $order_detail['order_mobile'] }}" required @if($order_detail['order_type'] == \App\Models\Order::ORDER_SUNING) disabled @endif>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="inputReceiveAddress" class="col-sm-2 control-label"><i class="text-danger">*</i>收货地址</label>--}}
                        {{--<div class="col-sm-10">--}}
                          {{--<input type="text" class="form-control" id="inputReceiveAddress" placeholder="收货地址" name="address" value="{{ $order_detail['order_address'] }}" required  @if($order_detail['order_type'] == \App\Models\Order::ORDER_SUNING) disabled @endif>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@if($order_detail['order_type'] != \App\Models\Order::ORDER_SUNING)--}}
                    {{--<div class="form-group">--}}
                        {{--<div class="col-sm-2 control-label"></div>--}}
                        {{--<div class="col-sm-10">--}}
                          {{--<button type="submit" class="btn btn-primary" onclick="save_event_listener('receiver')">保存</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@endif--}}
                {{--</form>--}}
                {{--@else--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>收货人</dt>--}}
                    {{--<dd>{{ $order_detail['address_name'] }}</dd>--}}
                {{--</dl>--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>手机号码</dt>--}}
                    {{--<dd>{{ $order_detail['order_mobile'] }}--}}
                    {{--</dd>--}}
                {{--</dl>--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>收货地址</dt>--}}
                    {{--<dd>{{ $order_detail['order_address'] }}</dd>--}}
                {{--</dl>--}}
                {{--@endif--}}
            {{--@elseif($order_detail['order_type'] == \App\Models\Order::ORDERGIFT)--}}
                {{--<dl class="dl-horizontal">--}}
                {{--<dt>收货方式</dt>--}}
                {{--@if(isset($order_detail['gift']) && !is_null($order_detail['gift']))--}}
                    {{--@if(isset($order_detail['gift']['shipping_type']))--}}
                        {{--<dd>--}}
                        {{--@if(array_key_exists((string)$order_detail['gift']['shipping_type'], \App\Models\OrderGift::SHIPPING_TYPE))--}}
                            {{--{{\App\Models\OrderGift::SHIPPING_TYPE[(string)$order_detail['gift']['shipping_type']]}}--}}
                        {{--@endif--}}
                        {{--</dd>--}}
                        {{--</dl>--}}
                        {{--@if( $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_SELF)--}}
                            {{--@foreach($seller_order as $seller)--}}
                            {{--<dl class="dl-horizontal">--}}
                                {{--<dt>自提地址</dt>--}}
                                {{--<dd>{{ $seller['seller']['delivery_address'] }}</dd>--}}
                            {{--</dl>--}}
                            {{--<dl class="dl-horizontal">--}}
                                {{--<dt>联系电话</dt>--}}
                                {{--<dd>{{ $seller['seller']['delivery'] }}</dd>--}}
                            {{--</dl>--}}
                            {{--@endforeach--}}
                            {{--@if(!is_null($order_detail['gift']['remark']))--}}
                            {{--<dl class="dl-horizontal">--}}
                                {{--<dt>其他备注</dt>--}}
                                {{--<dd>{{ $order_detail['gift']['remark'] }}</dd>--}}
                            {{--</dl>--}}
                            {{--@endif--}}
                        {{--@elseif( $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_EXPRESS || $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_SEND)--}}
                            {{--<dl class="dl-horizontal">--}}
                                {{--<dt>收货人</dt>--}}
                                {{--<dd>{{ $order_detail['address_name'] }}</dd>--}}
                            {{--</dl>--}}
                            {{--<dl class="dl-horizontal">--}}
                                {{--<dt>手机号码</dt>--}}
                                {{--<dd>{{ $order_detail['order_mobile'] }}--}}
                                {{--</dd>--}}
                            {{--</dl>--}}
                            {{--<dl class="dl-horizontal">--}}
                                {{--<dt>收货地址</dt>--}}
                                {{--<dd>{{ $order_detail['order_address'] }}</dd>--}}
                            {{--</dl>--}}
                            {{--@if(!is_null($order_detail['gift']['remark']))--}}
                            {{--<dl class="dl-horizontal">--}}
                                {{--<dt>其他备注</dt>--}}
                                {{--<dd>{{ $order_detail['gift']['remark'] }}</dd>--}}
                            {{--</dl>--}}
                            {{--@endif--}}
                        {{--@else--}}
                        {{--<dl class="dl-horizontal">--}}
                            {{--<dt>其他备注</dt>--}}
                            {{--<dd>{{ $order_detail['gift']['remark'] }}</dd>--}}
                        {{--</dl>--}}
                        {{--@endif--}}
                        {{--@if($order_detail['order_status'] === config('WAIT_BUYER_CONFIRM_GOODS'))--}}
                        {{--<form class="form-horizontal form-confirm" onsubmit="return false;">--}}
                            {{--<input type="hidden" name="uid" value="{{$order_detail['user_id']}}">--}}
                            {{--<div class="form-group">--}}
                                {{--<div class="col-sm-offset-1 col-sm-12">--}}
                                  {{--<button type="submit" class="btn btn-primary" onclick="save_event_listener('confirm')">确认收货</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                        {{--@endif--}}
                    {{--@endif--}}
                    {{--@endif--}}
                {{--@endif--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}
    {{-- 收货结束 --}}

    {{-- 物流开始 --}}
    {{--<div role="tabpanel" class="tab-pane fade" id="delivery">--}}
        {{--<div class="content-wrap">--}}
            {{--@if($order_detail['order_type'] != \App\Models\Order::ORDERGIFT)--}}
                {{--@if($order_detail['order_status'] === config('WAIT_SELLER_SEND_GOODS'))--}}
                {{--<form class="form-horizontal form-delivery" onsubmit="return false;">--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="inputDeliveryName" class="col-sm-2 control-label"><i class="text-danger">*</i>物流名称</label>--}}
                        {{--<div class="col-sm-10">--}}
                          {{--<input type="text" class="form-control" id="inputDeliveryName" placeholder="物流名称" name="name" required>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="inputDeliveryNum" class="col-sm-2 control-label"><i class="text-danger">*</i>发货单号</label>--}}
                        {{--<div class="col-sm-10">--}}
                          {{--<input type="text" class="form-control" id="inputDeliveryNum" placeholder="发货单号" name="num" required>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<div class="col-sm-2 control-label"></div>--}}
                        {{--<div class="col-sm-10">--}}
                          {{--<button type="submit" class="btn btn-primary" onclick="save_event_listener('delivery')">保存</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</form>--}}
                {{--@else--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>物流名称</dt>--}}
                    {{--<dd>--}}
                        {{--{{$order_detail['delivery']['express_name'] ?? ''}}--}}
                    {{--</dd>--}}
                {{--</dl>--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>发货单号</dt>--}}
                    {{--<dd>--}}
                        {{--{{$order_detail['delivery']['delivery_num'] ?? ''}}--}}
                    {{--</dd>--}}
                {{--</dl>--}}
                {{--@endif--}}
            {{--@else--}}
                {{--@if(isset($order_detail['gift']) && !is_null($order_detail['gift']))--}}
                    {{--@if($order_detail['order_status'] == config('WAIT_SELLER_SEND_GOODS'))--}}
                    {{--<div class="alert alert-warning" role="alert">--}}
                        {{--礼品订单出库管理由业务系统控制--}}
                    {{--</div>--}}
                    {{--@else--}}
                        {{--@if(isset($order_detail['gift']['shipping_type']))--}}
                            {{--@if( $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_SELF)--}}
                                {{--<dl class="dl-horizontal">--}}
                                    {{--<dt>取件人</dt>--}}
                                    {{--<dd>{{ $order_detail['user']['user_name'] }}</dd>--}}
                                {{--</dl>--}}
                                {{--<dl class="dl-horizontal">--}}
                                    {{--<dt>联系电话</dt>--}}
                                    {{--<dd>{{ $order_detail['user']['user_mobile'] }}</dd>--}}
                                {{--</dl>--}}
                            {{--@elseif( $order_detail['gift']['shipping_type'] == \App\Models\OrderGift::SHIPPING_TYPE_EXPRESS)--}}
                                {{--<dl class="dl-horizontal">--}}
                                    {{--<dt>物流名称</dt>--}}
                                    {{--<dd>--}}
                                        {{--{{$order_detail['delivery']['express_name'] ?? ''}}--}}
                                    {{--</dd>--}}
                                {{--</dl>--}}
                                {{--<dl class="dl-horizontal">--}}
                                    {{--<dt>发货单号</dt>--}}
                                    {{--<dd>--}}
                                        {{--{{$order_detail['delivery']['delivery_num'] ?? ''}}--}}
                                    {{--</dd>--}}
                                {{--</dl>--}}
                            {{--@else--}}
                            {{--@endif--}}
                        {{--@endif--}}
                    {{--@endif--}}

                {{--@endif--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}
    {{-- 物流结束 --}}

    {{-- 退款开始 --}}
    {{--<div role="tabpanel" class="tab-pane fade" id="refund">--}}
        {{--<div class="content-wrap">--}}
            {{--@if(!is_null($order_detail['refund']))--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>退款类型</dt>--}}
                    {{--<dd>--}}
                        {{--@if(array_key_exists($order_detail['refund']['refund_type'], \App\Models\OrderRefund::REFUND_TYPE))--}}
                            {{--{{\App\Models\OrderRefund::REFUND_TYPE[$order_detail['refund']['refund_type']]}}--}}
                        {{--@endif--}}
                    {{--</dd>--}}
                {{--</dl>--}}
                {{--@if(!is_null($order_detail['refund']['reason']))--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>退款原因</dt>--}}
                    {{--<dd>{{ $order_detail['refund']['reason']['msg'] }}</dd>--}}
                {{--</dl>--}}
                {{--@endif--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>申请理由</dt>--}}
                    {{--<dd>{{ $order_detail['refund']['demand_reason'] }}</dd>--}}
                {{--</dl>--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>申请金额</dt>--}}
                    {{--<dd>￥{{ $order_detail['refund']['demand_money'] }}</dd>--}}
                {{--</dl>--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>申请时间</dt>--}}
                    {{--<dd>{{ $order_detail['refund']['demand_time'] }}</dd>--}}
                {{--</dl>--}}
                {{--@if(($order_detail['refund']['is_refund'] == \App\Models\OrderRefund::REFUND_STATUS_APPLY))--}}
                    {{--<form class="form-horizontal form-refund" onsubmit="return false;">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="inputDeliveryNum" class="col-sm-2 control-label">--}}
                                {{--<i class="text-danger">*</i>--}}
                                {{--<span>处理退款</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<label class="radio-inline">--}}
                                    {{--<input type="radio" id="inlineRadio1" name="type" onchange="set_refund_require_style()" value="1" required> 同意--}}
                                {{--</label>--}}
                                {{--<label class="radio-inline">--}}
                                    {{--<input type="radio" id="inlineRadio2" name="type" onchange="set_refund_require_style()" value="2" required> 驳回--}}
                                {{--</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="inputDeliveryNum" class="col-sm-2 control-label">--}}
                                {{--<span>退款金额</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-10">--}}
                              {{--<input type="number" class="form-control" id="inputDeliveryNum" placeholder="退款金额，同意退款时必填" name="money">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="inputDeliveryNum" class="col-sm-2 control-label">--}}
                                {{--<span>答复内容</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-10">--}}
                              {{--<input type="text" class="form-control" id="inputDeliveryNum" placeholder="答复内容，驳回退款时必填" name="reply">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<div class="col-sm-2 control-label"></div>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<button type="submit" class="btn btn-primary" onclick="save_event_listener('refund')">保存</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--@else--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>处理状态</dt>--}}
                    {{--<dd>--}}
                        {{--@if(array_key_exists($order_detail['refund']['is_refund'], \App\Models\OrderRefund::REFUND_STATUS))--}}
                            {{--{{\App\Models\OrderRefund::REFUND_STATUS[$order_detail['refund']['is_refund']]}}--}}
                        {{--@endif--}}
                    {{--</dd>--}}
                {{--</dl>--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>退款金额</dt>--}}
                    {{--<dd>{{ $order_detail['refund']['refund_money'] }}</dd>--}}
                {{--</dl>--}}
                {{--<dl class="dl-horizontal">--}}
                    {{--<dt>答复内容</dt>--}}
                    {{--<dd>{{ $order_detail['refund']['action_reason'] }}</dd>--}}
                {{--</dl>--}}
                {{--@endif--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}
    {{-- 退款结束 --}}

{{-- tab结束 --}}
</div>
