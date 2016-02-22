<?php
/**
 * Template: One Touch - One Big Two Small
 *
 * This file is used to output the template used
 * for a particular page slider. A custom loop is
 * created to allow you to access the current
 * page/post. You can access this loop by referencing
 * the $cps_query variable.
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 *
 */

/**
 * Here are the variables that are available
 * automatically. Do not set a value to
 * these variables, they are already available
 * to use.
 */

$show_title; // Boolean - Show/Hide Title
$show_icon; // Boolean - Show/Hide Icons
$show_category; // Boolean - Show/Hide Categories
$show_link; // Boolean - Show/Hide Link to Page
$show_description; // Boolean - Show/Hide Description
$decription_limit; // Int - Description Limit
$template_slug; // String - Template slug e.g. one_touch_one_big_two_small
$slider_id; // Unique Identifier for slider
$count; // Int - Running count

/**
 * Fetch Dynamic Options
 *
 * Get the dynamic options for this page slider based
 * on the template used.
 *
 */
$options['auto_mode'];
$options['scroll_timer'];
$options['start_first'];
$options['category_background_color'];
$options['slide_hover_color'];
$options['slide_grid'];
$options['opacity'];

/**
 * Variable that hold the location to
 * the plugins image directory (without
 * the trailing slash). Use it in the following
 * context:
 *
 * $img_dir_url . '/my-image.jpg'
 *
 */
$img_dir_url;

?>

<?php if (0 == $count) : ?>
<script>jQuery(document).ready(function(){jQuery( '#<?php echo $slider_id; ?> .crumina_slider').cruminaPageSlider();}); </script>

