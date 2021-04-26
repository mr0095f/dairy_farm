<?php

namespace App\Http\Middleware;
use Closure;
use Session;
use Auth;

class BranchCheck
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
        if (Auth::user()->user_type == 1)
        {
            if(Session::has('branch_id')){
                return $next($request);
            }else{
                return redirect('select-branch');
            }
        }
        else
        {
            session(['branch_id' => Auth::user()->branch_id]);
            return $next($request);
        }
    }
}
