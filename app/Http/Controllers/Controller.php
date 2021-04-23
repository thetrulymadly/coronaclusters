<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return array
     */
    protected function getBreadcrumbs()
    {
        $breadcrumbs = [];
        $url = array_filter(explode('/', request()->canonicalPath));
        while (count($url) > 0) {
            $breadcrumbs[] = [
                'url' => request()->get('localeUrl') . implode('/', $url),
                'name' => ucwords(str_replace(['-', '_', '&', '(', ')', '%'], ' ', last($url))),
            ];
            array_pop($url);
        }

        return array_reverse($breadcrumbs);
    }
}
