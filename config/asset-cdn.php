<?php

return [

    'use_cdn' => env('USE_CDN', false),

    'cdn_url' => env('CDN_URL', ''),

    'filesystem' => [
        'disk' => 'asset-cdn',

        'options' => [
            //
        ],
    ],

    'files' => [
        'ignoreDotFiles' => true,

        'ignoreVCS' => true,

        'include' => [
            'paths' => [
                'css',
                'js',
                'fonts',
                'images',
                'webfonts',
                '/',
            ],
            'files' => [
                'mix-manifest.json',
            ],
            'extensions' => [
                '*.css',
                '*.js',
                '*.js.map',
                '*.jpg',
                '*.png',
                '*.svg',
                '*.gif',
                '*.woff2',
                '*.woff',
                '*.json',
            ],
            'patterns' => [
                //
            ],
        ],

        'exclude' => [
            'paths' => [
                'page-cache',
                'vendor',
            ],
            'files' => [
                //
            ],
            'extensions' => [
                '*.html',
                '*.xml',
                '*.txt',
                '*.php',
                '*.config',
                '*.ico',
            ],
            'patterns' => [
                '^(favicon|ms-icon|mstile|apple-touch-icon)',
            ],
        ],
    ],

];
