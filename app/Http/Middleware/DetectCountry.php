<?php

namespace App\Http\Middleware;

use App\Models\Country;
use Closure;
use GeoIp2\Exception\AddressNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Symfony\Component\HttpFoundation\Response;
use GeoIp2\Database\Reader;

class DetectCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $reader = new Reader(resource_path('GeoLite2-Country.mmdb'));
            $c = $reader->country($request->ip());
            Country::setCurrent($c->country->isoCode, $c->country->name);
        } catch (AddressNotFoundException) {
            Country::setCurrent('', 'Unknown');
        } catch (InvalidDatabaseException $e) {
            Log::error($e);
        }

        return $next($request);
    }
}
