<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     19 April 2021
 */

namespace App\Http\Middleware\PageSpeed;

class RemoveQuotes extends \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes
{
    public function apply($buffer)
    {
        $replace = [
//            '/ src="(.\S*?)"/' => ' src=$1',
            '/ width="(.\S*?)"/' => ' width=$1',
            '/ height="(.\S*?)"/' => ' height=$1',
            '/ name="(.\S*?)"/' => ' name=$1',
            '/ charset="(.\S*?)"/' => ' charset=$1',
            '/ align="(.\S*?)"/' => ' align=$1',
            '/ border="(.\S*?)"/' => ' border=$1',
            '/ crossorigin="(.\S*?)"/' => ' crossorigin=$1',
            '/ type="(.\S*?)"/' => ' type=$1',
            '/\/>/' => '>',
        ];

        return $this->replace($replace, $buffer);
    }
}
