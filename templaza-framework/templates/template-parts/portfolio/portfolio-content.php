<?php
defined('ABSPATH') or exit();
use TemPlazaFramework\Functions;
$options            = Functions::get_theme_options();
$post_type          = get_post_type(get_the_ID());
$prefix             = $post_type.'-page';
if($post_type == 'portfolio'){
	$prefix = 'portfolio';
}
$thumbnail_size= $options[$prefix.'-thumbnail-size'];

//get Hits
$hits   =   '';
$count_key = 'post_views_count';
$count = get_post_meta(get_the_ID(), $count_key, true);
if ($count == '' || empty($count)) { // If such views are not
	delete_post_meta(get_the_ID(), $count_key);
	add_post_meta(get_the_ID(), $count_key, '0');
	$hits = 0; // return value of 0
}else{
	$hits = $count;
}

//do filter
$charity_tag_portfolio = wp_get_post_terms( get_the_ID() , 'portfolio_tag' );
// init counter
$i = 1;
$tag_content    =   '';
$tag_data       =   array();
if($charity_tag_portfolio){
	?>
	<?php
	foreach ( $charity_tag_portfolio as $term ) {
		$charity_term_link = get_term_link( $term, array( 'portfolio_tag') );
		if( is_wp_error( $charity_term_link ) )
			continue;
		$tag_data[] =   $term->slug;
		if($i < count($charity_tag_portfolio)){
		    if ( $i == count($charity_tag_portfolio) - 1 ) {
			    $tag_content .= esc_html($term->name.' & ');
		    } else {
			    $tag_content .= esc_html($term->name.', ');
		    }
		}else{
		    $tag_content .= esc_html($term->name);
		}
		$i++;
	}
}

?>
<article class="templaza-portfolio-item" data-tag="<?php echo esc_attr(implode(' ', $tag_data)); ?>" data-date="<?php echo esc_attr(get_the_date('Y-m-d')); ?>" data-hits="<?php echo esc_attr($hits); ?>">
    <div class="uk-inline tz-portfolio-thumbnail">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($thumbnail_size,array( 'alt' => '' )); ?></a>
    </div>
    <h3 class="uk-h5 uk-margin-remove-bottom"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <div class="uk-article-meta portfolio-meta uk-margin-small">
	    <?php
	    if($charity_tag_portfolio){
		    echo esc_html($tag_content);
	    }
	    ?>
    </div>
</article>