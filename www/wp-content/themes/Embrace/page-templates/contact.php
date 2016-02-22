<?php
/**
 * Template Name: Contact Page
 *
 * @package   Reactor
 * @subpackge Page-Templates
 * @link      http://www.catswhocode.com/blog/how-to-create-a-built-in-contact-form-for-your-wordpress-theme
 * @since     1.0.0
 */


$page_lay = reactor_option( '', '', '_page_layout_select' );
$custom_form = reactor_option( '', '', '_custom_form_shortcode' );
?>


<?php // get the page options
$contact_email = reactor_option( 'contact_email_to', get_option( 'admin_email' ) );
$email_subject = reactor_option( 'contact_email_subject', get_bloginfo( 'name' ) . __( ' - Contact Form Message', 'crum' ) );
$msg_sent = reactor_option( 'contact_email_sent', __( 'Thank you! Your email was sent successfully.', 'crum' ) );
$additional_text = wpautop( reactor_option( false, false, '_contacts_text' ) );


// begin form validation
if ( isset( $_POST['submitted'] ) ) {
	if ( trim( $_POST['contactName'] ) === '' ) {
		$nameError  = apply_filters( 'reactor_contactform_error_name', '<small class="error">Please enter your name.</small>' );
		$errorClass = 'error';
		$hasError   = true;
	}
	else {
		$name = trim( $_POST['contactName'] );
	}
	if ( trim( $_POST['email'] ) === '' ) {
		$emailError = apply_filters( 'reactor_contactform_error_email', '<small class="error">Please enter your email address.</small>' );
		$errorClass = 'error';
		$hasError   = true;
	}
	else {
		if ( ! preg_match( "/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $_POST['email'] ) ) ) {
			$emailError = apply_filters( 'reactor_contactform_error_email_invalid', '<small class="error">You entered an invalid email address.</small>' );
			$errorClass = 'error';
			$hasError   = true;
		}
		else {
			$email = trim( $_POST['email'] );
		}
	}
	if ( trim( $_POST['comments'] ) === '' ) {
		$commentError = apply_filters( 'reactor_contactform_error_message', '<small class="error">Please enter a message.</small>' );
		$errorClass   = 'error';
		$hasError     = true;
	}
	else {
		if ( function_exists( 'stripslashes' ) ) {
			$comments = stripslashes( trim( $_POST['comments'] ) );
		}
		else {
			$comments = trim( $_POST['comments'] );
		}
	}
	if ( ! isset( $hasError ) ) {
		$emailTo = get_option( 'tz_email' );
		if ( ! isset( $emailTo ) || ( $emailTo == '' ) ) {
			$emailTo = apply_filters( 'reactor_contactform_emailto', $contact_email );
		}
		$subject = apply_filters( 'reactor_contactform_subject', $email_subject );
		$body    = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: ' . $name . ' <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;
		wp_mail( $emailTo, $subject, $body, $headers );
		$emailSent = true;
	}

} // end form validation
?>

<?php get_header(); ?>

<div id="primary" class="site-content">

<?php reactor_content_before(); ?>

	<div id="content" role="main">

<?php set_layout( 'pages', true, $page_lay ); ?>

<?php reactor_inner_content_before(); ?>

<?php // get the page loop
get_template_part( 'loops/loop', 'page' ); ?>

<?php // begin contact form ?>

	<div class="row">
		<div class="<?php reactor_columns( 12 ); ?>">
			<div class="row">

				<?php if ($additional_text): ?>

				<div class="<?php reactor_columns( 4 ) ?>">
					<div class="additional-text">
						<?php echo do_shortcode( $additional_text ); ?>
					</div>
				</div>

				<div class="<?php reactor_columns( 8 ) ?>">

					<?php else: ?>

					<div class="<?php reactor_columns( 12 ) ?>">

						<?php endif; ?>

						<?php if ( $custom_form ): echo do_shortcode( $custom_form );
						else:

							if ( isset( $emailSent ) && $emailSent == true ) {
								?>
								<div class="thanks">
									<?php echo apply_filters( 'reactor_contactform_success', $msg_sent ); ?>
								</div>
							<?php
							}
							else {
								?>
								<?php if ( ! isset( $hasError ) ) {
									$nameError    = '';
									$emailError   = '';
									$commentError = '';
									$errorClass   = '';
								} ?>
								<form action="<?php the_permalink(); ?>" id="contactForm" method="post" class="nice">

									<h2><span><?php _e( 'Send us message', 'crum' ); ?></span></h2>

									<div class="row">
										<div class="<?php reactor_columns( 6 ) ?>">
											<label class="<?php echo $errorClass; ?>" for="contactName"><?php _e( 'Enter your name:', 'crum' ); ?></label>
											<input type="text" name="contactName" id="contactName" value="<?php if ( isset( $_POST['contactName'] ) ) {
												echo $_POST['contactName'];
											} ?>" class="required" />
											<?php if ( $nameError != '' ) : ?>
												<span class="error"><?php echo $nameError; ?></span>
											<?php endif; ?>

											<label class="<?php echo $errorClass; ?>" for="email"><?php _e( 'Email for feedback:', 'crum' ); ?></label>
											<input type="text" name="email" id="email" value="<?php if ( isset( $_POST['email'] ) ) {
												echo $_POST['email'];
											} ?>" class="required email" />
											<?php if ( $emailError != '' ) : ?>
												<span class="error"><?php echo $emailError; ?></span>
											<?php endif; ?>

											<label for="contactSubject"><?php _e( 'Message description:', 'crum' ); ?></label>
											<input type="text" name="contactSubject" id="contactSubject" value="<?php if ( isset( $_POST['contactSubject'] ) )
												echo $_POST['contactSubject']; ?>" />

										</div>
										<div class="<?php reactor_columns( 6 ) ?>">
											<label class="<?php echo $errorClass; ?>" for="commentsText"><?php _e( 'Leave a message:', 'crum' ); ?></label>
											<textarea name="comments" id="commentsText" rows="10" cols="80" class="required <?php echo $errorClass; ?>"><?php if ( isset( $_POST['comments'] ) ) {
													if ( function_exists( 'stripslashes' ) ) {
														echo stripslashes( $_POST['comments'] );
													}
													else {
														echo $_POST['comments'];
													}
												} ?></textarea>
											<?php if ( $commentError != '' ) : ?>
												<span class="error"><?php echo $commentError; ?></span>
											<?php endif; ?>

											<br>

											<div class="row">

												<div class="answer <?php reactor_columns( 4 ) ?>">
													<?php $img_source_path = get_template_directory_uri() . '/library/inc/Captcha/secpic.php';
													echo( '<span id="captcha_reload" class="right"><img onclick="cap_reload(); return false;" title="' . __( 'Click on picture if you want to reload captcha', 'crum' ) . '" src="' . $img_source_path . '" alt="secure code" style="cursor:pointer;" /></span>' );?>

													<script language="javascript" type="text/javascript">
														function cap_reload() {
															var random_value = new Date().getTime();
															document.getElementById('captcha_reload').innerHTML = '<img onclick="cap_reload(); return false;" title="<?php _e('Click on picture if you want to reload captcha','crum'); ?>" src="<?php echo $img_source_path; ?>?random_value=' + random_value + '" alt="captcha" style="cursor:pointer;" />';
														}
													</script>
												</div>
												<div class="<?php reactor_columns( 3 ) ?>">
													<input type="text" name="captcha" id="captcha" class="required" />

													<?php if ( isset( $captchaError ) && ( $captchaError != '' ) ): ?>
														<span class="error"><?php echo $captchaError; ?></span>

													<?php endif; ?>
												</div>

												<div class="<?php reactor_columns( 5 ) ?>">
													<input type="submit" value="<?php echo apply_filters( 'reactor_contactform_submit', __( 'Send message', 'crum' ) ); ?>" class="button right" />
												</div>
											</div>

										</div>
									</div>
									<input type="hidden" name="submitted" id="submitted" value="true" />
								</form>
							<?php } ?>

						<?php endif; ?>

						<?php reactor_inner_content_after(); ?>

					</div>
					<!-- .columns -->
				</div>
				<!-- .row -->
			</div>

			<?php reactor_inner_content_after(); ?>

			<?php set_layout( 'pages', false, $page_lay ); ?>

			<!-- #column -->

		</div>
		<!-- #content -->

		<?php reactor_content_after(); ?>

	</div><!-- #primary -->

<?php get_footer(); ?>