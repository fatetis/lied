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
        addSkuDetail();
    })

    //添加规格事件
    $(document).on('click', '.self-sku-additem', function () {
        let skuAddHtmlObj = $(".prehtml .self_sku_additem");
        let addHtmlObj = $(".self_sku_additem");
        let skuAddHtml = skuAddHtmlObj.clone();
        if(addHtmlObj.length > 1){
            skuAddHtml.find(".self_sku_picture").eq(0).remove();
        }
        skuAddHtml.addClass('self_auto_sku_container');
        $(this).parent().before(skuAddHtml);
        // $('.self_sku_container .self_sku_picture').eq(0).remove();
        if(addHtmlObj.length > 2){
            $(this).attr({'disabled': ''})
        }
    })

    //删除规格事件
    $(document).on('click', '.self-sku-error', function () {
        $(this).parents('.self_sku_additem').remove();
        addSkuDetail();
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
                // 移除规格值select框
                // that.parents('.self_sku_additem').find('.self_sku .self_sku_item').remove();
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
        $(document.body).append(selectHtml);
        selectShow(key,top,thatHeight,left,thatWidth)

    })

    //改变li状态：不可选、选中、可选
    let checkLiStatus = (thatObjData,thatInlineInput,sku = false, object = false) => {
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
        let parentObj = $('.'+selectClass); //规格object
        let parentSkuObj = parentObj.find('.ant-select-search__field'); //规格名object
        let parentSkuChildVal = parentSkuObj.data('child');

        if(!that.hasClass('ant-select-dropdown-menu-item-disabled')){
            $(this).addClass('ant-select-dropdown-menu-item-active').siblings().removeClass('ant-select-dropdown-menu-item-active');
            // select元素操纵
            parentObj.find('.ant-select-selection-selected-value')
                .text(val)
                .css(selectObj)
                .next()
                .css('display','none')
                .find('.ant-select-search__field')
                .val('')
                .next()//隐藏框obj
                .val(key);
        }


        if(parentSkuChildVal == undefined){
            parentObj.parents('.self_sku_additem').find('.self_sku .self_sku_item').remove();
            return false;
        }

        addSkuDetail();
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
                    mainObject.find('.media_id').val(file_id);
                    addSkuDetail();
                },
                Error: function (up, err) {
                    toastr.error('ERROR');
                }
            }
        });
        //在实例对象上调用init()方法进行初始化
        uploader.init();
    }

    // sku缩略图删除
    $(document).on('click', '.anticon-delete', function () {
        let that = $(this);
        let idObject = $('.' + that.data('id'));
        idObject.find('.self_uploaded').hide();
        idObject.find('.self_upload').show();
    })

    // 将每个规格值都进行组合
    const addSkuDetail = () => {
        let skuDetailContainer = $('.self_sku_detail_container'); // 规格明细容器选择器object
        let skuDetailTheadTr = skuDetailContainer.find('.self_sku_detail_thead tr'); // 规格明细容器thead下的tr选择器object
        let skuDetailTbody = skuDetailContainer.find('.self_sku_detail_body'); // 规格明细容器thead下的tr选择器object
        let skuDetailTbodyTr = skuDetailTbody.find('.self_sku_detail_tr'); //页面tbody tr元素选择器

        let skuDeatailTheadStr = '';
        let skuDetailTbodyStr = '';
        let skuDataJson = skuIdToChecked();
        //规格名的键值对的数据
        let skuDetailNameJson = skuDataJson.skuDetailNameJson;
        //规格值的键值对数据
        let skuDetailChildNameJson = skuDataJson.skuDetailChildNameJson;
        //规格值的键与media值的数据
        let skuDetailChildMediaIdJson = skuDataJson.skuDetailChildMediaIdJson;

        //规格值自由组合的数据
        let skuCombine = permutation(skuDataJson.skuDetailJson);
        //规格名html模板渲染
        $.each(skuDetailNameJson, function(key,value) {
            skuDeatailTheadStr += '<th class="th-sku">'+value+'</th>';
        });
        let service_data = eval("(" + $('input[name=sku_attr]').val() + ")") == undefined ? [] : eval("(" + $('input[name=sku_attr]').val() + ")");
        //规格值html模板渲染
        $.each(skuCombine, function(key,value) {
            let skuDetailTbodyHtml = $('.prehtml .self_sku_detail tr').clone(); //克隆tbody tr模板
            let skuChildIdArr = [];
            let media = '';

            $.each(value, function(k,val) {
                skuDetailTbodyHtml.find('.self_sku_detail_fixed_column').before('<td><div class="flex-view" style="align-items: center; justify-content: flex-start; flex-direction: row;"><span>'+skuDetailChildNameJson[val]+'</span></div></td>');
                skuChildIdArr.push(val)
                if (skuDetailChildMediaIdJson[val] != undefined) media = skuDetailChildMediaIdJson[val];
            });
            // 规格详细原始排序
            let skuChildIndex = skuChildIdArr.join('-');
            // 规格详细排序从小到大
            skuChildIdArr.sort(function (a, b) {
                return a - b;
            });
            // 数组转成字符串
            let skuChildId = skuChildIdArr.join('-');
            //价格
            skuDetailTbodyHtml.find('.self_sku_detail_price input').attr({
                'name': 'prosku[' + skuChildId + '][price]',
                'value': service_data[key] == undefined ? '' : service_data[key]['price']
            });
            //库存
            skuDetailTbodyHtml.find('.self_sku_detail_stock_num input').attr({
                'name': 'prosku[' + skuChildId + '][stock_num]',
                'value': service_data[key] == undefined ? '' : service_data[key]['stock']['quantity']
            });
            //编码
            skuDetailTbodyHtml.find('.self_sku_detail_code input').attr({
                'name': 'prosku[' + skuChildId + '][code]',
                'value': service_data[key] == undefined ? '' : service_data[key]['code']
            });
            //成本价格
            skuDetailTbodyHtml.find('.self_sku_detail_cost_price input').attr({
                'name': 'prosku[' + skuChildId + '][cost_price]',
                'value': service_data[key] == undefined ? '' : service_data[key]['cost_price']
            });
            // 库存报警数
            skuDetailTbodyHtml.find('.self_sku_detail_warn_num input').attr({
                'name': 'prosku[' + skuChildId + '][warn_number]',
                'value': service_data[key] == undefined ? '' : service_data[key]['stock']['warn_number']
            });
            // 销量
            skuDetailTbodyHtml.find('.self_sku_detail_td_last span').eq(0).text(service_data[key] == undefined ? 0 : service_data[key]['sold_num']).next().attr({
                'name': 'prosku[' + skuChildId + '][sold_num]',
                'value': service_data[key] == undefined ? 0 : service_data[key]['sold_num']
            });

            // 规格id
            skuDetailTbodyHtml.find('.self_sku_detail_td_last')
                .append('<input type="hidden" value="' + skuChildIndex + '" name="prosku[' + skuChildId + '][attr_key]">');
            //图片id
            skuDetailTbodyHtml.find('.self_sku_detail_td_last')
                .append('<input type="hidden" value="' + media + '" name="prosku[' + skuChildId + '][media_id]">');
            //clone对象导出html
            skuDetailTbodyStr += skuDetailTbodyHtml.prop('outerHTML');

        });

        //渲染规格明细
        skuDetailContainer.css('display', 'block'); // 规格明细显示
        if(skuDetailTbodyStr == '') skuDetailContainer.css('display', 'none');
        if(skuDetailTheadTr.find('.th-sku').length > 0) skuDetailTheadTr.find('.th-sku').remove();
        if(skuDetailTbodyTr.length > 0) skuDetailTbodyTr.remove();
        skuDetailTheadTr.find('.th-price').before(skuDeatailTheadStr);
        skuDetailTbody.append(skuDetailTbodyStr);

    };

    function trim(str) { //删除左右两端的空格
        return str.replace(/(^\s*)|(\s*$)/g, "");
    }

    // 统计skuDetail选中的元素id
    const skuIdToChecked = () => {
        let skuAutoObj = $('.self_auto_sku_container');
        let skuDetailJson = {};
        let skuDetailNameJson = {};
        let skuDetailChildNameJson = {};
        let skuDetailChildMediaIdJson = {};
        //规格名循环
        for (let i = 0; i < skuAutoObj.length; i++) {
            let skuName = trim(skuAutoObj.eq(i).find('.ant-select-selection-selected-value').eq(0).text());
            let skuId = skuAutoObj.eq(i).find('.self_attr').val();
            let skuChildObj = skuAutoObj.eq(i).find('.self_sku_item');
            if (skuId == '') return false;
            skuDetailNameJson["'" + skuId + "'"] = skuName;
            //规格值循环
            let skuChildJson = [];
            for (let j = 0; j < skuChildObj.length; j++) {
                let skuChildName = trim(skuChildObj.eq(j).find('.ant-select-selection-selected-value').text());
                let skuChildId = skuChildObj.eq(j).find('.self_attr_value').val();
                let mediaId = skuChildObj.eq(j).find('.self_uploaded input').val();
                if (skuChildId == '') return false;
                skuChildJson.push(skuChildId);
                skuDetailChildNameJson[skuChildId] = skuChildName;
                if (mediaId != undefined) skuDetailChildMediaIdJson[skuChildId] = mediaId;
            }
            skuDetailJson["'" + skuId + "'"] = skuChildJson;
        }
        return {
            'skuDetailJson': skuDetailJson,
            'skuDetailNameJson': skuDetailNameJson,
            'skuDetailChildNameJson': skuDetailChildNameJson,
            'skuDetailChildMediaIdJson': skuDetailChildMediaIdJson,
        };
    };

    // 随机组合数据
    const permutation = (source) => {
        const result = [];
        const _result = {};
        const convert = (arr, index) => {
            if(source[arr[index]] == undefined) return false;
            for (let i = 0; i < source[arr[index]].length; i++) {
                if (source[arr[index]][i]) {
                    _result[arr[index]] = source[arr[index]][i]
                    if (index === arr.length - 1) {
                        result.push(JSON.parse(JSON.stringify(_result)));
                    } else {
                        convert(arr, index + 1);
                    }
                }
            }
        };
        convert(Object.keys(source), 0);
        return result;
    };

    // 数字组件向上事件
    $(document).on('click', '.ant-input-number-handler-up', function () {
        let that = $(this);
        let inputObj = that.parent().parent().find('input');
        let inputNum = parseFloat(inputObj.val());
        if (isNaN(inputNum) || inputNum >= 99) return false;
        inputObj.val(accAdd(inputNum, 1));
    })

    // 数字组件向下事件
    $(document).on('click', '.ant-input-number-handler-down', function () {
        let that = $(this);
        let inputObj = that.parent().parent().find('input');
        let inputNum = parseFloat(inputObj.val());
        if (isNaN(inputNum) || inputNum <= 1) return false;
        inputObj.val(accSub(inputNum, 1));
    })

    // 浮点数减法函数
    function accSub(arg1, arg2) {
        var r1, r2, m, n;
        try {
            r1 = arg1.toString().split(".")[1].length
        } catch (e) {
            r1 = 0
        }
        try {
            r2 = arg2.toString().split(".")[1].length
        } catch (e) {
            r2 = 0
        }
        m = Math.pow(10, Math.max(r1, r2));
        //动态控制精度长度
        n = (r1 >= r2) ? r1 : r2;
        return ((arg1 * m - arg2 * m) / m).toFixed(n);
    }

    // 浮点数加法函数
    function accAdd(arg1, arg2) {
        var r1, r2, m, c;
        try {
            r1 = arg1.toString().split(".")[1].length
        } catch (e) {
            r1 = 0
        }
        try {
            r2 = arg2.toString().split(".")[1].length
        } catch (e) {
            r2 = 0
        }
        c = Math.abs(r1 - r2);
        m = Math.pow(10, Math.max(r1, r2))
        if (c > 0) {
            var cm = Math.pow(10, c);
            if (r1 > r2) {
                arg1 = Number(arg1.toString().replace(".", ""));
                arg2 = Number(arg2.toString().replace(".", "")) * cm;
            } else {
                arg1 = Number(arg1.toString().replace(".", "")) * cm;
                arg2 = Number(arg2.toString().replace(".", ""));
            }
        } else {
            arg1 = Number(arg1.toString().replace(".", ""));
            arg2 = Number(arg2.toString().replace(".", ""));
        }
        return (arg1 + arg2) / m
    }

    $(document).on('click', '.ant-input-group-addon', function () {
        let that = $(this);
        let type = that.attr('data-group-type');
        let val = that.parent().find('input').val();
        let self_batch_value = $('.self_batch_value').find('.ant-checkbox-checked').length;
        let oparateObj;
        switch (type) {
            case 'price' :
                oparateObj = $('.self_sku_detail_container .self_sku_detail_price input');
                break;
            case 'const_price' :
                oparateObj = $('.self_sku_detail_container .self_sku_detail_cost_price input');
                break;
            case 'stock' :
                oparateObj = $('.self_sku_detail_container .self_sku_detail_stock_num input');
                break;
        }
        eachBatchVal(val, oparateObj, self_batch_value);
    })

    $(document).on('click', '.self_batch_value span', function () {
        let that = $(this);
        if (that.hasClass('ant-checkbox-checked')) {
            that.removeClass('ant-checkbox-checked');
            return false;
        }
        that.addClass('ant-checkbox-checked');
    })

    const eachBatchVal = (val, oparateObj, self_batch_value) => {
        if (self_batch_value == 1) {
            oparateObj.val(val);
        }
        for (let i = 0; i < oparateObj.length; i++) {
            let eqVal = oparateObj.eq(i).val();
            if (eqVal == '') oparateObj.eq(i).val(val);
        }
    };

    $(document).on("mouseover mouseout", '.self_tips', function (event) {
        let that = $(this);
        let position = that.offset();
        let width = that.width();
        let height = that.height();
        let tipHtml = $('.prehtml .ant-tooltip').clone();
        let thatTip = that.data('tipisset');
        let thatP = that.parent().parent().attr('class');
        if (event.type == "mouseover") {
            if (thatTip != undefined) {
                //计算弹窗位置
                that.addClass('ant-tooltip-open');
                let tipObj = $('.' + thatTip);
                let tip_width = tipObj.width();
                let tip_height = tipObj.height();
                let left = position.left - (tip_width / 2) + (width / 2) + 'px';
                let top = position.top - (tip_height / 2) - 22 - height + 'px';
                tipObj.css({'left': left, 'top': top}).removeClass('ant-tooltip-hidden');
                return false;
            }
            let randStr = randKey();
            let contentStr;
            that.addClass('ant-tooltip-open').attr('data-tipisset', randStr);
            tipHtml.addClass(randStr);
            switch (thatP) {
                case 'th-code':
                    contentStr = '为方便管理，可以自定义编码，比如货号';
                    break;
                case 'text-cost-price':
                    contentStr = '成本价未来会用于营销建议，利润分析等';
                    break;
            }
            tipHtml.find('.ant-tooltip-content .ant-tooltip-inner').text(contentStr);
            $(document.body).append(tipHtml);
            //计算弹窗位置
            let tip_width = tipHtml.width();
            let tip_height = tipHtml.height();
            let left = position.left - (tip_width / 2) + (width / 2) + 'px';
            let top = position.top - (tip_height / 2) - 22 - height + 'px';
            $('.' + randStr).css({'left': left, 'top': top}).removeClass('ant-tooltip-hidden')

        } else if (event.type == "mouseout") {
            $('.' + thatTip).addClass('ant-tooltip-hidden');
            that.removeClass('ant-tooltip-open')
        }
    });
    addSkuDetail();
})


