<?php

return array(

    // Main menu
    'main'          => array(
        //// Dashboard
        array(
            'title' => 'Dashboard',
            'path'  => '',
            'icon'  => theme()->getSvgIcon("common/media/icons/duotune/art/art002.svg", "svg-icon-2"),
        ),

        //// Modules
        array(
            'classes' => array('content' => 'pt-8 pb-2'),
            'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Modules</span>',
        ),
    ),
    // Horizontal menu
    'horizontal'    => array(
        array(
            'title'   => 'Two Factor Auth',
            'path'    => '/two-factor-auth-setting',
            'classes' => array('item' => 'me-lg-1'),
        ),
    ),
);
