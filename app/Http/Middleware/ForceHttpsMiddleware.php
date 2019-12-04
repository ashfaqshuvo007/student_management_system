<?php



namespace app\Http\Middleware;



use Closure;



class ForceHttpsMiddleware {



    public function handle($request, Closure $next)

    {

            if (!$request->secure() && env('APP_ENV') === 'local') {

                return redirect()->secure($request->getRequestUri());

            }



            return $next($request); 

    }

}