<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-11-20 05:04
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Pudongping\JsonRpc\Contract\CalculatorServiceInterface;

return [
    'consumers' => [
        [
            'name' => 'AlexCalculatorService',
            'service' => CalculatorServiceInterface::class,
            // 如果没有将服务提供者注册到服务中心，那么则需要开启 nodes 节点
            // 'nodes' => [
            //     ['host' => env('JSON_RPC_PROVER_BASE_URL', '127.0.0.1'), 'port' => (int)env('JSON_RPC_PROVER_BASE_URL_PORT', 9512)],
            // ],
            'registry' => [
                'protocol' => 'consul',
                'address' => env('CONSUL_RIGISTRY', 'http://127.0.0.1:8500'),
            ],
        ],
    ],
];