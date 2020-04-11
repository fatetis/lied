<?php
/**
 * Created by PhpStorm.
 * User: fatetis
 * Date: 2020/4/1 0001
 * Time: 15:55
 */

namespace App\Utils\Request;


use App\Exceptions\SelfException;

class RequestService extends AbstractRequest
{

    protected $imessage_model;

    protected $request_url;

    const POST = 'POST';

    const GET = 'GET';

    const OK = '20000';

    // 请求数据的url别名
    const REQ_URL_FIELDS = array(
        'user_register',
        'user_save_password',
        'user_modify_mobile',
        'user_update_password',
    );

    // 接收数据的url别名
    const RES_URL_FIELDS = array(
        ''
    );

    public function __construct()
    {
        $this->imessage_model = new InternalMessageLog();
        $this->setRequestUrl();
    }


    protected function setRequestUrl()
    {
        $this->request_url = [
            'user_register' => [
                'url' => 'user/add_account',
                'type' => $this->imessage_model::YHZX_USER_REGISTER,
            ],
            'user_save_password' => [
                'url' => 'user/update_password',
                'type' => $this->imessage_model::YHZX_USER_SAVEPASSWORD
            ],
            'user_modify_mobile' => [
                'url' => 'user/modify_mobile',
                'type' => $this->imessage_model::YHZX_USER_MODIFY_MOBILE
            ],
            'user_update_password' => [
                'url' => 'user/update_password',
                'type' => $this->imessage_model::YHZX_USER_UPDATE_PASSWORD
            ],
        ];

    }

    public function getRequestUrl($key, $data)
    {
        $result = isset($this->request_url[$key]) ? array_merge([
            'request_url' => env('UCENTER_URL') . '/api/' . $this->request_url[$key]['url'],
            'request_system_type' => in_array($key, self::REQ_URL_FIELDS) ? $this->imessage_model::BKQWMALL : $this->imessage_model::BKQWYHZX,
            'reponse_system_type' => in_array($key, self::RES_URL_FIELDS) ? $this->imessage_model::BKQWYHZX : $this->imessage_model::BKQWMALL,
        ], $this->request_url[$key]) : [];
        return $result;
    }

    public function requestLast($res_data, $req_data, $alias_data)
    {

        $result = $this->imessage_model->query()->create([
            'request_data' => json_encode($res_data, JSON_UNESCAPED_UNICODE),
            'reponse_data' => json_encode($req_data, JSON_UNESCAPED_UNICODE),
            'request_system_type' => $alias_data['request_system_type'],
            'reponse_system_type' => $alias_data['reponse_system_type'],
            'type' => $alias_data['type']
        ]);
        if (empty($result)) {
            throw new WrongException('请求日志记录失败');
        }

    }

    public function checkReqStatus($responseData)
    {

        if (!isset($responseData['status']) || $responseData['status'] != self::OK) {
            throw new WrongException($responseData['msg'] ?? '请求失败，未知原因');
        }

    }


}