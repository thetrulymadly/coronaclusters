<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class LocaleMiddleware
 * @package App\Http\Middleware
 */
class LocaleMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($locale = $this->getLocaleFromPath($request)) {
            $request->setLocale($locale);
            app()->setLocale($locale);
            $request->merge([
                'localeEnabled' => true,
                'localePath' => $locale,
                'localeUrl' => config('app.url') . $locale . '/',
                'canonicalPath' => $this->getPathWithoutLocale($request),
                'canonicalUrl' => config('app.url') . $this->getPathWithoutLocale($request) . '/',
            ]);
        }

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function getPathWithoutLocale(Request $request)
    {
        $path = explode('/', $request->path());
        unset($path[0]);

        return implode('/', $path);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function getLocaleFromPath(Request $request)
    {
        $path = explode('/', $request->path());

        if (in_array($path[0], config('corona.locales'))) {
            return $path[0];
        }

        return false;
    }
}
