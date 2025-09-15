<?php

declare(strict_types=1);

namespace App\Model;

class MonitorLinkModel extends Model
{
    protected ?string $table = 'monitor_link';
    public ?string $connection = 'pg_default';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];

    public function getList(array $conditions, int $page, int $pageSize): array
    {
        $query = self::query();
        if (!empty($conditions['link_platform'])) {
            $query = $query->where('link_platform', $conditions['link_platform']);
        }
        $count = $query->count();
        if ($count == 0) {
            return [[], 0];
        }
        $list = $query->offset(($page - 1) * $pageSize)
            ->limit($pageSize)
            ->get();
        return [$list, $count];
    }
}
