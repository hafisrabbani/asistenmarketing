<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WritterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session('loggedWritter')){
            return redirect(route('writter.login'))->with('error','Anda harus login dahulu');
        }
        return $next($request);
    }
}
