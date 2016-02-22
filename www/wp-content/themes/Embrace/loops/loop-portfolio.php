<?php
/**
 * The loop for displaying portfolio posts on the portfolio page template
 *
 * @package    Reactor
 * @subpackage loops
 * @since      1.0.0
 */
?>

<?php // get the options
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$order_by = reactor_option( 'folio_sort_field', 'date' );
$order = reactor_option( 'folio_post_order', 'DESC' );


//Number posts per page
$options_number_per_page = reactor_option('_folio_number_to_display');
$meta_number_per_page = reactor_option('','','portfolio_number_to_display');
if (isset ($meta_number_per_page) && !($meta_number_per_page == '')){
	$number_posts = $meta_number_per_page;
}elseif(isset($options_number_per_page) && !($options_number_per_page == '')){
	$number_posts = $options_number_per_page;
}else{
	$number_posts = '10';
}
//end Number posts per page

//Folio sorting panel

$meta_sorting_panel = reactor_option('','','single_folio_sorting_panel');
$options_sorting_panel = reactor_option( 'folio_sort_panel', true);

	if (isset($meta_sorting_panel) &&  ($meta_sorting_panel == 'on')){
		$folio_sorting_panel = $meta_sorting_panel;
	}elseif(isset($options_sorting_panel) ){
		$folio_sorting_panel = $options_sorting_panel;
	}else{
		$folio_sorting_panel = false;
	}

//end Folio sorting panel

//Post columns
$meta_post_columns = reactor_option('','','single_folio_grid_columns');
$options_post_columns = reactor_option( 'folio_post_columns', '3');

if (isset($meta_post_columns) && !($meta_post_columns == 'default')){
	$post_columns = $meta_post_columns;
}elseif(isset($options_post_columns) && !($options_post_columns == '')){
	$post_columns = $options_post_columns;
}else{
	$post_columns = '2';
}

//end Post columns

// Item spacing

$meta_items_space = reactor_option('','','single_folio_space_gap');
$options_items_space = reactor_option( 'folio_items_space', true);

if (isset($meta_items_space) && !($meta_items_space == 'default') && !($meta_items_space == '')){
	if ( $meta_items_space == 'not_show' ) {
		$folio_items_space = 'no-margin';
	} else {
		$folio_items_space = '';
	}
}elseif(isset($options_items_space) && !($options_items_space == '0')){
	$folio_items_space = '';
}else{
	$folio_items_space = 'no-margin';
}

//end Item spacing

//Folio template

$meta_folio_template = reactor_option('','','single_folio_template');
$options_folio_template = reactor_option( 'folio_template', 'list' );

if(isset($meta_folio_template) && !($meta_folio_template == 'default') && !($meta_folio_template == '')){
	$folio_template = $meta_folio_template;
}elseif(isset($options_folio_template) && !($options_folio_template == '')){
	$folio_template = $options_folio_template;
}else{
	$folio_template = 'list';
}

//end Folio template

//List style

$meta_list_style = reactor_option('','','single_folio_list_style');
$options_list_style = reactor_option( 'list_style', 'left');

if(isset($meta_list_style) && !($meta_list_style == 'default') && !($meta_list_style == '')){
	$list_style = $meta_list_style;
}elseif(isset($options_list_style) && !($options_list_style == '')){
	$list_style = $options_list_style;
}else{
	$list_style = 'left';
}

//end List style






/*
$folio_loading_effect = reactor_option( 'folio_loading_effect', 'bottomToTop');
$folio_sort_effect = reactor_option( 'folio_sort_effect', 'quicksand');
$folio_sort_effect = reactor_option( 'folio_sort_effect', 'quicksand');
*/

global $portfolio_query;

$blog_cut_array = $blog_cut_slugs = array();
$selected_custom_categories = wp_get_object_terms( get_the_ID(), 'portfolio-category' );
if ( ! empty( $selected_custom_categories ) ) {
	if ( ! is_wp_error( $selected_custom_categories ) ) {
		foreach ( $selected_custom_categories as $termy ) {
			$blog_cut_array[] = $termy->term_id;
			$blog_cut_slugs[] = $termy->slug;
		}
	}
}

if ( is_front_page() ) {
	$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
}
else {
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
}

if ( ! empty ( $blog_cut_array ) ) {
	$folio_custom_query = array(
		'tax_query' => array(
			array(
				'taxonomy' => 'portfolio-category',
				'field'    => 'id',
				'terms'    => $blog_cut_array,
			)
		)
	);
}
else {
	$folio_custom_query = array();
}


if ( is_tax( 'portfolio-tag' ) ) {
	$args = array(
		'post_type'      => 'portfolio',
		'orderby'        => $order_by,
		'order'          => $order,
		'portfolio-tag'  => $term->name,
		'posts_per_page' => $number_posts,
		'paged'          => $paged,

	);
}
elseif ( is_tax( 'portfolio-category' ) ) {
	$args = array(
		'post_type'          => 'portfolio',
		'orderby'            => $order_by,
		'order'              => $order,
		'portfolio-category' => $term->name,
		'posts_per_page'     => $number_posts,
		'paged'              => $paged,

	);
}
else {
	$args = array(
		'post_type'      => 'portfolio',
		'orderby'        => $order_by,
		'order'          => $order,
		'posts_per_page' => $number_posts,
		'paged'          => $paged,

	);
}
$args = array_merge( $args, $folio_custom_query );  ?>

<?php // start the portfolio loop
$portfolio_query = new WP_Query( $args );
?>


<?php // category submenu function

if ( is_page_template('page-templates/portfolio.php') && $folio_sorting_panel && ($folio_template == 'grid') ) {

	if ( ! empty ( $blog_cut_array ) ){
		reactor_category_submenu( array('taxonomy' => 'portfolio-category', 'quicksand' => true,  'terms_args' => array('include' => $blog_cut_array) ) );
	} else {
		reactor_category_submenu( array('taxonomy' => 'portfolio-category', 'quicksand' => true) );
	}
}

if ( $portfolio_query->have_posts() ) :

    if ($folio_template == 'grid') {

        echo '<ul id="main-loop" class="portfolio-sortable multi-column small-block-grid-2  medium-block-grid-' . $post_columns . ' ' . $folio_items_space . '" >';

    } elseif ($folio_template == 'grid-inline') {

        echo '<ul id="main-loop" class="multi-column with-inline-desc small-block-grid-2  medium-block-grid-' . $post_columns . ' ' . $folio_items_space . '" >';

    } else {

        echo '<div id="main-loop" class="list no-masonry list-style-' . $list_style . '">';

	} ?>

	<?php reactor_loop_before(); ?>
	<?php while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
		global $more;
		$more = 0; ?>

		<?php get_template_part( 'post-formats/portfolio', $folio_template ); ?>

		<?php reactor_loop_after(); ?>

	<?php endwhile; // end of the portfolio loop ?>
		<?php if (($folio_template  == 'grid') || ($folio_template == 'grid-inline')) {
			echo '</ul>';
		} else {
			echo '</div>';
		} ?>
<?php // if no posts are found
else : reactor_loop_else(); ?>

<?php endif; // end have_posts() check ?>

<?php if ($folio_template == 'grid-inline') { ?>
<script>
    jQuery(document).ready(function () {
        Grid.init();
    });
</script>
<?php } ?>
