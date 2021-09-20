<?php

defined('TEMPLAZA_FRAMEWORK');

use TemPlazaFramework\CSS;
use TemPlazaFramework\Functions;
use TemPlazaFramework\Templates;

$charity_id             = isset($atts['id'])?$atts['id']:time();
$charity_custom_class   = isset($atts['custom-container-class'])?' '.$atts['custom-container-class']:'';
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $charity_options = array();
}else{
    $charity_options            = Functions::get_theme_options();
}
$charity_post_type       = get_post_type(get_the_ID());
$prefix                 = 'blog-single';

$charity_show_thumbnail         = isset($charity_options[$prefix.'-thumbnail'])?filter_var($charity_options[$prefix.'-thumbnail'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_tag               = isset($charity_options[$prefix.'-tag'])?filter_var($charity_options[$prefix.'-tag'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_meta              = isset($charity_options[$prefix.'-meta'])?filter_var($charity_options[$prefix.'-meta'], FILTER_VALIDATE_BOOLEAN):false;
$charity_show_date              = isset($charity_options[$prefix.'-date'])?filter_var($charity_options[$prefix.'-date'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_share             = isset($charity_options[$prefix.'-share'])?filter_var($charity_options[$prefix.'-share'], FILTER_VALIDATE_BOOLEAN):false;
$charity_show_title             = isset($charity_options[$prefix.'-title'])?filter_var($charity_options[$prefix.'-title'], FILTER_VALIDATE_BOOLEAN):false;
$charity_show_author            = isset($charity_options[$prefix.'-author'])?filter_var($charity_options[$prefix.'-author'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_related           = isset($charity_options[$prefix.'-related'])?filter_var($charity_options[$prefix.'-related'], FILTER_VALIDATE_BOOLEAN):false;
$charity_show_comment           = isset($charity_options[$prefix.'-comment'])?filter_var($charity_options[$prefix.'-comment'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_category          = isset($charity_options[$prefix.'-category'])?filter_var($charity_options[$prefix.'-category'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_description       = isset($charity_options[$prefix.'-description'])?filter_var($charity_options[$prefix.'-description'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_comment_count     = isset($charity_options[$prefix.'-comment-count'])?filter_var($charity_options[$prefix.'-comment-count'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_post_view         = isset($charity_options[$prefix.'-post-view'])?filter_var($charity_options[$prefix.'-post-view'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_post_next_preview = isset($charity_options[$prefix.'-next-preview'])?filter_var($charity_options[$prefix.'-next-preview'], FILTER_VALIDATE_BOOLEAN):true;

$charity_blog_slider_autoplay   = isset($charity_options['blog-slider-autoplay'])?filter_var($charity_options['blog-slider-autoplay'], FILTER_VALIDATE_BOOLEAN):true;
$charity_blog_thumbnail_size    = isset($charity_options[$prefix.'-thumbnail-size'])?$charity_options[$prefix.'-thumbnail-size']:'large';
$charity_blog_thumbnail_effect  = isset($charity_options[$prefix.'-thumbnail-effect'])?$charity_options[$prefix.'-thumbnail-effect']:'none';

$charity_blog_slider_animation  = isset($charity_options['blog-slider-animation'])?$charity_options['blog-slider-animation']:'';
$charity_blog_slider_nav        = isset($charity_options['blog-slider-nav'])?filter_var($charity_options['blog-slider-nav'], FILTER_VALIDATE_BOOLEAN):true;
$charity_blog_slider_kenburns   = isset($charity_options['blog-slider-kenburns'])?filter_var($charity_options['blog-slider-kenburns'], FILTER_VALIDATE_BOOLEAN):true;

$charity_blog_slider_options = '';
if($charity_blog_slider_autoplay == true){
    $charity_blog_slider_options .='autoplay: true; ';
}
if($charity_blog_slider_animation != ''){
    $charity_blog_slider_options .='animation: '.$charity_blog_slider_animation. '';
}
?>
<div class="templaza-blog">
    <div id="templaza-single-<?php echo esc_attr($charity_id); ?>" class="templaza-single templaza-single-<?php
    echo esc_attr($charity_post_type.' '.$charity_custom_class); ?> templaza-blog-body">
        <?php
        if ( have_posts() ) : while (have_posts()) : the_post() ;
            do_action('templaza_set_postviews',get_the_ID());
            ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class('templaza-blog-item'); ?>>
                <div class="templaza-blog-item-wrap">
                    <div class="templaza-blog-item-content templaza-archive-item  templaza-single-box">
                        <div class="templaza-item-heading">
                            <?php if ($charity_show_title){
                                do_action('templaza_single_title_post');
                            }?>
                            <div class="uk-text-center">
                                <?php
                                if ($charity_show_meta) {
                                    do_action('templaza_single_meta_post');
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($charity_show_thumbnail
                            && has_post_thumbnail()
                            && (
                                has_post_format('gallery')  ||
                                has_post_format('image')  ||
                                has_post_format('video') ||
                                has_post_format('audio') ||
                                has_post_format('link') ||
                                has_post_format()==false ||
                                has_post_format('quote')) ): ?>
                        <div class="uk-margin-large-bottom templaza-single-feature">
                            <?php
                            if (has_post_format('gallery')){
                                do_action('templaza_gallery_post');
                            }

                            if(has_post_thumbnail() && empty(has_post_format('gallery')) && empty(has_post_format('audio'))
                                && empty(has_post_format('video')) && empty(has_post_format('quote'))&& empty(has_post_format('link'))){
                                do_action('templaza_image_post');
                            }
                            if (has_post_format('video')){
                                do_action('templaza_video_post');
                            }
                            if (has_post_format('audio')){
                                do_action('templaza_audio_post');
                            }
                            if (has_post_format('link')){
                                do_action('templaza_link_post');
                            }
                            if (has_post_format('quote')) {
	                            do_action('templaza_quote_post');
                            }
                            ?>
                        </div>
                        <?php
                        endif;
                        ?>
                        <div class="<?php if (has_post_thumbnail()) echo esc_attr('uk-container-small uk-container'); ?>">
                            <div class="templaza-single-content uk-margin-medium-bottom">
                                <?php
                                the_content();
                                wp_link_pages();
                                ?>
                            </div>
                            <?php
                            if($charity_show_tag && has_tag() && get_the_tag_list()){
                                do_action('templaza_single_tag_post');
                            }
                            if($charity_show_share){
                                ?>
                                <div class="templaza-single-share uk-margin-large-bottom">
                                    <?php do_action('templaza_share_post'); ?>
                                </div>
                            <?php }
                            $post_nav = posts_nav_link();
                            if($charity_show_post_next_preview){
                                do_action('templaza_single_next_post');
                            }
                            if($charity_show_author){
                                do_action('templaza_single_author_post');
                            }
                            if($charity_show_related){
                                do_action('templaza_single_related_post');
                            }
                            if($charity_show_comment){ ?>
                                <div class="templaza-single-comment">
                                    <?php comments_template( '', true ); ?>
                                </div><!-- end comments -->
                                <?php
                            }
                            ?>
                        </div>

                    </div>

                </div>
            </div>
        <?php
        endwhile; // end while ( have_posts )
        endif; // end if ( have_posts )
        ?>
    </div>
</div>