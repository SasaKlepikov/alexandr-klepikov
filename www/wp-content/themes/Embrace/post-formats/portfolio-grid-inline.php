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
$folio_item_separate_titles = (! reactor_option( 'folio_item_separate_titles', 1 )) ? 'inline-titles' : '';

//Read more button
$meta_item_read_more = reactor_option('','','single_folio_read_more');
$options_item_read_more = reactor_option( 'folio_item_read_more' );

if (isset($meta_item_read_more) && ! ($meta_item_read_more == 'default')){
	if ( $meta_item_read_more == 'show' ) {
		$folio_item_read_more = '';
	} else {
		$folio_item_read_more = 'no-read-more-button';
	}
}elseif(isset($options_item_read_more) && !($options_item_read_more == '0')){
	$folio_item_read_more = '';
}else{
	$folio_item_read_more = 'no-read-more-button';
}

//end Read more button



$my_product_image_gallery = '';
$embed_url = get_post_meta( $post->ID, '_folio_embed', true );
$self_hosted_url_mp4 = get_post_meta( $post->ID, '_folio_self_hosted_mp4', true );
$self_hosted_url_webm = get_post_meta( $post->ID, 'folio_self_hosted_webm', true );


if ( metadata_exists( 'post', $post->ID, '_my_product_image_gallery' ) ) {
$my_product_image_gallery = get_post_meta( $post->ID, '_my_product_image_gallery', true );

$attachments = array_filter(explode(',', $my_product_image_gallery));

?>

<?php // get the categories for data-type storting
$port_cats = '';
$the_id = get_the_ID();
$the_terms = get_the_terms( $the_id, 'portfolio-category' );
$cat_array = array();
$cat_array[] = 'isotope-item';
//$cat_array[] = $folio_item_separate_titles;  TODO: make layout with hidden titles
$cat_array[] = $folio_item_read_more;

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

            echo '<img src = "' . $thumb . '" class="lazyload" data-src="'.$thumb.'" alt= "' . get_the_title() . '" />';

        }
        else {

            $image_url = '';

            $thumb = get_template_directory_uri() . '/library/img/no-image/no-portfolio-item-small.jpg';

            echo '<img src = "' . $thumb . '" class="lazyload" data-src="'.$thumb.'" alt= "' . get_the_title() . '" />';

        } ?>

        <div class="overlay"></div>

	    <div class="links">

		    <?php $folio_meta_description = get_post_meta( get_the_ID(), '_folio_description', true );

		    if ( isset( $folio_meta_description ) && ! ( $folio_meta_description == '' ) ) {
			    $folio_item_description = $folio_meta_description;
		    } else {
			    $folio_item_description = strip_shortcodes( get_post_field( 'post_content', $post->ID ) );
		    }
		    $folio_item_description = apply_filters('the_content', $folio_item_description);
		    $folio_item_description = str_replace(array('<p>','</p>'),array('','<br /><br />'), $folio_item_description);

		    $inline_grid_button_text = reactor_option( '_folio_inline_grid_read_more' );
		    if ( isset( $inline_grid_button_text ) && ! ( $inline_grid_button_text == '' ) ) {
			    $button_text = $inline_grid_button_text;
		    } else {
			    $button_text = __( 'View full project', 'crum' );
		    }
		    ?>

		    <a href="<?php the_permalink(); ?>" data-buttontext="<?php echo $button_text;?>" data-largesrc="<?php echo $thumb; ?>" data-title="<?php the_title(); ?>" data-description="<?php echo str_replace('"',"'",htmlspecialchars($folio_item_description)); ?>" class="link"><i class="embrace-info2"></i></a>

	    </div>
    </div>
    <div class="item-grid-title">
        <h5 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h5>
        <?php the_terms( $id, 'portfolio-category', '<div class="categories">', ',  ','</div>' ); ?>
    </div>
    <div class="full-media">

        <?php if ( $attachments ) {

					echo '<div class="mini-gallery">';

						foreach ( $attachments as $attachment_id ) {

							$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array

							$thumb_image = theme_thumb( $image_attributes[0], 554, 390, true );

							echo '<div class="gallery-item"><div class="entry-thumb">';

							echo '<img src="'.$thumb_image.'" alt="'.get_the_title($post->ID).'"><div class="overlay"></div>';

							echo '<div class="links"><a href="' . $image_attributes[0] . '" class="zoom">';

							echo '<i class="embrace-diagonal_navigation"></i>';

							echo '</a></div></div></div>';
						}
						echo '</div>'; ?>
				<?php } ?>
        <?php } ?>

        <div class="embedd-video"><?php $embed_url = get_post_meta($post->ID, '_folio_embed', true);

        if ($embed_url):

            $embed_code = wp_oembed_get($embed_url);

            echo '<div class="single-folio-video flex-video">' . $embed_code . '</div>';

        endif;

        if (((get_post_meta($post->ID, '_folio_self_hosted_mp4', true) != '') || (get_post_meta($post->ID, 'folio_self_hosted_webm', true) != '')) && has_post_thumbnail()) {

            $thumb = get_post_thumbnail_id();
            $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
            $article_image = theme_thumb($img_url, 800, 600, true); ?>



            <link href="https://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
            <script src="https://vjs.zencdn.net/c/video.js"></script>

            <video id="video-post<?php the_ID(); ?>" class="video-js vjs-default-skin" controls
                   preload="auto"
                   width="800"
                   height="600"
                   poster="<?php echo $article_image ?>"
                   data-setup="{}">

                <?php if (get_post_meta($post->ID, '_folio_self_hosted_mp4', true)): ?>
                    <source src="<?php echo get_post_meta($post->ID, '_folio_self_hosted_mp4', true) ?>"
                            type='video/mp4'>
                <?php endif; ?>
                <?php if (get_post_meta($post->ID, '_folio_self_hosted_webm"', true)): ?>
                    <source src="<?php echo get_post_meta($post->ID, '_folio_self_hosted_webm"', true) ?>"
                            type='video/webm'>
                <?php endif; ?>
            </video>

        <?php } ?></div>


    </div>
</li>

<!-- #portfolio item  -->