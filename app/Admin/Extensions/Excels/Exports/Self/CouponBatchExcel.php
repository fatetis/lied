<?php
/**
 * Created by PhpStorm.
 * User: fatetis
 * Date: 2019/7/5 0005
 * Time: 14:06
 */

namespace App\Admin\Extensions\Excels\Exports\Self;

use App\Exceptions\SelfException;
use App\Models\CouponsBatch;
use App\Models\CouponsOffline;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CouponBatchExcel implements FromCollection,WithHeadings
{

    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function headings(): array
    {
        return [
            '线下券名称',
            '券码',
        ];
    }

    public function collection()
    {
        $data = [];
        $arr = [];
        $result = CouponsBatch::where(['id' => $this->id])->first();
        $offlineCount = CouponsOffline::where(['coupon_batch_id' => $this->id])->count();
        if(!$result) throw new SelfException('线下券数据不存在');
        if($offlineCount >= $result['num']){
            throw new SelfException('此线下券已达最大生成数量');
        }
        //生成券码
        for($i=$offlineCount;$i<$result['num'];$i++){
            $code = $this->createCodeToCouponOffline($result['id'],$i);
            $arr[$i] = ['coupon_batch_id' => $result['id'], 'code' => $code, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
            $data[$i][] = [$result['name'],$code];
        }
        //插入数据
        $insertResult = CouponsOffline::insert($arr);
        if($insertResult){
            return new Collection($data);
        }else{
            throw new SelfException('数据已生成，但导出excel失败');
        }

    }

    /**
     * 8位数券码生成
     * @param $id
     * @param $i
     * @return bool|string
     * Author: fatetis
     * Date:2019/7/10 001011:15
     */
    protected function createCodeToCouponOffline($id, $i)
    {
        $str = $id.$i;
        $num = mb_strlen($str);
        return getARandLetter(8-$num,$str);
    }

}
