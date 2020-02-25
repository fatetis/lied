(function () {
    //------------ 阿里云OSS start ------------

    //指定长度的随机字符串
    function random_string(len) {
        len = len || 32;
        var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var maxPos = chars.length;
        var pwd = '';
        for (i = 0; i < len; i++) {
            pwd += chars.charAt(Math.floor(Math.random() * maxPos));
        }
        return pwd;
    }

    //获取文件的后缀名
    function get_suffix(filename) {
        var pos = filename.lastIndexOf('.');
        var suffix = '';
        if (pos !== -1) {
            suffix = filename.substring(pos)
        }
        return suffix.toLowerCase();
    }

    // 图片初始化上传
    function init_upload(id, csrf_token) {
        var browse_button = $('#' + id + '_alioss_upload');
        var multi = Boolean(browse_button.attr('data-multi'));
        var upload_url = browse_button.attr('upload_url');
        var is_lock = browse_button.attr('is_lock');
        var container = document.getElementById(id + '_container');
        if (multi) {
            // 多图可拖动
            Sortable.create(container, {animation: 150, group: {pull: false, put: false,}, handle: 'img'});
        }
        var uploader = new plupload.Uploader({
            runtimes: 'html5,flash,silverlight,html4',
            browse_button: browse_button.attr('id'),//'pickfiles',
            container: container,
            url: '/admin/upload/image',
            flash_swf_url: '/vendor/laravel-admin-ext/sk-image/plupload/Moxie.swf',
            silverlight_xap_url: '/vendor/laravel-admin-ext/sk-image/plupload/Moxie.xap',
            multi_selection: multi,//false单选，true多选
            multipart_params: {'_token': csrf_token, 'upload_url': upload_url, 'is_lock': is_lock === undefined ? 0 : is_lock},
            unique_names: true,
            //过滤
            filters: {
                max_file_size: '10mb',     //单文件最大size
                mime_types: [
                    {title: "Image files", extensions: "jpg,jpeg,png"}
                ]
            },
            init: {
                FilesAdded: function (up, files) {
                    uploader.start();//选择文件后立即上传
                },
                BeforeUpload: function (up, file) {
                    // console.log('BeforeUpload');

                    if (multi) {
                        // 多图
                        $('#' + id + '_container').append('<div id="' + file.id + '" class="show_upload_pic_item"><div class="alioss_percent">0%</div></div>');
                    } else {
                        // 单图
                        let obj = $('#' + id + '_container');
                        if(obj.find('.show_upload_pic_item').length > 0){
                            obj.find('.show_upload_pic_item').remove();
                        }
                        obj.append('<div id="' + file.id + '" class="show_upload_pic_item"><div class="alioss_percent">0%</div></div>');
                        // browse_button.parent().append('<div id="' + file.id + '"><div class="alioss_percent">0%</div></div>');
                    }
                    file_ext = get_suffix(file.name); //后缀名
                    filename_new = Date.parse(new Date()) / 1000 + '_' + random_string(10) + file_ext;
                    // set_upload_param(up, filename_new); //重设参数
                },
                UploadProgress: function (up, file) {
                    // console.log('UploadProgress');

                    $('#' + file.id).find('.alioss_percent').html(file.percent + '%');
                },
                FileUploaded: function (up, file, info) {
                    // console.log('FileUploaded');

                    if(200 != info.status){
                        RemoveBitMap(file.id);
                        alert("1抱歉！出错了" );
                        return;
                    }

                    var result = eval("(" + info.response + ")");
                    if(true == result.uploaded){
                        var file_id = result.url;
                        var src = result.src;
                    }else {
                        RemoveBitMap(file.id);
                        alert("2抱歉！出错了：" + result.msg);
                        return;
                    }
                    if (multi) {
                        // 多图
                        $('#' + file.id).html([
                            '<img src="' + src + '" style="margin-bottom: 3px;width: 80%;height: 80%">',
                            '<div class="operat_warp" style="display: inline-block">',
                            '<input type="hidden" name="' + id + '[]" value="' + file_id + '" />',
                            '<a class="example-image-link" href="' + src + '" data-lightbox="example-set">预览</a> / ',
                            '<a href="javascript:void(0);" onclick="alioss_del_file(this,1)" data-filename="' + file_id + '">删除</a>',
                            '</div>'
                        ].join(''));
                    } else {
                        // 单图
                        $('#' + file.id).html([
                            '<img src="' + src + '" style="margin-bottom: 3px;width: 80%;height: 80%">',
                            '<div class="operat_warp" style="display: inline-block">',
                            '<input type="hidden" name="' + id + '" value="' + file_id + '" />',
                            '<a class="example-image-link" href="' + src + '" data-lightbox="example-set">预览</a> / ',
                            '<a href="javascript:void(0);" onclick="alioss_del_file(this,1)" data-filename="' + file_id + '">删除</a>',
                            '</div>'
                        ].join(''));

                    }
                },
                UploadComplete: function (up, files) {
                    // console.log('UploadComplete');

                    // console.log('Complete');
                },
                Error: function (up, err) {
                    // console.log('Error');
                    RemoveBitMap(err.file.id);
                    alert("3抱歉！出错了：" + err.message);
                },

            }
        });
        // 上传失败，移除占位图
        function RemoveBitMap(file_id) {
            $('#'+file_id).remove();
        }
        //初始化上传
        uploader.init();
    }

    window.alioss_upload = init_upload;

    // 图片删除文件 仅仅删除页面上的html标签
    window.alioss_del_file = function (obj, type) {
        if (type) { // 多图
            let parents = $(obj).parents('.show_upload_pic');
            let parentsNum = parents.find('.show_upload_pic_item').length;
            let key = $(obj).siblings('input').attr('name');
            if(parentsNum <= 1){
                parents.append('<input type="hidden" name="'+key+'" value="">');
            }
            $(obj).parents('.show_upload_pic_item').remove();
        } else {
            // 单图
            var show_upload_pic_item = $(obj).attr('data-filename', '').parents('.show_upload_pic_item');
            show_upload_pic_item.find('img.Js_alioss_btn').attr('src', '/vendor/laravel-admin-ext/sk-image/pic_add.png');
            var operat_warp = show_upload_pic_item.find('.operat_warp').hide();
            operat_warp.find('input').val('');
            operat_warp.find('a:eq(0)').attr('href', '');
            operat_warp.find('a:eq(2)').attr('data-filename', '');
        }
    };


    const init_video_upload = (name, token) => {
        var browse_button = $('#' + name + '_video_upload');
        var multi = Boolean(browse_button.attr('data-multi'));
        var upload_url = browse_button.attr('upload_url');
        var container = document.getElementById(name + '_container');
        var uploader = new plupload.Uploader({
            runtimes: 'gears,html5,html4,silverlight,flash', //上传插件初始化选用那种方式的优先级顺序
            browse_button: browse_button.attr('id'),//'pickfiles',
            container: container,
            url: '/admin/upload/video',
            flash_swf_url: '/vendor/laravel-admin-ext/sk-image/plupload/Moxie.swf',
            silverlight_xap_url: '/vendor/laravel-admin-ext/sk-image/plupload/Moxie.xap',
            multi_selection: multi,//false单选，true多选
            // multipart_params: {'_token': token, 'upload_url': upload_url},
            unique_names: true,
            //过滤
            filters: {
                max_file_size: '50mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
                mime_types: [//允许文件上传类型
                    {title: "files", extensions: "mp4"}
                ]
            },
            chunk_size: "8mb",
            init: {
                FilesAdded: function (up, file) {
                    uploader.start();//选择文件后立即上传
                },
                BeforeUpload: function (up, file) {
                    // 阻断多次提交
                    browse_button.attr("disabled", "disabled").css('opacity', 0.6);
                    // 设置上传参数
                    uploader.setOption("multipart_params", {
                        "totalSize": file.origSize,
                        '_token': token,
                        'upload_url': upload_url,
                        'file_ext': file.type
                    });

                    let containerObj = $('#' + name + '_container');
                    //限定只能传一个
                    let videoLength = containerObj.find('video').length;
                    if (videoLength >= 1) {
                        alioss_del_video(containerObj.eq(0).find('.show_upload_pic_item .example-image-link').next());
                    }
                    // 多图
                    containerObj.append('<div id="' + file.id + '" class="show_upload_pic_item"><div class="alioss_percent">0%</div></div>');
                },
                UploadProgress: function (up, file) {
                    $('#' + file.id).find('.alioss_percent').html(file.percent + '%');
                },
                FileUploaded: function (up, file, info) {
                    var result = eval("(" + info.response + ")");
                    if (result.code != 200) {
                        RemoveBitMaps(file.id);
                        browse_button.attr("disabled", false).css('opacity', 1);
                        swal('上传失败', result.msg, 'error');
                        return false;
                    }
                    var file_id = result.data.url;
                    var src = result.data.src;
                    // 多图
                    $('#' + file.id).html([
                        '<video src="' + src + '"  style="width: 100%"  controls="controls">您的浏览器不支持 video 标签。</video>',
                        '<div class="operat_warp" style="display: inline-block;">',
                        '<input type="hidden" name="' + name + '" value="' + file_id + '" />',
                        '<a class="example-image-link" href="' + src + '" target="_blank">预览</a> / ',
                        '<a href="javascript:void(0);" onclick="alioss_del_video(this)" data-filename="' + file_id + '">删除</a>',
                        '</div><style>.show_upload_pic_item{width: 200px;height: unset;}</style>'
                    ].join(''));

                },
                UploadComplete: function (up, files) {
                    browse_button.attr("disabled", false).css('opacity', 1);
                },
                Error: function (up, err) {
                    console.log(err);

                    browse_button.attr("disabled", false).css('opacity', 1);
                    RemoveBitMaps(err.file.id);
                    swal('上传出错', '仅支持mp4格式，上传最大为50M', 'error');
                },

            }
        });

        // 上传失败，移除占位图
        function RemoveBitMaps(file_id) {
            $('#' + file_id).remove();
        }

        //初始化上传
        uploader.init();
    }
    window.init_video_upload = init_video_upload;

    window.alioss_del_video = function (obj) {
        let parents = $(obj).parents('.show_upload_pic');
        let parentsNum = parents.find('.show_upload_pic_item').length;
        let key = $(obj).parents('.show_upload_pic_item').find('input').attr('name');
        if (parentsNum <= 1) {
            parents.append('<input type="hidden" name="' + key + '" value="">');
        }
        $(obj).parents('.show_upload_pic_item').remove()

    };
})();