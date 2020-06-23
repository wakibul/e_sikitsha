<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Response;
use Closure;

class MemberMiddleware
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
        if ($request->user() && $request->user()->type != 'franchise')
        {
            return Response::view('unauthorized',['role'=>'Franchise']);
        }
        return $next($request);
    }
}
