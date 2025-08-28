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

namespace App\Service;

use App\Model\AdminUserModel;
use Exception;

class LoginUserService implements LoginUserInterface
{
    private array $loginUser = [];

    public function set(?array $loginUser = null): void
    {
        if (! is_null($loginUser)) {
            $this->loginUser = $loginUser;
        }
    }

    public function userId(): int
    {
        return $this->loginUser['id'] ?? 0;
    }

    public function mainUserId(): int
    {
        return $this->loginUser['main_user_id'] ?? 0;
    }

    public function username(): string
    {
        return $this->loginUser['username'] ?? '';
    }

    public function userInfo(): array
    {
        return $this->loginUser;
    }

    /**
     * @throws Exception
     */
    public function login(string $email, string $password): array
    {
        $user = AdminUserModel::where('email', $email)->first();
        if (empty($user)) {
            throw new Exception('用户不存在');
        }

        if ($this->encodePassword($password) !== $user->password) {
            throw new Exception('密码错误');
        }

        if ($user->state !== 1) {
            throw new Exception('账号已被锁定');
        }

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'main_user_id' => $user->main_user_id,
        ];
    }

    public function encodePassword($originalPassword): string
    {
        return md5(md5($originalPassword));
    }
}
