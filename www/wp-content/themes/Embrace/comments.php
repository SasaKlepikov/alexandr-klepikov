<?php
/**
 * The template for displaying comments
 * uses callback reactor_comments in includes/comments.php
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */

// Do not delete these lines
if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die ('Please do not load this page directly. Thanks!');
} ?>

<?php if ( post_password_required() ) { ?>
<div class="alert help">
  <p class="nocomments">
    <?php _e('This post is password protected. Enter the password to view comments.', 'crum'); ?>
  </p>
</div>
<?php return; } ?>

<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
    <h2 class="comments-title">
		<?php comments_number(__('No Responses','crum'),__('One Response','crum'),__( '% Responses  ','crum'));?>
    </h2>
    <ol class="commentlist">
		<?php wp_list_comments( array('callback' => 'reactor_comments', 'style' => 'ol') ); ?>
    </ol>
    
		<?php if ( get_comment_pages_count() > 1 && get_option('page_comments') ) : ?>
        <nav id="comment-nav-below" class="navigation" role="navigation">
            <div class="nav-previous"><?php previous_comments_link( __('&larr; Older Comments', 'crum') ); ?></div>
            <div class="nav-next"><?php next_comments_link( __('Newer Comments &rarr;', 'crum') ); ?></div>
        </nav>
		<?php endif; ?>
    
	<?php elseif ( !comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments') ) : ?>
        <p class="nocomments"><?php _e('Comments are closed.', 'crum'); ?></p>
    <?php endif; ?>
    
    <?php if ( comments_open() ) : ?>
    <div id="respond-form">
		<div id="cancel-comment-reply">
			<p class="small">
				<?php cancel_comment_reply_link(); ?>
			</p>
		</div>
      
		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<div class="alert help">
			<p><?php printf('You must be %1$slogged in%2$s to post a comment.', '<a href="<?php echo wp_login_url( get_permalink() ); ?>">', '</a>'); ?></p>
		</div>
      
      <?php else : 
	       comment_form( array( 
                'logged_in_as' => '<div class="row"><p class="comments-logged-in-as  large-12 columns">' . __('Logged in as', 'crum') . ' <a href="' . get_option('url') .'/wp-admin/profile.php">' . $user_identity . '</a>. <a href="' . wp_logout_url( get_permalink() ) . '" title="' . __('Log out of this account', 'crum') . '">' . __('Log out', 'crum') . '&raquo;</a></p>',
				
                'fields' => array( 
                    'author' => '<div class="row"><p class="comment-form-author large-6 columns"><label for="author">' . __('Name ', 'crum') . ( $req ? __('( required )', 'crum') : '') . '</label> '.'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . __('Your Name*', 'crum') . '" tabindex="1"' . ( $req ? __( "aria-required='true'" ) : '') . ' /></p>',
				
					'email' => '<p class="comment-form-email large-6 columns"><label for="email">' . __('Email ', 'crum') . ( $req ? __('( required )', 'crum') : '') . '</label> '.'<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . __('Your E-Mail*', 'crum') . '" tabindex="2"' . ( $req ? __( "aria-required='true'" ) : '') . ' /></p>',
				
					//'url' => '<p class="comment-form-url large-6 columns end"><label for="url">' . __('Website ', 'crum') . '</label>' . '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __('URL ', 'crum') . '" tabindex="3" /></p>',
                ),	
				
					'comment_field' => '<p class="comment-form-comment large-12 columns"><label for="comment">' . __('Your Comment ', 'crum') . '</label>' . '<textarea name="comment" id="comment" placeholder="' . __('Your Comment here...', 'crum') . '" rows="8" tabindex="4"></textarea></p></div>',
				
					'comment_notes_after' => '',
				
					'label_submit' => __('Send Message', 'crum'),

					'class_submit' => 'button ',
				
					'id_submit' => 'submit'
				

			) );  
		endif; ?>

    </div>
    <?php endif; ?>
</div><!-- end #comments -->
<?php endif; ?>
