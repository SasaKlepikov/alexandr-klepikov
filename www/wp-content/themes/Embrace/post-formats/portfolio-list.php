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
$embed_url = get_post_meta( $post->ID, '_folio_embed', true );
$self_hosted_url_mp4 = get_post_meta( $post->ID, '_folio_self_hosted_mp4', true );
$self_hosted_url_webm = get_post_meta( $post->ID, 'folio_self_hosted_webm', true );
/*
if ( metadata_exists( 'post', $post->ID, '_my_product_image_gallery' ) ) {
$my_product_image_gallery = get_post_meta( $post->ID, '_my_product_image_gallery', true );

$attachments = array_filter(explode(',', $my_product_image_gallery));
*/
?>

<article id="portfolio-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-body row">

		<div class="<?php reactor_columns( 8 ); ?> media-content">

			<div class="entry-thumb no-margin">

				<?php
				if ( has_post_thumbnail() ) {
					$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
				}
				else {
					$image_url = get_template_directory_uri() . '/library/img/no-image/big.png';
				}
				$thumb = theme_thumb( $image_url, 765, 350, true);
				echo '<img src = "' . $thumb . '" class="lazyload" data-src="'.$thumb.'" alt= "' . get_the_title() . '" />';?>

				<div class="overlay"></div>

                <div class="links">

                    <a href="<?php the_permalink(); ?>" class="link"><i class="crumicon-forward"></i></a>

                </div>
			</div>
		</div>
		<div class="<?php reactor_columns( 4 ); ?> text-content">
			<div class="project-description">
				<div class="row">
					<div class="large-12 columns">

						<header class="title-portfolio">
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'crum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>

							<div class="subheader">
								<?php the_terms( $id, 'portfolio-category','<span class="categories">'. __('Categories','crum') .': ', ',  ','</span>' );
								the_terms( $id, 'portfolio-tag', '<span class="tags">'. __('Tags','crum') . ': ', ',  ','</span>' ); ?>
							</div>
						</header>


						<div class="entry-content"><p>
								<?php if ( get_post_meta( get_the_ID(), '_folio_description', true ) != '' ) { ?>
									<?php $text = get_post_meta( get_the_ID(), '_folio_description', true ); ?>
								<?php
								}
								else {
                                    $text  = get_the_excerpt();
								}

                                echo wp_trim_words( $text, 30, null );

                                ?>
							</p></div>
						<!-- .entry-content -->

                        <?php if (get_post_meta($post->ID, '_folio_details_fields', true)!='') { ?>
                                <ul class="project-detail">
                                    <?php $fields = get_post_meta($post->ID, '_folio_details_fields', true);
                                    foreach ($fields as $field) {
                                        $field = explode('|',$field);
                                        echo '<li>';
                                        if ($field[0] == 'url'){
                                            echo '<a href="' . $field[1] .'" target="_blank">'.$field[1].'<span>';
                                        } else {
                                            echo '<span>' . $field[0] . ': </span>' . $field[1];
                                        }
                                        echo '</li>';
                                    } ?>
                                </ul>
                        <?php } ?>
                    </div>
				</div>

				<div class="row buttons">
					<div class="large-12 columns">
						<a class="vc_btn vc_btn_sky vc_btn_md vc_btn_rounded" href="<?php the_permalink(); ?>"><?php _e( 'View this project', 'crum' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- .entry-body -->
</article><!-- #post -->