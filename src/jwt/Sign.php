<?php
/**
 * Created by PhpStorm.
 * User: simon <wu_mengmeng@foxmail.com>
 * Date: 2022/6/30 0030
 * Time: 18:00
 */

namespace SimonJWTToken\JWT;

class Sign extends Base
{

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 算法加密
     *
     * @param string $sting
     *
     * @return string
     * @author simon <wu_mengmeng@foxmail.com>
     */
    public function signature($sting = '')
    {
        if(!is_string($sting)){
            $this->error_msg = 'Signature data must be a string!';
            return false;
        }
        if(strlen($sting) <= 0){
            $this->error_msg = 'Signature data cannot be empty!';
            return false;
        }
        $alg    = strtolower($this->config['algo']);
        $secret = $this->config['secret'];

        switch ($alg) {
            case 'hs256':
                $result = hash_hmac('sha256', $sting, $secret, true);
                break;
            default:
                $result = md5("{$secret}_{$sting}");
        }
        $result = str_replace('=', '', base64_encode($result));
        return $result;
    }


}