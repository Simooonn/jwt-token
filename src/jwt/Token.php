<?php
/**
 * Created by PhpStorm.
 * User: simon <wu_mengmeng@foxmail.com>
 * Date: 2022/6/30 0030
 * Time: 18:00
 */

namespace SimonJWTToken\JWT;

class Token extends Base
{
    private $new_payload,$new_sign,$token;
    private $error_msg = '';

    public function __construct()
    {
        parent::__construct();
        $this->new_sign             = new Sign();
        $this->new_payload          = new Payload();
    }


    /**
     *
     *
     * @return array|bool
     * @author simon <wu_mengmeng@foxmail.com>
     */
    private function arr_token()
    {
        $token = $this->get_token();
        if (empty($token)) {
            return false;
        }
        $arr_token = explode('.', $token);
        if (count($arr_token) != 3) {
            return false;
        }

        return $arr_token;
    }

    private function get_arr_claim()
    {
        $arr_token = $this->arr_token();
        $arr_claim = json_decode(base64_decode($arr_token[1]), true);

        return $arr_claim;
    }

    private function claim_lifetime()
    {
        $n_lifetime = $this->get_arr_claim()['lft'];
        return $n_lifetime;
    }

    private function claim_expiretime()
    {
        $n_expiretime = $this->get_arr_claim()['exp'];
        return $n_expiretime;
    }

    public function claim_user_id()
    {
        $uid = intval($this->get_arr_claim()['sub']);
        return $uid;
    }

    /**
     * 生成token
     *
     * @param int $uid
     *
     * @return string
     * @author simon <wu_mengmeng@foxmail.com>
     */
    public function create_token($uid = 0)
    {
        $uid = intval($uid);
        if($uid <= 0){
            $this->error_msg = 'uid cannot be less than 0';
            return false;
        }

        //payload data
        $payload   = $this->new_payload->get_payload($uid);
        if($payload === false){
            $this->error_msg = $this->new_payload->error_msg;
            return false;
        }

        //signature data
        $signature   = $this->new_sign->signature($payload);
        if($signature === false){
            $this->error_msg = $this->new_sign->error_msg;
            return false;
        }
        return $payload . '.' . $signature;
    }

    private function get_token()
    {

    }

    public function check_token()
    {
        $token = $this->get_token();
        if (empty($token)) {
            return false;
        }
        //对比数据，检查数据是否被篡改

        return true;
    }

    public function check_token_isexpire()
    {
        if (!$this->check_token()) {
            return false;
        }
        //对比数据，检查数据是否过期

        return true;
    }


    public function refresh_token(){
        //检查token是否合法
        if (!$this->check_token_isexpire()) {
            return false;
        }

        $uid    = $this->claim_user_id();
        $token = $this->create_token($uid);
        return $token;
    }









}
