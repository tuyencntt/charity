<?php
global $content_width;
if ( ! isset( $content_width ) ) {
	$content_width = 580;
}
if ( ! function_exists( 'charity_basic_fonts_url' ) ) {
	function charity_basic_fonts_url()
	{
		$charity_fonts_url = '';
		$charity_font_families = array();
		$font_subsets = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Barlow, translate this to 'off'. Do not translate into your own language. */
		if ('off' !== esc_html_x('on', 'Barlow font: on or off', 'charity')) {
			$charity_font_families[] = 'Barlow Semi Condensed:400,500,600';
		}
		/* translators: If there are characters in your language that are not supported by Saira, translate this to 'off'. Do not translate into your own language. */
		if ('off' !== esc_html_x('on', 'Saira font: on or off', 'charity')) {
			$charity_font_families[] = 'Saira:300,500,600';
		}

		if ($charity_font_families) {

			$charity_query_args = array(
				'family' => urlencode(implode('|', $charity_font_families)),
				'subset' => urlencode($font_subsets),
			);

			$charity_fonts_url = add_query_arg($charity_query_args, 'https://fonts.googleapis.com/css');
		}
		return esc_url_raw($charity_fonts_url);
	}
}

if ( !function_exists('charity_basic_continue_reading_text') ) {
	function charity_basic_continue_reading_text() {
		$continue_reading = sprintf(
		/* translators: %s: Name of current post. */
			esc_html__( 'Continue reading %s', 'charity' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		);

		return $continue_reading;
	}
}