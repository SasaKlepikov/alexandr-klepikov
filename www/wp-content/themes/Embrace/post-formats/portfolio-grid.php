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

//Separate items
$meta_item_separate_titles = reactor_option('','','single_folio_item_description');
$options_item_separate_titles = reactor_option( 'folio_item_separate_titles', 1 );

if (isset($meta_item_separate_titles) && ! ($meta_item_separate_titles == 'default')){
	if ( $meta_item_separate_titles == 'show' ) {
		$folio_item_separate_titles = '';
	} else {
		$folio_item_separate_titles = 'inline-titles';
	}
}elseif(isset($options_item_separate_titles) && !($options_item_separate_titles == '0')){
	$folio_item_separate_titles = 'inline-titles';
}else{
	$folio_item_separate_titles = '';
}


//end Separate items

?>

<?php // get the categories for data-type storting
$port_cats = '';
$the_id = get_the_ID();
$the_terms = get_the_terms( $the_id, 'portfolio-category' );
$cat_array = array();
$cat_array[] = 'isotope-item';
$cat_array[] = $folio_item_separate_titles;

if ( $the_terms && ! is_wp_error( $the_terms ) ) :

    foreach ( $the_terms as $the_term ) {
        $cat_array[] = $the_term->slug;
    }
endif;
?>

<li id="portfolio-<?php the_ID(); ?>" <?php post_class( $cat_array ); ?>>
    <div class="entry-thumb no-radius no-margin">

        <?php
        $image_url = '';

        if ( has_post_thumbnail() ) {
            $image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

            $thumb = theme_thumb( $image_url, 480, 420, true );

            echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

        }
        else {

            $image_url = '';

            $thumb = get_stylesheet_directory_uri() . '/library/img/no-image/no-portfolio-item-small.jpg';

            echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

        } ?>

        <div class="overlay"></div>

        <div class="links">

            <a href="<?php the_permalink(); ?>" class="link"><i class="crumicon-forward"></i></a>

        </div>

    </div>
    <div class="item-grid-title">
        <h5 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h5>
        <?php the_terms( $id, 'portfolio-category', '<div class="categories">', ',  ','</div>' ); ?>
    </div>
</li>

<!-- #portfolio item  -->