<?php
/**
 *  author:fatetis
 *  time:2019-0108 16:26
 */
namespace App\Services;


abstract class BaseService
{

    protected $table;

    /**
     * 以id查询单条数据,查询失败报错
     * @param $id array|string
     * @return mixed
     */
    private function findOrFail($id)
    {
        return $this->table::findOrFail($id);
    }
    /**
     * 以id查询单条数据
     * @param $id array|string
     * @return mixed
     */
    private function find($id)
    {
        return $this->table::find($id);
    }

    /**
     * 以id查询单条数据,查询失败报错
     * @param $id array|string
     * @return mixed
     */
    private function firstOrFail($id)
    {
        return $this->table::firstOrFail($id);
    }

    /**
     * 简单查询单条数据
     * @param $where array
     * @return mixed
     */
    private function first($where)
    {
        return $this->table::where($where)->first();
    }

    /**
     * 插入数据
     * @param $parameter array
     * @return mixed
     */
    private function create($parameter)
    {
        return $this->table::create($parameter);
    }

    /**
     * 条件插入记录，若无插入，有返回
     * @param $where array
     * @param $parameter array
     * @return mixed
     */
    private function firstOrCreate($where, $parameter)
    {
        return $this->table::firstOrCreate($where, $parameter);
    }

    /**
     * 条件插入记录，若无插入，有返回
     * @param $where array
     * @param $parameter array
     * @return mixed
     */
    private function updateOrCreate($where, $parameter)
    {
        return $this->table::updateOrCreate($where, $parameter);
    }

    /**
     * 判断模型数据是否有效 依is_show来判断
     * @param $id string|array
     * @param $isAudit bool 可选是否加审核条件判断
     * @return bool
     */
    private function checkModelDataById($id, $isAudit = false)
    {
        $where['is_show'] = 1;
        if($isAudit){
            $where['is_audit'] = 1;
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

    private function get($where=[], $orderBy = [], $groupBy = [], $select = '')
    {
        $sql = $this->table::query();
        if(!empty($where))
            $sql->where($where);
        if(!empty($orderBy)){
            collect($orderBy)->filter(function($value,$key) use ($sql){
                $sql->orderBy($key,$value);
            });
        }
        if(!empty($groupBy)){
            collect($groupBy)->filter(function($value,$key) use ($sql){
                $sql->groupBy($key,$value);
            });
        }
        if(!empty($select))
            $sql->select($select);
        return $sql->get();
    }

    private function pluck($key, $value)
    {
        return $this->query()->pluck($key, $value);
    }

    private function whereIn($key, $value)
    {
        return $this->query()->whereIn($key, $value);
    }

    private function where($where)
    {
        return $this->query()->where($where);
    }

    private function toArray()
    {
        return $this->table::toArray();
    }

    private function query()
    {
        return $this->table::query();
    }

    private function with($key, $fuc)
    {
        return $this->table::query()->with($key, $fuc);
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
