<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

// CSRFを除外したいURLリスト
    protected $routes = [
        'api/addlist',
    ];

    // handleを変更
    public function handle($request, Closure $next){
        if($this->excludedRoutes($request)){
            return $this->addCookieToResponse($request, $next($request));
        }
        return parent::handle($request, $next);
    }

    /*
    * CSRFを除外したいURLであるかどうかをチェックする。
    * @param Request リクエスト
    * @return boolean CSRFを除外したいURLであればtrue
    **/
    protected function excludedRoutes($request){
        foreach($this->routes as $route){
            if ($request->is($route)){ return true; }
        }
    }
}
