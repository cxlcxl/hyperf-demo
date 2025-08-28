<?php
declare(strict_types=1);

namespace App\Service;

interface LoginUserInterface
{
    public function userId(): int;

    public function mainUserId(): int;

    public function username(): string;

    public function userInfo(): array;
}