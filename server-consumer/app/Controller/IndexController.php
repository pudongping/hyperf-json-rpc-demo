<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use Pudongping\JsonRpc\Contract\CalculatorServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController()
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{

    /**
     * @Inject
     * @var CalculatorServiceInterface
     */
    protected $calculatorService;

    public function index()
    {

        // var_dump('首页');

    }

    public function test()
    {
        $add = $this->calculatorService->add(2, 3);
        var_dump('测试加法 ====> ', $add);

        $minus = $this->calculatorService->minus(2, 3);
        var_dump('测试减法 ====> ', $minus);
    }

}
