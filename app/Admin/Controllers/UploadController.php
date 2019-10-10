<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        ini_set('display_errors', 1);
        $path = $request->input('upload_url','');

        try{
            $file_key = key($request->file());
            if ($request->file($file_key)->isValid()){

                $file_extension = $request->$file_key->extension();
                $filename = randStr(). "." . $file_extension;

                $filepath = urlStandard('skimage').'/';
                if (!empty($path)){
                    $filepath = $path.'/';
                }

                if (!Storage::exists($filepath)) {
                    $aa = Storage::makeDirectory($filepath);
                }
                $savepath =  $filepath . $filename;

                $bool = Storage::put($savepath,file_get_contents($request->$file_key->getRealPath()));//上传

                if($bool){

                    //skimage图片form组件
                    $data = $savepath;

                    $src = Storage::url($savepath);

                    return [
                        "uploaded" => true,
                        "fileName" => $filename,
                        "url" => $data ?? '',
                        "src" => $src,
                        "error" => [
                            "message" => ''
                        ]
                    ];
                }else{
                    throw new \Exception('alioss上传错误');
                }



            }else{
                return [
                    "uploaded" => false,
                    "fileName" => '',
                    "url" => '',
                    "error" => [
                        "message" => '上传出错！'
                    ]
                ];
            }
        }catch(\Exception $e){

            return [
                "uploaded" => false,
                "fileName" => '',
                "url" => '',
                "error" => [
                    "message" => '上传出错！'.$e->__toString()
                ]
            ];
        }
    }
}
