<?php
$auto_excerpt = reactor_option('auto_excerpt', false);
$thumb_custom_width = reactor_option('','','_cr_post_thumb_width');
$thumb_custom_height = reactor_option('','','_cr_post_thumb_height');

if (isset($thumb_custom_height) && !($thumb_custom_height == '')){
	$thumb_height = $thumb_custom_height;
}else{
	$thumb_height = '350';
}

if(isset($thumb_custom_width) && !($thumb_custom_width == '')){
	$thumb_width = $thumb_custom_width;
}else{
	$thumb_width = '765';
}
?>

<article id="blog-post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-body row">

		<div class="<?php reactor_columns( 8 ); ?> media-content">

			<div class="entry-thumb no-margin">

				<?php
				if ( has_post_thumbnail() ) {
					$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
				}
				else {
					$image_url = get_template_directory_uri() . '/library/img/no-image/large.png';
				}
				$thumb = theme_thumb( $image_url, $thumb_width, $thumb_height, true);

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

						<header class="title-blog-post">
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'crum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>

							<div class="subheader">
								<?php the_terms( $id, 'category','<span class="categories">'. __('Categories','crum') .': ', ',  ','</span>' );
								the_terms( $id, 'tag', '<span class="tags">'. __('Tags','crum') . ': ', ',  ','</span>' ); ?>
							</div>
						</header>


						<div class="entry-content"><p>
								<?php

								the_excerpt();

								?>
							</p></div>
						<!-- .entry-content -->


					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- .entry-body -->
</article><!-- #post -->