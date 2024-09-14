<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @property string $maintenance_to
 * @property string $maintenance_message
 */
class Config extends Model
{
    protected $table = 'config';

    public $timestamps = false;

    private static ?Config $_maintenance = null;
    private static bool $_maintenanceFetched = false;

    public function getMaintenanceToAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i');
    }

    public static function setMaintenance(string $to, string $message)
    {
        Config::query()->delete();
        $config = new Config();
        $config->maintenance_to = $to;
        $config->maintenance_message = $message;
        $config->save();
    }

    public static function getMaintenance(): Config|null
    {
        if (!self::$_maintenanceFetched) {
            self::$_maintenance = Config::where('maintenance_to', '>', DB::raw('NOW()'))->first();
            self::$_maintenanceFetched = true;
        }
        return self::$_maintenance;
    }
}
