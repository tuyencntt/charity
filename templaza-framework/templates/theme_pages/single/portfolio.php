<?php

defined('TEMPLAZA_FRAMEWORK') or exit();
use TemPlazaFramework\Functions;
$options            = Functions::get_theme_options();
$post_type          = get_post_type(get_the_ID());
$prefix             = $post_type.'-page';
$thumbnail_size     = $options[$prefix.'-image-size'];
$gallery_size       = $options[$prefix.'-gallery-size'];
?>
<div class="templaza-portfolio-single">
	<?php
	if(have_posts()):
		while(have_posts()):the_post();
			do_action('templaza_set_postviews',get_the_ID());
			?>
            <div class="templaza-archive-item uk-margin-large-top">
                <h1 class="templaza-portfolio-item-title title uk-heading-medium uk-container-small uk-container uk-text-center">
					<?php the_title(); ?>
                </h1>
                <div class="templaza-blog-item-info templaza-post-meta uk-article-meta uk-text-center uk-margin-large-bottom">
                    <span><i class="fa fa-calendar"></i><?php echo esc_html(get_the_date()); ?></span>
                    <span class="author">
                    <i class="fas fa-user"></i>
                    <?php echo get_the_author_posts_link();?>
                    </span>
                    <span class="category">
                         <i class="fas fa-folder"></i>
                        <?php
                        $charity_cat_portfolio = get_the_terms( get_the_ID() , 'portfolio-category' );
                        // init counter
                        $i = 1;
                        if($charity_cat_portfolio){
	                        foreach ( $charity_cat_portfolio as $term ) {
		                        $charity_term_link = get_term_link( $term, 'portfolio-category');
		                        if( is_wp_error( $charity_term_link ) )
			                        continue;
		                        if($i < count($charity_cat_portfolio)){
			                        ?>
                                    <a href="<?php echo esc_url($charity_term_link);?>"><?php echo esc_html($term->name.',');?></a>
			                        <?php
		                        }else{
			                        ?>
                                    <a href="<?php echo esc_url($charity_term_link);?>"><?php echo esc_html($term->name);?></a>
			                        <?php
		                        }
		                        $i++;
	                        }
                        }
                        ?>
                    </span>

					<?php
					edit_post_link();
					?>
                </div>
                <div class="uk-container uk-container-large uk-margin-large">
                    <div class="uk-inline"><?php the_post_thumbnail($thumbnail_size,array( 'alt' => '' )); ?></div>
                </div>
                <div class="uk-container uk-container-small uk-margin-large uk-text-lead">
                    <?php the_excerpt(); ?>
                </div>
                <?php
                $charity_portfolio_gallery = rwmb_meta( 'gallery', array( 'size' => $gallery_size ) );
                if ($charity_portfolio_gallery && count($charity_portfolio_gallery)) {
                    ?>
                    <div class="templaza-portfolio-gallery uk-container uk-container-large uk-margin-large">
                        <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-text-center uk-grid-small" data-uk-grid="masonry: true" data-uk-lightbox="animation: scale">
			                <?php
			                foreach ($charity_portfolio_gallery as $key => $gallery_item){
				                $item_url = wp_get_attachment_url( $key );
				                $item_caption = wp_get_attachment_metadata( $key );
				                $attachment = get_post($key);
				                ?>
                                <div class="templaza-gallery-item">
                                    <div class="img-inner">
                                        <a class="uk-inline" href="<?php echo esc_url($item_url)?>" >
                                            <i class="fas fa-search"></i>
                                        </a>
						                <?php echo wp_get_attachment_image($key, $gallery_size); ?>
                                        <div class="uk-overlay uk-light uk-position-bottom uk-position-z-index"><?php echo esc_html($attachment->post_excerpt); ?></div>
                                    </div>
                                </div>
				                <?php
			                }
			                ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="templaza-single-content uk-margin-large uk-container-small uk-container">
					<?php
					the_content();
					wp_link_pages();
					?>
                </div>

				<?php
				$charity_tag_portfolio = wp_get_post_terms( get_the_ID() , 'portfolio_tag' );
				// init counter
				if($charity_tag_portfolio){
					?>
                    <div class="tz-item-tags uk-margin-large uk-article-meta uk-container-small uk-container">
						<?php
						foreach ( $charity_tag_portfolio as $term ) {
							$charity_term_link = get_term_link( $term, array( 'portfolio_tag') );
							if( is_wp_error( $charity_term_link ) )
								continue;
							?>
                            <a href="<?php echo esc_url($charity_term_link);?>"><?php echo esc_html('#'.$term->name);?></a>
							<?php
						}
						?>
                    </div>
					<?php
				}
				?>
	            <?php
	            $charity_portfolio_embed = rwmb_get_value( 'oembed' );
	            if ($charity_portfolio_embed ) {
		            if($charity_portfolio_embed) {
			            $video = parse_url($charity_portfolio_embed);
			            switch($video['host']) {
				            case 'youtu.be':
					            $id = trim($video['path'],'/');
					            $src = '//www.youtube.com/embed/' . $id .'?iv_load_policy=3';
					            break;

				            case 'www.youtube.com':
				            case 'youtube.com':
					            parse_str($video['query'], $query);
					            $id = $query['v'];
					            $src = '//www.youtube.com/embed/' . $id .'?iv_load_policy=3';
					            break;

				            case 'vimeo.com':
				            case 'www.vimeo.com':
					            $id = trim($video['path'],'/');
					            $src = "//player.vimeo.com/video/{$id}?autoplay=1&loop=1&muted=1&autopause=0&title=0&byline=0&portrait=0&controls=0";
			            }
		            }
                    echo '<div class="templaza-portfolio-embed uk-container uk-container-large uk-margin-large">';
                    echo '<div class="tz-embed-responsive tz-embed-responsive-16by9">';
	                echo '<iframe class="tz-embed-responsive-item" src="'.esc_url($src).'" webkitAllowFullScreen mozallowfullscreen allowFullScreen loading="lazy"></iframe>';
	                echo '</div>';
	                echo '</div>';
                }
                ?>
            </div>
            <div class="templaza-basic-nav-post uk-container uk-container-large uk-margin-large-top uk-margin-large-bottom">
				<?php
				// Previous/next post navigation.
				$charity_next =  '<span data-uk-icon="icon: arrow-right"></span>';
				$charity_prev =  '<span data-uk-icon="icon: arrow-left"></span>';

				$charity_next_label     = esc_html__( 'Next post', 'charity' );
				$charity_previous_label = esc_html__( 'Previous post', 'charity' );

				the_post_navigation(
					array(
						'next_text' => '<p class="meta-nav ">' . $charity_next_label . $charity_next . '</p><h5 class="post-title">%title</h5>',
						'prev_text' => '<p class="meta-nav">' . $charity_prev . $charity_previous_label . '</p><h5 class="post-title">%title</h5>',
					)
				);
				?>
            </div>
		<?php
		endwhile;
	endif;
	?>
</div>