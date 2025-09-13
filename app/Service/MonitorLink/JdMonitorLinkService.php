<?php

declare(strict_types=1);

namespace App\Service\MonitorLink;

use App\Constants\LinkPlatform;

class JdMonitorLinkService extends MonitorLinkService
{
    public function linkList(array $params, int $page, int $pageSize): array
    {
        $conditions = [
            'link_platform' => LinkPlatform::JD,
            'link_name' => $params['link_name'],
            'advertiser_id' => $params['advertiser_id'],
            'jd_task_id' => $params['jd_task_id'],
            'media_type' => $params['media_type'],
            'promotion_type' => $params['promotion_type'],
            'sku_id' => $params['sku_id'],
            'is_export' => $params['is_export'],
            'link_ids' => $params['link_ids'],
            'link_type' => $params['link_type'],
        ];
        return $this->getLinkList($conditions, $page, $pageSize);
    }
}
