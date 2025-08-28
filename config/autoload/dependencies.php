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

use App\Service\LoginUserInterface;
use App\Service\LoginUserService;
use App\Service\JwtService;

return [
    LoginUserInterface::class => LoginUserService::class,
    JwtService::class => JwtService::class,
];
