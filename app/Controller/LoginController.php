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

use App\Service\JwtService;
use App\Service\LoginUserService;
use Exception;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

#[Controller(prefix: 'user')]
class LoginController extends AbstractController
{
    #[Inject]
    protected JwtService $jwtService;

    #[RequestMapping(path: 'login', methods: 'post')]
    public function login()
    {
        $data = $this->request->all();
        $validate = $this->v->make($data, [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
        ]);
        if ($validate->fails()) {
            return $this->fail($validate->errors()->first());
        }
        try {
            $loginUser = (new LoginUserService())->login($data['email'], $data['password']);

            // Generate JWT token
            $tokenPayload = [
                'id' => $loginUser['id'],
                'username' => $loginUser['username'] ?? $loginUser['email'],
                'email' => $loginUser['email'],
                'main_user_id' => $loginUser['main_user_id'],
                'login_time' => time(),
            ];

            $token = $this->jwtService->generateToken($tokenPayload, 1440); // 24 hours

            return $this->success([
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 1440 * 60, // seconds
            ]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    #[RequestMapping(path: 'refresh', methods: 'post')]
    public function refresh()
    {
        $authorization = $this->request->getHeaderLine('Authorization');

        if (empty($authorization) || ! str_starts_with($authorization, 'Bearer ')) {
            return $this->fail('Authorization header is required', 401);
        }

        $token = substr($authorization, 7);

        $newToken = $this->jwtService->refreshToken($token, 1440);

        if (! $newToken) {
            return $this->fail('Invalid or expired token', 401);
        }

        return $this->success([
            'token' => $newToken,
            'token_type' => 'Bearer',
            'expires_in' => 1440 * 60,
        ]);
    }
}
