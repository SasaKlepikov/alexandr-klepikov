<div class="carousel-item grid-item">
<div class="entry-thumb no-radius no-margin">

	<?php
	$image_url = '';

	if ( has_post_thumbnail() ) {
		$image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

		if ( isset($crop_thumb_disable) && ($crop_thumb_disable == 'true') ) {
			$thumb = theme_thumb( $image_url, 480, 420, false );
		} else {
			$thumb = theme_thumb( $image_url, 480, 420, true );
		}

		echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

	}
	else {

		$image_url = '';

		$thumb = get_template_directory_uri() . '/library/img/no-image/no-portfolio-item-small.jpg';

		echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

	} ?>

	<div class="overlay"></div>

    <div class="links">

        <a href="<?php the_permalink(); ?>" class="link"><i class="crumicon-forward"></i></a>

    </div>
</div>
<div class="item-grid-title">
    <h5 class="entry-title">
        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'crum' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
    </h5>
    <?php the_terms( get_the_ID(), 'portfolio-category', '<div class="categories">', ',  ','</div>' ); ?>
</div></div>