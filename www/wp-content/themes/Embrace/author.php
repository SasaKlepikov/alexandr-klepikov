<?php
/**
 * The template for displaying author archive pages
 *
 * @package Reactor
 * @subpackge Templates
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

	<div id="primary" class="site-content">
    
    	<?php reactor_content_before(); ?>

		<div id="content" role="main">

			<div class="row">

				<?php set_layout('archive', true); ?>
                
                <?php reactor_inner_content_before(); ?>
                
				<?php if ( have_posts() ) : the_post(); ?>

                    <?php rewind_posts(); ?>
        
                    <?php // If a user has filled out their description, show a bio on their entries.
                    if ( get_the_author_meta('description') ) : ?>
						<div class="about-author">
							<figure class="author-photo">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
							</figure>

							<div class="info-wrap">
								<div class="author-name"><?php the_author_posts_link(); ?>
									<span><?php _e( 'Post author', 'crum' ); ?></span></div>

								<div class="share-icons">
									<?php if ( get_the_author_meta( 'twitter' ) ) {
										echo '<a href="', the_author_meta( 'twitter' ), '"><i class="crum-icon crum-twitter-3"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'cr_facebook' ) ) {
										echo '<a href="', the_author_meta( 'cr_facebook' ), '"><i class="crum-icon crum-facebook"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'googleplus' ) ) {
										echo '<a href="', the_author_meta( 'googleplus' ), '"><i class="crum-icon crum-google__x2B_"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'linkedin' ) ) {
										echo '<a  href="', the_author_meta( 'linkedin' ), '"><i class="crum-icon crum-linkedin"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'vimeo' ) ) {
										echo '<a  href="', the_author_meta( 'vimeo' ), '"><i class="crum-icon crum-vimeo"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'lastfm' ) ) {
										echo '<a  href="', the_author_meta( 'lastfm' ), '"><i class="crum-icon crum-last_fm"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'tumblr' ) ) {
										echo '<a  href="', the_author_meta( 'tumblr' ), '"><i class="crum-icon crum-tumblr"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'skype' ) ) {
										echo '<a  href="', the_author_meta( 'skype' ), '"><i class="crum-icon crum-skype"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'vkontakte' ) ) {
										echo '<a  href="', the_author_meta( 'vkontakte' ), '"><i class="crum-icon crum-rus-vk-01"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'deviantart' ) ) {
										echo '<a  href="', the_author_meta( 'deviantart' ), '"><i class="crum-icon crum-deviantart"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'picasa' ) ) {
										echo '<a  href="', the_author_meta( 'picasa' ), '"><i class="crum-icon crum-picasa"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'wordpress' ) ) {
										echo '<a  href="', the_author_meta( 'wordpress' ), '"><i class="crum-icon crum-wordpress"></i></a>';
									} ?>
									<?php if ( get_the_author_meta( 'instagram' ) ) {
										echo '<a  href="', the_author_meta( 'instagram' ), '"><i class="crum-icon crum-instagram"></i></a>';
									} ?>
								</div>
							</div>

							<div class="ovh">
								<div class="author-description">
									<p><?php the_author_meta( 'description' ); ?></p>
								</div>
							</div>
						</div>
                    <?php endif; ?>

                <?php endif; // end have_posts() check ?>
                <div id="main-loop">
                    <?php // get the loop
                    get_template_part('loops/loop', 'index'); ?>
                </div>
                <?php reactor_inner_content_after(); ?>

				<?php set_layout('archive', false); ?>

			</div><!-- .row -->

		</div><!-- #content -->
        
        <?php reactor_content_after(); ?>
        
	</div><!-- #primary -->

<?php get_footer(); ?>