<?php
/**
 *  author:fatetis
 *  time:2019-0108 16:26
 */
namespace App\Services;

abstract class BaseService
{

    protected $table;

    const YES = 1;

    /**
     * 判断模型数据是否有效 依is_show来判断
     * @param $id string|array
     * @param $isAudit bool 可选是否加审核条件判断
     * @return bool
     */
    private function checkModelDataById($id, $isAudit = false)
    {
        $where['is_show'] = self::YES;
        if($isAudit){
            $where['is_audit'] = self::YES;
        }
        $query = $this->table::where($where);
        if(is_array($id)){
            $result = $query->whereIn('id', $id)->get();
            return $result->isEmpty() ? false : $result;
        }else{
            $result = $query->where('id',$id)->first();
            return $result ? $result : false;
        }

    }


    /**
     * user: fatetis
     * __call,__callStatic是为了service层之间能静态调用方法
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

}
