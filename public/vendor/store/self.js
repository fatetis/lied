$(function () {

    const selectObj = {'opacity':1, 'display':'block'};//选择框div样式show
    //添加规格值事件
    $(document).on('click', '.self-sku-add', function () {
        let skuHtmlObj = $('.prehtml .self_sku_item');
        let skuHtml = skuHtmlObj.clone();
        $(this).before(skuHtml)
    })

    //删除规格值事件
    $(document).on('click', '.self-sku-value-error', function () {
        $(this).parents('.self_sku_item').remove();
    })

    //添加规格事件
    $(document).on('click', '.self-sku-additem', function () {
        let skuAddHtmlObj = $(".prehtml .self_sku_additem");
        let addHtmlObj = $(".self_sku_additem");
        let skuAddHtml = skuAddHtmlObj.clone();
        if(addHtmlObj.length > 1){
            skuAddHtml.find(".self_sku_picture").eq(0).remove();
        }
        $(this).parent().before(skuAddHtml);
        // $('.self_sku_container .self_sku_picture').eq(0).remove();
        if(addHtmlObj.length > 5){
            $(this).attr({'disabled': ''})
        }
    })

    //删除规格事件
    $(document).on('click', '.self-sku-error', function () {
        $(this).parents('.self_sku_additem').remove();
        if($('.self_sku_additem').length <= 5){
            $('.self-sku-additem').removeAttr('disabled')
        }
    })

    //选择框下拉事件
    $(document).on('click', '.ant-select', function () {

        let selectHtmlObj = $('.prehtml .self_select_html');//模板文件外层class
        let selectHtml = selectHtmlObj.clone();
        let key = randKey();
        let that = $(this);
        let top = that.offset().top //距离浏览器上边距离
        let thatHeight = that.height(); //本身高度
        let left = that.offset().left //距离浏览器左边距离
        let thatWidth = that.width(); //本身宽度
        let thatObjData = that.data('select-obj'); //获取data-select-obj属性值
        let thatInline = that.find('.ant-select-search--inline'); //该选择框下的inline元素
        let thatInlineInput = thatInline.find('.ant-select-search__field'); //该选择框下的inline元素
        if(thatInlineInput.val() == ''){
            thatInline.css('display','block').prev().css({'display':'block', 'opacity':'0.4'}) //改变状态显示
        }else{
            thatInline.css('display','block').prev().css({'display':'none', 'opacity':'0.4'}) //改变状态显示
        }

        if(thatObjData != undefined){
            selectShow(thatObjData,top,thatHeight,left,thatWidth)
            return false;
        }

        that.attr('data-select-obj',key).addClass(key);
        selectHtml.attr('id',key)
        $(document.body).append(selectHtml);
        selectShow(key,top,thatHeight,left,thatWidth)


    })

    //除option元素外，点击其他元素触发点击事件
    $('div.wrapper *').not('.self_select_html').click(function () {
        $('.ant-select-dropdown').css('display','none')
        let createObj = $('.self-createProAttr');//生成的obj元素
        if(createObj.length > 0){
            createObj.remove()
        }
    })

    //选择框option离开事件
    $(document).on('mouseleave', '.self_select_html', function () {
        let that = $(this);
        that.find('.ant-select-dropdown').css('display','none')
        let selectClass = that.parents('.self_select_html').attr('id')
        $('.'+selectClass).find('.ant-select-selection-selected-value').css(selectObj)
    })

    //选择框option点击事件
    $(document).on('click', '.self_select_html li', function () {
        let that = $(this);
        let val = that.text().trim();
        let key = that.data('key');
        let selectClass = that.parents('.self_select_html').attr('id');
        if(!that.hasClass('ant-select-dropdown-menu-item-disabled')){
            $(this).addClass('ant-select-dropdown-menu-item-active').siblings().removeClass('ant-select-dropdown-menu-item-active');
            // select元素操纵
            $('.'+selectClass).find('.ant-select-selection-selected-value')
                .text(val)
                .css(selectObj)
                .next()
                .css('display','none')
                .find('input[type=hidden]') //隐藏框obj
                .val(key)
                .prev()
                .val('');
        }
    })

    $(document).on('blur', '.ant-select-search--inline .ant-select-search__field', function () {
        let that = $(this);
        let prevObj = that.parents('.ant-select-search--inline').prev();
        that.val('')
        prevObj.css(selectObj)
    })

    // input框触发函数
    function optionChangeFuc() {
        let that = $(this);
        let val = that.val();
        let url = that.data('url');
        let prevObj = that.parents('.ant-select-search--inline').prev();
        let liId = that.parents('.ant-select').data('select-obj');
        let ulObj = $('#'+liId).find('.ant-select-dropdown-menu');//选择框ul元素
        let liObj = ulObj.find('li');//选择框li元素
        let createObj = $('.self-createProAttr');//生成的obj元素
        let obj = $('#'+liId).find('.ant-select-dropdown')
        if(val == ''){
            prevObj.css({'display':'block', 'opacity':1});
            liObj.css('display', 'block');
            if(createObj.length > 0){
                createObj.remove()
            }
            return false;
        }
        prevObj.css('display','none');
        $.post(url,
            {key:val},
            function(d){
                let data = JSON.parse(d.data)
                liObj.css('display', 'none');
                if(data.length <= 0){
                    createObj.remove();
                    ulObj.append('<div role="option" class="ant-select-dropdown-menu-item self-createProAttr"><span style="color: #00a7d0">点击创建</span>:&nbsp&nbsp<i>'+val+'</i></div>');
                }else{
                    createOptionByLiArray(ulObj,data)
                }
            })
    }

    //input框改变一秒后触发函数
    $(document).on('input', '.ant-select-search--inline .ant-select-search__field', debounce(optionChangeFuc, 500))

    //点击创建按钮触发点击事件
    $(document).on('click', '.self-createProAttr', function () {
        let that = $(this);
        let text = that.find('i').text();
        let url = $('.createProAttrUrl').val()
        let ulObj = that.parents('.ant-select-dropdown-menu');//选择框ul元素
        $.post(url,
            {key:text},
            function (d) {
                let data = JSON.parse(d.data)
                createOptionByLiObject(ulObj,data)
            })
    })

    //随机生成字符串
    let randKey = (length = 32) => {
        if (length > 0) {
            var data = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
            var nums = "";
            for (var i = 0; i < length; i++) {
                var r = parseInt(Math.random() * 61);
                nums += data[r];
            }
            return nums;
        } else {
            return false;
        }
    }

    //唤起select-option选择框
    let selectShow = (obj,top,height,left,width) => {
        $('#'+obj).find('.ant-select-dropdown').css({'top': top+height+5, 'left': left, 'min-width': width, 'display': 'block'}).find('li').css('display','block');
    }

    //插入数据到选择框option里--data为元素
    let createOptionByLiArray = (ulObj,data) => {
        data.forEach((item, index) => {
            if($(`.self-optionid-${item['id']}`).length <= 0){
                ulObj.prepend(`<li role="option" class="ant-select-dropdown-menu-item self-optionid-${item['id']}" data-key="${item['id']}">${item['name']}</li>`)
            }else{
                $(`.self-optionid-${item['id']}`).css('display','block')
            }
        })
    }

    //插入数据到选择框option里--data为对象
    let createOptionByLiObject = (ulObj,data) => {
        $('.self-createProAttr').remove();
        for(var item in data){
                if($(`.self-optionid-${data['id']}`).length <= 0){
                    ulObj.prepend(`<li role="option" class="ant-select-dropdown-menu-item self-optionid-${data['id']}" data-key="${data['id']}">${data['name']}</li>`)
                }else{
                    $(`.self-optionid-${data['id']}`).css('display','block')
                }
        }
    }

    //防抖debounce代码：
    function debounce(fn,delay) {
        var timeout = null; // 创建一个标记用来存放定时器的返回值
        return function (e) {
            // 每当用户输入的时候把前一个 setTimeout clear 掉
            clearTimeout(timeout);
            // 然后又创建一个新的 setTimeout, 这样就能保证interval 间隔内如果时间持续触发，就不会执行 fn 函数
            timeout = setTimeout(() => {
                fn.apply(this, arguments);
            }, delay);
        };
    }


})
