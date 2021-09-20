<?php
if(!class_exists('Charity_Theme_Functions')){
    class Charity_Theme_Functions{
        public function __construct(){
            $this -> hook();
        }
        public static function locate_my_template($template_names, $load = false, $require_once = true, $args = array()){
            $located    = '';
            foreach ( (array) $template_names as &$template_name ) {
                if ( ! $template_name ) {
                    continue;
                }
                if(!preg_match('/\.php$/i', $template_name)){
                    $template_name  .= '.php';
                }
                if ( file_exists( get_template_directory() . '/templaza-framework/templates/' . $template_name ) ) {
                    $located = get_template_directory() . '/templaza-framework/templates/' . $template_name;
                    break;
                }
            }
            if($load && $located != '') {
                load_template($located, $require_once, $args);
            }

            return $located;
        }
        public function load_my_layout($partial, $load = true, $require_once = true, $args = array()){
            $partial    = str_replace('.', '/', $partial);
            $located    = self::locate_my_template((array) $partial, $load, $require_once, $args);

            return $located;
        }
        public function hook(){
            add_filter('user_contactmethods', array($this, 'templaza_modify_contact_methods'));
            add_filter('wp_kses_allowed_html', array($this, 'templaza_wpkses_post_tags'), 10, 2);
            add_filter('upload_mimes', array($this, 'templaza_mime_types'));
            add_filter('edit_post_link', array($this, 'templaza_edit_post_link'),10,3);
            add_filter('the_content_more_link', array($this, 'templaza_modify_read_more_link'));

            add_action('templaza_get_postviews',array($this,'templaza_get_post_views'));
            add_action('templaza_set_postviews',array($this,'templaza_set_post_views'));
            add_action('templaza_get_commentcount_post',array($this,'templaza_get_comment_count_post'));
            add_action('templaza_breadcrumb',array($this,'templaza_breadcrumbs'));
            add_action('templaza_share_post',array($this,'templaza_get_share_social'));
            add_action('templaza_pagination',array($this,'templaza_pagination'));
            add_action('templaza_gallery_post',array($this,'templaza_get_gallery_post'));
            add_action('templaza_image_post',array($this,'templaza_get_image_post'));
            add_action('templaza_video_post',array($this,'templaza_get_video_post'));
            add_action('templaza_audio_post',array($this,'templaza_get_audio_post'));
            add_action('templaza_title_post',array($this,'templaza_get_title_post'));
            add_action('templaza_meta_post_header',array($this,'templaza_get_meta_post_header'));
            add_action('templaza_meta_post_footer',array($this,'templaza_get_meta_post_footer'));
            add_action('templaza_link_post',array($this,'templaza_get_link_post'));
            add_action('templaza_quote_post',array($this,'templaza_get_quote_post'));
            add_action('templaza_excerpt_post',array($this,'templaza_get_excerpt_post'));
            add_action('templaza_readmore_post',array($this,'templaza_get_readmore_post'));
            add_action('templaza_single_title_post',array($this,'templaza_single_get_title_post'));
            add_action('templaza_single_meta_post',array($this,'templaza_single_get_meta_post'));
            add_action('templaza_single_tag_post',array($this,'templaza_single_get_tag_post'));
            add_action('templaza_single_next_post',array($this,'templaza_single_get_next_post'));
            add_action('templaza_single_author_post',array($this,'templaza_single_get_author_post'));
            add_action('templaza_single_related_post',array($this,'templaza_single_get_related_post'));
            add_action('templaza_author_social',array($this,'templaza_author_social'));
            add_action('templaza_search_no_result',array($this,'templaza_search_no_result'));
            add_action('templaza_archive_no_result',array($this,'templaza_archive_no_result'));
            add_action('templaza_all_taxonomy',array($this,'templaza_all_taxonomy'),10,2);

        }
        public function templaza_modify_contact_methods($profile_fields)
        {
            $profile_fields['job'] = 'Job';
            $profile_fields['facebook'] = esc_html__('Facebook URL','charity');
            $profile_fields['twitter'] = esc_html__('Twitter URL','charity');
            $profile_fields['instagram'] = esc_html__('Instagram URL','charity');
            $profile_fields['dribbble'] = esc_html__('Dribbble URL','charity');
            $profile_fields['linkedin'] = esc_html__('Linkedin URL','charity');
            $profile_fields['pinterest'] = esc_html__('Pinterest URL','charity');
            $profile_fields['youtube'] = esc_html__('Youtube URL','charity');
            $profile_fields['vimeo'] = esc_html__('Vimeo URL','charity');
            $profile_fields['flickr'] = esc_html__('Flickr URL','charity');
            $profile_fields['tumblr'] = esc_html__('Tumblr URL','charity');
            $profile_fields['whatsapp'] = esc_html__('WhatsApp URL','charity');
            return $profile_fields;
        }
        public function templaza_modify_read_more_link() {
            return '';
        }

        public function templaza_get_post_views($postID)
        {
            $args   = get_defined_vars();
            $this->load_my_layout('template-parts.content-views',true,false,$args);
        }

        function templaza_set_post_views($postID)
        {
            $count_key = 'post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if ($count == '') {
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            } else {
                $count++; // Incremental view
                update_post_meta($postID, $count_key, $count); // update count
            }
        }

        public function templaza_get_comment_count_post()
        {
            $templaza_comment_count = wp_count_comments(get_the_ID());
            if ($templaza_comment_count->approved == ''|| $templaza_comment_count->approved < 2) {
                echo esc_html__('Comment:','charity').' '.esc_html($templaza_comment_count->approved);
            }else{
                echo esc_html__('Comments:','charity').' '.esc_html($templaza_comment_count->approved);
            }
        }

        public function templaza_wpkses_post_tags( $tags, $context ) {
            if ( 'post' === $context ) {
                $tags['iframe'] = array(
                    'src'             => true,
                    'height'          => true,
                    'width'           => true,
                    'frameborder'     => true,
                    'allowfullscreen' => true,
                    'data-uk-responsive' => true,
                    'data-uk-video' => true,
                );
            }

            return $tags;
        }

        function templaza_author_social () {
            $author_social = array('facebook','twitter','instagram','dribbble','linkedin','pinterest','youtube','vimeo','flickr','tumblr','whatsapp');
            foreach($author_social as $item){
                if(get_the_author_meta($item)){
                    ?>
                    <a href="<?php echo esc_url(get_the_author_meta($item));?>" target="_blank">
                        <i class="fab fa-<?php echo esc_attr($item);?>"></i>
                    </a>
                    <?php
                }
            }
        }        

        public function templaza_mime_types( $mimes ){
            $mimes['svg'] = 'image/svg+xml';
            return $mimes;
        }

        public function templaza_pagination() {
            the_posts_pagination( array(
                'type' => 'plain',
                'mid_size' => 2,
                'prev_text' => ent2ncr('<i class="fa fa-angle-double-left"></i>'),
                'next_text' => ent2ncr('<i class="fa fa-angle-double-right"></i>'),
                'screen_reader_text' => '',
            ) );
        }
        public function templaza_edit_post_link($link, $post_id, $text) {
            if ( is_admin() ) {
                return $link;
            }

            $edit_url = get_edit_post_link( $post_id );

            if ( ! $edit_url ) {
                return;
            }

            return '<span class="post-edit"><i class="fas fa-edit"></i><a href="' . esc_url( $edit_url ) . '">' . esc_html__('Edit','charity') . '</a></span>';
        }

        public function templaza_get_share_social () {
            $this->load_my_layout('template-parts.content-share',true,false);
        }

        public function templaza_breadcrumbs() {
            $this->load_my_layout('template-parts.breadcrumb_html');
        }

        public function templaza_get_gallery_post() {
            $this->load_my_layout('template-parts.content-gallery',true,false);
        }

        public function templaza_get_image_post() {
            $this->load_my_layout('template-parts.content-image',true,false);
        }

        public function templaza_get_video_post() {
            $this->load_my_layout('template-parts.content-video',true,false);
        }

        public function templaza_get_audio_post() {
            $this->load_my_layout('template-parts.content-audio',true,false);
        }

        public function templaza_get_title_post() {

            $this->load_my_layout('template-parts.content-title',true,false);
        }

        public function templaza_get_meta_post_header() {
            $this->load_my_layout('template-parts.content-meta-header',true,false);
        }
	    public function templaza_get_meta_post_footer() {
		    $this->load_my_layout('template-parts.content-meta-footer',true,false);
	    }

        public function templaza_get_link_post() {
            $this->load_my_layout('template-parts.content-link',true,false);
        }

        public function templaza_get_quote_post() {
            $this->load_my_layout('template-parts.content-quote',true,false);
        }

        public function templaza_get_excerpt_post() {
            $this->load_my_layout('template-parts.content-excerpt',true,false);
        }

        public function templaza_get_readmore_post() {
            $this->load_my_layout('template-parts.content-readmore',true,false);
        }

        public function templaza_single_get_title_post() {
            $this->load_my_layout('template-parts.content-single-title',true,false);
        }

        public function templaza_single_get_meta_post() {
            $this->load_my_layout('template-parts.content-single-meta',true,false);
        }

        public function templaza_single_get_tag_post() {
            $this->load_my_layout('template-parts.content-single-tag',true,false);
        }

        public function templaza_single_get_next_post() {
            $this->load_my_layout('template-parts.content-single-next-preview',true,false);
        }

        public function templaza_single_get_author_post() {
            $this->load_my_layout('template-parts.content-single-author',true,false);
        }

        public function templaza_single_get_related_post() {
            $this->load_my_layout('template-parts.content-single-related',true,false);
        }

        public  function templaza_search_no_result( ) {
            $this->load_my_layout('template-parts.content-search-no-result', true, false);
        }

        public  function templaza_archive_no_result( ) {
            $this->load_my_layout('template-parts.content-archive-no-result', true, false);
        }

        public  function templaza_all_taxonomy( $taxonomy,$empty) {
            $args   = get_defined_vars();
            $this->load_my_layout('template-parts.all-taxonomy', true, false,$args);
        }

    }

    $charity_theme_functions = new Charity_Theme_Functions();

}