<div class="crumina-slider-wrap loading" id="<?php echo $slider_id; ?>">
<div class="crumina_slider <?php echo $template_slug; ?>" <?php if($options['auto_mode'] != 'false'): ?> data-autoscroll="<?php if (!empty($options['scroll_timer'])){ echo $options['scroll_timer'] * 1000;} else {echo '5000';} ?>"<?php endif;?> <?php if(!($options['start_first'] == 'false')): echo 'data-start-first="yes"'; endif;?>>
		<ul class="slidee">
			<!-- Output Each Item underneath this line -->
			<li>

				<?php endif; ?>


				<?php while ($cps_query->have_posts()) :
				$cps_query->the_post(); ?>
				<?php
				/**
				 * Determine classes
				 * @var string
				 */

				global $more;
				$more = 0;

				?>

				<?php
				/*************************
				 * Slider Layout templates
				 ************************/


				/*****************
				/ *  2 Big items
				/*****************/

				if ( $options['slide_grid'] == '2big' ) {


					if ( has_post_thumbnail() ) {
						$thumb       = get_post_thumbnail_id();
						$img_url     = wp_get_attachment_url( $thumb, 'full' ); //get img URL
                        $large_image_w = '586';
                        $large_image_h = '586';

                        $large_image = theme_thumb( $img_url, $large_image_w, $large_image_h, true );
					}
					else {
						$large_image = $img_dir_url . '/586x586.png';
					} ?>

					<?php if ( ( $count != 0 ) && ( 0 == $count % 2 ) ) :
						echo '<!-- Output Each Item underneath this line --></li><li>';
					endif; ?>

					<?php $format = get_post_format();
					if ( false === $format ) {
						$format = 'standard';
					}
					$large = true;
					?>

					<div class="big2 large w-50 cr-sl-item cr-sl-item-<?php echo $format; ?> cr-sl-item-<?php echo $count; ?>">

						<?php  include ('embrace-item.php'); ?>

					</div>
				<?php }


				/*****************
				/*  1 Big 4 Small
				/*****************/

				if ( $options['slide_grid'] == '1big-4small' ) {


					if ( has_post_thumbnail() ) {
						$thumb       = get_post_thumbnail_id();
						$img_url     = wp_get_attachment_url( $thumb, 'full' ); //get img URL

                        $large_image_w = '586';
                        $large_image_h = '586';

                        $large_image = theme_thumb( $img_url, $large_image_w, $large_image_h, true );

                        $small_image_w = '293';
                        $small_image_h = '293';
                        $small_image = theme_thumb( $img_url, $small_image_w, $small_image_h, true );
					}
					else {
                        $large_image = $img_dir_url . '/586x586.png';
						$small_image = $img_dir_url . '/293x293.png';
					} ?>

					<?php if ( ( $count != 0 ) && ( 0 == $count % 5 ) ) :
						echo '<!-- Output Each Item underneath this line --></li><li>';
					endif; ?>

					<?php $format = get_post_format();
					if ( false === $format ) {
						$format = 'standard';
					} ?>

					<div class="big1-small4 <?php if ( ( $count == 0 ) || ( 0 == $count % 5 ) ) : ?>large w-50<?php $large= true; else: ?>small w-25<?php $large= false; endif; ?> cr-sl-item cr-sl-item-<?php echo $format; ?> cr-sl-item-<?php echo $count; ?>">

						<?php  include ('embrace-item.php'); ?>

					</div>
				<?php }

				/*****************
				/*  4 Small 1 Big
				/*****************/

				if ( $options['slide_grid'] == '4small-1big' ) {


					if ( has_post_thumbnail() ) {
						$thumb       = get_post_thumbnail_id();
						$img_url     = wp_get_attachment_url( $thumb, 'full' ); //get img URL
                        $large_image_w = '586';
                        $large_image_h = '586';

                        $large_image = theme_thumb( $img_url, $large_image_w, $large_image_h, true );

                        $small_image_w = '293';
                        $small_image_h = '293';
                        $small_image = theme_thumb( $img_url, $small_image_w, $small_image_h, true );
					}
					else {
                        $large_image = $img_dir_url . '/586x586.png';
                        $small_image = $img_dir_url . '/293x293.png';
					} ?>

					<?php if ( ( $count != 0 ) && ( 0 == $count % 5 ) ) :
						echo '<!-- Output Each Item underneath this line --></li><li>';
					endif; ?>

					<?php $format = get_post_format();
					if ( false === $format ) {
						$format = 'standard';
					} ?>

					<div class="small4-big1 <?php if ( ( $count == 0 ) || ( 0 == $count % 5 ) ) : ?>large w-50<?php $large= true; else: ?>small w-25<?php $large= false; endif; ?> cr-sl-item cr-sl-item-<?php echo $format; ?> cr-sl-item-<?php echo $count; ?>">

						<?php  include ('embrace-item.php'); ?>

					</div>
				<?php }

				/*****************
				/*  8 Small
				/*****************/

				if ( $options['slide_grid'] == '8small' ) {


					if ( has_post_thumbnail() ) {
						$thumb       = get_post_thumbnail_id();
						$img_url     = wp_get_attachment_url( $thumb, 'full' ); //get img URL

                        $small_image_w = '293';
                        $small_image_h = '293';
                        $small_image = theme_thumb( $img_url, $small_image_w, $small_image_h, true );
					}
					else {
                        $small_image = $img_dir_url . '/293x293.png';
					} ?>

					<?php if ( ( $count != 0 ) && ( 0 == $count % 8 ) ) :
						echo '<!-- Output Each Item underneath this line --></li><li>';
					endif; ?>

					<?php $format = get_post_format();
					if ( false === $format ) {
						$format = 'standard';
					} ?>

					<div class="small8 small w-25 <?php $large= false;?> cr-sl-item cr-sl-item-<?php echo $format; ?> cr-sl-item-<?php echo $count; ?>">

						<?php  include ('embrace-item.php'); ?>

					</div>
				<?php }

				/**********************
				/*  4 Rectangle Blocks
				/*********************/

				if ( $options['slide_grid'] == '4-large' ) {


					if ( has_post_thumbnail() ) {
						$thumb       = get_post_thumbnail_id();
						$img_url     = wp_get_attachment_url( $thumb, 'full' ); //get img URL

                        $large_image_w = '650';
                        $large_image_h = '340';

                        $large_image = theme_thumb( $img_url, $large_image_w, $large_image_h, true );
					}
					else {
						$large_image = $img_dir_url . '/650x340.png';
					} ?>

					<?php if ( ( $count != 0 ) && ( 0 == $count % 4 ) ) :
						echo '<!-- Output Each Item underneath this line --></li><li>';
					endif; ?>

					<?php $format = get_post_format();
					if ( false === $format ) {
						$format = 'standard';
					} ?>

					<div class="large4 large w-50 <?php $large= true;?> cr-sl-item cr-sl-item-<?php echo $format; ?> cr-sl-item-<?php echo $count; ?>">

						<?php  include ('embrace-item.php'); ?>

					</div>
				<?php }

                /**********************
				/*  Full - width
				/*********************/

				if ( $options['slide_grid'] == '1large' ) {


					if ( has_post_thumbnail() ) {
						$thumb       = get_post_thumbnail_id();
						$img_url     = wp_get_attachment_url( $thumb, 'full' ); //get img URL

                        $large_image_w = '1170';
                        $large_image_h = '536';

                        $large_image = theme_thumb( $img_url, $large_image_w, $large_image_h, true );

					}
					else {
						$large_image = $img_dir_url . '/1171x536.png';
					} ?>

                    <?php if ( $count != 0 ) :
                        echo '<!-- Output Each Item underneath this line --></li><li>';
                    endif; ?>

					<?php $format = get_post_format();
					if ( false === $format ) {
						$format = 'standard';
					} ?>

					<div class="large1 large w-100 <?php $large = true;?> cr-sl-item cr-sl-item-<?php echo $format; ?> cr-sl-item-<?php echo $count; ?>">

						<?php  include ('embrace-item.php'); ?>

					</div>


				<?php }	?>

				<?php if ($count == $total_posts - 1 || 0 == $total_posts) : ?>
			</li>
		</ul>
        <ul class="pages"></ul>
	</div>
</div>
<?php endif; ?>

<?php $count ++;
endwhile; ?>

