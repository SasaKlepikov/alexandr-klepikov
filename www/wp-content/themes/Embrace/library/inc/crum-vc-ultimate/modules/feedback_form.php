<?php

if (!class_exists('Crum_Feedback_Form')){

	class Crum_Feedback_Form{

		function __construct(){
			add_action('admin_init', array($this, 'crum_feedback_form_init'));
			add_shortcode('crum_feedback_form', array($this, 'crum_feedback_form_form'));
		}

		function generate_id() {
			$uniue_id = uniqid( 'id_' );

			return $uniue_id;
		}

		function crum_feedback_form_init(){

			if (function_exists('vc_map')){

				vc_map(
					array(
						"name"        => __( "Feedback form", "crum" ),
						"base"        => "crum_feedback_form",
						"icon"        => "",
						"category"    => __( "Presentation", "crum" ),
						"description" => __( "Feedback form form", "crum" ),
						"show_settings_on_create" => true,
						"params" => array(
							array(
								"type" => "textfield",
								"heading" => __( "Title", "crum" ),
								"param_name"=> "feedback_title",
								"group" => "",
								"description" => __( "Set title for block", "crum" ),
							),
							array(
								"type" => "textarea",
								"heading" => __( "Description", "crum" ),
								"param_name"=> "feedback_description",
								"group" => "",
								"description" => __( "Set description for block", "crum" ),
							),
							array(
								"type" => "textfield",
								"heading" => __( "E-mail address", "crum" ),
								"param_name"=> "feedback_email",
								"group" => "",
								"description" => __( "Email address, for feedback ", "crum" ),
							),
							array(
								"type" => "textfield",
								"heading" => __( "Button text", "crum" ),
								"param_name"=> "feedback_button_text",
								"group" => "",
								"description" => __( "Send feedback button text", "crum" ),
							),
							array(
								"type" => "vc_link",
								"heading" => __( "Button link", "crum" ),
								"param_name"=> "feedback_button_link",
								"group" => "",
								"description" => __( "You can link or remove the existing link on the button from here.", "crum" ),
							),
							array(
								"type" => "textfield",
								"heading" => __( "Feedback success", "crum" ),
								"param_name"=> "feedback_success",
								"group" => "",
								"description" => __( "Message after success form sent ", "crum" ),
							),
							array(
								"type" => "colorpicker",
								"heading" => __( "Button background color", "crum" ),
								"param_name"=> "feedback_button_color",
								"group" => "",
								"description" => __( "Color of the button.", "crum" ),
							),
							array(
								"type"       => "checkbox",
								"heading"    => __( "", "crum" ),
								"param_name" => "feedback_border_style",
								"value"      => array( "Make form fields border white" => "enable" ),
								"group"       => "",
							),
							array(
								"type" => "textfield",
								"heading" => __( "First field placeholder", "crum" ),
								"param_name"=> "feedback_placeholder_1",
								"group" => "",
								"description" => __( "Set placeholder to describe your input fields", "crum" ),
							),
							array(
								"type" => "textfield",
								"heading" => __( "Second field placeholder", "crum" ),
								"param_name"=> "feedback_placeholder_2",
								"group" => "",
								"description" => __( "Set placeholder to describe your input fields", "crum" ),
							),
							array(
								"type"       => "dropdown",
								"param_name" => "feedback_form_id",
								"value"      => array( $this->generate_id() ),
								"group"       => "",
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Animation", "crum" ),
								"param_name"  => "module_animation",
								"value"       => array(
									__( "No Animation", "crum" )       => "",
									__( "FadeIn", "crum" )             => "transition.fadeIn",
									__( "FlipXIn", "crum" )            => "transition.flipXIn",
									__( "FlipYIn", "crum" )            => "transition.flipYIn",
									__( "FlipBounceXIn", "crum" )      => "transition.flipBounceXIn",
									__( "FlipBounceYIn", "crum" )      => "transition.flipBounceYIn",
									__( "SwoopIn", "crum" )            => "transition.swoopIn",
									__( "WhirlIn", "crum" )            => "transition.whirlIn",
									__( "ShrinkIn", "crum" )           => "transition.shrinkIn",
									__( "ExpandIn", "crum" )           => "transition.expandIn",
									__( "BounceIn", "crum" )           => "transition.bounceIn",
									__( "BounceUpIn", "crum" )         => "transition.bounceUpIn",
									__( "BounceDownIn", "crum" )       => "transition.bounceDownIn",
									__( "BounceLeftIn", "crum" )       => "transition.bounceLeftIn",
									__( "BounceRightIn", "crum" )      => "transition.bounceRightIn",
									__( "SlideUpIn", "crum" )          => "transition.slideUpIn",
									__( "SlideDownIn", "crum" )        => "transition.slideDownIn",
									__( "SlideLeftIn", "crum" )        => "transition.slideLeftIn",
									__( "SlideRightIn", "crum" )       => "transition.slideRightIn",
									__( "SlideUpBigIn", "crum" )       => "transition.slideUpBigIn",
									__( "SlideDownBigIn", "crum" )     => "transition.slideDownBigIn",
									__( "SlideLeftBigIn", "crum" )     => "transition.slideLeftBigIn",
									__( "SlideRightBigIn", "crum" )    => "transition.slideRightBigIn",
									__( "PerspectiveUpIn", "crum" )    => "transition.perspectiveUpIn",
									__( "PerspectiveDownIn", "crum" )  => "transition.perspectiveDownIn",
									__( "PerspectiveLeftIn", "crum" )  => "transition.perspectiveLeftIn",
									__( "PerspectiveRightIn", "crum" ) => "transition.perspectiveRightIn",
								),
								"description" => __( "", "crum" ),
								"group"       => "Animation Settings",
							),
						)
					)
				);

			}

		}

		function crum_feedback_form_form($atts, $content = null){

			$feedback_title = $feedback_description = $feedback_email = $feedback_button_text = $feedback_success = $feedback_button_link = $feedback_button_color = $feedback_border_style = $feedback_placeholder_1 = $feedback_placeholder_2 = $feedback_form_id = $module_animation = '';

			extract(
				shortcode_atts(
					array(
						"feedback_title" => "",
						"feedback_description" => "",
						"feedback_email" => "",
						"feedback_button_text" => "",
						"feedback_success" => "",
						"feedback_button_link" => "",
						"feedback_button_color" => "",
						"feedback_border_style" => "",
						"feedback_placeholder_1" => "",
						"feedback_placeholder_2" => "",
						"feedback_form_id" => "",
						"module_animation" => "",
					),$atts
				)
			);

			if ( $feedback_border_style == 'enable' ) {
				$underline_enable = 'class="white-border"';
			} else {
				$underline_enable = '';
			}

			if (isset($feedback_placeholder_1) && !($feedback_placeholder_1 == '')){
				$placeholder_first = $feedback_placeholder_1;
			}else{
				$placeholder_first = __('Enter your name','crum');
			}

			if (isset($feedback_button_text) && !($feedback_button_text == '')){
				$button_text = $feedback_button_text;
			}else{
				$button_text = __("Learn More", "crum");
			}

			if (isset($feedback_success) && !($feedback_success == '')){
				$success_message = $feedback_success;
			}else{
				$success_message = __("Thank for your feedback", "crum");
			}

			if (isset($feedback_placeholder_2) && !($feedback_placeholder_2 == '')){
				$placeholder_second = $feedback_placeholder_2;
			}else{
				$placeholder_second = __('Email for feedback','crum');
			}

			if (isset($feedback_button_color) && !($feedback_button_color == '')){
				$button_style = 'style="background-color:'.$feedback_button_color.'"';
			}else{
				$button_style = '';
			}

			$animate = $animation_data = '';
			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = ' data-animate-type = "'.$module_animation.'" ';
			}

			$output = '';

			$output .= '<div class="feedback-block">';

			if (isset($feedback_title) && !($feedback_title == '')){

				$output .= '<span class="feedback-title">'.$feedback_title.'</span>';

			}

			if (isset($feedback_description) && !($feedback_description == '')){

				$output .= '<div class="feedback-description">';
				$output .= $feedback_description;
				$output .= '</div>';//feedback-description

			}

			if ( isset( $_POST['submitted'.$feedback_form_id] ) ) {

				if ( trim( $_POST['feedbackName_'.$feedback_form_id] ) === '' ) {
					$nameError  = apply_filters( 'reactor_contactform_error_name', '<small class="error">Please enter your name.</small>' );
					$hasError   = true;
				} else {
					$name = trim( $_POST['feedbackName_'.$feedback_form_id] );
				}

				if ( trim( $_POST['feedbackMail_'.$feedback_form_id] ) === '' ) {
					$emailError = apply_filters( 'reactor_contactform_error_email', '<small class="error">Please enter your email address.</small>' );
					$hasError   = true;
				} else {
					$email = trim( $_POST['feedbackMail_'.$feedback_form_id] );
				}

				if ( ! isset( $hasError ) ) {
					$emailTo = $feedback_email;
					if ( ! isset( $emailTo ) || ( $emailTo == '' ) ) {
						$email_admin = reactor_option('contact_email_to');
						$emailTo = $email_admin;
					}
					$subject = 'You received e-mail from '.get_bloginfo('name').'';

					$body    = "$placeholder_first: $name \n\n$placeholder_second: $email \n\n";

					//$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n" . 'Reply-To: ' . $email;

					if (wp_mail( $emailTo, $subject, $body)) {
						$emailSent = true;
					}else{
						$emailSent = false;
					}
				}

			}//form validation end

			$build_link = vc_build_link($feedback_button_link);

			if ( isset( $emailSent ) && $emailSent == true ) {
				ob_start();?>

				<?php if(isset($build_link['url']) && !($build_link['url'] == '')){?>

				<script language="javascript" type="text/javascript">
				window.location.href="<?php echo $build_link['url'];?>";
				</script>

					<?php }else{?>

					<div class="thanks">
						<?php echo $success_message; ?>
					</div>

					<?php }?>

				<?php $output .= ob_get_clean();
			} else {
				?>
				<?php if ( ! isset( $hasError ) ) {
					$nameError    = '';
					$emailError   = '';
				}
				ob_start();

				?>

				<div class="feedback-form-div <?php echo $animate; ?>" <?php echo $animation_data; ?>>

					<form action="<?php echo ( isset( $_SERVER["REQUEST_URI"] ) ) ? $_SERVER["REQUEST_URI"] : ''; ?>" name="feedbackForm<?php echo '_' . $feedback_form_id; ?>" id="feedbackForm<?php echo '_' . $feedback_form_id; ?>" method="post" <?php echo $underline_enable; ?>>


							<input type="text" placeholder="<?php echo $placeholder_first ?>" name="feedbackName<?php echo '_' . $feedback_form_id; ?>" id="feedbackName<?php echo '_' . $feedback_form_id; ?>" value="<?php if ( isset( $_POST[ 'feedbackName_' . $feedback_form_id ] ) ) {
								echo $_POST[ 'feedbackName_' . $feedback_form_id ];
							} ?>" class="required" />
							<?php if ( $nameError != '' ) : ?>
								<span class="error"><?php echo $nameError; ?></span>
							<?php endif; ?>

							<input type="text" placeholder="<?php echo $placeholder_second ?>" name="feedbackMail<?php echo '_' . $feedback_form_id; ?>" id="feedbackMail<?php echo '_' . $feedback_form_id; ?>" value="<?php if ( isset( $_POST[ 'feedbackMail_' . $feedback_form_id ] ) ) {
								echo $_POST[ 'feedbackMail_' . $feedback_form_id ];
							} ?>" class="required" />
							<?php if ( $emailError != '' ) : ?>
								<span class="error"><?php echo $emailError; ?></span>
							<?php endif; ?>

							<button type="submit" class="button" <?php echo $button_style ?>>
								<span><?php echo $button_text ?></span>
							</button>


						<input type="hidden" name="submitted<?php echo $feedback_form_id; ?>" id="submitted" value="true" />

					</form>

				</div>
				<?php $output .= ob_get_clean();

			}

			$output .= '</div>';//feedback-block


			return $output;

		}

	}

}

if (class_exists('Crum_Feedback_Form')){
	$Crum_Feedback_Form = new Crum_Feedback_Form;
}