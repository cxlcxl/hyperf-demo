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

namespace App\Middleware;

use App\Service\JwtService;
use App\Service\LoginUserInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginAuthMiddleware implements MiddlewareInterface
{
    protected ContainerInterface $container;

    protected RequestInterface $request;

    protected HttpResponse $response;

    #[Inject]
    protected JwtService $jwtService;

    #[Inject]
    protected LoginUserInterface $loginUser;

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorization = $this->request->getHeaderLine('Authorization');
        if (empty($authorization)) {
            return $this->unauthorizedResponse('Authorization header is required');
        }

        // Extract token from "Bearer {token}" format
        if (! str_starts_with($authorization, 'Bearer ')) {
            return $this->unauthorizedResponse('Authorization header must be Bearer token');
        }

        $token = substr($authorization, 7);
        if (empty($token)) {
            return $this->unauthorizedResponse('Token is required');
        }

        // Validate token
        if (! $this->jwtService->isValid($token)) {
            return $this->unauthorizedResponse('Invalid or expired token');
        }

        $claims = $this->jwtService->getAllClaims($token);
        $this->loginUser->set($claims);

        return $handler->handle($request);
    }

    protected function unauthorizedResponse(string $message): ResponseInterface
    {
        return $this->response->json([
            'code' => 401,
            'msg' => $message,
            'data' => null,
        ])->withStatus(401);
    }
}
