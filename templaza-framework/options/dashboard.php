<?php

defined('TEMPLAZA_FRAMEWORK') or exit();

// -> START Portfolio Section
Templaza_API::set_section('settings',
	array(
		'title'      => esc_html__( 'Dashboard', 'charity' ),
		'id'         => 'dashboard',
		'icon'       => 'el el-th',
		'fields'     => array(
			array(
				'id'       => 'dashboard_number',
				'type'     => 'spinner',
				'title'    => esc_html__('Number Images ', 'charity'),
				'subtitle' => esc_html__('Number images load in portfolio list','charity'),
				'default'  => '12',
				'min'      => '3',
				'step'     => '1',
				'max'      => '60',
			),
		)
	)
);