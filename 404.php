<?php
get_header();
?>
	<div class="templaza-basic-wrap uk-container uk-container-large uk-margin-xlarge-top uk-text-center">
		<span class="templaza-404-tagline uk-heading-large"><?php echo esc_html__( '404', 'charity' ); ?></span>

		<h2 class="templaza-404-title uk-heading-small uk-margin-remove-top"><?php echo esc_html__( 'Page not found', 'charity' ); ?></h2>

		<p class="templaza-404-text uk-margin-medium-bottom"><?php echo esc_html__( 'Oops! The page you are looking for does not exist. It might have been moved or deleted.', 'charity' ); ?></p>

		<div class="templaza-404-button">
			<a class="uk-button uk-button-large uk-button-default uk-border-pill" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Back to home', 'charity' ); ?></a>
		</div>
	</div>
<?php
get_footer();