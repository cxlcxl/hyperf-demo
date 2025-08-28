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

use App\Middleware\LoginAuthMiddleware;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;

#[Controller(prefix: 'user')]
#[Middleware(LoginAuthMiddleware::class)]
class UserController extends AbstractController
{
    #[RequestMapping(path: 'profile', methods: 'get')]
    public function profile()
    {
        return $this->success([$this->loginUser->userInfo()]);
    }
}
