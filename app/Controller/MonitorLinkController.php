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
use App\Service\MonitorLink\JdMonitorLinkService;
use Exception;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;

#[Controller(prefix: 'monitor-link')]
#[Middleware(LoginAuthMiddleware::class)]
class MonitorLinkController extends AbstractController
{
    #[RequestMapping(path: 'jd-list', methods: 'POST')]
    public function jdLinkList()
    {
        try {
            $params = $this->request->post('conditions', []);
            $page = $this->request->post('page', 1);
            $pageSize = $this->request->post('page_size', 20);
            $result = (new JdMonitorLinkService())->linkList($params, $page, $pageSize);
            return $this->success($result);
        } catch (Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
}
