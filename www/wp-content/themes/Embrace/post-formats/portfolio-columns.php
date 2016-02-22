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

<?php // Template options
global $post;
$folio_item_link_zoom = reactor_option( 'folio_item_link_zoom', 1 );
$display_description = reactor_option( 'folio_item_description', true );
$more_button = reactor_option( 'folio_item_read_more', true );
$ext_titles = reactor_option( 'folio_item_separate_titles', true );
$post_columns = reactor_option( 'folio_post_columns', '3');
$my_product_image_gallery = '';


?>

<?php // get the categories for data-type storting
$port_cats = '';
$the_id = get_the_ID();
$the_terms = get_the_terms( $the_id, 'portfolio-category' );
$cat_array = array();

if ( $the_terms && ! is_wp_error( $the_terms ) ) :
	$cat_array[] = 'isotope-item';
	foreach ( $the_terms as $the_term ) {
		$cat_array[] = $the_term->slug;
	}
endif;
?>

<li id="portfolio-<?php the_ID(); ?>" <?php post_class( $cat_array ); ?>>
	<article>
		<div class="entry-body">

			<div class="entry-thumb <?php if ( ! $ext_titles ) : echo 'inner-desc-portfolio'; endif; ?>">


				<?php
				if ( has_post_thumbnail() ) {
					$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
				}
				else {
					$image_url = get_template_directory_uri() . '/library/img/no-image/big.png';
				}

				echo '<img src = "' . $image_url . '" class="lazyload" data-src="'.$image_url.'" alt= "' . get_the_title() . '" />';

				?>
				<div class="overlay"></div>
				<?php crum_portfolio_swohcase( $image_url, $thumb ); ?>

				<?php if ( ! $ext_titles ) { ?>
					<div class="inner-title-portfolio">
						<h3 class="entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'crum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h3>

						<div class="subheader">
							<?php the_terms( $id, 'portfolio-category', '<i class="crum-icon crum-folder-open"></i> ', ',  ' );
							the_terms( $id, 'portfolio-tag', ' <i class="crum-icon crum-tags"></i> ', ',  ' ); ?>
						</div>

					</div>
				<?php } ?>

			</div>


			<?php if ( $ext_titles ) { ?>

				<header class="title-portfolio">
					<h3 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'crum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h3>

					<div class="subheader">
						<?php the_terms( $id, 'portfolio-category', '<i class="crum-icon crum-folder-open"></i> ', ',  ' );
						the_terms( $id, 'portfolio-tag', ' <i class="crum-icon crum-tags"></i> ', ',  ' ); ?>
					</div>
				</header>
				<?php if ( $display_description ) { ?>
					<div class="entry-content"><p>
							<?php if ( get_post_meta( get_the_ID(), '_folio_description', true ) != '' ) { ?>
								<?php echo get_post_meta( get_the_ID(), '_folio_description', true ); ?>
							<?php
							}
							else {
								the_excerpt();
							} ?>
						</p></div>
					<!-- .entry-content -->
				<?php } ?>

				<?php if ( $more_button ) { ?>
					<a class="button" href="<?php the_permalink(); ?>"><?php _e( 'More info', 'crum' ); ?></a>
				<?php } ?>
			<?php } ?>
	</article>
	<!-- #post -->
</li>