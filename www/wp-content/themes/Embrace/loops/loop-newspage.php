<?php
/**
 * The loop for displaying posts on the news page template
 *
 * @package    Reactor
 * @subpackage loops
 * @since      1.0.0
 */
?>

<?php // the get options
$options_number_per_page = reactor_option('posts_per_page');
$meta_number_per_page = reactor_option('','','blog_number_to_display');
if (isset ($meta_number_per_page) && !($meta_number_per_page == '')){
	$number_posts = $meta_number_per_page;
}elseif(isset($options_number_per_page) && !($options_number_per_page == '')){
	$number_posts = $options_number_per_page;
}else{
	$number_posts = '10';
}

$post_display_type = reactor_option('','','blog_post_style');
if ($post_display_type == 'blog_left_aligned'){
	$list_style = 'list list-style-left';
}elseif($post_display_type == 'blog_right_aligned'){
	$list_style = 'list list-style-right';
}else{
	$list_style = '';
}

$newspage_post_columns = get_post_meta( get_the_ID(), 'newspage_post_columns', true );
$post_columns = $newspage_post_columns ? $newspage_post_columns : '1';
if (isset($post_display_type) && !($post_display_type == 'default')){
	$post_columns = '1';
}

$blog_cut_array = array();
$selected_custom_categories = wp_get_object_terms( get_the_ID(), 'category' );
if ( ! empty( $selected_custom_categories ) ) {
	if ( ! is_wp_error( $selected_custom_categories ) ) {
		foreach ( $selected_custom_categories as $termy ) {
			$blog_cut_array[] = $termy->term_id;
		}
	}
}

$blog_custom_categories = $blog_cut_array ? $blog_cut_array : '';
if ( $blog_custom_categories ) {
	$blog_custom_categories = implode( ",", $blog_custom_categories );
}


// start post the loop
if (is_front_page()) {
	$paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}
$args = array(
	'post_type'      => 'post',
	'posts_per_page' => $number_posts,
	'paged'          => $paged,
	'cat'            => $blog_custom_categories
);

global $newspage_query;
$newspage_query = new WP_Query( $args ); ?>

<?php if ( $newspage_query->have_posts() ) : ?>

	<?php while ( $newspage_query->have_posts() ) : $newspage_query->the_post();
		global $more;
		$more = 0; ?>
		<?php // get sticky featured posts
		if ( is_sticky( get_the_ID() ) ) : ?>

			<?php // display newspage post format
			if ( !get_post_format() ) : get_template_part('post-formats/format', 'standard');
			else : get_template_part('post-formats/format', get_post_format()); endif; ?>

		<?php endif; // end if sticky ?>
	<?php endwhile; // end of the featured post loop ?>
<?php endif;
rewind_posts(); //end have_posts() check and rewind $post ?>

<?php if ( $newspage_query->have_posts() && ! is_sticky( get_the_ID() ) ) : ?>

	<?php reactor_loop_before(); ?>

	<?php // if more than one column use block-grid
	if ( $post_columns != 1 ) {
		echo '<ul id="main-loop" class="js-masonry  multi-column large-block-grid-' . $post_columns . '" data-masonry-options=\'{ "itemSelector": ".masonry-item"}\'>';
	} else {
        echo '<div id="main-loop" class="'.$list_style.' no-masonry">';
    } ?>

	<?php while ( $newspage_query->have_posts() ) : $newspage_query->the_post();
		global $more;
		$more = 0; ?>
		<?php // no stickys in this loop
		if ( ! is_sticky( get_the_ID() ) ) : ?>

			<?php reactor_post_before(); ?>

			<?php if ( $post_columns != 1 )
				echo '<li class="masonry-item">'; ?>

			<?php // get post format and display template for that format
			if ( isset($post_display_type) && !($post_display_type == 'default') && !($post_display_type == '') )
			{
				get_template_part('post-formats/format', 'list');
			} else{
				if ( !get_post_format() ) : get_template_part('post-formats/format', 'standard');
				else : get_template_part('post-formats/format', get_post_format()); endif;
			}
			?>

			<?php if ( $post_columns != 1 )
				echo '</li>'; ?>

			<?php reactor_post_after(); ?>

		<?php endif; // end if not sticky ?>
	<?php endwhile; // end of the post loop ?>

	<?php if ( $post_columns != 1 ){
		echo '</ul>';
    } else {
        echo '</div>';
    }?>

	<?php reactor_loop_after(); ?>

<?php // if no posts are found
else : reactor_loop_else(); ?>

<?php endif; // end have_posts() check ?>

