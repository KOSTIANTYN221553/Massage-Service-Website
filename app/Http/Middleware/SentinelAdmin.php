<?php

namespace App\Http\Middleware;

use App\Task;
use Closure;
use Illuminate\Support\Facades\Request;
use Sentinel;


class SentinelAdmin
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
        if(!Sentinel::check()){
            return redirect('admin/signin')->with('info', 'You must be logged in!');
        }

        $user = Sentinel::getuser();
        if($user['type']*1 == 1){
            return redirect("/");
        }

        $admin_except_url = array("admin/manager","admin/manager/info/*", "admin/schedule","admin/schedule/info/*" );
        $shop_url = array("admin/shops","admin/shops/info/*", "admin/shops/*", "admin/manager","admin/manager/*","admin/manager/info/*", "admin/schedule","admin/schedule/info/*","admin/schedule/*","admin/schedule/info/*",
                    "admin/notice","admin/notice/info/*","admin/board","admin/board/*", "admin/board/info/*","admin/review","admin/review/*", "admin/review/info/*","admin/shop_question","admin/shop_question/*",
                    "admin/shop_board","admin/shop_board/*",);
        if(Request::is("admin/logout")){
            return $next($request);
        }

        if($user['type']*1 == 99){
            $check = true;
            foreach($admin_except_url as $url){
                if(Request::is($url)){
                    $check = false;
                    break;
                }
            }

            if(!$check){
                return redirect("admin/shop_type");
            }
        }else if($user['type']*1 == 70){
            $check = false;
            foreach($shop_url as $url){
                if(Request::is($url)){
                    $check = true;
                    break;
                }
            }
            if(!$check){
                return redirect("admin/shops");
            }
        }

        return $next($request);
    }
}
