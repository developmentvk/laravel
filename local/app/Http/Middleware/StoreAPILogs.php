<?php

namespace App\Http\Middleware;

use Closure;

class StoreAPILogs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public $start, $end;

    public function handle($request, Closure $next)
    {
        $authorization = $request->header('Authorization');
        $this->start = microtime(true);
        $url      = $request->fullUrl();
        $method   = $request->getMethod();
        $ip       = $request->getClientIp();
        $log      = "{$ip}: [{$method}] @ {$url} JWT Token : {$authorization}";
        \Log::info('*** ==== | Request Start | ==== ***');
        \Log::info($log, ['request' => $request->all()]);

        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->end = microtime(true);
        $duration = number_format(($this->end - $this->start), 3);
        $ip       = $request->getClientIp();
        $status   = $response->getStatusCode();
        $log      = "{$ip}: [{$status}]";
        \Log::info($log);
        \Log::info($response);
        \Log::info('*** ==== | Request Complete | ==== ***');
    }
}
