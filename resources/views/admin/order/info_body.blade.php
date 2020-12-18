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

    @if($data['show_delivery'])
        <li role="presentation">
            <a href="#delivery" aria-controls="delivery" role="tab" data-toggle="tab">配送信息</a>
        </li>
    @endif

    <li role="presentation">
        <a href="#refund" aria-controls="refund" role="tab" data-toggle="tab">退款信息</a>
    </li>

</ul>

<div class="tab-content">
    {{-- 基本信息开始 --}}
    <div role="tabpanel" class="tab-pane fade in active" id="home">
        <div class="content-wrap">
            <div class="div-out-height">
                <div class="out_scoll">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>商品id</th>
                            <th class="product_thumb">商品图片</th>
                            <th class="product_name">商品名称</th>
                            <th>SKU</th>
                            <th>数量</th>
                            <th>单价</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data['product'] as $value)
                            <tr>
                                <td>{{ $value['product_id'] ?? '' }}</td>
                                <td class="product_thumb">
                                    <img src="{{ $value['sku_media'] ?? '' }}">
                                </td>
                                <td>{{ $value['product_name'] ?? '' }}</td>
                                <td>{{ $value['sku'] ?? '' }}</td>
                                <td>{{ $value['number'] }}</td>
                                <td>¥{{ $value['product_price'] }}</td>
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
            @if (!empty($data['pay_log']))
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
    <div role="tabpanel" class="tab-pane fade" id="receive">
        <div class="content-wrap">
            <form class="form-horizontal form-receiver" onsubmit="return false;">
                <div class="form-group">
                    <label for="inputReceiver" class="col-sm-2 control-label"><i class="text-danger">*</i>收货人</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputReceiver" placeholder="收货人" name="name"
                               value="{{ $data['shipping_address']['name'] }}" required
                               @if($data['order_status_num'] != \App\Models\OrderBase::ORDER_STATUS_WAIT_DELIVERY) disabled @endif>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputReceiveMobile" class="col-sm-2 control-label"><i
                                class="text-danger">*</i>手机号码</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputReceiveMobile" placeholder="手机号码" name="mobile"
                               value="{{ $data['shipping_address']['mobile'] }}" required
                               @if($data['order_status_num'] != \App\Models\OrderBase::ORDER_STATUS_WAIT_DELIVERY) disabled @endif>
                    </div>
                </div>

                @if($data['order_status_num'] != \App\Models\OrderBase::ORDER_STATUS_WAIT_DELIVERY)
                    <div class="form-group">
                        <label for="inputReceiveAddress" class="col-sm-2 control-label"><i
                                    class="text-danger">*</i>详细地址</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputReceiveAddress" placeholder="收货地址"
                                   value="{{ $data['shipping_address']['address'] }}" required disabled>
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <label class="control-label col-sm-2">收货地址</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <select name="input_province" id="input_province" class="form-control">
                                    <option value="">--请选择--</option>
                                    @foreach($data['province_data'] as $key => $value)
                                        <option value="{{ $key }}" @if($key == $data['shipping_address']['region_pid']) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="input_city" id="input_city" class="form-control">
                                    <option value="">--请选择--</option>
                                    @foreach($data['city_data'] as $key => $value)
                                        <option value="{{ $key }}" @if($key == $data['shipping_address']['region_cid']) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="input_area" id="input_area" class="form-control">
                                    <option value="">--请选择--</option>
                                    @foreach($data['area_data'] as $key => $value)
                                        <option value="{{ $key }}" @if($key == $data['shipping_address']['region_aid']) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputReceiveAddress" class="col-sm-2 control-label"><i
                                    class="text-danger">*</i>详细地址</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputReceiveAddress" placeholder="收货地址"
                                   name="address_detail" value="{{ $data['shipping_address']['address_detail'] }}" required>
                        </div>
                    </div>
                @endif
                @if($data['order_status_num'] == \App\Models\OrderBase::ORDER_STATUS_WAIT_DELIVERY)
                    <div class="form-group">
                        <div class="col-sm-2 control-label"></div>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" onclick="save_event_listener('receiver')">保存
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
    {{-- 收货结束 --}}

    {{-- 物流开始 --}}
    <div role="tabpanel" class="tab-pane fade" id="delivery">
        <div class="content-wrap">
            <form class="form-horizontal form-delivery" onsubmit="return false;">
                <div class="div-out-height">
                    <div class="out_scoll">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>商品id</th>
                                <th class="product_thumb">商品图片</th>
                                <th class="product_name">商品名称</th>
                                <th>SKU</th>
                                <th>发货单号</th>
                                <th>物流状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data['product'] as $value)
                                <tr>
                                    <td>
                                        @if(!isset($value['delino']))
                                            <input name="order_child_ids" value="{{ $value['id'] }}" checked="true"
                                                   type="checkbox" style="margin:0 8px;">
                                        @endif
                                        <span>{{ $value['product_id'] ?? '' }}</span>
                                    </td>
                                    <td class="product_thumb">
                                        <img src="{{ $value['sku_media'] ?? '' }}">
                                    </td>
                                    <td>{{ $value['product_name'] ?? '' }}</td>
                                    <td>{{ $value['sku'] ?? '' }}</td>
                                    <td>{{ $value['delino'] ?? '' }}</td>
                                    <td>{{ $value['status'] ?? '' }}</td>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($data['show_delivery_save'])
                    <div class="form-group delivery_show">
                        <label for="inputDeliveryNum" class="col-sm-2 control-label">
                            <i class="text-danger">*</i>发货单号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputDeliveryNum" placeholder="发货单号"
                                   name="delino" required>
                        </div>
                    </div>
                    <div class="form-group delivery_show">
                        <div class="col-sm-2 control-label"></div>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" onclick="save_event_listener('delivery')">
                                保存
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
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
