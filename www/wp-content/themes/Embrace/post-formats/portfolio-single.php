<?php
/**
 * The template for displaying posts on the portfolio page,
 * portfolio-single, taxonomy-portfolio-category and taxonomy-portfolio-tag
 *
 * @package    Reactor
 * @subpackage Post-Formats
 * @since      1.0.0
 */
?>

<?php   $portfolio_page_link = get_permalink( reactor_option( 'portfolio_page_select', 'portfolio' ) );

$is_full = reactor_option( 'portfolio_single_style', 'full' );

$gallery_type = reactor_option( 'portfolio_gallery_type', 'default' );

$show_share_buttons = reactor_option( 'portfolio_share_buttons', 'show' );

?>

	<div class="row folio-top">
		<nav class="nav-folio-single nav-buttons <?php echo reactor_columns( 4 ); ?>">

				<span class="nav-previous">
            		<?php previous_post_link( '%link', '<i class="crumicon-arrow-left"></i>', false ); ?>
            	</span>

			<?php if ( $portfolio_page_link ) : ?>
				<span class="full-page-link"><a href="<?php echo $portfolio_page_link ?>"><i
							class="crumicon-layout"></i></a></span>
			<?php endif; ?>
			<span class="nav-next">
            		<?php next_post_link( '%link', '<i class="crumicon-arrow-right"></i>', false ); ?>
            	</span>
			<!-- .nav-single -->
		</nav>
		<div class="<?php echo reactor_columns( 8 ); ?>">
			<?php if ( $show_share_buttons == 'show' ) {
				reactor_share_post();
			} ?>
		</div>
	</div>

<div class="row folio-main">

<div class="portfolio-media <?php echo ( $is_full ) ? reactor_columns( 12 ) : reactor_columns( 8 ); ?>">
<?php

