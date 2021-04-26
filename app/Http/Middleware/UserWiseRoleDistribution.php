<?php

namespace App\Http\Middleware;
use Closure;
use Session;
use Auth;
use Route;
use App\Models\UserType;
use App\Library\UserRoleWiseAccess;

class UserWiseRoleDistribution
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
        if(Auth::user()->user_type==0||Auth::user()->user_type==''||Auth::user()->user_type==null){
            Auth::logout();
            Session::put('error', 'Sorry, You are not authorised as user.');
            return redirect('/');
        }else{
            //return $next($request);

            /*------------------------------------------------------------------------------*/

            $currentAction = \Route::currentRouteAction();
            list($controller, $method) = explode('@', $currentAction);
            $controller = preg_replace('/.*\\\/', '', $controller);

            if($controller=='DashboardController'){
                return $next($request);
            }

            if(Auth::user()->user_type==1){
                return $next($request);
            }
            else{
                $data=UserType::where('id', Auth::user()->user_type)->pluck('user_role')->first();
                $userRoleAccess = json_decode($data, true);
                $definedAccessArr = UserRoleWiseAccess::controllerMethods();
                if(isset($definedAccessArr[$controller][$method])){
                    if(isset($userRoleAccess[$controller][$method])){
                        return $next($request);
                    }
                    else{
                        Session::flash('flash_message','Access Permission Denied !');
                        return redirect()->back()->with('status_color','danger');
                    }
                }
                else{
                    return $next($request);
                }
            }

            /*------------------------------------------------------------------------------*/
        }
    }
}
