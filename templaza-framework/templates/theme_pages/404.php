<?php
use TemPlazaFramework\CSS;
use TemPlazaFramework\Functions;
use TemPlazaFramework\Templates;

$error = new WP_Error();

$options    = Functions::get_theme_options();

$errorContent   = isset($options['404-content'])?$options['404-content']:'';
$errorButton    = isset($options['404-call-to-action'])?$options['404-call-to-action']:'';
// Background Image
$background_setting_404    = isset($options['404-background-setting'])?$options['404-background-setting']:0;

$styles = '';
$video  = [];
if($background_setting_404){
    if($background_setting_404 =="color"){
        $background_color_404 = isset($options['404-background-color'])?$options['404-background-color']:'';

        if (!empty($background_color_404)) {
            $bg_color   = CSS::make_color_rgba($background_color_404['color'], $background_color_404['alpha'],
                $background_color_404['rgba']);
            if(!empty($bg_color)) {
                $styles = 'background-color:' . $bg_color;
            }
        }
    }
    if($background_setting_404 =="image"){
        $background_404 = isset($options['404-background'])?$options['404-background']:array();
        if(count($background_404)){
            $styles .= CSS::background($background_404['background-color'], $background_404['background-image'],
                $background_404['background-repeat'], $background_404['background-attachment'],
                $background_404['background-position'], $background_404['background-size']);
        }
    }

    if($background_setting_404 =="video"){
        $attributes = [];
        $background_video_404 = isset($options['404-background-video'])?$options['404-background-video']:array();

        if (count($background_video_404) && !empty($background_video_404['url'])) {
            $attributes['data-templaza-video-bg'] = $background_video_404['url'];
//            $videobgjs = 'vendor/jquery.jdvideobg.js';
//            if(!isset($template->_js[$videobgjs])){
//                $template->addScript($videobgjs);
            wp_enqueue_script('tzfrm_templazavideobg', Functions::get_my_url().'/assets/js/vendor/jquery.templazavideobg.js');
//            }
        }

        $return = [];
        foreach ($attributes as $key => $value) {
            $return[] = $key . '="' . $value . '"';
        }
        $video =  $return;
    }

    if(!empty($styles)){
        Templates::add_inline_style('.templaza-error-page{'.$styles.'}');
    }
}
?>
    <div class="templaza-error-page uk-container uk-container-small uk-text-center">
        <div class="col-12 text-center align-self-center">
            <?php
            if (!empty($errorContent) && $error ->has_errors()) {
                $errorContent   = str_replace('{errorcode}', $error -> get_error_code(), $errorContent);
                $errorContent   = str_replace('{errormessage}', htmlspecialchars($error ->get_error_message(), ENT_QUOTES, 'UTF-8'), $errorContent);
                echo  wp_kses_post($errorContent);

            } elseif($error -> has_errors()) {
                ?>
                <div class="py-5">
                    <h2 class="display-1"><?php echo esc_html($error -> get_error_code()); ?></h2>
                    <h5 class="display-4"><?php echo esc_html(htmlspecialchars($error -> get_error_message(), ENT_QUOTES, 'UTF-8')); ?></h5>
                </div>
                <?php
            }else{
            ?>
                <h1 class="title-404"><?php echo esc_html__('404 ERROR!', 'charity'); ?></h1>
                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'charity' ); ?></p>
                <?php get_search_form(); ?>
            <?php
            }
            ?>
            <a class="btn btn-backtohome" href="<?php echo get_home_url(); ?>" role="button"><?php echo esc_html($errorButton); ?></a>

        </div>
    </div>
