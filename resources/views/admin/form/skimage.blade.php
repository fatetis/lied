<link rel="stylesheet" href="{{ asset('vendor/laravel-admin-ext/sk-image/skimage_style.css') }}">
{{--lightbox2 灯箱--}}
<link rel="stylesheet" href="{{ asset('vendor/laravel-admin-ext/lightbox/lightbox/lightbox.min.css') }}">
<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">
    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        @if(strpos($attributes, 'images') === false)
            <?php
            $all_path = old($id, $value) ? old($id, $value) : '';
            $resize_path = old($id, $value) ? old($id, $value) : '';
            ?>
            <div class="show_upload_pic_item">
                <img style="width: 80%;height: 80%" data-multi="" id="{{$id}}_alioss_upload" class="Js_alioss_btn admin_form_sk-image" src="/images/static/loading.png"
                     data-original="{{$resize_path ? $resize_path : '/vendor/laravel-admin-ext/sk-image/pic_add.png'}}" {!! $attributes !!}>
                <div class="operat_warp" @if(old($id, $value)) style="display: inline-block;" @endif>
                    <input type="hidden" name="{{$id}}" value="{{old($id, $value)}}">
                    <a href="{{$all_path}}" target="_blank">预览</a>
                    / <a href="javascript:void(0);" data-filename="" onclick="alioss_del_file(this,0)">删除</a>
                </div>
                <div id="{{$id}}_container"></div>
            </div>
        @else
            <button id="{{$id}}_alioss_upload" type="button" class="btn btn-success btn-flat Js_alioss_btn" {!! $attributes !!}>
                选择文件
            </button>
            <div class="box box-widget">
                <!-- /.box-header -->
                <div id="{{$id}}_container" class="box-body show_upload_pic">
                    @if(old($id, $value))
                        @if(is_array(old($id, $value)))
                            @foreach(old($id, $value) as $p)
                                <div class="show_upload_pic_item">
                                    <img src="{{ asset($p) }}" data-original="{{asset($p)}}" style="margin-bottom: 3px;width: 80%;height: 80%" >
                                    <div class="operat_warp" style="display: inline-block">
                                        <input type="hidden" name="{{$id}}[]" value="{{$p}}">
                                        <a class='example-image-link ' href="{{asset($p)}}" data-lightbox='example-set' data-title=''>预览</a>
                                        / <a href="javascript:void(0);" onclick="alioss_del_file(this,1,true)" data-filename="{{$p}}">删除</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="show_upload_pic_item">
                                <img src="{{ route('getMedia', old($id, $value)) }}" data-original="{{ route('getMedia', old($id, $value)) }}" style="margin-bottom: 3px;width: 80%;height: 80%" >
                                <div class="operat_warp" style="display: inline-block">
                                    <input type="hidden" name="{{$id}}" value="{{old($id, $value)}}">
                                    <a class='example-image-link ' href="{{route('getMedia', old($id, $value))}}" data-lightbox='example-set' data-title=''>预览</a>
                                    / <a href="javascript:void(0);" onclick="alioss_del_file(this,1,true)" data-filename="{{old($id, $value)}}">删除</a>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
        @endif
        @include('admin::form.help-block')
    </div>
</div>
<script src="{{ asset('vendor/laravel-admin-ext/sk-image/Sortable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/laravel-admin-ext/sk-image/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/laravel-admin-ext/sk-image/alioss.js') }}" type="text/javascript"></script>
{{--lightbox2 灯箱--}}
<script src="{{ asset('vendor/laravel-admin-ext/lightbox/lightbox/lightbox.min.js') }}" type="text/javascript"></script>
