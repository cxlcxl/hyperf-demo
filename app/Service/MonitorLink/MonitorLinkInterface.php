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

namespace App\Service\MonitorLink;

interface MonitorLinkInterface
{
    public function getLinkList(array $params, int $page, int $pageSize): array;

    public function exportLinkList(array $params): array;

    public function createLink(array $params): bool;

    public function updateLink(int $id, array $params): bool;

    public function deleteLink(int $id): bool;

    public function getLinkInfo(int $id): array;
}
