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

use App\Service\LoginUserInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected RequestInterface $request;

    #[Inject]
    protected ResponseInterface $response;

    #[Inject]
    protected LoginUserInterface $loginUser;

    #[Inject]
    protected ValidatorFactoryInterface $v;

    public function success(array $data, string $msg = 'success'): \Psr\Http\Message\ResponseInterface
    {
        return $this->response->json([
            'code' => 0,
            'request_id' => '',
            'msg' => $msg,
            'data' => $data,
        ]);
    }

    public function fail(string $msg, int $code = -1, $data = null): \Psr\Http\Message\ResponseInterface
    {
        return $this->response->json([
            'code' => $code,
            'request_id' => '',
            'msg' => $msg,
            'data' => $data,
        ]);
    }
}
