<?php
/**
 * @copyright Copyright (c) 2021 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     22 April 2021
 */

return [
    'blood_groups' => [
        'O+',
        'O-',
        'A+',
        'A-',
        'B+',
        'B-',
        'AB+',
        'AB-',
        'Don\'t Know',
    ],
    'nearby_radius_options' => [
        75 => '75 km',
        150 => '150 km',
        300 => '300 km',
        301 => '300+ km', // anything greater than 300
    ],
    'max_nearby_distance' => 300,
    'default_nearby_distance' => 150,
];
