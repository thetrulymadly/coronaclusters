<?php
/**
 * @copyright Copyright (c) 2020 TrulyMadly Matchmakers Pvt. Ltd. (https://github.com/thetrulymadly)
 *
 * @author    Deekshant Joshi (deekshant.joshi@gmail.com)
 * @since     20 April 2020
 */

return [
    'page' => [
        'title' => '<span class="text-primary">Corona</span> <span class="text-secondary">India</span> Tracker',
        'url' => '',
        'meta' => [
            'title' => 'Covid-19 India Update (LIVE) : N Cases and N Deaths from Coronavirus Outbreak in India - Corona Clusters | Historical Data & Daily Charts of Corona Virus in Indian States',
            'description' => 'Realtime Corona Virus Statistics & Covid-19 cases in India by Indian States , Cities & Districts. Corona virus stats for Confirmed Cases, Daily New Cases, Patient Recoveries, Daily Deaths and Total Death toll by Indian State, Cities & Districts based on Health bulletins by varios states & districts in India and other reliable coronavirus news sources. Corona Clusters | Historical Data & Daily Charts of Covid-19 in Indian States',
            'keywords' => 'Corona cases in india, corona cases by indian states, corona cases by indian cities, corona cases by indian districts , Covid-19 cases in india, Covid-19 cases by indian states, Covid-19 cases by indian cities, Covid-19 cases by indian districts , Corona deaths in india, corona death by indian states, corona deaths by indian cities, corona deaths by indian districts , Covid deaths in india, Covid deaths by indian states, Covid deaths by indian cities, Covid deaths by indian districts',
        ],
    ],

    'api' => [
        'raw_data' => 'https://api.covid19india.org/raw_data.json',
        'raw_data_3' => 'https://api.covid19india.org/raw_data3.json',
        'raw_data_4' => 'https://api.covid19india.org/raw_data4.json',
        'data' => 'https://api.covid19india.org/data.json',
        'state_data' => 'https://api.covid19india.org/state_district_wise.json',
        'travel_history' => 'https://api.covid19india.org/travel_history.json',
        'testing_data' => 'https://api.covid19india.org/data.json',

        'google_geocode_api' => 'https://maps.googleapis.com/maps/api/geocode/json?key=' . env('GOOGLE_API_KEY') . '&address=',
    ],

    'theme' => env('COVID_THEME', 'default'),

    'stats_colors' => [
        'confirmed' => 'text-danger',
        'active' => 'text-primary',
        'recovered' => 'text-success',
        'deaths' => 'text-dark',
    ],

    'table' => [
        'raw_data' => [
            'patientnumber',
            'agebracket',
            'contractedfromwhichpatientsuspected',
            'currentstatus',
            'statepatientnumber',
            'statuschangedate',
            'dateannounced',
            'detectedcity',
            'detecteddistrict',
            'detectedstate',
            'estimatedonsetdate',
            'gender',
            'nationality',
            'notes',
            'backupnotes',
            'source1',
            'source2',
            'source3',
        ],
        'state_data' => [
            'state',
            'confirmed',
            'delta_confirmed',
            'deaths',
            'delta_deaths',
            'recovered',
            'active',
            'lastupdatedtime',
        ],
        'district_data' => [
            'district',
            'confirmed',
            'delta_confirmed',
            'deaths',
            'delta_deaths',
            'recovered',
            'active',
            'lastupdatedtime',
        ],
        'city_data' => [
            'city',
            'confirmed',
            'delta_confirmed',
            'deaths',
            'delta_deaths',
            'recovered',
            'active',
            'lastupdatedtime',
        ],
        'testing_data' => [
            'updatetimestamp',
            'totalsamplestested',
            'today_totalsamplestested',
//            'today_totalpositivecases',
//            'today_totalpositivecases_percent',
//            'totalindividualstested',
//            'today_totalindividualstested',
//            'totalpositivecases',
//            'percent_increase_positive',
//            'percent_increase_tested',
//            'source',
        ],
    ],

    'advisory_text_count' => env('COVID_ADVISORY_COUNT', 1),

    'google_api_key' => env('GOOGLE_API_KEY'),

    'locales' => explode(',', env('COVID_LOCALES', ['en'])),
];
