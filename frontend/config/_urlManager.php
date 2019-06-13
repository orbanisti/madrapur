<?php
use Sitemaped\Sitemap;

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Pages
        /*[
            'pattern' => 'page/<slug>',
            'route' => 'page/view'
        ],*/

        // Articles
        [
            'pattern' => 'article/index',
            'route' => 'article/index'
        ],
        [
            'pattern' => 'article/attachment-download',
            'route' => 'article/attachment-download'
        ],
        [
            'pattern' => 'article/<slug>',
            'route' => 'article/view'
        ],

        // .co.uk routes
        [
            'pattern' => '<cruise-shop:\w+>',
            'route' => 'site/index'
        ],
        [
            'pattern' => '<slug>',
            'route' => 'site/index',
        ],
        [
            'pattern' => 'page/<slug>',
            'route' => 'site/index',
        ],
        [
            'pattern' => 'product/<slug>',
            'route' => 'site/index'
        ],
        [
            'pattern' => 'privacy-policy',
            'route' => 'site/index'
        ],
        [
            'pattern' => 'checkout',
            'route' => 'site/index'
        ],
        [
            'pattern' => 'checkout/thankyou/<orderRef>/<status>',
            'route' => 'site/index'
        ],
        [
            'pattern' => 'cart',
            'route' => 'site/index'
        ],

        // Sitemap
        [
            'pattern' => 'sitemap.xml',
            'route' => 'site/sitemap',
            'defaults' => [
                'format' => Sitemap::FORMAT_XML
            ]
        ],
        [
            'pattern' => 'sitemap.txt',
            'route' => 'site/sitemap',
            'defaults' => [
                'format' => Sitemap::FORMAT_TXT
            ]
        ],
        [
            'pattern' => 'sitemap.xml.gz',
            'route' => 'site/sitemap',
            'defaults' => [
                'format' => Sitemap::FORMAT_XML,
                'gzip' => true
            ]
        ],
    ]
];
