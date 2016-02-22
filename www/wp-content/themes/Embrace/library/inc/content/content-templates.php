<?php
/**
 * Page Templates Content
 * hook in the content for page templates
 *
 * @package Reactor
 * @author  Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since   1.0.0
 * @link    http://codex.wordpress.org/Function_Reference/register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/*----------------------------------------------------------------------------------
/*   Helpers functions
----------------------------------------------------------------------------------*/

/**
 * logo display
 * in the header of countdown
 *
 * @since 1.0.0
 */

function reactor_on_page_logo() {

	global $crum_theme_option;

	$logo = get_post_meta( get_the_ID(), '_soon_logo', true ) ? get_post_meta( get_the_ID(), '_soon_logo', true ) : $crum_theme_option['custom_logo_media']['url'];
	$desc = get_post_meta( get_the_ID(), '_soon_tagline', true ) ? get_post_meta( get_the_ID(), '_soon_tagline', true ) : get_bloginfo( 'description' );

	$logo = ( $logo ) ? '<img src="' . $logo . '" alt="' . get_bloginfo( 'name' ) . '" />' : '<h1>' . get_bloginfo( 'name' ) . '</h1>';

	if ( $logo ) {
		echo '<div class="logo">' . $logo . '</div>';
	}

	echo '<h3>' . $desc . '</h3>';

}


/**
 * logo display
 * in the header of countdown
 *
 * @since 1.0.0
 */

function reactor_countdown() {

	$count_time = get_post_meta( get_the_ID(), '_soon_date', true ) ? get_post_meta( get_the_ID(), '_soon_date', true ) : '';

	if ( $count_time ) {

		?>

		<script>
			jQuery(document).ready(function () {

				jQuery('#countdown').countdown('<?php echo $count_time ?>', function (event) {
					jQuery(this).html(event.strftime('<ul class="countdown"><li class="circle"><span class="digit">%D</span><span class="time"><?php _e('Days','crum') ?></span></li><li class="delim">:</li>' +
						'<li class="circle"><span class="digit">%H</span><span class="time"><?php _e('Hours','crum') ?></span><li class="delim">:</li>' +
						'<li class="circle"><span class="digit">%M</span><span class="time"><?php _e('mins','crum') ?></span></li><li class="delim">:</li>' +
						'<li class="circle"><span class="digit">%S</span><span class="time"><?php _e('secs','crum') ?></span></li></ul>'));
				});
			});
		</script>

		<div id="countdown"></div>



	<?php
	} else {
		echo '<h3>Please edit page and set proper time in additional field</h3>';
	}
}


/**
 * Subscribe form
 * in the header of countdown
 *
 * @since 1.0.0
 */


function reactor_subscribe_form() {

	$mail_address = get_post_meta( get_the_ID(), '_soon_mail', true ) ? get_post_meta( get_the_ID(), '_soon_mail', true ) : get_option( 'admin_email' );

	if ( isset( $_POST["submitted"] ) ) {

		if ( trim( $_POST['email'] ) === '' ) {
			$emailError = apply_filters( 'reactor_contactform_error_email', '<small class="error">Please enter your email address.</small>' );
			$errorClass = 'error';
			$hasError   = true;
		} else {
			if ( ! preg_match( "/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $_POST['email'] ) ) ) {
				$emailError = apply_filters( 'reactor_contactform_error_email_invalid', '<small class="error">You entered an invalid email address.</small>' );
				$errorClass = 'error';
				$hasError   = true;
			} else {
				$email = trim( $_POST['email'] );
			}
		}
		if ( ! isset( $hasError ) ) {
			$subscribe_message = 'Congratulations! You have new subscriber! His e-mail is: ' . $_POST["email"] . '';
			$subscribe_message = wordwrap( $subscribe_message, 70 );
			wp_mail( $mail_address, 'New Subscriber', $subscribe_message );
			$subscribtion = true;
		}
	}



	?>

	<?php if ( isset ( $subscribtion ) && $subscribtion == true ) { ?>
		<div class="thanks">
			<?php echo 'You have successfully subscribed!'; ?>
		</div>
	<?php } else { ?>
		<?php if ( ! isset ( $hasError ) ) {
			$emailError = '';
			$errorClass = '';
		}?>
		<!-- // SUBSCRIBE // -->
		<section id="subscribe">
			<form action="<?php the_permalink(); ?>" method="POST">
				<div class="row collapse">
					<div class="large-9 columns">
						<input type="text" class="text" name="email" placeholder="Your email address here" value="<?php if ( isset( $_POST['email'] ) ) {
							echo $_POST['email'];
						} ?>" />
						<?php if ( ! ( $emailError == '' ) ): ?>
							<span class="error"><?php echo $emailError; ?></span>
						<?php endif; ?>
					</div>

					<div class="large-3 medium-3 columns">
						<input type="submit" class="button expand" value="Subscribe">
					</div>
				</div>
				<input type="hidden" name="submitted" id="submitted" value="true" />
			</form>
		</section>
		<!-- // END SUBSCRIBE // -->
	<?php } ?>

<?php
}

