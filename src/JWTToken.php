<?php
/**
 * Created by PhpStorm.
 * User: simon <wu_mengmeng@foxmail.com>
 * Date: 2022/6/30 0030
 * Time: 18:00
 */

namespace SimonJWTToken;
use SimonJWTToken\JWT\Token;

class JWTToken
{
    private $new_token;
    public function __construct()
    {
        $this->new_token = new Token();
    }

    /**
     * create token
     *
     * @return mixed
     * @author simon <wu_mengmeng@foxmail.com>
     */
    public function createToken($uid = 0)
    {
        return $this->new_token->create_token($uid);
    }

    /**
     * 刷新token
     *
     * @return mixed
     * @author simon <wu_mengmeng@foxmail.com>
     */
    public function refreshToken()
    {
        return $this->new_token->refresh_token();
    }

    /**
     * 检测登录状态
     *
     * @return bool
     * @author simon <wu_mengmeng@foxmail.com>
     */
    public function checkToken()
    {
        return $this->new_token->check();
    }

    /**
     * 获取用户id
     *
     * @return int|null
     * @author simon <wu_mengmeng@foxmail.com>
     */
    public function userId()
    {
        return $this->model_jwt->user_id();

    }

    /**
     * 获取用户信息
     *
     * @return mixed|null
     * @author simon <wu_mengmeng@foxmail.com>
     */
    public function user()
    {
        return $this->model_jwt->user();
    }


}