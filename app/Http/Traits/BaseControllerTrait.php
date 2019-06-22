<?php

namespace App\Http\Controllers\Traits;

trait BaseControllerTrait{

    protected function successJson($msg = '',$data = [],$url = ''){
        return response()->json([
            'status'=>200,
            'msg'=>$msg,
            'data'=>$data,
            'url'=>$url
        ]);
    }

    protected function errorJson($msg = '',$data = [],$url = ''){
        return response()->json([
            'status'=>400,
            'msg'=>$msg,
            'data'=>$data,
            'url'=>$url
        ]);
    }
    
    /**
     * 上传文件
     * @params $file source 文件资源
     * @params $path string 上传路径 uploads/$path
     * @params $accept string 文件可上传类型
     * @return array
     */
    protected function uploadImg($file, $path='images', $accept='*') {
        //文件后缀白名单
        switch ($accept) {
            case 'image':
                $white = ['bmp', 'png', 'jpg', 'jpeg', 'gif'];
                break;
            default:
                $white = [];
                break;
        }
        
        try{
            if ($file->isValid()){
                //文件后缀
                $file_extension = $file->extension();
                //验证文件类型
                if ($accept != '*' && !empty($white) && !in_array($file_extension, $white)) {
                    return [
                        "uploaded" => false,
                        "fileName" => '',
                        "path" => '',
                        "url" => '',
                        "error" => [
                            "message" => '非法文件类型'
                        ]
                    ];
                }
                
                //文件名
                $file_name = md5(uniqid(rand())).".".$file_extension;
                //上传
                $store_path = $file->storeAs($path, $file_name, 'admin');
                //预览路径
                $previewname = asset('uploads/' . $store_path);
                
                return [
                    "uploaded" => true,
                    "fileName" => $file_name,
                    "path" => $store_path,
                    "url" => $previewname,
                    "error" => [
                        "message" => ''
                    ]
                ];

            }else{
                return [
                    "uploaded" => false,
                    "fileName" => '',
                    "path" => '',
                    "url" => '',
                    "error" => [
                        "message" => '上传出错！'
                    ]
                ];
            }
        }catch(WrongException $e){
            return [
                "uploaded" => false,
                "fileName" => '',
                "path" => '',
                "url" => '',
                "error" => [
                    "message" => '上传出错！'.$e->__toString()
                ]
            ];
        }
    }
}
