<?php
/**
 * Created by PhpStorm.
 * User: fatetis
 * Date: 2020/4/1 0001
 * Time: 17:33
 */

namespace App\Utils\Request;


use App\Exceptions\SelfException;
use GuzzleHttp\Client;

abstract class AbstractRequest
{

    /**
     * 获取请求url或者验签操作
     * @param string $alias 请求url参数
     * @param array $data
     * @return mixed
     * Author: fatetis
     * Date:2020/4/1 000118:21
     */
    abstract function getRequestUrl($alias, $data);

    /**
     * 进行请求数据
     * @param $method
     * @param $alias
     * @param array $data
     * @param array $options
     * @return mixed|string
     * @throws SelfException
     * Author: fatetis
     * Date:2020/4/1 000118:21
     */
    public function request($method, $alias, array $data = [], array $options = [])
    {
        try {
            $client = new Client();
            //请求头
            $headers = [
                'decode_content' => true,
                'Content-Type' => 'application/json;charset=utf-8',
            ];
            //请求选项
            $options = array_merge([
                'headers' => $headers,
                'verify' => false,
                'json' => $data,
                'timeout' => 15 //默认5秒超时
            ], is_array($options) ? $options : []);

            $alias_data = $this->getRequestUrl($alias, $data);
            if (empty($alias_data)) throw new SelfException('url别名不存在');

            $request_url = $alias_data['request_url'];
            $result = $client->request($method, $request_url, $options);
            $responseData = $result->getBody()->getContents();

            $responseData = jd($responseData);

            $this->requestLast($data, $responseData, $alias_data);

            $this->checkReqStatus($responseData);

            return $responseData;
        } catch (SelfException $wrongException) {
            throw new SelfException($wrongException->getMessage());
        } catch (\Throwable $throwable) {
            return $throwable->getMessage();
        }

    }

    /**
     * 对请求数据的后续处理
     * @param $res_data
     * @param $req_data
     * @param $alias_data
     * @return mixed
     * Author: fatetis
     * Date:2020/4/1 000118:26
     */
    abstract function requestLast($res_data, $req_data, $alias_data);

    /**
     * 验证数据返回状态是否正确
     * @param $req_data
     * @return mixed
     * Author: fatetis
     * Date:2020/4/1 000118:26
     */
    abstract function checkReqStatus($req_data);

}