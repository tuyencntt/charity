<?php

defined('TEMPLAZA_FRAMEWORK') or exit();
$all_thumbnails = get_intermediate_image_sizes();
$arr_thumbnails = array();
foreach ($all_thumbnails as $thumbnail){
	$arr_thumbnails[$thumbnail] = $thumbnail;
}
$arr_thumbnails['full'] = 'full';
// -> START Portfolio Section
Templaza_API::set_section('templaza_style',
    array(
        'title'      => esc_html__( 'Portfolio Page', 'charity' ),
        'id'         => 'portfolio-page',
        'icon'       => 'el el-th',
        'fields'     => array(
	        array(
		        'id'       => 'portfolio-thumbnail-size',
		        'type'     => 'select',
		        'title'    => esc_html__('Thumbnail size', 'charity'),
		        'subtitle' => esc_html__('Choose image size of Portfolio archive page.', 'charity'),
		        'options'  => $arr_thumbnails,
		        'default'  => 'full',
	        ),
	        array(
		        'id'       => 'portfolio-page-image-size',
		        'type'     => 'select',
		        'title'    => esc_html__('Detail feature image size', 'charity'),
		        'subtitle' => esc_html__('Choose image size of Portfolio detail page.', 'charity'),
		        'options'  => $arr_thumbnails,
		        'default'  => 'full',
	        ),
	        array(
		        'id'       => 'portfolio-page-gallery-size',
		        'type'     => 'select',
		        'title'    => esc_html__('Gallery image size', 'charity'),
		        'subtitle' => esc_html__('Choose gallery image size of Portfolio detail page.', 'charity'),
		        'options'  => $arr_thumbnails,
		        'default'  => 'full',
	        ),
        )
    )
);

// -> START Portfolio Section
Templaza_API::set_fields('settings', 'portfolio-subsections',
	array(
		array(
			'id'       => 'portfolios_per_page',
			'type'     => 'spinner',
			'title'    => esc_html__('Portfolio per Page', 'charity'),
			'subtitle' => esc_html__('Portfolio items show per page', 'charity'),
			'default'  => '12',
			'min'      => '3',
			'step'     => '1',
			'max'      => '48',
		),
		array(
			'id'       => 'portfolio-thumbnail-size',
			'type'     => 'select',
			'title'    => esc_html__('Thumbnail size', 'charity'),
			'subtitle' => esc_html__('Choose image size of Portfolio archive page.', 'charity'),
			'options'  => $arr_thumbnails,
			'default'  => 'full',
		),
		array(
			'id'       => 'portfolio-page-image-size',
			'type'     => 'select',
			'title'    => esc_html__('Detail feature image size', 'charity'),
			'subtitle' => esc_html__('Choose image size of Portfolio detail page.', 'charity'),
			'options'  => $arr_thumbnails,
			'default'  => 'full',
		),
		array(
			'id'       => 'portfolio-page-gallery-size',
			'type'     => 'select',
			'title'    => esc_html__('Gallery image size', 'charity'),
			'subtitle' => esc_html__('Choose gallery image size of Portfolio detail page.', 'charity'),
			'options'  => $arr_thumbnails,
			'default'  => 'full',
		),
	)
);