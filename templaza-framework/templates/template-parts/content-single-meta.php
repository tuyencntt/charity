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
$show_comment_count = isset($options[$prefix.'-comment-count'])?filter_var($options[$prefix.'-comment-count'], FILTER_VALIDATE_BOOLEAN):true;
$show_date          = isset($options[$prefix.'-date'])?filter_var($options[$prefix.'-date'], FILTER_VALIDATE_BOOLEAN):true;
$show_author        = isset($options[$prefix.'-author'])?filter_var($options[$prefix.'-author'], FILTER_VALIDATE_BOOLEAN):true;
$show_category      = isset($options[$prefix.'-category'])?filter_var($options[$prefix.'-category'], FILTER_VALIDATE_BOOLEAN):true;
$show_post_view         = isset($options[$prefix.'-post-view'])?filter_var($options[$prefix.'-post-view'], FILTER_VALIDATE_BOOLEAN):false;
?>
<dl class="templaza-blog-item-info templaza-post-meta uk-article-meta">
    <?php if ($show_date){ ?>
        <dd><i class="fa fa-calendar"></i><?php echo esc_attr(get_the_date()); ?></dd>
    <?php } ?>
    <?php if($show_author){ ?>
        <dd class="author">
            <i class="fas fa-user"></i>
            <?php echo get_the_author_posts_link();?>
        </dd>
    <?php } ?>
    <?php if ($show_comment_count){ ?>
        <dd class="comment_count">
            <i class="fas fa-comment"></i>
            <?php do_action('templaza_get_commentcount_post'); ?>
        </dd>
    <?php } ?>
    <?php if($show_post_view):?>
        <dd class="views">
            <i class="fas fa-eye"></i>
            <?php do_action('templaza_get_postviews',get_the_ID()); ?>
        </dd>
    <?php endif; ?>
    <?php if($show_category){ ?>
        <dd class="category">
            <i class="fas fa-folder"></i>
            <?php the_category(', '); ?>
        </dd>
    <?php } ?>
    <?php if(is_sticky() && is_single()){ ?>
        <dd class="sticky">
            <i class="fas fa-thumbtack"></i>
            <?php echo esc_html__('Sticky','charity');?>
        </dd>
    <?php } ?>
    <?php
    edit_post_link();
    ?>
</dl>