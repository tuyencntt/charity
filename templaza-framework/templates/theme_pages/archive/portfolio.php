<?php
    /*
     * Archive Portfolio
     */
defined('TEMPLAZA_FRAMEWORK') or exit();
?>
<div class="templaza-portfolio">
    <div class="uk-grid-large uk-grid" data-uk-filter="target: .tz-portfolio-items; animation: delayed-fade">
        <div class="tzfilter uk-visible@m uk-first-column">
            <?php do_action('templaza_all_taxonomy','portfolio_tag',true); ?>
            <h5>Sort</h5>
            <ul class="uk-nav uk-nav-default">
                <li class="uk-margin-remove" data-uk-filter-control="sort: data-date; order: desc"><a href="#"><?php echo esc_html__('Newest','charity');?></a></li>
                <li class="uk-margin-remove" data-uk-filter-control="sort: data-date"><a href="#"><?php echo esc_html__('Oldest','charity');?></a></li>
                <li class="uk-margin-remove" data-uk-filter-control="sort: data-hits; order: desc"><a href="#"><?php echo esc_html__('Most Popular','charity');?></a></li>
            </ul>
        </div>
        <div class="uk-width-expand@m">
            <div class="tz-portfolio-items uk-grid-large uk-child-width-1-2@s uk-child-width-1-1@m uk-child-width-1-2@l uk-child-width-1-3@xl" data-uk-grid>
	            <?php
	            if ( have_posts() ) : while (have_posts()) : the_post() ;
		            get_template_part( 'templaza-framework/templates/template-parts/portfolio/portfolio-content');
	            endwhile; // end while ( have_posts )
	            endif; // end if ( have_posts )
	            global $wp_query; // you can remove this line if everything works for you
	            // don't display the button if there are not enough posts
	            ?>
            </div>
	        <?php
	        if ( $wp_query->max_num_pages > 1 ){
		        ?>
                <div class="templaza-loading uk-text-center uk-margin-large" >
                    <div data-uk-spinner class="uk-margin-right"></div>
                    <span class="loading"><?php echo esc_html__('Loading more posts...','charity');?></span>
                    <span class="endpost-text"></span>
                </div>
		        <?php
	        }
	        ?>
        </div>
    </div>
</div>