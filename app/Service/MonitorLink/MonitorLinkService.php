<?php

declare(strict_types=1);

namespace App\Service\MonitorLink;

use App\Model\MonitorLinkModel;
use App\Service\BaseService;

class MonitorLinkService extends BaseService implements MonitorLinkInterface
{
    public function getLinkList(array $params, int $page, int $pageSize): array
    {
        [$list, $count] = (new MonitorLinkModel())->getList($params, $page, $pageSize);
        return $this->page($list, $count, $page, $pageSize);
    }

    public function exportLinkList(array $params): array
    {
        // TODO: Implement exportLinkList() method.
    }

    public function createLink(array $params): bool
    {
        // TODO: Implement createLink() method.
    }

    public function updateLink(int $id, array $params): bool
    {
        // TODO: Implement updateLink() method.
    }

    public function deleteLink(int $id): bool
    {
        // TODO: Implement deleteLink() method.
    }

    public function getLinkInfo(int $id): array
    {
        // TODO: Implement getLinkInfo() method.
    }
}
