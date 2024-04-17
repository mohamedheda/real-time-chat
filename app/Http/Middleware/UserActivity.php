<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('api')->check())
            app(UserRepositoryInterface::class)->updateLastSeen();
        return $next($request);
    }
}
