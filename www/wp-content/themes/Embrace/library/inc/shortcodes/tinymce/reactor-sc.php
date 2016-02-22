<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new reactor_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="reactor-popup">

	<div id="reactor-shortcode-wrap">

		<div id="reactor-sc-form-wrap">

			<?php
			$select_shortcode = array(

					'select' => 'Choose a Shortcode',
					'alert' => 'Alert',
					'button' => 'Button',
					'columns' => 'Columns',
					'panel' => 'Panel',
					'reveal_modal' => 'Reveal Modal',
					'sign_in_form' => 'Login form',
					'dropcap' => 'Dropcap',
					'tooltip' => 'Tooltip',
					'flex_video' => 'Flex Video'

			);
			?>
			<table id="reactor-sc-form-table" class="reactor-shortcode-selector">
				<tbody>
					<tr class="form-row">
						<td class="label">Choose Shortcode</td>
						<td class="field">
							<div class="reactor-form-select-field">
							<div class="reactor-shortcodes-arrow">&#xf107;</div>
								<select name="reactor_select_shortcode" id="reactor_select_shortcode" class="reactor-form-select reactor-input">
									<?php foreach($select_shortcode as $shortcode_key => $shortcode_value): ?>
									<?php if($shortcode_key == $popup): $selected = 'selected="selected"'; else: $selected = ''; endif; ?>
									<option value="<?php echo $shortcode_key; ?>" <?php echo $selected; ?>><?php echo $shortcode_value; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<form method="post" id="reactor-sc-form">

				<table id="reactor-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody class="reactor-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="#" class="reactor-insert">Insert Shortcode</a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#reactor-sc-form-table -->

			</form>
			<!-- /#reactor-sc-form -->

		</div>
		<!-- /#reactor-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#reactor-shortcode-wrap -->

</div>
<!-- /#reactor-popup -->

</body>
</html>