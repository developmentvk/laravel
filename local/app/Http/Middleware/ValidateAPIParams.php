<?php

namespace App\Http\Middleware;

use Closure;

class ValidateAPIParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->locale) {
            errorMessage('required', false, ['attribute' => __('validation.attributes.locale')]);
        }

        if(!in_array($request->device_type, config('app.allowed_device_type'))) {
            errorMessage('in', false, ['attribute' => __('validation.attributes.device_type')]);
        }

        if(!$request->device_id) {
            errorMessage('required', false, ['attribute' => __('validation.attributes.device_id')]);
        }
        return $next($request);
    }
}
