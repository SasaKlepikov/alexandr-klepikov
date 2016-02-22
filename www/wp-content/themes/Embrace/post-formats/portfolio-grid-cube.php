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
$folio_item_inline = reactor_option( 'folio_item_inline', 1 );


?>

<?php // get the categories for data-type storting
$port_cats = '';
$the_id = get_the_ID();
$the_terms = get_the_terms($the_id, 'portfolio-category');
$cat_array = array();
$cat_array[] = 'cbp-item';

if ( $the_terms && !is_wp_error( $the_terms ) ) :
	foreach( $the_terms as $the_term ) {
		$cat_array[] = $the_term->slug;
	}
endif;

$item_folio_classes = implode(" ", $cat_array);

?>



<li class="<?php echo $item_folio_classes; ?>">
    <div class="cbp-caption">
        <div class="entry-thumb cbp-caption-defaultWrap">

            <?php
            if ( has_post_thumbnail() ) {
                $image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
            }
            else {
                $image_url = get_template_directory_uri() . '/library/img/no-image/big.png';
            }
            $thumb = theme_thumb( $image_url, 300, 300, true);
            echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';?>

            <div class="overlay"></div>

            <div class="links">

                <?php if ($folio_item_inline) { ?>

                <a href="#" class="cbp-singlePageInline"><i class="crumicon-info"></i></a>

                <?php } else { ?>

                <a href="<?php the_permalink(); ?>" class="link"><i class="crumicon-forward"></i></a>

                <?php } ?>

            </div>
        </div>

        <div class="cbp-caption-activeWrap">
            <div class="cbp-l-caption-alignLeft">
                <div class="item-grid-title">
                    <h5 class="entry-title">
                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'crum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </h5>
                    <?php the_terms( $id, 'portfolio-category', '<div class="categories">', ',  ','</div>' ); ?>
                </div>
            </div>
        </div>
    </div>
</li>

<?php if ($folio_item_inline) { ?>



<?php }?>

<!-- #portfolio item  -->