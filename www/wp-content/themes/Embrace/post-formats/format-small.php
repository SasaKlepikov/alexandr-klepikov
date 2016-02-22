<?php
/**
 * The template for displaying the small post format
 *
 * @package Reactor
 * @subpackage Post-Formats
 * @since 1.0.0
 */
?>

	<article id="post-<?php the_ID(); ?>" class="small-format mini-news clearfix">
        <div class="entry-body">

                <div class="entry-thumb">

					<?php
					if( has_post_thumbnail() ){
						$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
					} else {
						$image_url = get_template_directory_uri() . '/library/img/no-image/small.png';
					}
					$thumb = theme_thumb( $image_url, 70, 70, true );
					echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

					?>
					<div class="overlay"></div>
					<div class="links">
						<a href="<?php the_permalink(); ?>"><i class="crumicon-forward"></i></a>
					</div>

                </div>

            <h6 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h6>

            <div class="entry-content">
                <?php $trimexcerpt = get_the_excerpt() ? get_the_excerpt() : get_the_content();
                $shortexcerpt = wp_trim_words($trimexcerpt, $num_words = 10, $more = '… ');

                echo '<p>' . $shortexcerpt . '</p>';  ?>

            </div>
            
		</div><!-- .entry-body -->
	</article><!-- #post -->