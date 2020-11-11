<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Settings
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $pagination = (int) DB::table('settings')->where('key', 'pagination')->first()->value;
        $timeZone = DB::table('settings')->where('key', 'time_zone')->first()->value;

        Config::set('settings.pagination', $pagination);
        Config::set('app.timezone', $timeZone);

        return $next($request);
    }
}
