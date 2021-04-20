<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     21 April 2020
 */

namespace App\Http\Controllers;

use Carbon\Carbon;

/**
 * Class Helpers
 * @package App\Http\Controllers
 */
final class Helpers
{

    /**
     * @param string $string
     *
     * @return string
     */
    public static function sanitize(string $string)
    {
        // Remove index.php from url inserted by nginx
        $string = str_replace('/index.php', '', $string);

        return strtolower(str_replace([' ', '_', '&', '(', ')', '%', '[', ']'], '-', $string));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function beautify(string $string)
    {
        return ucwords(str_replace(['-', '_', '&', '(', ')', '%'], ' ', $string));
    }

    /**
     * @param string $datetime
     * @param string $format
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public static function getTimeAgo(string $datetime, string $format = 'Y-m-d h:i:s')
    {
        $now = Carbon::now();
        $timeago = $now->diff(Carbon::createFromFormat($format, $datetime));
        $time = 0;
        $ago = '';
        if ($timeago->i !== 0) {
            $time = $timeago->i;
            $ago = 'minutes';
        } elseif ($timeago->h !== 0) {
            $time = $timeago->h;
            $ago = 'hours';
        } elseif ($timeago->d !== 0) {
            $time = $timeago->d;
            $ago = 'days';
        } elseif ($timeago->m !== 0) {
            $time = $timeago->m;
            $ago = 'months';
        } elseif ($timeago->y !== 0) {
            $time = $timeago->y;
            $ago = 'years';
        }

        return $time !== 0 ? $time . ' ' . trans_choice('corona.time.' . $ago . '_ago', $time) : trans('corona.time.just_now');
    }

    /**
     * @param $path
     *
     * @return array
     */
    public static function extractStateCityFromUrl($path)
    {
        if (count(array_filter(explode('/', $path))) > 1) {
            $city = substr($path, strrpos($path, '/') + 1);
            $state = substr($path, 0, strrpos($path, '/'));
        } else {
            $city = '';
            $state = $path;
        }

        return [Helpers::beautify($state), Helpers::beautify($city)];
    }
}
