<?php

namespace App\Models;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use MaxMind\Db\Reader\InvalidDatabaseException;

/**
 * @property string $code
 * @property string $locale
 * @property string $name
 */
class Country extends Model
{
    use HasFactory;

    private static ?Country $_current = null;

    private static ?Collection $_countries = null;

    public static function getCurrent(): Country
    {
        if (self::$_current === null) {
            try {
                $reader = new Reader(resource_path('GeoLite2-Country.mmdb'));
                $c = $reader->country(request()->ip());
                self::setCurrent($c->country->isoCode, $c->country->name);
            } catch (AddressNotFoundException) {
                self::setCurrent('', 'Unknown');
            } catch (InvalidDatabaseException $e) {
                Log::error($e);
            }
        }
        return self::$_current;
    }

    public static function setCurrent(string $code, string $name)
    {
        if (self::$_current === null) {
            self::$_current = new Country();
            self::$_current->code = $code;
            self::$_current->locale = 'en';
            self::$_current->name = $name;
        }
    }

    /**
     * @return Country[]
     */
    public static function getAll() : Collection
    {
        if (self::$_countries === null) {
            self::$_countries = Country::orderBy('code', 'asc')->get();
        }
        return self::$_countries;
    }
}
