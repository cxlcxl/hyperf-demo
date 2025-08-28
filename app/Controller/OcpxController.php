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

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

#[Controller(prefix: 'ocpx')]
class OcpxController extends AbstractController
{
    #[RequestMapping(path: 'callback', methods: 'get')]
    public function callback()
    {
        return $this->success([
            'a' => $this->loginUser->userId(),
            'b' => '萨德法撒旦法撒旦法三的',
        ]);
    }
}