if ( ! post_password_required( get_the_id() ) ) {
	global $post;

	$embed_url = get_post_meta( $post->ID, '_folio_embed', true );

	if ( $embed_url ):

		$embed_code = wp_oembed_get( $embed_url );

		echo '<div class="single-folio-video flex-video">' . $embed_code . '</div>';

	endif;

    $self_mp4 = get_post_meta( $post->ID, '_folio_self_hosted_mp4', true ) ? get_post_meta( $post->ID, '_folio_self_hosted_mp4', true ) : false;
    $self_webm = get_post_meta( $post->ID, 'folio_self_hosted_webm', true ) ? get_post_meta( $post->ID, 'folio_self_hosted_webm', true ) : false;

	if ( ( ( $self_mp4 ) || ( $self_webm ) ) && has_post_thumbnail() ) {

		$thumb         = get_post_thumbnail_id();
		$img_url       = wp_get_attachment_url( $thumb, 'full' ); //get img URL
		$article_image = theme_thumb( $img_url, 800, 600, true ); ?>



		<link href="https://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
		<script src="https://vjs.zencdn.net/c/video.js"></script>

		<video id="video-post<?php the_ID(); ?>" class="video-js vjs-default-skin" controls
		       preload="auto"
		       width="auto"
		       height="auto"
		       poster="<?php echo $article_image ?>"
		       data-setup="{}">

			<?php if ( get_post_meta( $post->ID, '_folio_self_hosted_mp4', true ) ): ?>
				<source src="<?php echo get_post_meta( $post->ID, '_folio_self_hosted_mp4', true ) ?>"
				        type='video/mp4'>
			<?php endif; ?>
			<?php if ( get_post_meta( $post->ID, '_folio_self_hosted_webm"', true ) ): ?>
				<source src="<?php echo get_post_meta( $post->ID, '_folio_self_hosted_webm"', true ) ?>"
				        type='video/webm'>
			<?php endif; ?>
		</video>

	<?php } ?>

	<?php
	if ( metadata_exists( 'post', $post->ID, '_my_product_image_gallery' ) ) {
		$my_product_image_gallery = get_post_meta( $post->ID, '_my_product_image_gallery', true );
	} else {
		// Backwards compat
		$attachment_ids           = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids' );
		$attachment_ids           = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
		$my_product_image_gallery = implode( ',', $attachment_ids );
	}

	$attachments = array_filter( explode( ',', $my_product_image_gallery ) );

	if ( $attachments ) {
		if ( $gallery_type == 'default' ) {
			echo '<div class="master-slider ms-skin-default" id="masterslider">';

			foreach ( $attachments as $attachment_key => $attachment_id ) {
				$image_src = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array

				$main_image  = $image_src[0];
				$thumb_image = theme_thumb( $image_src[0], 250, 250, true );

				echo '<div class="ms-slide">';
				echo '<img src="' . $main_image . '" alt="" />';
				echo '<img class="ms-thumb" src="' . $thumb_image . '" alt="" />';
				echo '<a href="' . $image_src[0] . '" class="ms-lightbox magnific-gallery"><i class="embrace-zoom_in2"></i></a>';
				echo '</div>';
			}

			echo '</div>';
		} else {
			echo '<div id="my-work-slider"><ul class="slides">';

			foreach ( $attachments as $attachment_key => $attachment_id ) {

				$image_attributes = wp_get_attachment_image_src( $attachment_id ); // returns an array
				$image_src        = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array

				$attachment_url = '';

				if ( $gallery_type == 'advanced_gallery' ) {
					if ( $attachment_key === 0 ) {
						if ( ! $is_full ) {
							$attachment_url = theme_thumb( $image_src[0], 516, 514, true );
						} else {
							$attachment_url = theme_thumb( $image_src[0], 666, 666, true );
						}
					} else {
						if ( ! $is_full ) {
							$attachment_url = theme_thumb( $image_src[0], 258, 258, true );
						} else {
							$attachment_url = theme_thumb( $image_src[0], 333, 333, true );
						}
					}
				} else {
					$attachment_url = $image_src[0];
				}

				if ( $gallery_type == 'small_images_list' ) {
					$attachment_url = theme_thumb( $image_src[0], 400, 400, true );
				}
				if ( $gallery_type == 'middle_image_list' ) {
					$attachment_url = theme_thumb( $image_src[0], 770, 650, true );
				}
				if ( $gallery_type == 'big_images_list' ) {
					$attachment_url = theme_thumb( $image_src[0], 1280, 1024, true );
				}

				echo '<li>';
				echo '<a href="' . $image_src[0] . '" class="magnific-gallery">';
				echo '<img src="' . $attachment_url . '" alt="" />';
				echo '</a>';
				echo '</li>';
			}
			echo '  </ul>';
			echo '</div>';
		}
	} elseif ( has_post_thumbnail() && ( ! $embed_url ) && ( ! $self_mp4 ) && ( ! $self_webm ) ) {

		$thumb            = get_post_thumbnail_id();
		$image_attributes = wp_get_attachment_image_src( $thumb, 'full' ); // returns an array

		echo '<a href="' . $image_attributes[0] . '" class="zoom">';
		echo wp_get_attachment_image( $thumb, 'full' );
		echo '</a>';
	} ?>
	</div>

	<?php if ( ! $is_full ) {
		echo '<div class="';
		reactor_columns( 4 );
		echo ' end" ><div class="row" >';
	}

	if ( get_post_meta( $post->ID, '_folio_description', true ) != '' ) {
		?>
		<div class="folio-short-desc <?php echo $is_full ? reactor_columns( 8 ) : reactor_columns( 12 ); ?>">

			<h1 class="entry-title"><span><?php the_title(); ?></span></h1>
			<?php echo wpautop( get_post_meta( $post->ID, '_folio_description', true ) ); ?>

		</div>
	<?php
	}

	if ( get_post_meta( $post->ID, '_folio_details_fields', true ) != '' ) {
		?>

		<div class="folio-information <?php echo $is_full != '' ? reactor_columns( 4 ) : reactor_columns( 12 ); ?>">
			<h3><?php _e( 'Project Details', 'crum' ); ?></h3>

			<ul class="project-detail">
				<?php $fields = get_post_meta( $post->ID, '_folio_details_fields', true );
				foreach ( $fields as $field ) {
					$field = explode( '|', $field );
					echo '<li>';
					if ( $field[0] == 'url' ) {
						echo '<a class="vc_btn vc_btn_juicy_pink vc_btn_md vc_btn_rounded" href="' . $field[1] . '" target="_blank">	<i class="crumicon-link icon_left"></i>' . __( 'Visit site', 'crum' ) . '</a><span>';
					} else {
						echo '<span>' . $field[0] . ': </span>' . $field[1];
					}
					echo '</li>';
				} ?>
			</ul>
		</div>

	<?php } ?>

	</div>

	<?php if ( ! $is_full ) {
		echo '</div></div>';
	} ?>


	<?php the_content(); ?>

<?php
}

switch ( $gallery_type ) {
	case 'default':
		wp_enqueue_script( 'masterslider' );
		?>
		<script type="text/javascript">
			(function ($) {
				$(document).ready(function () {
					var slider = new MasterSlider();

					slider.control('arrows');
					slider.control('lightbox');
					slider.control('thumblist', {
						autohide : false,
						dir      : 'h',
						align    : 'bottom',
						width    : 158,
						height   : 158,
						margin   : 0,
						space    : 0,
						hideUnder: 400
					});

					slider.setup('masterslider', {
						width : 1280,
						height: 800,
						space : 5,
						loop  : true,
						view  : 'fade'
					});
				});
			})(jQuery);
		</script>
		<?php
		break;
	case 'big_images_list':
		break;
	case 'middle_image_list':
		?>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				var container = jQuery('#my-work-slider > ul');
				container.addClass('row collapse');
				jQuery('> li', container).addClass('columns large-6');
			});
		</script>
		<?php
		break;
	case 'small_images_list':
		?>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				var container = jQuery('#my-work-slider > ul');
				container.addClass('row collapse');
				jQuery('> li', container).addClass('columns large-4');
			});
		</script>
		<?php
		break;
	case 'advanced_gallery':
		?>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				var container = jQuery('#my-work-slider > ul');
				container.addClass('row collapse');
				jQuery('> li', container).first().addClass('columns large-8').end().not(':first').addClass('columns large-4');
			});
		</script>
		<?php
		break;
};