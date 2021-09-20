<?php
defined('TEMPLAZA_FRAMEWORK') or exit();
//require_once 'post-type/portfolio/portfolio.php';
//require_once 'dashboard.php';
use TemPlazaFramework\Functions;
Templaza_API::add_field_arguments('settings', 'blog-page',
    array(
        'blog-page-layout' => array(
            'options' => array(
                'grid' => 'Grid',
                'list' => 'List',
                'masonry' => 'Masonry',
            )
        ),
    )
);
Templaza_API::add_field_arguments('settings', 'headers',
    array(
        'header-mode' => array(
            'options'  => array(
                'horizontal' => array(
                    'alt'   => __('Horizontal', $this -> text_domain),
                    'title' => __('Horizontal', $this -> text_domain),
                    'class' => 'w-px-150 h-px-103',
                    'img'   => Functions::get_my_frame_url().'/options/patterns/horizontal-left.svg',
                ),
                'stacked' => array(
                    'alt'   => __('Stacked', $this -> text_domain),
                    'title' => __('Stacked', $this -> text_domain),
                    'class' => 'w-px-150 h-px-103',
                    'img'   => Functions::get_my_frame_url().'/options/patterns/stacked_style1.svg',
                ),
                'sidebar' => array(
                    'alt'   => __('Sidebar', $this -> text_domain),
                    'title' => __('Sidebar', $this -> text_domain),
                    'class' => 'w-px-150 h-px-103',
                    'img'   => Functions::get_my_frame_url().'/options/patterns/sidebar-1.svg',
                ),
                'charity' => array(
                    'alt'   => __('Charity', $this -> text_domain),
                    'title' => __('Charity', $this -> text_domain),
                    'class' => 'w-px-150 h-px-103',
                    'img'   => get_template_directory_uri().'/assets/images/header.jpg',
                ),
            ),
        ),
    )
);