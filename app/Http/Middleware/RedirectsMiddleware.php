<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     26 April 2020
 */

namespace App\Http\Middleware;

use Closure;

class RedirectsMiddleware
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
        if (explode('/', $request->path())[0] === config('translation.ui_url')) {
            return redirect('/');
        }

        return $next($request);
    }
}
