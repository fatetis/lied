<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Excels\Exports\Self\CouponBatchExcel;
use App\Exceptions\SelfException;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class DownLoadExcelController extends Controller
{

    public function outside($id)
    {
        try{
            switch ($id){
                case 1:
                    return Excel::download(new CouponBatchExcel, 'couponBatch.xlsx');
                    break;
            }
            throw new SelfException('找不到对应方法');
        }catch (SelfException $exception){
            return $exception->getMessage();
        }


    }

}
