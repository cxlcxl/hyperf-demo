<?php

declare(strict_types=1);

namespace App\Service;

class BaseService
{
    protected function page(array $list, int $count, int $page, int $pageSize): array
    {
        $pageInfo = [
            'total' => $count,
            'page' => $page,
            'page_size' => $pageSize,
            'total_page' => $count == 0 ? 0 : ceil($count / $pageSize),
        ];
        return [
            'list' => $list,
            'page_info' => $pageInfo,
        ];
    }

    protected function offset(int $page, int $pageSize): int
    {
        return ($page - 1) * $pageSize;
    }
}
