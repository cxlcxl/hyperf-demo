<?php

declare(strict_types=1);

namespace App\Model;

class AdminUserModel extends Model
{
    public ?string $table = 'admin_user';
    public ?string $connection = 'pg_default';
}