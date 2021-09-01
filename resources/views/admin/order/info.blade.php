<div class="modal fade" id="orderInfoModal" tabindex="-1" role="dialog" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">订单详情</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <p id="status_show_wrap">数据查询中...</p>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button> --}}
      </div>
    </div>
  </div>
</div>
<style>
  #orderInfoModal .modal-dialog {
    width: 1480px !important;
    position: absolute;
    left: 50%;
    top: 48%;
    transform: translate(-50%, -50%);
  }

  #orderInfoModal .nav {
    border: none !important;
  }

  #orderInfoModal .nav li {
    margin-right: 10px;
  }

  #orderInfoModal .nav .active a {
    color: white !important;
    border: none !important;
    background-color: #3c8dbc !important;
    border-radius: 5px !important;
  }

  #orderInfoModal .nav a,
  #orderInfoModal .nav a:hover,
  #orderInfoModal .nav .active a:active {
    border-radius: 5px !important;
  }

  #orderInfoModal .tab-pane {
    margin-top: 20px;
    margin-bottom: 20px;
  }

  #orderInfoModal .alert-warning {
    color: #8a6d3b !important;
    background-color: #fcf8e3 !important;
  }

  #orderInfoModal .content-wrap {
    margin-left: 20px;
  }

  #orderInfoModal .dl-horizontal dt {
    width: 80px;
    text-align: left;
  }

  #orderInfoModal .dl-horizontal dd {
    margin-left: 100px;
  }

  #orderInfoModal .control-label {
    width: 100px;
    text-align: left;
  }

  #orderInfoModal input[type="number"] {
    -moz-appearance: textfield;
  }

  #orderInfoModal #home .product_thumb {
    width: 120px;
  }

  #orderInfoModal #home .product_name {
    width: 240px;
  }

  #orderInfoModal #home img {
    width: 120px;
    height: 120px;
  }

  #orderInfoModal #delivery img {
    width: 120px;
    height: 120px;
  }

  #orderInfoModal #home table th,
  #orderInfoModal #home table td {
    text-align: center !important;
    padding: 8px !important;
    vertical-align: middle;
    width: 120px !important;
    word-break: break-word;
  }

  #orderInfoModal  table tbody {
    display: block;
    max-height: 380px;
    overflow-y: scroll;
  }

  /* #orderInfoModal #home table tbody, */
  #orderInfoModal #home .div-out-height,
  #orderInfoModal #home .out_scoll {
    scrollbar-width: none;
  }

  /* #orderInfoModal #home table tbody::-webkit-scrollbar, */
  #orderInfoModal #home .div-out-height::-webkit-scrollbar,
  #orderInfoModal #home .out_scoll::-webkit-scrollbar {
    display: none;
  }

  #orderInfoModal  table thead,
  #orderInfoModal  table tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
  }

  #orderInfoModal  table thead {
    width: calc(100% - 1em);
  }

  #orderInfoModal  .div-out-height {
    border: none;
    border-radius: 3px;
    background-color: #fff;
    position: relative;
    overflow: hidden;
    height: calc(100% - 65px);
  }

  #orderInfoModal #home .false_table {
    width: 100%;
    float: left;
  }

  #orderInfoModal #home .false_table table {
    margin: 0;
    width: calc(100% - 19px);
  }

  #orderInfoModal #home .out_scoll {
    overflow: scroll;
    overflow-x: hidden;
    clear: both;
    max-height: calc(100% - 150px);
  }

  #orderInfoModal .form-receiver label i,
  #orderInfoModal .form-refund label i {
    position: absolute;
    margin-left: -7px;
    line-height: 27px;
  }

  #orderInfoModal #status_show_wrap span{
    font-size: 14px;
    float: left;
    margin-left: 1px;
    line-height: 34px;
  }
