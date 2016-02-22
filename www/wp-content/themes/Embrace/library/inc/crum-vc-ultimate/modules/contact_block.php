<?php
session_start();
if (!class_exists('Crum_Contact_Block')) {
    class Crum_Contact_Block
    {
        function __construct()
        {
            add_shortcode('crum_contact_form', array(&$this, 'crum_contact_block_form'));
            add_action('admin_init', array(&$this, 'crum_contact_block_init'));
        }

        function generate_id()
        {
            $uniue_id = uniqid('id_');

            return $uniue_id;
        }

        function crum_contact_block_form($atts)
        {

            $contact_form_email = $contact_form_captcha = $contact_form_button_alignment = $contact_form_style = $contact_form_text_style = $contact_form_border_style = $contact_form_id = $module_animation = '';

            extract(
                shortcode_atts(
                    array(
                        'contact_form_email' => '',
                        'contact_form_captcha' => 'yes',
                        'contact_form_button_alignment' => 'center',
                        'contact_form_style' => 'style_1',
                        'contact_form_text_style' => 'label',
                        'contact_form_border_style' => '',
                        'contact_form_id' => '',
                        'module_animation' => '',
                    ), $atts
                )
            );

            $output = '';

            $contact_email = $contact_form_email;
            $email_subject = reactor_option('contact_email_subject', get_bloginfo('name') . __(' - Contact Form Message', 'crum'));
            $msg_sent = reactor_option('contact_email_sent', __('Thank you! Your email was sent successfully.', 'crum'));

            $animate = $animation_data = '';
            if (!($module_animation == '')) {
                $animate = ' cr-animate-gen';
                $animation_data = ' data-animate-type = "' . $module_animation . '" ';
            }

            if ($contact_form_style == 'style_1') {
                $name_width = 12;
                $email_width = 12;
                $subject_width = 12;
                $message_width = 6;
            } elseif ($contact_form_style == 'style_2') {
                $name_width = 4;
                $email_width = 4;
                $subject_width = 4;
                $message_width = 12;
            } elseif ($contact_form_style == 'style_3') {
                $name_width = 12;
                $email_width = 12;
                $subject_width = 12;
                $message_width = 12;
            } elseif ($contact_form_style == 'style_4') {
                $name_width = 6;
                $email_width = 6;
                $subject_width = 0;
                $message_width = 12;
            }

            if ($contact_form_button_alignment == 'right') {
                $button_alignment = ' right';
            } elseif ($contact_form_button_alignment == 'center') {
                $button_alignment = ' large-centered text-center';
            } else {
                $button_alignment = '';
            }

            if ($contact_form_button_alignment == 'right' && $contact_form_captcha == 'no') {
                $button_single_alignment = ' right';
            } elseif ($contact_form_button_alignment == 'center' && $contact_form_captcha == 'no') {
                $button_single_alignment = ' small-offset-3';
            } else {
                $button_single_alignment = '';
            }

            if ($contact_form_text_style == 'place' && $contact_form_style == 'style_1') {
                $row_count = 7;
            } elseif ($contact_form_text_style == 'place' && !($contact_form_style == 'style_1')) {
                $row_count = 5;
            } else {
                $row_count = 10;
            }
            if ($contact_form_border_style == 'enable' && ($contact_form_style == 'style_2' || $contact_form_style == 'style_4')) {
                $row_count = 1;
            }

            if ($contact_form_border_style == 'enable') {
                $underline_enable = 'class="white-border"';
            } else {
                $underline_enable = '';
            }

            // begin form validation
            if (isset($_POST['submitted' . $contact_form_id])) {
                if (trim($_POST['contactName_' . $contact_form_id]) === '') {
                    $nameError = apply_filters('reactor_contactform_error_name', '<small class="error">Please enter your name.</small>');
                    $errorClass = 'error';
                    $hasError = true;
                } else {
                    $name = sanitize_text_field($_POST['contactName_' . $contact_form_id]);
                }
                if (trim($_POST['email_' . $contact_form_id]) === '') {
                    $emailError = apply_filters('reactor_contactform_error_email', '<small class="error">Please enter your email address.</small>');
                    $errorClass = 'error';
                    $hasError = true;
                } else {
                    if (!preg_match('/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i', trim($_POST['email_' . $contact_form_id]))) {
                        $emailError = apply_filters('reactor_contactform_error_email_invalid', '<small class="error">You entered an invalid email address.</small>');
                        $errorClass = 'error';
                        $hasError = true;
                    } else {
                        $email = sanitize_text_field($_POST['email_' . $contact_form_id]);
                    }
                }
                if (trim($_POST['comments_' . $contact_form_id]) === '') {
                    $commentError = apply_filters('reactor_contactform_error_message', '<small class="error">Please enter a message.</small>');
                    $errorClass = 'error';
                    $hasError = true;
                } else {
                    $comments = sanitize_text_field($_POST['comments_' . $contact_form_id]);

                }
                if (isset($_SESSION['secpic']) && isset($_POST['captcha_' . $contact_form_id]) && !($_SESSION['secpic'] == strtolower($_POST['captcha_' . $contact_form_id]))) {
                    $captchaError = apply_filters('reactor_captcha_error_message', '<small class="error">' . __('Please enter correct captcha.', 'reactor') . '</small>');
                    $errorClass = 'error';
                    $hasError = 'true';
                }

                if (!isset($hasError)) {
                    $emailTo = $contact_email;

                    if (!isset($emailTo) || ($emailTo == '') || ($emailTo == 'wwwww')) {
	                    $emailTo = reactor_option('contact_email_to');
                    }

                    $subject =  $email_subject;
                    $body = "Name: $name \n\n Email: $email \n\n Comments: $comments";
                    $headers = 'From: ' . $name . ' <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;


                    if (wp_mail($emailTo, $subject, $body, $headers)) {
                        $emailSent = true;
                    } else {
                        $emailSent = false;
                    }
                }

            } // end form validation



            if (isset($emailSent) && $emailSent == true) {
                ob_start();
                ?>
                <div class="thanks">
                    <?php echo apply_filters('reactor_contactform_success', $msg_sent); ?>
                </div>
                <?php
                $output = ob_get_clean();
            } else {
                ?>
                <?php if (!isset($hasError)) {
                    $nameError = '';
                    $emailError = '';
                    $commentError = '';
                    $errorClass = '';
                }
                ob_start();

                ?>
	            <div class="contact-form-div <?php echo $animate; ?>" <?php echo $animation_data; ?>>
		            <form action="<?php echo ( isset( $_SERVER["REQUEST_URI"] ) ) ? $_SERVER["REQUEST_URI"] : ''; ?>"
		                  name="contactForm<?php echo '_' . $contact_form_id; ?>"
		                  id="contactForm<?php echo '_' . $contact_form_id; ?>"
		                  method="post" <?php echo $underline_enable; ?>>

			            <div class="row">
				            <?php if ($contact_form_style == 'style_1'): ?>
				            <div class="<?php reactor_columns( 6 ) ?>">
					            <?php endif; ?>

					            <?php if ( ! ( $contact_form_style == 'style_1' )): ?>
					            <div class="<?php reactor_columns( $name_width ) ?>">
						            <?php endif; ?>

						            <?php if ( $contact_form_text_style == 'label' ): ?>
							            <label class="<?php echo $errorClass; ?>"
							                   for="contactName"><?php _e( 'Enter your name:', 'crum' ); ?></label>
						            <?php endif; ?>
						            <input type="text"
						                   placeholder="<?php if ( $contact_form_text_style == 'place' ):_e( 'Enter your name:', 'crum' ); endif; ?>"
						                   name="contactName<?php echo '_' . $contact_form_id; ?>"
						                   id="contactName<?php echo '_' . $contact_form_id; ?>"
						                   value="<?php if ( isset( $_POST[ 'contactName_' . $contact_form_id ] ) ) {
							                   echo sanitize_text_field($_POST[ 'contactName_' . $contact_form_id ]);
						                   } ?>" class="required"/>
						            <?php if ( $nameError != '' ) : ?>
							            <span class="error"><?php echo $nameError; ?></span>
						            <?php endif; ?>

						            <?php if ( ! ( $contact_form_style == 'style_1' )): ?>
					            </div>
				            <?php endif; ?>

					            <?php if ( ! ( $contact_form_style == 'style_1' )): ?>
					            <div class="<?php reactor_columns( $email_width ) ?>">
						            <?php endif; ?>

						            <?php if ( $contact_form_text_style == 'label' ): ?>
							            <label class="<?php echo $errorClass; ?>"
							                   for="email"><?php _e( 'Email for feedback:', 'crum' ); ?></label>
						            <?php endif; ?>
						            <input type="text"
						                   placeholder="<?php if ( $contact_form_text_style == 'place' ):_e( 'Email for feedback:', 'crum' ); endif; ?>"
						                   name="email<?php echo '_' . $contact_form_id; ?>"
						                   id="email<?php echo '_' . $contact_form_id; ?>"
						                   value="<?php if ( isset( $_POST[ 'email_' . $contact_form_id ] ) ) {
							                   echo sanitize_text_field($_POST[ 'email_' . $contact_form_id ]);
						                   } ?>" class="required email"/>
						            <?php if ( $emailError != '' ) : ?>
							            <span class="error"><?php echo  $emailError; ?></span>
						            <?php endif; ?>

						            <?php if ( ! ( $contact_form_style == 'style_1' )): ?>
					            </div>
				            <?php endif; ?>

					            <?php if ( ! ( $contact_form_style == 'style_4' ) ): ?>

						            <?php if ( ! ( $contact_form_style == 'style_1' ) ): ?>
							            <div class="<?php reactor_columns( $subject_width ) ?>">
						            <?php endif; ?>

						            <?php if ( $contact_form_text_style == 'label' ): ?>
							            <label
								            for="contactSubject"><?php _e( 'Message description:', 'crum' ); ?></label>
						            <?php endif; ?>
						            <input type="text"
						                   placeholder="<?php if ( $contact_form_text_style == 'place' ):_e( 'Message description:', 'crum' ); endif; ?>"
						                   name="contactSubject<?php echo '_' . $contact_form_id; ?>"
						                   id="contactSubject<?php echo '_' . $contact_form_id; ?>"
						                   value="<?php if ( isset( $_POST[ 'contactSubject_' . $contact_form_id ] ) ) {
							                   echo sanitize_text_field( $_POST[ 'contactSubject_' . $contact_form_id ] );
						                   } ?>"/>

						            <?php if ( ! ( $contact_form_style == 'style_1' ) ): ?>
							            </div>
						            <?php endif; ?>

					            <?php endif; ?>
					            <?php if ($contact_form_style == 'style_1'): ?>
				            </div>
			            <?php endif; ?>
				            <div class="<?php reactor_columns( $message_width ) ?>">
					            <?php if ( $contact_form_text_style == 'label' ): ?>
						            <label class="<?php echo $errorClass; ?>"
						                   for="commentsText"><?php _e( 'Leave a message:', 'crum' ); ?></label>
					            <?php endif; ?>
					            <textarea
						            placeholder="<?php if ( $contact_form_text_style == 'place' ):_e( 'Leave a message:', 'crum' ); endif; ?>"
						            name="comments<?php echo '_' . $contact_form_id; ?>"
						            id="comments<?php echo '_' . $contact_form_id; ?>" rows="<?php echo $row_count; ?>"
						            cols="80"
						            class="required <?php echo $errorClass; ?>"><?php if ( isset( $_POST[ 'comments_' . $contact_form_id ] ) ) {

								        echo sanitize_text_field($_POST[ 'comments_' . $contact_form_id ]);

						            } ?></textarea>
					            <?php if ( $commentError != '' ) : ?>
						            <span class="error"><?php echo $commentError; ?></span>
					            <?php endif; ?>

					            <br>

				            </div>


			            </div>

			            <div class="row">
				            <div class="<?php reactor_columns( 6 );
				            echo $button_alignment; ?>">
					            <?php if ($contact_form_captcha == 'yes'){ ?>
					            <div class="row">
						            <div class=" answer <?php reactor_columns( 3 ) ?>">

							            <?php $img_source_path = get_template_directory_uri() . '/library/inc/Captcha/secpic.php';
							            echo( '<span id="captcha_reload' . $contact_form_id . '"><img onclick="cap_reload' . $contact_form_id . '(); return false;" title="' . __( 'Click on picture if you want to reload captcha', 'crum' ) . '" src="' . $img_source_path . '" alt="secure code" style="cursor:pointer;" /></span>' ); ?>

							            <script language="javascript" type="text/javascript">
								            function cap_reload<?php echo esc_attr($contact_form_id);?>() {
									            var random_value = new Date().getTime();
									            document.getElementById('captcha_reload<?php echo esc_attr($contact_form_id);?>').innerHTML = '<img onclick="cap_reload<?php echo esc_attr($contact_form_id)?>(); return false;" title="<?php _e('Click on picture if you want to reload captcha','crum'); ?>" src="<?php echo esc_url($img_source_path); ?>?random_value=' + random_value + '" alt="captcha" style="cursor:pointer;" />';
								            }
							            </script>

						            </div>
						            <div class="<?php reactor_columns( 3 ) ?>">

							            <input type="text" name="captcha<?php echo '_' . $contact_form_id; ?>"
							                   id="captcha<?php echo '_' . $contact_form_id; ?>" class="captcha"/>

							            <?php if ( isset( $captchaError ) && ( $captchaError != '' ) ): ?>
								            <span class="error"><?php echo $captchaError; ?></span>

							            <?php endif; ?>

						            </div>

						            <div class="<?php reactor_columns( 6 );
						            echo $button_single_alignment; ?>">

							            <?php } ?>
							            <button type="submit"
							                    class="button <?php echo $contact_form_button_alignment; ?>">
								            <i class="embrace-envelope_out2"></i><span><?php echo __( 'Send message', 'crum' ); ?></span>
							            </button>

							            <?php if ($contact_form_captcha == 'yes'){ ?>
						            </div>
					            </div>
				            <?php } ?>

				            </div>

			            </div>

			            <input type="hidden" name="submitted<?php echo $contact_form_id; ?>" id="submitted"
			                   value="true"/>
		            </form>
	            </div>
                <?php
                $output .= ob_get_clean();
            }


            return $output;
        }

        function crum_contact_block_init()
        {
            if (function_exists('vc_map')) {

                $group = __("Main Options", "crum");

                vc_map(
                    array(
                        "name" => __("Contact form", "crum"),
                        "base" => "crum_contact_form",
                        "icon" => "crum_contact_form_icon",
                        "category" => __("Presentation", "crum"),
                        "description" => __("Contact form", "crum"),
                        "params" => array(
                            array(
                                "type" => "textfield",
                                "heading" => __("Contact email", "crum"),
                                "param_name" => "contact_form_email",
                                "group" => $group,
                                "description" => __("Set contact form email address", "crum"),
                            ),
                            array(
                                "type" => "dropdown",
                                "heading" => __("Show captcha", "crum"),
                                "param_name" => "contact_form_captcha",
                                "description" => __("Display captcha on contact form", "crum"),
                                "value" => array(
                                    "Yes" => "yes",
                                    "No" => "no",
                                ),
                                "group" => $group,
                            ),
                            array(
                                "type" => "dropdown",
                                "heading" => __("Button alignment", "crum"),
                                "param_name" => "contact_form_button_alignment",
                                "description" => __("Select alignment of submit button", "crum"),
                                "value" => array(
                                    "Center" => "center",
                                    "Left" => "left",
                                    "Right" => "right",
                                ),
                                "group" => $group,
                            ),
                            array(
                                "type" => "dropdown",
                                "heading" => __("Form style", "crum"),
                                "param_name" => "contact_form_style",
                                "description" => __("Select style of contact form block", "crum"),
                                "value" => array(
                                    "Style 1" => "style_1",
                                    "Style 2" => "style_2",
                                    "Style 3" => "style_3",
                                    "Style 4" => "style_4",
                                ),
                                "group" => $group,
                            ),
                            array(
                                "type" => "dropdown",
                                "heading" => __("Text style", "crum"),
                                "param_name" => "contact_form_text_style",
                                "description" => __("Select style of contact form text", "crum"),
                                "value" => array(
                                    "Label" => "label",
                                    "Placeholder" => "place",
                                ),
                                "group" => $group,
                            ),
                            array(
                                "type" => "checkbox",
                                "heading" => __("", "crum"),
                                "param_name" => "contact_form_border_style",
                                "value" => array("Make form fields border white" => "enable"),
                                "group" => $group,
                            ),
                            array(
                                "type" => "dropdown",
                                "param_name" => "contact_form_id",
                                "value" => array($this->generate_id()),
                                "group" => $group,
                            ),
                            array(
                                "type" => "dropdown",
                                "class" => "",
                                "heading" => __("Animation", "crum"),
                                "param_name" => "module_animation",
                                "value" => array(
                                    __("No Animation", "crum") => "",
                                    __("FadeIn", "crum") => "transition.fadeIn",
                                    __("FlipXIn", "crum") => "transition.flipXIn",
                                    __("FlipYIn", "crum") => "transition.flipYIn",
                                    __("FlipBounceXIn", "crum") => "transition.flipBounceXIn",
                                    __("FlipBounceYIn", "crum") => "transition.flipBounceYIn",
                                    __("SwoopIn", "crum") => "transition.swoopIn",
                                    __("WhirlIn", "crum") => "transition.whirlIn",
                                    __("ShrinkIn", "crum") => "transition.shrinkIn",
                                    __("ExpandIn", "crum") => "transition.expandIn",
                                    __("BounceIn", "crum") => "transition.bounceIn",
                                    __("BounceUpIn", "crum") => "transition.bounceUpIn",
                                    __("BounceDownIn", "crum") => "transition.bounceDownIn",
                                    __("BounceLeftIn", "crum") => "transition.bounceLeftIn",
                                    __("BounceRightIn", "crum") => "transition.bounceRightIn",
                                    __("SlideUpIn", "crum") => "transition.slideUpIn",
                                    __("SlideDownIn", "crum") => "transition.slideDownIn",
                                    __("SlideLeftIn", "crum") => "transition.slideLeftIn",
                                    __("SlideRightIn", "crum") => "transition.slideRightIn",
                                    __("SlideUpBigIn", "crum") => "transition.slideUpBigIn",
                                    __("SlideDownBigIn", "crum") => "transition.slideDownBigIn",
                                    __("SlideLeftBigIn", "crum") => "transition.slideLeftBigIn",
                                    __("SlideRightBigIn", "crum") => "transition.slideRightBigIn",
                                    __("PerspectiveUpIn", "crum") => "transition.perspectiveUpIn",
                                    __("PerspectiveDownIn", "crum") => "transition.perspectiveDownIn",
                                    __("PerspectiveLeftIn", "crum") => "transition.perspectiveLeftIn",
                                    __("PerspectiveRightIn", "crum") => "transition.perspectiveRightIn",
                                ),
                                "description" => __("", "crum"),
                                "group" => "Animation Settings",
                            ),
                        ),
                    )
                );
            }
        }

    }
}

if (class_exists('Crum_Contact_Block')) {
    $Crum_Contact_Block = new Crum_Contact_Block;
}