<?php

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area templaza-comment-form uk-margin-medium">
    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) :
        ?>
        <h3 class="comments-title box-title uk-margin-medium-bottom">
            <?php
            $charity_comment_count = get_comments_number();
            if ( '1' === $charity_comment_count ) {
                echo number_format_i18n( $charity_comment_count );
                ?>
            <strong><?php echo esc_html__('Comment','charity')?></strong>
            <?php
            } else {
                echo number_format_i18n( $charity_comment_count );
                ?>
                <strong><?php echo esc_html__('Comments','charity')?></strong>
            <?php
            }
            ?>
        </h3><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
	            'style'      => 'ol',
	            'short_ping' => true,
	            'avatar_size' => 75,
            ) );
            ?>
        </ol><!-- .comment-list -->

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() ) :
            ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'charity' ); ?></p>
        <?php
        endif;

    endif; // Check for have_comments().
    ?>

    <div class="CommentForm">
        <?php
        $charity_commenter = wp_get_current_commenter();
        $charity_req      = get_option( 'require_name_email' );
        $charity_aria_req = ( $charity_req ? " aria-required='true'" : '' );
        $charity_comment_title = esc_html__( 'Leave a Comment','charity').'';
        if(!is_user_logged_in()){
            $charity_args = array(
                'comment_notes_after' => '',
                'fields' => apply_filters( 'comment_form_default_fields',
                    array(
                        '<div class="content-form content-flex row">',
                        'author' => '<div class="col comment-form-author">'
                            . '<input id="author" name="author" type="text" value="' . esc_attr( $charity_commenter['comment_author'] ) . '" size="30"' . $charity_aria_req . ' placeholder="'.esc_attr__('Enter your name...','charity').'" /></div>',
                        'email'  => '<div class="col comment-form-email">'
                            . '<input id="comment-email" name="email" type="text" value="' . esc_attr(  $charity_commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $charity_aria_req . ' placeholder="'.esc_attr__('Email','charity').'" /></div>',
                        'subject'  => '<div class="col comment-form-subject">'
                            . '<input id="comment-subject" name="subject" type="text" value="" size="30" placeholder="'.esc_attr__('Subject','charity').'" /></div>',
                        '</div>',
                    )
                ),
                'comment_field'        => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="90" rows="4" required="required" placeholder="'.esc_attr__('Your Comments...','charity').'"></textarea></div>',
                'label_submit'      =>  esc_html__( 'Submit','charity'),
                'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title box-title">',
                'title_reply_after' => '</h3>',
                'title_reply'       =>  $charity_comment_title,
                'class_submit'  =>'templaza-btn'
            );
        }else{
            $charity_args = array(
                'comment_notes_after' => '',
                'fields' => apply_filters( 'comment_form_default_fields',
                    array(
                        '<div class="content-form">',
                        'author' => '<div class="comment-form-author">'
                            .'<label>'.( $charity_req ? esc_html__('Your Name','charity') : '' ).'</label>'
                            . '<input id="author" name="author" type="text" value="' . esc_attr( $charity_commenter['comment_author'] ) . '" size="30"' . $charity_aria_req . ' /></div>',
                        'email'  => '<div class="comment-form-email">'
                            .'<label>'.( $charity_req ? esc_html__('Your Email','charity') : '' ).'</label>'
                            . '<input id="comment-email" name="email" type="text" value="' . esc_attr(  $charity_commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $charity_aria_req . ' /></div>',
                        'subject' => '<div class="comment-form-subject">',
                        '</div>'
                    )
                ),
                'comment_field'        => '<div class="comment-form-comment login"><label>'.esc_html__('Comments','charity').'</label> <textarea id="comment" name="comment" cols="90" rows="4" required="required"></textarea></div>',
                'label_submit'      =>  esc_html__( 'Submit','charity'),
                'title_reply'       =>  $charity_comment_title,
                'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title box-title">',
                'title_reply_after' => '</h3>',
                'class_submit'  =>'templaza-btn'
            );
        }

        comment_form( $charity_args ); ?>
    </div>

</div><!-- #comments -->
