<?php

declare(strict_types=1);

namespace App\Service\Api;

class ApiBaseService
{
    public function jcCallback()
    {
        if (empty($params['uk'])) {
            throw new \Exception("UniqueKey 参数缺失");
        }
        $mediaType = $params['media_type'] ?? 2;
        $transformType = intval($params['transformtype'] ?? 0);

        $eventType = $params['event_type'] ?? 'click';
        $callback = $params['callback'] ?? '';
        $batchId = BaseService::createBatchId();
        $res = self::addTaskLogTable(0, [
            'ad_click_id' => $params['ad_click_id'] ?? 0,
            'ocpx_platform' => OCPXPlatform::JC,
            'click_time' => intval($params['click_time'] ?? time()),
            'media_type' => $mediaType,
            'media_callback' => $callback,
            'transform_type' => $transformType,
            'pid' => $params['pid'] ?? '',
            'ad_site_id' => $params['ad_site_id'] ?? 0,
            'event_type' => self::EventType[$eventType] ?? 1,
            'uk' => $params['uk'],
        ], $batchId, 'jcConvertCallbackTask', '', self::$taskQueues);
        return $res ? ['success' => true, 'msg' => 'success'] : [];
    }
}