<?php

namespace App\Http\Middleware;

use Closure;

class employee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$jabatan)
    {
        if(($jabatan != "manager")&&($jabatan!="")){
          return $next($request);
        }else{
          return redirect('/');
        }
    }
}
