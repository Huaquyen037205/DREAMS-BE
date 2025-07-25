<?php

namespace App\Http\Middleware;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

   protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        session()->flash('error', 'Bạn cần đăng nhập để thực hiện những quyền hạn admin này!');
        return route('Admin.Login');
        // return response()->json(['message' => 'Unauthorized'], 401);
    }
}
}
