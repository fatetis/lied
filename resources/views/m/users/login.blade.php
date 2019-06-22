
<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<input type="hidden" name="name" value="kuns">
<input type="hidden" name="password" value="abc123456">
<button id="sub">提交</button>
<script>
    $('#sub').on('click',function(){
        $.ajax({
            url:"{{ route('postLogin',['_token'=>csrf_token()]) }}",
            data:{name:$("input[name=name]").val(),password:$("input[name=password]").val()},
            type:'POST',
            success:function(d){
                console.log(d.msg)
                // console.log(JSON.parse(d.msg));
            },
            error:function(d){
                console.log(546);
            }
        });
    });
</script>

