<?php

namespace App\Helpers;

use App\Enums\Gender;
use Illuminate\Support\Facades\DB;

class Statistics
{
    /**
     * @param int $lastDaysCount
     * @param Gender $gender
     * @return array ['2023-09-14' => 1, '2023-09-15' => 0, ...]
     */
    public static function getRegisteredUsersCount(int $lastDaysCount, Gender $gender): array
    {
        if ($lastDaysCount < 1) $lastDaysCount = 1;
        $data = DB::select("
            WITH recursive date_ranges AS (
                select cast(NOW() - interval ? day as Date) as d
                union all select d + interval 1 day from date_ranges
                where d < cast(NOW() as Date)
            )
            SELECT
                GROUP_CONCAT(f.total separator ',') AS data
            FROM (
                    SELECT 1 as id, CONCAT(d, '=', (
                        select COUNT(*)
                        from users
                        where gender = ? AND CAST(created_at as Date) = d)
                    ) AS total
                    FROM date_ranges
                    GROUP BY CAST(d AS Date)
                    ORDER BY d ASC
                ) as f
            group by f.id
            LIMIT 1",
            [$lastDaysCount - 1, $gender->value]
        );
        $res = array_map(function($item) {
            $i = explode('=', $item);
            return [$i[0] => intval($i[1])];
        }, explode(',', is_array($data) && count($data) > 0 ? $data[0]->data : ''));

        usort($res, function($a, $b) { return array_key_first($a) > array_key_first($b); });

        return $res;
    }


    /**
     * @param Gender $gender
     * @return int
     */
    public static function getTotalRegisteredUsersCount(Gender $gender): int
    {
        $data = DB::select("SELECT COUNT(*) AS c FROM users WHERE gender = ?", [$gender->value]);
        return is_array($data) && count($data) > 0 ? $data[0]->c : 0;
    }
}
