<?php
defined('ABSPATH') or exit();
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $options = array();
}else{
    $options            = Functions::get_theme_options();
}
$post_type          = get_post_type(get_the_ID());
$prefix             = $post_type.'-page';
if($post_type == 'post'){
    $prefix = 'blog-page';
}
if($post_type == 'post' && is_single()){
    $prefix = 'blog-single';
}
$show_comment_count = isset($options[$prefix.'-comment-count'])?filter_var($options[$prefix.'-comment-count'], FILTER_VALIDATE_BOOLEAN):false;

$show_post_view     = isset($options[$prefix.'-post-view'])?filter_var($options[$prefix.'-post-view'], FILTER_VALIDATE_BOOLEAN):false;
?>
<dl class="templaza-blog-item-info templaza-post-meta templaza-post-meta-header uk-article-meta uk-margin-remove-bottom">
    <?php if ($show_date){ ?>
        <dd><?php echo esc_attr(get_the_date()); ?></dd>
    <?php } ?>
    <?php if ($show_comment_count){ ?>
        <dd class="comment_count">
            <?php do_action('templaza_get_commentcount_post'); ?>
        </dd>
    <?php } ?>
    <?php if($show_post_view):?>
        <dd class="views">
            <?php do_action('templaza_get_postviews',get_the_ID()); ?>
        </dd>
    <?php endif; ?>
</dl>