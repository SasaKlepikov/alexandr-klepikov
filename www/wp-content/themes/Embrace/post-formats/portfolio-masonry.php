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
$my_product_image_gallery = '';
$masonry_item_sizing = get_post_meta( $post->ID, '_portfolio_item_masonry_sizing', true );
$masonry_item_sizing = $masonry_item_sizing ? $masonry_item_sizing : 'regular';

?>

<?php // get the categories for data-type storting
$port_cats = '';
$the_id = get_the_ID();
$the_terms = get_the_terms($the_id, 'portfolio-category');
$cat_array = array();

if ( $the_terms && !is_wp_error( $the_terms ) ) :
	$cat_array[] = 'isotope-item';
	foreach( $the_terms as $the_term ) {
		$cat_array[] = $the_term->slug;
	}
endif;

$masonry_folio_classes = array_merge(array($masonry_item_sizing,'elastic-portfolio-item'),$cat_array);
$masonry_folio_classes = implode(" ",$masonry_folio_classes);
?>


<article id="portfolio-<?php the_ID(); ?>" class="<?php echo $masonry_folio_classes; ?>">
	<div class="entry-body">
		<div class="entry-thumb no-margin inner-desc-portfolio">

			<?php
			if ( has_post_thumbnail() ) {
				$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

				switch ( $masonry_item_sizing ) {
					case 'wide':
						$thumb = theme_thumb( $image_url, 1000, 500, true );
						break;
					case 'tall':
						$thumb = theme_thumb( $image_url, 500, 1000, true );
						break;
					case 'regular':
						$thumb = theme_thumb( $image_url, 500, 500, true );
						break;
					case 'wide_tall':
						$thumb = theme_thumb( $image_url, 1000, 1000, true );
						break;
					default:
						$thumb = theme_thumb( $image_url, 500, 500, true );
						break;
				}

				echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

			}
			else {

				$image_url = '';

				switch ( $masonry_item_sizing ) {
					case 'wide':
						$no_image_size = 'no-portfolio-item-wide.jpg';
						break;
					case 'tall':
						$no_image_size = 'no-portfolio-item-tall.jpg';
						break;
					case 'regular':
						$no_image_size = 'no-portfolio-item-tiny.jpg';
						break;
					case 'wide_tall':
						$no_image_size = 'no-portfolio-item-tiny.jpg';
						break;
					default:
						$no_image_size = 'no-portfolio-item-small.jpg';
						break;
				}

				$thumb = get_template_directory_uri() . '/library/img/no-image/' . $no_image_size . '';

				echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

			} ?>

			<div class="overlay"></div>

			<?php crum_portfolio_swohcase( $image_url, $thumb ); ?>

			<div class="inner-title-portfolio">
				<h4 class="entry-title no-margin">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'crum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h4>

				<div class="subheader">
					<?php the_terms( $id, 'portfolio-category', '<i class="crum-icon crum-folder-open"></i> ', ',  ' );
					the_terms( $id, 'portfolio-tag', ' <i class="crum-icon crum-tags"></i> ', ',  ' ); ?>
				</div>

			</div>


		</div>
	</div>
</article><!-- #post -->