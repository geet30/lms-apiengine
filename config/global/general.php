<?php
return array(
    // Product
    'product' => array(
        'name'        => 'LMS - Dashboard',
        'description' => 'LMS - Lead management system',
        'preview'     => 'https://preview.keenthemes.com/metronic8/laravel',
        'home'        => 'https://keenthemes.com/metronic',
        'purchase'    => 'https://1.envato.market/EA4JP',
        'licenses'    => array(
            'terms' => 'https://themeforest.net/licenses/standard',
            'types' => array(
                array(
                    'title'       => 'Regular License',
                    'description' => 'For single end product used by you or one client',
                    'tooltip'     => 'Use, by you or one client in a single end product which end users are not charged for',
                    'price'       => '39',
                ),
                array(
                    'title'       => 'Extended License',
                    'description' => 'For single SaaS app with paying users',
                    'tooltip'     => 'Use, by you or one client, in a single end product which end users can be charged for.',
                    'price'       => '939',
                ),
            ),
        ),
        'demos'       => array(
            'common' => array(
                'title'       => 'CIMET',
                'description' => 'LMS Dashboard',
                'published'   => true,
                'thumbnail'   => 'demos/common.png',
            )
        ),
    ),

    // Meta
    'meta'    => array(
        'title'       => 'LMS - Lead management system',
        'description' => 'Lead management system',
        'keywords'    => 'Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon',
        'canonical'   => 'https://www.cimet.com.au',
    ),

    // General
    'general' => array(
        'website'             => 'https://www.cimet.com.au/',
        'licenses'            => 'https://keenthemes.com/licensing',
        'social-accounts'     => array(
            array(
                'name' => 'Youtube', 'url' => 'https://www.youtube.com/c/KeenThemesTuts/videos', 'logo' => 'svg/social-logos/youtube.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Github', 'url' => 'https://github.com/KeenthemesHub', 'logo' => 'svg/social-logos/github.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Twitter', 'url' => 'https://twitter.com/keenthemes', 'logo' => 'svg/social-logos/twitter.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Instagram', 'url' => 'https://www.instagram.com/keenthemes', 'logo' => 'svg/social-logos/instagram.svg', "class" => "h-20px",
            ),

            array(
                'name' => 'Facebook', 'url' => 'https://www.facebook.com/keenthemes', 'logo' => 'svg/social-logos/facebook.svg', "class" => "h-20px",
            ),
            array(
                'name' => 'Dribbble', 'url' => 'https://dribbble.com/keenthemes', 'logo' => 'svg/social-logos/dribbble.svg', "class" => "h-20px",
            ),
        ),
    ),

    // Layout
    'layout'  => array(
        // Docs
        'docs'          => array(
            'logo-path'  => array(
                'default' => 'logos/logo.svg',
                'dark'    => 'logos/logo.png',
            ),
            'logo-class' => 'h-25px',
        ),

        // Illustration
        'illustrations' => array(
            'set' => 'sketchy-1',
        ),

        // Engage
        'engage'        => array(
            'demos'    => array(
                'enabled'   => true,
                'direction' => 'end',
            ),
            'explore'  => array(
                'enabled'   => true,
                'direction' => 'end',
            ),
            'help'     => array(
                'enabled'   => true,
                'direction' => 'end',
            ),
            'purchase' => array(
                'enabled' => true,
            ),
        ),
    ),
    
    /**
     * Sale Status
     */
    'saleStatus'=>[
        1 => 'Pending',2 => 'Reject',3 => 'Cancel',4 => 'Submitted',5 => 'Retailer Rejection',6 => 'Accepted',7 => 'Recon Sale',8 => 'Paid',9 => 'In Question',10 => 'Affiliate Payable',11 => 'Affiliate Paid',12 => 'Resubmitted'
    ],

);
