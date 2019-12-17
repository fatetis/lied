{{--<link rel="stylesheet" href="{{ asset('vendor/store/5.chunk.css') }}">--}}
<link rel="stylesheet" href="{{ asset('vendor/store/6.chunk.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/store/umi.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/store/vendors.chunk.css') }}">
{{--ant-select-dropdown元素隐藏：ant-select-dropdown-hidden--}}
{{--li被选中状态：ant-select-dropdown-menu-item-active--}}
{{--li不可选状态：ant-select-dropdown-menu-item-disabled--}}

<style>
    .jiantou {
        position: absolute;
        width: 0;
        height: 0;
        top: -7px;
        left: 50%;
        margin-left: -2.5px;
        border-style: solid;
        border-color: transparent;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid #666;
    }

    .jiantou:after {
        position: absolute;
        display: block;
        width: 0;
        height: 0;
        top: 0;
        margin-left: -10px;
        border-color: transparent transparent #fff;
        border-style: solid;
        border-width: 0 10px 10px;
        content: "";
    }
</style>

{{--url存放框--}}
<div class="prehtml" style="display: none">
    {{--商品规格值clone模板--}}
    <div class="mr-10 mb-10 antd-pro-pages-goods-widget-styles-sku_values_item self_sku_item">
        <div class="ant-select ant-select-enabled self_random_key " style="width: 150px;">
            <div class="ant-select-selection
                                    ant-select-selection--single" role="combobox" aria-autocomplete="list"
                 aria-haspopup="true"
                 aria-controls="ddecfc9c-c099-4627-bba2-3b4384958ce7"
                 aria-expanded="false"
                 tabindex="0">
                <div class="ant-select-selection__rendered ">
                    <div class="ant-select-selection-selected-value" title=""
                         style="display: block; opacity: 1;">

                    </div>
                    <div class="ant-select-search ant-select-search--inline"
                         style="display: none;">
                        <div class="ant-select-search__field__wrap">
                            {{--data-url：查找url；data-create-url：创建url--}}
                            <input autocomplete="off" class="ant-select-search__field"
                                   data-url="{{ route('proAttrValueGetApi', ['_token'=>csrf_token()]) }}"
                                   data-create-url="{{ route('proAttrValueCreateApi', ['_token'=>csrf_token()]) }}"
                                   value="">
                            <input class="self_attr_value" type="hidden" name="attr_value[]" value="">
                            <span class="ant-select-search__field__mirror">
                                                        &nbsp;
                                                    </span>
                        </div>
                    </div>
                </div>
                <span class="ant-select-arrow" unselectable="on"
                      style="user-select: none;">
                                            <i aria-label="图标: down"
                                               class="anticon anticon-down ant-select-arrow-icon">
                                                <svg viewBox="64 64 896 896" class="" data-icon="down"
                                                     width="1em" height="1em"
                                                     fill="currentColor" aria-hidden="true">
                                                    <path
                                                            d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z">
                                                    </path>
                                                </svg>
                                            </i>
                                        </span>
            </div>
        </div>
        <a class="antd-pro-pages-goods-widget-styles-sku_values_item_del_btn self-sku-value-error">
            <i aria-label="图标: close-circle" class="anticon anticon-close-circle"
               style="font-size: 15px;">
                <svg viewBox="64 64 896 896" class="" data-icon="close-circle"
                     width="1em"
                     height="1em" fill="currentColor" aria-hidden="true">
                    <path fill="#1890ff"
                          d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
                    </path>
                    <path fill="#e6f7ff"
                          d="M512 140c-205.4 0-372 166.6-372 372s166.6 372 372 372 372-166.6 372-372-166.6-372-372-372zm171.8 527.1c1.2 1.5 1.9 3.3 1.9 5.2 0 4.5-3.6 8-8 8l-66-.3-99.3-118.4-99.3 118.5-66.1.3c-4.4 0-8-3.6-8-8 0-1.9.7-3.7 1.9-5.2L471 512.3l-130.1-155a8.32 8.32 0 0 1-1.9-5.2c0-4.5 3.6-8 8-8l66.1.3 99.3 118.4 99.4-118.5 66-.3c4.4 0 8 3.6 8 8 0 1.9-.6 3.8-1.8 5.2l-130.1 155 129.9 154.9z">
                    </path>
                    <path fill="#1890ff"
                          d="M685.8 352c0-4.4-3.6-8-8-8l-66 .3-99.4 118.5-99.3-118.4-66.1-.3c-4.4 0-8 3.5-8 8 0 1.9.7 3.7 1.9 5.2l130.1 155-130.1 154.9a8.32 8.32 0 0 0-1.9 5.2c0 4.4 3.6 8 8 8l66.1-.3 99.3-118.5L611.7 680l66 .3c4.4 0 8-3.5 8-8 0-1.9-.7-3.7-1.9-5.2L553.9 512.2l130.1-155c1.2-1.4 1.8-3.3 1.8-5.2z">
                    </path>
                </svg>
            </i>
        </a>

    </div>
    {{--select选择框--}}
    <div style="position: absolute; top: 0px; left: 0px; width: 100%;" class="self_select_html">
        <div>
            <div class="ant-select-dropdown ant-select-dropdown--single ant-select-dropdown-placement-bottomLeft">
                <div style="overflow: auto; transform: translateZ(0px);">
                    <ul role="listbox"
                        class="ant-select-dropdown-menu  ant-select-dropdown-menu-root ant-select-dropdown-menu-vertical"
                        tabindex="0">
                        @foreach($attrData as $key => $value)
                            <li role="option" class="ant-select-dropdown-menu-item" data-key="{{ $value->id }}">
                                {{ $value->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{--商品规格模板--}}
    <div class="self_sku_additem">
        <div class="antd-pro-pages-goods-widget-styles-sku_group_title">
                        <span>
                            规格名：
                        </span>
            <div class="f-c" style="flex: 1 1 0%;">
                <div class="ant-select ant-select-enabled" style="width: 150px;">
                    <div class="ant-select-selection
                                ant-select-selection--single" role="combobox" aria-autocomplete="list"
                         aria-haspopup="true" aria-expanded="false"
                         tabindex="0">
                        {{--<div class="ant-select-selection__rendered">--}}
                        {{--<div class="ant-select-selection-selected-value" title="颜色"--}}
                        {{--style="display: block; opacity: 1;">--}}
                        {{--颜色--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="ant-select-selection__rendered">
                            <div class="ant-select-selection-selected-value" title=""
                                 style="display: block; opacity: 1;">
                            </div>
                            <div class="ant-select-search ant-select-search--inline" style="display: none;">
                                <div class="ant-select-search__field__wrap">
                                    <input data-url="{{ route('proAttrGetApi', ['_token'=>csrf_token()]) }}"
                                           data-create-url="{{ route('proAttrCreateApi', ['_token'=>csrf_token()]) }}"
                                           autocomplete="off" class="ant-select-search__field" value="">
                                    <input class="self_attr" type="hidden" name="attr[]" value="">
                                    <span class="ant-select-search__field__mirror">
                                        &nbsp;
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span class="ant-select-arrow" unselectable="on" style="user-select: none;">
                                        <i aria-label="图标: down"
                                           class="anticon anticon-down ant-select-arrow-icon">
                                            <svg viewBox="64 64 896 896" class="" data-icon="down" width="1em"
                                                 height="1em"
                                                 fill="currentColor" aria-hidden="true">
                                                <path
                                                        d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z">
                                                </path>
                                            </svg>
                                        </i>
                                    </span>
                    </div>
                </div>
                <div class="f-c-c font-12 ml-10 self_sku_picture">
                    <label class="ant-checkbox-wrapper">
                                    <span class="ant-checkbox self_style_control">
                                        <input type="checkbox" class="ant-checkbox-input" value="">
                                        <span class="ant-checkbox-inner">
                                        </span>
                                    </span>
                        <span>
                                        <a>
                                            添加规格图片
                                        </a>
                                    </span>
                    </label>
                </div>
            </div>
            {{--规格名叉叉--}}
            <a style="line-height: 1;" class="self-sku-error">
                <i aria-label="图标: close-circle" class="anticon anticon-close-circle"
                   style="font-size: 16px;">
                    <svg viewBox="64 64 896 896" class="" data-icon="close-circle" width="1em"
                         height="1em" fill="currentColor" aria-hidden="true">
                        <path
                                d="M685.4 354.8c0-4.4-3.6-8-8-8l-66 .3L512 465.6l-99.3-118.4-66.1-.3c-4.4 0-8 3.5-8 8 0 1.9.7 3.7 1.9 5.2l130.1 155L340.5 670a8.32 8.32 0 0 0-1.9 5.2c0 4.4 3.6 8 8 8l66.1-.3L512 564.4l99.3 118.4 66 .3c4.4 0 8-3.5 8-8 0-1.9-.7-3.7-1.9-5.2L553.5 515l130.1-155c1.2-1.4 1.8-3.3 1.8-5.2z">
                        </path>
                        <path
                                d="M512 65C264.6 65 64 265.6 64 513s200.6 448 448 448 448-200.6 448-448S759.4 65 512 65zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
                        </path>
                    </svg>
                </i>
            </a>
        </div>
        <div class="antd-pro-pages-goods-widget-styles-sku_group_container">
                        <span style="flex-shrink: 0; line-height: 30px;">
                            规格值：
                        </span>
            <div class="flex self_sku" style="flex-wrap: wrap; flex: 1 1 0%;">

                <button type="button" class="ant-btn mb-10 self-sku-add" style="flex-shrink: 0;">
                    <i aria-label="图标: plus" class="anticon anticon-plus">
                        <svg viewBox="64 64 896 896" class="" data-icon="plus" width="1em"
                             height="1em"
                             fill="currentColor" aria-hidden="true">
                            <path
                                    d="M848 474H550V152h-76v322H176c-4.4 0-8 3.6-8 8v60c0 4.4 3.6 8 8 8h298v322h76V550h298c4.4 0 8-3.6 8-8v-60c0-4.4-3.6-8-8-8z">
                            </path>
                        </svg>
                    </i>
                    <span>
                                    添加规格值
                                </span>
                </button>
            </div>
        </div>
    </div>
    {{--图片插件模板-new--}}
    <div style="float: unset;margin-top: 15px;position: relative;width: 104px"
         class="ant-upload-list ant-upload-list-picture-card self_pic_clone">
        <div class="antd-pro-pages-goods-widget-styles-arrow jiantou"></div>
        <div class="ant-upload-list-item ant-upload-list-item-done">
            <div class="self_upload" style="height: 100%; cursor: pointer;">
            <span class="ant-upload-list-item-actions" style="opacity: 1">
                <i aria-label="图标: plus-circle" class="anticon anticon-plus-circle">
                <svg viewBox="64 64 896 896" class="" data-icon="plus-circle" width="1em" height="1em"
                     fill="currentColor"
                     aria-hidden="true">
                <path d="M696 480H544V328c0-4.4-3.6-8-8-8h-48c-4.4 0-8 3.6-8 8v152H328c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h152v152c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V544h152c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8z"></path>
                <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z"></path>
                </svg>
                </i>添加图片
            </span>
            </div>

            <div class="self_uploading" style="height: 100%; display: none">
            <span class="ant-upload-list-item-actions"
                  style="opacity: 1; display: inline-block; width: 48px; height: 48px; text-align: center; line-height: 48px; font-size: 12px; border-radius: 50%; background-color: #1890ff; color: #ffffff">
                0%
            </span>
            </div>

            <div class="self_uploaded" style="display: none; height: 100%;">
                <div class="ant-upload-list-item-info">
            <span>
                <a target="_blank" rel="noopener noreferrer" class="ant-upload-list-item-thumbnail">
                    <img/>
                </a>
            </span>
                </div>
                <span class="ant-upload-list-item-actions">
                <a target="_blank" title="预览文件" rel="noopener noreferrer">
                    <i aria-label="图标: eye-o" class="anticon anticon-eye-o">
                        <svg viewBox="64 64 896 896" class="" data-icon="eye" width="1em" height="1em"
                             fill="currentColor"
                             aria-hidden="true">
                        <path d="M942.2 486.2C847.4 286.5 704.1 186 512 186c-192.2 0-335.4 100.5-430.2 300.3a60.3 60.3 0 0 0 0 51.5C176.6 737.5 319.9 838 512 838c192.2 0 335.4-100.5 430.2-300.3 7.7-16.2 7.7-35 0-51.5zM512 766c-161.3 0-279.4-81.8-362.7-254C232.6 339.8 350.7 258 512 258c161.3 0 279.4 81.8 362.7 254C791.5 684.2 673.4 766 512 766zm-4-430c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm0 288c-61.9 0-112-50.1-112-112s50.1-112 112-112 112 50.1 112 112-50.1 112-112 112z"></path>
                        </svg>
                    </i>
                </a>
                <i aria-label="图标: delete" title="删除文件" tabindex="-1" class="anticon anticon-delete">
                    <svg viewbox="64 64 896 896" class="" data-icon="delete" width="1em" height="1em"
                         fill="currentColor"
                         aria-hidden="true">
                    <path d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z"></path>
                    </svg>
                </i>
            </span>
            </div>
        </div>
    </div>
    {{--sku规格明细--}}
    <table class="self_sku_detail">
        <tr class="ant-table-row ant-table-row-level-0 self_sku_detail_tr">
            {{--<td>--}}
            {{--<div class="flex-view" style="align-items: center; justify-content: flex-start; flex-direction: row;">--}}
            {{--<span>--}}
            {{--蓝--}}
            {{--</span>--}}
            {{--</div>--}}
            {{--</td>--}}
            <td class="self_sku_detail_fixed_column">
                <div class="ant-row ant-form-item">
                    <div class="ant-form-item-control-wrapper">
                        <div class="ant-form-item-control">
                        <span class="ant-form-item-children">
                            <div class="ant-input-number"
                                 style="width: 100px;">
                                <div class="ant-input-number-handler-wrap">
                                    <span unselectable="unselectable"
                                          role="button"
                                          aria-label="Increase Value"
                                          aria-disabled="false"
                                          class="ant-input-number-handler ant-input-number-handler-up ">
                                        <i aria-label="图标: up"
                                           class="anticon anticon-up ant-input-number-handler-up-inner">
                                            <svg viewBox="64 64 896 896"
                                                 class="" data-icon="up"
                                                 width="1em" height="1em"
                                                 fill="currentColor"
                                                 aria-hidden="true">
                                                <path
                                                        d="M890.5 755.3L537.9 269.2c-12.8-17.6-39-17.6-51.7 0L133.5 755.3A8 8 0 0 0 140 768h75c5.1 0 9.9-2.5 12.9-6.6L512 369.8l284.1 391.6c3 4.1 7.8 6.6 12.9 6.6h75c6.5 0 10.3-7.4 6.5-12.7z">
                                                </path>
                                            </svg>
                                        </i>
                                    </span>
                                    <span unselectable="unselectable"
                                          role="button"
                                          aria-label="Decrease Value"
                                          aria-disabled="false"
                                          class="ant-input-number-handler ant-input-number-handler-down ">
                                        <i aria-label="图标: down"
                                           class="anticon anticon-down ant-input-number-handler-down-inner">
                                            <svg viewBox="64 64 896 896"
                                                 class="" data-icon="down"
                                                 width="1em" height="1em"
                                                 fill="currentColor"
                                                 aria-hidden="true">
                                                <path
                                                        d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z">
                                                </path>
                                            </svg>
                                        </i>
                                    </span>
                                </div>
                                <div class="ant-input-number-input-wrap"
                                     role="spinbutton" aria-valuemin="0">
                                    {{--<input class="ant-input-number-input"--}}
                                           {{--autocomplete="off" min="0"--}}
                                           {{--step="1"--}}
                                           {{--id="goods_skus[17][price]"--}}
                                           {{--data-__meta="[object Object]"--}}
                                           {{--data-__field="[object Object]"--}}
                                           {{--value="">--}}
                                </div>
                            </div>
                        </span>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="ant-row ant-form-item">
                    <div class="ant-form-item-control-wrapper">
                        <div class="ant-form-item-control">
                        <span class="ant-form-item-children">
                            <div class="ant-input-number"
                                 style="width: 100px;">
                                <div class="ant-input-number-handler-wrap">
                                    <span unselectable="unselectable"
                                          role="button"
                                          aria-label="Increase Value"
                                          aria-disabled="false"
                                          class="ant-input-number-handler ant-input-number-handler-up ">
                                        <i aria-label="图标: up"
                                           class="anticon anticon-up ant-input-number-handler-up-inner">
                                            <svg viewBox="64 64 896 896"
                                                 class="" data-icon="up"
                                                 width="1em" height="1em"
                                                 fill="currentColor"
                                                 aria-hidden="true">
                                                <path
                                                        d="M890.5 755.3L537.9 269.2c-12.8-17.6-39-17.6-51.7 0L133.5 755.3A8 8 0 0 0 140 768h75c5.1 0 9.9-2.5 12.9-6.6L512 369.8l284.1 391.6c3 4.1 7.8 6.6 12.9 6.6h75c6.5 0 10.3-7.4 6.5-12.7z">
                                                </path>
                                            </svg>
                                        </i>
                                    </span>
                                    <span unselectable="unselectable"
                                          role="button"
                                          aria-label="Decrease Value"
                                          aria-disabled="false"
                                          class="ant-input-number-handler ant-input-number-handler-down ">
                                        <i aria-label="图标: down"
                                           class="anticon anticon-down ant-input-number-handler-down-inner">
                                            <svg viewBox="64 64 896 896"
                                                 class="" data-icon="down"
                                                 width="1em" height="1em"
                                                 fill="currentColor"
                                                 aria-hidden="true">
                                                <path
                                                        d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z">
                                                </path>
                                            </svg>
                                        </i>
                                    </span>
                                </div>
                                <div class="ant-input-number-input-wrap"
                                     role="spinbutton" aria-valuemin="0">
                                    {{--<input class="ant-input-number-input"--}}
                                           {{--autocomplete="off" min="0"--}}
                                           {{--step="1"--}}
                                           {{--id="goods_skus[17][stock_num]"--}}
                                           {{--data-__meta="[object Object]"--}}
                                           {{--data-__field="[object Object]"--}}
                                           {{--value="">--}}
                                </div>
                            </div>
                        </span>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="ant-row ant-form-item">
                    <div class="ant-form-item-control-wrapper">
                        <div class="ant-form-item-control">
                        <span class="ant-form-item-children">
                            <span class="ant-input-affix-wrapper"
                                  style="width: 150px;">
                                {{--<input type="text" id="goods_skus[17][code]"--}}
                                       {{--data-__meta="[object Object]"--}}
                                       {{--data-__field="[object Object]"--}}
                                       {{--class="ant-input" value="">--}}
                                <span class="ant-input-suffix">
                                </span>
                            </span>
                        </span>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="ant-row ant-form-item">
                    <div class="ant-form-item-control-wrapper">
                        <div class="ant-form-item-control">
                        <span class="ant-form-item-children">
                            <div class="ant-input-number"
                                 style="width: 100px;">
                                <div class="ant-input-number-handler-wrap">
                                    <span unselectable="unselectable"
                                          role="button"
                                          aria-label="Increase Value"
                                          aria-disabled="false"
                                          class="ant-input-number-handler ant-input-number-handler-up ">
                                        <i aria-label="图标: up"
                                           class="anticon anticon-up ant-input-number-handler-up-inner">
                                            <svg viewBox="64 64 896 896"
                                                 class="" data-icon="up"
                                                 width="1em" height="1em"
                                                 fill="currentColor"
                                                 aria-hidden="true">
                                                <path
                                                        d="M890.5 755.3L537.9 269.2c-12.8-17.6-39-17.6-51.7 0L133.5 755.3A8 8 0 0 0 140 768h75c5.1 0 9.9-2.5 12.9-6.6L512 369.8l284.1 391.6c3 4.1 7.8 6.6 12.9 6.6h75c6.5 0 10.3-7.4 6.5-12.7z">
                                                </path>
                                            </svg>
                                        </i>
                                    </span>
                                    <span unselectable="unselectable"
                                          role="button"
                                          aria-label="Decrease Value"
                                          aria-disabled="false"
                                          class="ant-input-number-handler ant-input-number-handler-down ">
                                        <i aria-label="图标: down"
                                           class="anticon anticon-down ant-input-number-handler-down-inner">
                                            <svg viewBox="64 64 896 896"
                                                 class="" data-icon="down"
                                                 width="1em" height="1em"
                                                 fill="currentColor"
                                                 aria-hidden="true">
                                                <path
                                                        d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z">
                                                </path>
                                            </svg>
                                        </i>
                                    </span>
                                </div>
                                <div class="ant-input-number-input-wrap"
                                     role="spinbutton" aria-valuemin="0">
                                    {{--<input class="ant-input-number-input"--}}
                                           {{--autocomplete="off" min="0"--}}
                                           {{--step="1"--}}
                                           {{--id="goods_skus[17][cost_price]"--}}
                                           {{--data-__meta="[object Object]"--}}
                                           {{--data-__field="[object Object]"--}}
                                           {{--value="">--}}
                                </div>
                            </div>
                        </span>
                        </div>
                    </div>
                </div>
            </td>
            <td class="self_sku_detail_td_last">
                {{--<span value="0" id="goods_skus[17][sold_num]">0</span>--}}
                {{--<span value="17" id="goods_skus[17][attr_key]"></span>--}}
                {{--<span value="false" id="goods_skus[17][is_image]"></span>--}}
                {{--<span value="0" id="goods_skus[17][media_id]" ></span>--}}
            </td>
        </tr>
    </table>

</div>

{{--数据存放--}}
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="_date" value="{{ date('Ymd') }}">

{{--正文--}}
<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">
    {{--{{$label}}--}}
    <label for="{{$id}}" class="col-sm-2 control-label">商品规格</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')
        <div class="ant-col-22 ant-form-item-control-wrapper self_sku_container">
            <div class="ant-form-item-control has-success">
		<span class="ant-form-item-children">
			<div class="ant-card ant-card-bordered ant-card-wider-padding ant-card-padding-transition">
				<div class="ant-card-body" style="padding: 0px;">
					<div class="antd-pro-pages-goods-widget-styles-sku_group_title">
						<button type="button" class="ant-btn ant-btn-primary self-sku-additem">
							<span>
								添加商品规格
							</span>
						</button>
					</div>
				</div>
			</div>
		</span>
                <div class="ant-form-extra">
                    如有颜色、尺码等多种规格，请添加商品规格，最多添加3个规格
                </div>
            </div>
        </div>

        <input type="hidden" name="{{$name}}" value="{{ old($column, $value) }}"/>

    </div>

</div>
<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!} self_sku_detail_container" style="display: none">
    <label class="col-sm-2 control-label">规格明细</label>
    <div class="{{$viewClass['field']}}">
        <div class="ant-col-22 ant-form-item-control-wrapper">
            <div class="ant-form-item-control">
				<span class="ant-form-item-children">
					<div class="ant-card ant-card-bordered ant-card-wider-padding ant-card-padding-transition">
						<div class="ant-card-body" style="padding: 0px;">
							<div class="ant-table ant-table-middle ant-table-scroll-position-left undefined">
								<div class="ant-table-content">
									<div class="ant-table-body">
										<table>
											<thead class="ant-table-thead self_sku_detail_thead">
												<tr>
													{{--<th class="th-sku">--}}
														{{--<span>--}}
															{{--颜色--}}
														{{--</span>--}}
													{{--</th>--}}
													<th class="th-price">
														价格（元）
													</th>
													<th class="th-stock">
														库存
													</th>
													<th class="th-code">
														规格编码
														<a>
															<i aria-label="图标: question-circle"
                                                               class="anticon anticon-question-circle">
																<svg viewBox="64 64 896 896" class=""
                                                                     data-icon="question-circle" width="1em"
                                                                     height="1em" fill="currentColor"
                                                                     aria-hidden="true">
																	<path
                                                                            d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
																	</path>
																	<path
                                                                            d="M623.6 316.7C593.6 290.4 554 276 512 276s-81.6 14.5-111.6 40.7C369.2 344 352 380.7 352 420v7.6c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V420c0-44.1 43.1-80 96-80s96 35.9 96 80c0 31.1-22 59.6-56.1 72.7-21.2 8.1-39.2 22.3-52.1 40.9-13.1 19-19.9 41.8-19.9 64.9V620c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8v-22.7a48.3 48.3 0 0 1 30.9-44.8c59-22.7 97.1-74.7 97.1-132.5.1-39.3-17.1-76-48.3-103.3zM472 732a40 40 0 1 0 80 0 40 40 0 1 0-80 0z">
																	</path>
																</svg>
															</i>
														</a>
													</th>
													<th class="text-cost-price">
														成本价
														<a>
															<i aria-label="图标: question-circle"
                                                               class="anticon anticon-question-circle">
																<svg viewBox="64 64 896 896" class=""
                                                                     data-icon="question-circle" width="1em"
                                                                     height="1em" fill="currentColor"
                                                                     aria-hidden="true">
																	<path
                                                                            d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
																	</path>
																	<path
                                                                            d="M623.6 316.7C593.6 290.4 554 276 512 276s-81.6 14.5-111.6 40.7C369.2 344 352 380.7 352 420v7.6c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V420c0-44.1 43.1-80 96-80s96 35.9 96 80c0 31.1-22 59.6-56.1 72.7-21.2 8.1-39.2 22.3-52.1 40.9-13.1 19-19.9 41.8-19.9 64.9V620c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8v-22.7a48.3 48.3 0 0 1 30.9-44.8c59-22.7 97.1-74.7 97.1-132.5.1-39.3-17.1-76-48.3-103.3zM472 732a40 40 0 1 0 80 0 40 40 0 1 0-80 0z">
																	</path>
																</svg>
															</i>
														</a>
													</th>
													<th class="text-right">
														销量
													</th>
												</tr>
											</thead>
											<tbody class="ant-table-tbody self_sku_detail_body">

											</tbody>
										</table>
									</div>
									<div class="ant-table-footer p-10 f-c" style="padding: 10px;">
										<span>
											批量设置：
										</span>
										<div class="mr-10">
											<span class="ant-input-group-wrapper" style="width: 150px;">
												<span class="ant-input-wrapper ant-input-group">
													<span class="ant-input-affix-wrapper">
														<input placeholder="价格" type="text" class="ant-input" value="">
														<span class="ant-input-suffix">
														</span>
													</span>
													<span class="ant-input-group-addon">
														<a>
															设置
														</a>
													</span>
												</span>
											</span>
										</div>
										<div class="mr-10">
											<span class="ant-input-group-wrapper" style="width: 150px;">
												<span class="ant-input-wrapper ant-input-group">
													<span class="ant-input-affix-wrapper">
														<input placeholder="库存" type="text" class="ant-input" value="">
														<span class="ant-input-suffix">
														</span>
													</span>
													<span class="ant-input-group-addon">
														<a>
															设置
														</a>
													</span>
												</span>
											</span>
										</div>
										<div class="mr-10">
											<span class="ant-input-group-wrapper" style="width: 150px;">
												<span class="ant-input-wrapper ant-input-group">
													<span class="ant-input-affix-wrapper">
														<input placeholder="成本价" type="text" class="ant-input" value="">
														<span class="ant-input-suffix">
														</span>
													</span>
													<span class="ant-input-group-addon">
														<a>
															设置
														</a>
													</span>
												</span>
											</span>
										</div>
										<label class="ant-checkbox-wrapper">
											<span class="ant-checkbox">
												<input type="checkbox" name="self_add_image" class="ant-checkbox-input"
                                                       value="">
												<span class="ant-checkbox-inner">
												</span>
											</span>
											<span>
												覆盖原有值
											</span>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</span>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/store/self.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/laravel-admin-ext/sk-image/plupload/plupload.full.min.js') }}"
        type="text/javascript"></script>