/*----------------------------------------------------------------------------------
/*   Template including
----------------------------------------------------------------------------------*/


/**
 * Coming soon page
 *
 *
 * @since 1.0.0
 */

function soon_styles() {
	if ( is_page_template( 'page-templates/coming-soon.php' ) ):
		$custom_bg = get_post_meta( get_the_ID(), '_soon_background', true ) ? get_post_meta( get_the_ID(), '_soon_background', true ) : false;
		if ( $custom_bg ) {
			echo '<style type="text/css">html,body{height:100%} body{background: url(' . $custom_bg . ') center; }</style>';
		}

	endif;
}

add_action( 'wp_head', 'soon_styles', 70 );

function soon_top_page() {
	if ( is_page_template( 'page-templates/coming-soon.php' ) ):
		reactor_on_page_logo();
		reactor_countdown();
	endif;
}

add_action( 'reactor_page_before', 'soon_top_page', 1 );


function soon_bott_page() {
	if ( is_page_template( 'page-templates/coming-soon.php' ) ):
		reactor_subscribe_form();
	endif;
}

add_action( 'reactor_page_before', 'soon_bott_page', 1 );

/*----------------------------------------------------------------------------------
/*   Other Templates Functions
----------------------------------------------------------------------------------*/

function crum_portfolio_swohcase( $img_url, $thumb ) {
	global $post;
	$folio_item_link_zoom = reactor_option( 'folio_item_link_zoom', 1 );?>

	<div class="links">

		<a href="<?php the_permalink(); ?>"><i class="crumicon-forward"></i></a>

		<?php
		if ( $folio_item_link_zoom ) {
			$pp_gal               = array();
			$embed_url            = get_post_meta( $post->ID, '_folio_embed', true );
			$self_hosted_url_mp4  = get_post_meta( $post->ID, '_folio_self_hosted_mp4', true );
			$self_hosted_url_webm = get_post_meta( $post->ID, 'folio_self_hosted_webm', true );
			if ( metadata_exists( 'post', $post->ID, '_my_product_image_gallery' ) ) {
				$my_product_image_gallery = get_post_meta( $post->ID, '_my_product_image_gallery', true );
				$gal_img_ids              = explode( ',', $my_product_image_gallery );
				foreach ( $gal_img_ids as $gal_img_id ) {
					if ( $gal_img_id ) {
						$gal      = wp_get_attachment_image_src( $gal_img_id, 'large' );
						$pp_gal[] = ( '\'' . $gal[0] . '\'' );
					}
				}
				$pretty_gal = implode( ",", $pp_gal ); ?>
				<a href="<?php echo $img_url; ?>" class="zoom"><i class="crumicon-resize-enlarge"></i></a>

				<?php if ( $embed_url ) { ?>

					<a href="<?php echo $embed_url; ?>" class="zoom"><i class="crum-icon crum-youtube3"></i></a>

				<?php } elseif ( ( $self_hosted_url_mp4 || $self_hosted_url_webm ) && ! ( $thumb == '' ) ) { ?>

					<a href="<?php echo '#crum_self_hosted_mp4_' . $post->ID; ?>" class="zoom"><i class="crum-icon crum-youtube3"></i></a>
					<div id="<?php echo 'crum_self_hosted_mp4_' . $post->ID; ?>" class="hide">

						<video id="video-post<?php the_ID(); ?>" class="video-js vjs-default-skin" controls
							   preload="auto"
							   width="800"
							   height="600"
							   poster="<?php echo $thumb ?>"
							   data-setup="{}">

							<?php if ( $self_hosted_url_mp4 ): ?>
								<source src="<?php echo $self_hosted_url_mp4; ?>"
										type='video/mp4'>
							<?php endif; ?>
							<?php if ( $self_hosted_url_webm ): ?>
								<source src="<?php echo $self_hosted_url_webm; ?>"
										type='video/webm'>
							<?php endif; ?>
						</video>
					</div>

				<?php } ?>

				<?php if ( $my_product_image_gallery ): ?>

					<a id="<?php echo 'gal_link_' . $post->ID; ?>" href="#"><i class="crumicon crumicon-camera"></i></a>

				<?php endif;


			}
			?>

		<?php }; ?>
	</div>

	<script type="text/javascript">
		jQuery("#<?php echo 'gal_link_'.$post->ID; ?>").on("click", function (e) {
			api_images = [<?php echo $pretty_gal;?>];
			jQuery.prettyPhoto.open(api_images);
			e.preventDefault();
		});
	</script>

<?php }