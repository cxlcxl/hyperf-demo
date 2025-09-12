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

#[Controller(prefix: 'monitor-link')]
#[Middleware(LoginAuthMiddleware::class)]
class MonitorLinkController extends AbstractController
{
    #[RequestMapping(path: 'jd-list', methods: 'get')]
    public function JDLinkList()
    {
        return $this->success([
            'a' => $this->loginUser->userId(),
            'b' => '萨德法撒旦法撒旦法三的',
        ]);
    }
}
