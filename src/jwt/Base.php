<?php
/**
 * Created by PhpStorm.
 * User: simon <wu_mengmeng@foxmail.com>
 * Date: 2022/6/30 0030
 * Time: 18:00
 */

namespace SimonJWTToken\JWT;

class Base
{

    protected $error_msg = '';

    protected $config;

    protected function __construct()
    {
        $this->config = [
            'ttl'=>2 * 24,
            'typ'=>'simon-jwt-token',
            'algo'=>'hs256',//Currently, only hs256 is supported.
            'secret'=>env('simon_jwt_secret') ?? '972a58f4f6e0b5f93a02711342fa6d5f',
            'typ'=>'aaa',
            'typ'=>'aaa',
        ];
    }

}