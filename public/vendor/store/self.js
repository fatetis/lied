$(function () {
    const selectObj = {'opacity':1, 'display':'block'};//选择框div样式show
    //添加规格值事件
    $(document).on('click', '.self-sku-add', function () {
        let that = $(this);
        let pid = that.parents('.self_sku_additem').find('.antd-pro-pages-goods-widget-styles-sku_group_title .ant-select-search__field').next().val();//获取父级pid的value值
        let prevVal = that.prev().find('.ant-select-search__field').next().val();//input框value值
        let skuHtml = $('.prehtml .self_sku_item').clone();//模板库克隆
        if(pid == ''){
            toastr.error('请先添加规格名');
            return false;
        }
        if(prevVal == ''){
            toastr.error('请先选择上一个规格值');
            return false;
        }

        skuHtml.find('.ant-select-search__field').attr('data-child',1)
        that.before(skuHtml)

        if($('.self_style_control').hasClass('ant-checkbox-checked')){
            let picClone = $('.prehtml .self_pic_clone').clone();
            let self_sku = $('.self_style_control').parents('.self_sku_additem').find('.self_sku_item');
            // console.log(self_sku.length);
            for(let i = 0; i < self_sku.length; i++){
                if(self_sku.eq(i).find('.self_pic_clone').length <= 0){
                    self_sku.eq(i).append(picClone);
                }
            }
        }
        assignmentUploadImg();

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
        if(addHtmlObj.length > 4){
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
        let thatInlineInput = thatInline.find('.ant-select-search__field'); //该选择框下的input元素
        let sku = false; // 父级元素还是子元素，true为父级 false为子级
        if(thatInlineInput.val() == ''){
            thatInline.css('display','block').prev().css({'display':'block', 'opacity':'0.4'}) //改变状态显示
        }else{
            thatInline.css('display','block').prev().css({'display':'none', 'opacity':'0.4'}) //改变状态显示
        }
        if(thatInlineInput.data('child') != 1){
            //父级元素值改变，子元素select框移除
            let childObj = that.parents('.self_sku_additem').find('.self_sku .ant-select');
            sku = true;
            if(childObj.length > 0){
                for(let i = 0; i < childObj.length;  i++){
                    let childObjId = childObj.eq(i).data('select-obj');
                    if(childObjId != undefined){
                        $('#'+childObjId).remove();
                    }
                }
                that.parents('.self_sku_additem').find('.self_sku .self_sku_item').remove();
            }

            let liobject = selectHtml.find('li');
            checkLiStatus(liobject, thatInlineInput, sku, true)
        }else{
            checkLiStatus(thatObjData, thatInlineInput)
        }


        //检测该元素是否存在option选项
        if(thatObjData != undefined){
            selectShow(thatObjData,top,thatHeight,left,thatWidth)
            return false;
        }

        that.attr('data-select-obj',key).addClass(key);
        selectHtml.attr('id',key)
        //子选择框重新获取li数据
        if(thatInlineInput.data('child') == 1){
            let pid = thatInlineInput.parents('.self_sku_additem').find('.antd-pro-pages-goods-widget-styles-sku_group_title .ant-select-search__field').next().val();//获取父级pid的value值
            let ulObj = selectHtml.find('.ant-select-dropdown-menu') //ul选择器
            let liObj  = ulObj.find('li');
            liObj.remove();
            $.post(thatInlineInput.data('url'),
                {pid:pid},
                function (d) {
                    let data = JSON.parse(d.data)
                    // 获取所有的规格value值
                    let attrValueObj = $('.self_sku_container .self_attr_value');
                    let attrValueArray = [];
                    for(let i = 0; i < attrValueObj.length;  i++){
                        let attrValue = attrValueObj.eq(i).val();
                        if(attrValue != ''){
                            attrValueArray[i] = attrValue;
                        }
                    }
                    if(data.length <= 0){
                        ulObj.append(`<li role="option" class="ant-select-dropdown-menu-item ant-select-dropdown-menu-item-disabled self-nothingAttrValue"><span style="color: rgba(0,0,0,.65)">暂无规格值</span></li>`);
                    }else{
                        createOptionByLiArray(ulObj,data,attrValueArray)
                    }
                })
        }
        // console.log(selectHtml.find('.ant-select-dropdown-menu li').length)
        $(document.body).append(selectHtml);
        selectShow(key,top,thatHeight,left,thatWidth)

    })

    let checkLiStatus = (thatObjData,thatInlineInput,sku = false, object = false) => {
        //改变li状态：不可选、选中、可选start
        let attrValueObj = sku ? $('.self_sku_container .self_attr') : $('.self_sku_container .self_attr_value');
        let attrValueArray = [];
        let liObj = object ? thatObjData : $('#'+thatObjData).find('li');
        for(let i = 0; i < attrValueObj.length;  i++){
            let attrValue = attrValueObj.eq(i).val();
            if(attrValue != ''){
                attrValueArray[i] = attrValue;
            }
        }
        if(attrValueArray.length > 0){
            liObj.each(function () {
                let liKey = $(this).data('key');
                if(attrValueArray.indexOf(String(liKey)) >= 0 ){
                    $(this).removeClass('ant-select-dropdown-menu-item-active').addClass('ant-select-dropdown-menu-item-disabled')
                }else{
                    $(this).removeClass('ant-select-dropdown-menu-item-disabled')
                }
                if(liKey == thatInlineInput.next().val()){
                    $(this).removeClass('ant-select-dropdown-menu-item-disabled').addClass('ant-select-dropdown-menu-item-active')
                }
            })
        }
        //改变li状态：不可选、选中、可选end
    }

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
                .find('.ant-select-search__field')
                .val('')
                .next()//隐藏框obj
                .val(key);
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
        let createUrl = that.data('create-url');
        let prevObj = that.parents('.ant-select-search--inline').prev();
        let liId = that.parents('.ant-select').data('select-obj');
        let ulObj = $('#'+liId).find('.ant-select-dropdown-menu');//选择框ul元素
        let liObj = ulObj.find('li');//选择框li元素
        let createObj = $('.self-createProAttr');//生成的obj元素
        let obj = $('#'+liId).find('.ant-select-dropdown')
        let data = {key:val};
        let child = 0;
        let pid = 0;
        if(val == ''){
            prevObj.css(selectObj);
            liObj.css('display', 'block');
            if(createObj.length > 0){
                createObj.remove()
            }
            return false;
        }
        if(that.data('child') == 1){
            data.pid = that.parents('.self_sku_additem').find('.antd-pro-pages-goods-widget-styles-sku_group_title .ant-select-search__field').next().val();//获取父级pid的value值
            pid = data.pid;
            child = 1;
        }
        prevObj.css('display','none');
        $.post(url,
            data,
            function(d){
                let data = JSON.parse(d.data)
                liObj.css('display', 'none');
                if(data.length <= 0){
                    createObj.remove();
                    ulObj.append(`<div role="option" class="ant-select-dropdown-menu-item self-createProAttr self-createProAttr-click" data-create-url="${createUrl}" data-child="${child}" data-pid="${pid}"><span style="color: #00a7d0">点击创建</span>:&nbsp&nbsp<i>${val}</i></div>`);
                }else{
                    createOptionByLiArray(ulObj,data)
                }
            })
    }

    //input框改变500ms后触发函数
    $(document).on('input', '.ant-select-search--inline .ant-select-search__field', debounce(optionChangeFuc, 500))

    //点击创建按钮触发点击事件
    $(document).on('click', '.self-createProAttr-click', function () {
        let that = $(this);
        let text = that.find('i').text();
        let url = that.data('create-url');
        let ulObj = that.parents('.ant-select-dropdown-menu');//选择框ul元素
        let data = {key:text};
        if(that.data('child') == 1){
            data.pid = that.data('pid');
        }
        $.post(url,
            data,
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
    let createOptionByLiArray = (ulObj,data,dataed = []) => {
        let unclickClassName = '';
        data.forEach((item, index) => {
            if(ulObj.find(`.self-optionid-${item['id']}`).length <= 0){
                //改变li为不可选状态
                if(dataed.length > 0 && dataed.indexOf(String(item['id'])) >= 0){
                    unclickClassName = 'ant-select-dropdown-menu-item-disabled';
                }
                ulObj.prepend(`<li role="option" class="ant-select-dropdown-menu-item self-optionid-${item['id']} ${unclickClassName}" data-key="${item['id']}">${item['name']}</li>`)
            }else{
                ulObj.find(`.self-optionid-${item['id']}`).css('display','block')
            }
        })
    }

    //插入数据到选择框option里--data为对象
    let createOptionByLiObject = (ulObj,data) => {
        $('.self-createProAttr').remove();
        $('.self-nothingAttrValue').remove();
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
    
    $(document).on('click', '.self_sku_picture', function () {

        let picClone = $('.prehtml .self_pic_clone').clone();
        let skuObj = $(this).parents('.self_sku_additem');
        let that = $(this);
        let thatPic = that.find('.self_style_control');
        if(thatPic.hasClass('ant-checkbox-checked')){
            thatPic.removeClass('ant-checkbox-checked');
            that.parents('.self_sku_additem').find('.self_pic_clone').remove();
            return false;
        }
        if(that.parents('.self_sku_additem').find('.self_pic_clone').length > 0){
            return false;
        }
        thatPic.addClass('ant-checkbox-checked'); //添加选中样式
        skuObj.find('.self_sku_item').append(picClone);
        assignmentUploadImg();
    })

    //给每个skuimg加上图片plupload事件
    function assignmentUploadImg(){
        let eachObj  = $('.self_sku_item .self_pic_clone');
        for(let i = 0; i < eachObj.length; i++){
            let idObj = eachObj.eq(i).attr('id')
            if(idObj == undefined){
                eachObj.eq(i).attr('id', i).find('.self_upload').attr('id', i+'_browse');
                init_upload(i)
            }
        }
    }

    // 图片上传
    function init_upload(idObj)
    {
        let container = document.getElementById(idObj);
        let _token = $('input[name=_token]').val();
        let date = $('input[name=_date]').val();
        let upload_url = 'images/sku/'+date;
        //实例化一个plupload上传对象
        var uploader = new plupload.Uploader({
            runtimes: 'html5,flash,silverlight,html4',
            browse_button: idObj+'_browse', //触发文件选择对话框的按钮，为那个元素id
            url: '/admin/upload/image', //服务器端的上传页面地址
            flash_swf_url: '/vendor/laravel-admin-ext/sk-image/plupload/Moxie.swf', //swf文件，当需要使用swf方式进行上传时需要配置该参数
            silverlight_xap_url: '/vendor/laravel-admin-ext/sk-image/plupload/Moxie.xap', //silverlight文件，当需要使用silverlight方式进行上传时需要配置该参数
            unique_names: true,
            container: container,
            multi_selection: false,//false单选，true多选
            multipart_params: {'_token': _token, 'upload_url': upload_url},
            filters: {
                max_file_size: '10mb',     //单文件最大size
                mime_types: [
                    {title: "Image files", extensions: "jpg,jpeg,png"}
                ]
            },
            init: {
                FilesAdded: function (up, file) {
                    uploader.start();//选择文件后立即上传
                },
                BeforeUpload: function (up, file) {
                    $('#' + idObj).addClass(file.id).find('.anticon-delete').attr('data-id', file.id);
                },
                UploadProgress: function (up, file) {
                    let idObject = $('.' + file.id);
                    idObject.find('.self_upload').hide();
                    idObject.find('.self_uploading').show().find('span').text(file.percent + '%');
                },
                FileUploaded: function (up, file, info) {
                    let idObject = $('.' + file.id);
                    let mainObject = idObject.find('.self_uploaded');
                    if (200 != info.status) {
                        toastr.error('抱歉！出错了1');
                        return false;
                    }
                    var result = eval("(" + info.response + ")");
                    if (true == result.uploaded) {
                        var file_id = result.url;
                        var src = result.src;
                    } else {
                        toastr.error('抱歉！出错了1' + result.msg);
                        return false;
                    }
                    idObject.find('.self_uploading').hide();
                    mainObject.show();
                    // a标签href属性及img标签src属性替换url路径
                    mainObject.find('.ant-upload-list-item-info a').attr('href', src).find('img').attr({
                        'src': src,
                        'alt': '加载失败'
                    });
                    mainObject.find('.ant-upload-list-item-actions a').attr('href', src);
                },
                Error: function (up, err) {
                    toastr.error('ERROR');
                }
            }
        });
        //在实例对象上调用init()方法进行初始化
        uploader.init();
    }

    $('.anticon-delete').on('click', function () {
        let that = $(this);
        let idObject = $('.' + that.data('id'));
        idObject.find('.self_uploaded').hide();
        idObject.find('.self_upload').show();
    })

})
