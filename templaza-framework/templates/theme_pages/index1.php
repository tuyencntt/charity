<?php
/*
 * Archive Service
 */
defined('TEMPLAZA_FRAMEWORK');
use TemPlazaFramework\Functions;

$charity_id             = isset($atts['id'])?$atts['id']:time();
$charity_custom_class   = isset($atts['custom_container_class'])?' '.$atts['custom_container_class']:'';
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $charity_options = array();
}else{
    $charity_options            = Functions::get_theme_options();
}

$charity_post_type          = get_post_type(get_the_ID());
$prefix             = $charity_post_type.'-page';

if($charity_post_type == 'post' || is_search()){
    $prefix = 'blog-page';
}
if(isset($_GET['view'])){
    $blog_layout = $_GET['view'];
}else{
    $blog_layout        = isset($options[$prefix.'-layout'])?$options[$prefix.'-layout']:'list';
}
$charity_grid_col      = isset($options[$prefix.'-grid-column'])?$options[$prefix.'-grid-column']:2;
$charity_thumbnail_size= isset($options[$prefix.'-thumbnail-size'])?$options[$prefix.'-thumbnail-size']:'large';
$charity_thumbnail_effect = isset($options[$prefix.'-thumbnail-effect'])?$options[$prefix.'-thumbnail-effect']:'none';
$charity_leading      = isset($options[$prefix.'-leading'])?filter_var($options[$prefix.'-leading'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_thumbnail     = isset($options[$prefix.'-thumbnail'])?filter_var($options[$prefix.'-thumbnail'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_title         = isset($options[$prefix.'-title'])?filter_var($options[$prefix.'-title'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_description   = isset($options[$prefix.'-description'])?filter_var($options[$prefix.'-description'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_readmore      = isset($options[$prefix.'-readmore'])?filter_var($options[$prefix.'-readmore'], FILTER_VALIDATE_BOOLEAN):false;
$charity_show_share         = isset($options[$prefix.'-share'])?filter_var($options[$prefix.'-share'], FILTER_VALIDATE_BOOLEAN):false;
$charity_show_thumbnail_audio = isset($options[$prefix.'-thumb-audio'])?filter_var($options[$prefix.'-thumb-audio'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_thumbnail_video = isset($options[$prefix.'-thumb-video'])?filter_var($options[$prefix.'-thumb-video'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_thumbnail_link = isset($options[$prefix.'-thumb-link'])?filter_var($options[$prefix.'-thumb-link'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_thumbnail_quote = isset($options[$prefix.'-thumb-quote'])?filter_var($options[$prefix.'-thumb-quote'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_pagination = isset($options[$prefix.'-pagination'])?filter_var($options[$prefix.'-pagination'], FILTER_VALIDATE_BOOLEAN):true;
$charity_show_category      = isset($options[$prefix.'-category'])?filter_var($options[$prefix.'-category'], FILTER_VALIDATE_BOOLEAN):true;
$blog_cl = '';
if ($blog_layout == 'grid') {
    $bl_layout_cl = 'templaza-blog-grid uk-child-width-1-'.$charity_grid_col.'@m';
    $blog_cl = '';
}else{
    $bl_layout_cl = 'templaza-blog-list uk-child-width-1-1';
    $blog_cl = '';
}
?>
<div id="templaza-archive-<?php echo esc_attr($id);?>" class="templaza-blog templaza-archive templaza-archive-<?php echo get_post_type().esc_attr($custom_class); ?>">
    <div class="templaza-blog-body <?php echo esc_attr($bl_layout_cl);?>" data-uk-grid>
        <?php
        $d=1;
        global $wp_query;
        if($wp_query->found_posts==0 && is_search()){
            do_action('templaza_search_no_result');
        }
        if (have_posts()) : while (have_posts()) : the_post();
            $format = get_post_format() ? : 'standard';
            if(is_sticky(get_the_ID())){
                $sticky_cl = 'templaza-sticky';
            }else{
                $sticky_cl = '';
            }
            if($blog_leading && $d==1 && $blog_layout=='grid'){
                $lead = 'uk-width-1-1';
                $wrap_lead_content = 'uk-container-small uk-container templaza-item-lead';
            }else{
                $lead = $wrap_lead_content = ' ';
            }
            ?>
            <div id='post-<?php the_ID(); ?>' class="<?php echo esc_attr($blog_cl. ' '.$sticky_cl.' '.$lead); ?> templaza-blog-item ">
                <div class="templaza-blog-item-wrap">
                    <?php
                    if(is_sticky(get_the_ID()) && has_post_thumbnail()){
                        ?>
                        <span class="templaza-sticky-post" title="<?php echo esc_html__('Sticky Post','charity');?>"><i class="fas fa-thumbtack"></i></span>
                        <?php
                    }
                    if ($charity_show_thumbnail){
                        if ($format == 'gallery') {
                            do_action('templaza_gallery_post');
                        }
                        if($format == 'standard'){
                            do_action('templaza_image_post');
                        }
                        if ($format =='video') {
                            if ($charity_show_thumbnail_video){
                                do_action('templaza_image_post');
                            }else{
                                do_action('templaza_video_post');
                            }
                        }
                        if ($format =='audio'){
                            if ($charity_show_thumbnail_audio){
                                do_action('templaza_image_post');
                            }else{
                                do_action('templaza_audio_post');
                            }
                        }
                        if ($format =='link'){
                            if ($charity_show_thumbnail_link){
                                do_action('templaza_image_post');
                            } else {
                                do_action('templaza_link_post');
                            }
                        }
                        if ($format == 'quote'){
                            if ($charity_show_thumbnail_quote){
                                do_action('templaza_image_post');
                            } else {
                                do_action('templaza_quote_post');
                            }
                        }
                    }
                    if ($format !='quote' && $format !='link') {
                        ?>
                        <div class="templaza-blog-item-content <?php echo esc_attr($wrap_lead_content);
                        if ($charity_show_thumbnail && has_post_thumbnail()) echo esc_attr(' uk-padding'); ?>">
                            <?php if ($show_category) { ?>
                                <span class="category">
                                <?php the_category(', '); ?>
                            </span>
                            <?php }
                            if ($charity_show_title) {
                                do_action('templaza_title_post');
                            }
                            if ($charity_show_description) {
                                do_action('templaza_excerpt_post');
                            }
                            if ($charity_show_share) {
                                do_action('templaza_share_post');
                            }
                            if ($charity_show_readmore) {
                                do_action('templaza_readmore_post');
                            }
                            do_action('templaza_meta_post_footer');
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            $d++;
        endwhile; // end while ( have_posts )

        endif; // end if ( have_posts )
        ?>
    </div>
    <?php if($show_pagination){?>
        <div class="templaza-blog-pagenavi">
            <?php
            do_action('templaza_pagination');
            ?>
        </div>
    <?php } ?>
</div>