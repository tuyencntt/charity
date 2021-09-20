<?php
defined('ABSPATH') or exit();
$title = html_entity_decode(get_the_title(get_the_ID()));
$tweet_title = urlencode($title);
?>
<div class="templaza-blog-share uk-article-meta uk-margin-top">
    <a class="facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_the_permalink(get_the_ID())); ?>">
        <i class="fab fa-facebook"></i>
        <span><?php esc_html__('Facebook','charity');?></span>
    </a>
    <a class="twitter" target="_blank" href="https://twitter.com/home?status=Check%20out%20this%20article:%20<?php print esc_attr($tweet_title); ?>%20-%20<?php echo urlencode(get_the_permalink(get_the_ID())); ?>">
        <i class="fab fa-twitter"></i>
        <span><?php esc_html__('Tweet','charity');?></span>
    </a>
    <?php $templaza_pin_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID())); ?>
    <a class="pinterest" data-pin-do="skipLink" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_attr($templaza_pin_image); ?>&description=<?php echo urlencode(get_the_title(get_the_ID())); ?>">
        <i class="fab fa-pinterest"></i>
        <span><?php esc_html__('Pinterest','charity');?></span>
    </a>
    <a class="linkedin" target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(get_the_ID()); ?>">
        <i class="fab fa-linkedin"></i>
        <span><?php esc_html__('Linkedin','charity');?></span>
    </a>
</div>