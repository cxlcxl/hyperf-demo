<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
class CommonController
{
    #[Inject]
    protected RequestInterface $request;

    #[Inject]
    protected ResponseInterface $response;

    #[RequestMapping(path: 'jc/callback', methods: 'get')]
    public function jcCallback()
    {
        $data = $this->request->all();
        $res = (new \App\Service\Api\ApiBaseService)->jcCallback($data);
        if (empty($res)) {
            return $this->response->json(["msg" => "error"]);
        }
        return $this->response->json(['Hello Hyperf!']);
    }
}
