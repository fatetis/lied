
<script type="text/javascript" src="{{ URL::asset('https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js') }}"></script>
<button id="sub">提交订单</button>
<script>
    $('#sub').on('click',function(){
        $.post({
            url:"{{ route('orderDealHigh',['_token'=>csrf_token()]) }}",
            data:{seckill:1},
            function(d){
                console.log(d);
            }
        });
    });
</script>

