<?php
namespace App\Admin\Extensions\Model;

use App\Models\Users;
use Illuminate\Contracts\Support\Renderable;

class OrderBaseModal implements Renderable
{
    public function render($key = null)
    {
        dump(12312);
         return (Users::find($key)->toArray());
    }
}
