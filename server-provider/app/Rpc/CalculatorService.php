<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-11-20 04:37
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

namespace App\Rpc;

use Hyperf\RpcServer\Annotation\RpcService;
use Pudongping\JsonRpc\Contract\CalculatorServiceInterface;

/**
 * @RpcService(name="AlexCalculatorService", protocol="jsonrpc-http", server="alex-jsonrpc-http", publishTo="consul")
 *
 * Class CalculatorService
 * @package App\Grpc
 */
class CalculatorService implements CalculatorServiceInterface
{

    /**
     * 实现一个加法运算
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    /**
     * 实现一个减法运算
     *
     * @param int $a
     * @param int $b
     * @return int
     */
    public function minus(int $a, int $b): int
    {
        return $a - $b;
    }

}