<?php
/**
 * Created by PhpStorm.
 * User: Windows7
 * Date: 2019/7/6 0006
 * Time: 9:53
 */

namespace App\Admin\Extensions\Actions;

use Encore\Admin\Admin;

class CouponBatchAction
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        $url = route('downLoadExcel');
        return <<<SCRIPT

$('.grid-check-row').on('click', function () {
    $(this).attr('disabled',true);
    var id = $(this).data('id');
    $.get(
        "{$url}",
        {id:id,type:1},
        function(d){
                    $('.grid-check-row').attr('disabled',false);

        console.log(d);return;
            $.pjax.reload('#pjax-container');
            $('.grid-check-row').attr('disabled',false);
            if(d.status == 'SSSSSSSS'){
                swal(d.message, '', 'success');
            }else{
                swal(d.message, '', 'error');
            }
        })

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());
        return "<a class='fa fa-download grid-check-row' data-id='{$this->id}'></a>";
    }

    public function __toString()
    {
        return $this->render();
    }

}
