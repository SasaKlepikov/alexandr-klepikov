<?php
/*
 * Atlantis item template part
 *
 * Crumina team
 */
?>


<?php if ( $format == 'video' ) {

    $post_video = get_post_meta(get_the_ID(), '_format_video_embed', true);

    if ($post_video) {
        $content = apply_filters('the_content',$post_video);
    } else {
        $content = apply_filters('the_content',get_the_content());
    }

	$content = do_shortcode('[flex_video widescreen="false"]'.$content.'[/flex_video]');

	echo $content;
}
else {

	$tax = get_post_type();

	?>
	<img src="<?php if ( $large ) : echo $large_image;
	else: echo $small_image; endif; ?>" alt="<?php the_title(); ?>" />
	<span class="bg"></span>
	<span class="text-desc">
		<?php if ( $show_link ) : ?>
		<a href="<?php the_permalink(); ?>">
			<?php endif; ?>
					<?php if ( $show_category ): ?>

						<?php
							switch ( $tax ) {
								case 'portfolio':
									$taxonomy = 'portfolio-category';
									break;
								case 'product':
									$taxonomy = 'product_cat';
									break;
								case 'post':
									$taxonomy = 'category';
									break;
								case 'page':
									$taxonomy = false;
									break;
								default:
									$taxonomy = 'category';
							}

						$terms = get_the_terms( get_the_ID(), $taxonomy);

						if ( $terms && ! is_wp_error( $terms ) ) :

							$tax_names = array();

							foreach ( $terms as $term ) {
								$tax_names[] = $term->name;
							}

							$tax_names = join( ", ", $tax_names );

							endif;
						?>

						<span class="item-category"><?php echo $tax_names; ?></span>

					<?php endif; ?>

		<?php if ( $show_title ): ?>
			<span class="item-title"><?php the_title(); ?></span>
		<?php endif; ?>
		<?php if ( $show_description ): ?>
			<span class="item-desc">
					<?php if ( $format == 'audio' ) {
						$content = get_the_content();
						$content = apply_filters('the_content', $content);
						echo $content;
					} elseif ($format == 'standard') {

						$content = get_the_excerpt();

						if ($tax == 'portfolio'){
							$content = get_post_meta(get_the_ID(), '_folio_description', true);
						}

						echo wp_trim_words($content, $decription_limit, ' ...');
					}?>

					</span>
		<?php endif; ?>
			<?php if ( $show_link ) : ?>
		</a>
	<?php endif; ?>
				</span>

<?php } ?>