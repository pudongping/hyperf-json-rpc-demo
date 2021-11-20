<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-11-20 05:01
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

return [
    'enable' => [
        // 开启服务发现
        'discovery' => true,
        // 开启服务注册
        'register' => true,
    ],
    // 服务消费者相关配置
    'consumers' => [],
    // 服务提供者相关配置
    'providers' => [],
    // 服务驱动相关配置
    'drivers' => [
        'consul' => [
            'uri' => env('CONSUL_RIGISTRY', 'http://127.0.0.1:8500'),
            'token' => '',
            'check' => [
                'deregister_critical_service_after' => '90m',
                'interval' => '1s',
            ],
        ],
    ],
];