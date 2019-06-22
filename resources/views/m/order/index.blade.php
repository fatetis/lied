
<script type="text/javascript" src="{{ URL::asset('https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js') }}"></script>
<input type="hidden" name="product_id" value="6">
<input type="hidden" name="attr_id" value="4">
<button id="sub">提交订单</button>
<script>
    $('#sub').on('click',function(){
        $.post({
            url:"{{ route('orderDeal',['_token'=>csrf_token()]) }}",
            data:{product_id:$("input[name=product_id]").val(),attr_id1:$("input[name=attr_id]").val(),brand_id:2,product_num:1,type:'mall'},
            function(d){
                console.log(d);
            }
        });
    });
</script>

