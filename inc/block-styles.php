<?php

if ( function_exists( 'register_block_style' ) ) {

	function charity_basic_register_block_styles() {

		// Latest Posts: Dividers.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'templaza-latest-posts-dividers',
				'label' => esc_html__( 'Dividers', 'charity' ),
			)
		);

		// Latest Posts: Borders.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'templaza-latest-posts-borders',
				'label' => esc_html__( 'Borders', 'charity' ),
			)
		);

		// Media & Text: Borders.
		register_block_style(
			'core/media-text',
			array(
				'name'  => 'templaza-border',
				'label' => esc_html__( 'Borders', 'charity' ),
			)
		);

	}
	add_action( 'init', 'charity_basic_register_block_styles' );
}
