<?php
/**
 * Created by PhpStorm.
 * User: fatetis
 * Date: 2019/7/5 0005
 * Time: 14:06
 */

namespace App\Admin\Extensions\Excels\Exports\Self;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CouponBatchExcel implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            '#',
            'Date',
        ];
    }

    public function collection()
    {
        return Product::query();
    }

}
