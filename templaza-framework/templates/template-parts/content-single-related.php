<?php
defined('ABSPATH') or exit();
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $options = array();
}else{
    $options            = Functions::get_theme_options();
}
$related_col      = isset($options['blog-related-column'])?$options['blog-related-column']:3;
$related_limit      = isset($options['blog-related-limit'])?$options['blog-related-limit']:3;

global $post;
$post_cats = wp_get_post_categories($post->ID);
if ($post_cats) {
    $post_cat_ids = array();
    foreach($post_cats as $post_cat_item) $post_cat_ids[] = $post_cat_item;
    $templaza_args=array(
        'category__in'          => $post_cat_ids,
        'post__not_in'          => array($post->ID),
        'posts_per_page'        => $related_limit
    );
    $templaza_query = new wp_query( $templaza_args );
    if($templaza_query->have_posts()){?>

        <div class="templaza-related-posts">
            <h3 class="box-title"><?php echo esc_html__('Related Posts','charity');?></h3>
            <div class="content-related uk-child-width-1-<?php echo esc_attr($related_col);?>@m uk-child-width-1-2@s" data-uk-grid>
                <?php
                while( $templaza_query->have_posts() ) {
                    $templaza_query->the_post();
                    ?>
                    <div class="templaza-blog-item">
                        <div class="templaza-blog-item-wrap">
                            <?php
                            if (has_post_format('gallery')) {
                                do_action('templaza_gallery_post');
                            }else{
                                do_action('templaza_image_post');
                            }
                            ?>
                            <div class="templaza-blog-item-content templaza-archive-item uk-padding-small">
                                <?php
                                do_action('templaza_title_post');
                                do_action('templaza_meta_post_header');
                                do_action('templaza_excerpt_post');
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php
    }
}