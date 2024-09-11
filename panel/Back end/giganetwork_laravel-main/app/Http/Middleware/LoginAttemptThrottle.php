<?php

namespace App\Http\Middleware;

use Illuminate\Cache\RateLimiter;
use Closure;

class LoginAttemptThrottle
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle($request, Closure $next, $maxAttempts = 3, $decayMinutes = 1)
    {
        $key = request('username') . '|' . $request->ip();

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return response()->json(['status' => 'error', 'message' => 'Too many login attempts. Please try again in ' . $decayMinutes . ' minute.'], 429);
        }

        $response = $next($request);

        if ($response instanceof \Illuminate\Http\JsonResponse && $response->status() === 401) {
            $this->limiter->hit($key, $decayMinutes * 60);
        } else {
            $this->limiter->clear($key);
        }

        return $response;
    }
}
