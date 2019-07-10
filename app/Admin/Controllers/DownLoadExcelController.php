<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Excels\Exports\Self\CouponBatchExcel;
use App\Exceptions\SelfException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DownLoadExcelController extends Controller
{

    public function outside(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        try{
            switch ($type){
                case 1:
                    return Excel::download(new CouponBatchExcel($id), 'couponBatch.xlsx');
                    break;
            }
            throw new SelfException(r('DLE001'));
        }catch (SelfException $exception){
            $msg = $exception->getMessage();
            elog($msg.'参数为'.$id);
            return abort('403', $msg);
        }
//        finally {
//            elog($exception->getMessage().'参数为'.$id);
//        }

    }

}