</style>
<script>
  $.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    var $radio = $('input[type=radio],input[type=checkbox]',this);
    $.each($radio,function(){
        if(!o.hasOwnProperty(this.name)){
            o[this.name] = '';
        }
    });
    return o;
  };
  var modal = $('#orderInfoModal');
  var oid;
  var modal_force_close;
  modal.on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    oid = button.data('oid');
    get_order_info();
  });

  modal.on('hidden.bs.modal', function (e) {
    modal.find('.modal-body').empty();
  });

  function save_event_listener(name)
  {
    if (typeof name === 'undefined') {
      throw new Error('param name is undefined!');
    }
    let form = $('.form-' + name);
    let check = form_check(form);
    if (check === false) {
      return false;
    }
    let url = '';
    switch(name) {
      case 'receiver':
        url = '{{route("admin.api.order.address.update",["_token"=>csrf_token()])}}';
        break;
      case 'delivery':
        url = '{{route("admin.api.order.delivery", ["_token"=>csrf_token()])}}';
        break;
      case 'refund':
        {{--url = '{{route("admin_deal_order_refund",["_token"=>csrf_token()])}}';--}}
        break;
      case 'pay':
        url = '{{route("admin.api.order.price.update", ["_token" => csrf_token()])}}';
        break;
    }
    let title = name == 'confirm' ? '收货' : '提交';
    swal({
      title: '确认' + title + '?',
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#1087dd",
      confirmButtonText: "确认",
      cancelButtonText: "取消"
    }).then(function(result) {
      if (result.value) {
        let orderno = modal.find('#detail-content-wrap').data('id');
        check.orderno = orderno;
        ajax_handler(url, check);
      }
    });
  }

  function get_order_info() {
    $.ajax({
      method: 'get',
      url: '{{route("admin.api.order",["_token" => csrf_token()])}}',
      data: {
        orderno: oid
      },
      beforeSend: function () {
        show_status('数据查询中...');
      },
      success: function (dt) {
        if (dt.status && dt.status === 'success') {
          modal.find('.modal-body').empty().html(dt.data);
          show_status('');
        } else {
          show_status('数据查询失败', 'error');
        }
      },
      error: function () {
        show_status('数据查询失败', 'error');
      }
    });
  }

  function ajax_handler(url, data)
  {
    $.ajax({
      method: 'post',
      url: url,
      data: data,
      beforeSend: function () {
        show_save_load();
      },
      success: function (dt) {
        if (dt.status && dt.status === 'success') {
          modal_force_close = {
            status: 'success',
            message: dt.message
          };
        } else {
            modal_force_close = {
            status: 'error',
            message: dt.message
          };
        }
      },
      error: function (dt) {
        modal_force_close = {
          status: 'error',
          message: dt.responseJSON.message
        };
      }
    });
  }

  function form_check(form)
  {
    let status = true;
    let arr = form.serializeObject();
    for (let i in arr) {
      let it = form.find('input[name="' + i + '"]');
      let str = it.parents('.form-group').find('label').eq(0).text();
      str = str.trim().replace('*', '').replace(/^\s+|\s+$/g, '');
      if (it && it.attr('required')) {
        if (arr[i] == '') {
          status = false;
          if (it.attr('type') == 'radio' || it.attr('type') == 'checkbox') {
            swal('请选择' + str, '', 'error');
          } else {
            swal('请填写' + str, '', 'error');
          }
          break;
        }
      }
    }
    if (status === false) {
      return status;
    }
    return arr;
  }

  function show_save_load()
  {
    stop_page_reload();
    let timerInterval
    Swal.fire({
      title: '服务器处理中，请勿刷新页面',
      timer: 15000,
      allowOutsideClick: false,
      padding: '30px',
      onBeforeOpen: () => {
        Swal.showLoading()
        timerInterval = setInterval(() => {
          if ( modal_force_close != null && typeof modal_force_close == 'object') {
            let res = modal_force_close;
            clearInterval(timerInterval);
            stop_page_reload(false);
            Swal.close();
            swal(res.message, '', res.status);
            if (res.status == 'success') {
                $.pjax.reload('#pjax-container');
              modal.modal('toggle');
            }
            modal_force_close = null;
          }
        }, 500)
      },
      onClose: () => {
        clearInterval(timerInterval);
        stop_page_reload(false);
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {
        swal('请求超时', '', 'error');
      }
    })
  }

  function stop_page_reload(is_close)
  {
    if (is_close === false) {
      window.onbeforeunload = null;
    } else {
      window.onbeforeunload = function(e) {
        var dialogText = 'Dialog text here';
        e.returnValue = dialogText;
        return dialogText;
      };
    }
  }

  function show_status(text, status) {
    let wrap = modal.find('#status_show_wrap');
    wrap.empty();
    let style = 'text-';
    if (typeof status == 'undefined') {
      status = 'info';
    }
    var arr = ['info', 'warning', 'error', 'success', 'primary'];
    if (arr.indexOf(status) === -1) {
      return false;
    }
    let cs = style + status;
    let sp = document.createElement('span');
    sp.classList = cs;
    sp.innerHTML = text;
    wrap.append(sp);
  }

  function set_refund_require_style()
  {
    let ele = $(event.target);
    let v = ele.val();
    let form = ele.parents('form');
    let html = '<i class="text-danger">*</i>';
    let ele_money = form.find('input[name="money"]');
    let ele_reply = form.find('input[name="reply"]');
    if (v == 1) {
      ele_money.attr('required', '').parents('.form-group').find('label').prepend(html);
      ele_reply.removeAttr('required').parents('.form-group').find('i').remove();
    } else if(v == 2) {
      ele_reply.attr('required', '').parents('.form-group').find('label').prepend(html);
      ele_money.removeAttr('required').parents('.form-group').find('i').remove();
    }
  }
</script>
<script>
    $(function () {
        var html = "";
        $("#input_city").append(html);
        $("#input_area").append(html);
        $(document).on('change', '#input_province', function () {
            let that = $(this);
            $.get(
                "{{ route('api.city', ['_token' => csrf_token()]) }}",
                {q: $('#input_province option:selected').val()},
                function (data) {
                    $("#input_city option").remove();
                    $("#input_area option").remove();
                    let html = "<option value=''>--请选择--</option>";
                    $("#input_city").append(html);
                    $("#input_area").append(html);
                    if (that.val() == "") return;

                    $.each(data, function (idx, item) {
                        html += "<option value='" + item.id + "'>" + item.text + "</option>";
                    });
                    $("#input_city option").remove();
                    $("#input_city").append(html);
                })
        });

        $(document).on('change', '#input_city', function () {
            let that = $(this);
            $.get(
                "{{ route('api.area', ['_token' => csrf_token()]) }}",
                {q: $('#input_city option:selected').val()},
                function (data) {
                    $("#input_area option").remove();
                    let html = "<option value=''>--请选择--</option>";
                    $("#input_area").append(html);
                    if (that.val() == "") return;

                    $.each(data, function (idx, item) {
                        html += "<option value='" + item.id + "'>" + item.text + "</option>";
                    });
                    $("#input_area option").remove();
                    $("#input_area").append(html);
                })
        });
    });
</script>
