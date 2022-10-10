<?php
/**
 * Created by PhpStorm.
 * User: simon <wu_mengmeng@foxmail.com>
 * Date: 2022/6/30 0030
 * Time: 18:00
 */

namespace SimonJWTToken\JWT;


class Payload extends Base
{

    private $ttl_time;//token有效期

    public function __construct()
    {
        parent::__construct();
        $this->ttl_time = $this->config['ttl'] * (60 * 60);
    }

    /**
     * base64 json转码
     *
     * @param $data
     *
     * @return mixed
     * @author simon <wu_mengmeng@foxmail.com>
     */
    private function base64_json_encode($data)
    {
        if(!is_array($data)){
            $this->error_msg = 'Data must be an array!';
            return false;
        }
        $result = str_replace('=', '', base64_encode(json_encode($data)));
        return $result;
    }

    /**
     * payload
     *
     * @param int $uid
     *
     * @return string
     * @author simon <wu_mengmeng@foxmail.com>
     */
    public function get_payload($uid = 0)
    {
        if($uid <= 0){
            $this->error_msg = 'uid cannot be less than 0';
            return false;
        }

        /* playload-header */
        $arr_data       = [
          'typ' => $this->config['typ'],//'simon-jwt-auth',
          'alg' => $this->config['algo'],
        ];
        $payload_header = $this->base64_json_encode($arr_data);
        if($payload_header === false){
            return false;
        }

        /* playload-claim */
        $now_time      = time();
        $arr_data      = [
          'iat' => $now_time,
          'exp' => $now_time + $this->ttl_time,
          'lft' => $this->ttl_time,
          'sub' => $uid,
        ];
        $payload_claim = $this->base64_json_encode($arr_data);
        if($payload_claim === false){
            return false;
        }

        /* playload */
        $payload = $payload_header . '.' . $payload_claim;
        return $payload;
    }


}