<?php
/**
 * Template Name: Coming soon
 *
 * @package   Reactor
 * @subpackge Page-Templates
 * @link      http://www.catswhocode.com/blog/how-to-create-a-built-in-contact-form-for-your-wordpress-theme
 * @since     1.0.0
 */
?>

<?php get_header(); ?>

	<div id="primary" class="site-content">

		<?php reactor_content_before(); ?>

		<div id="content" role="main">
			<div class="row">

				<div class="<?php reactor_columns( 12 ); ?>">

					<?php reactor_inner_content_before(); ?>

					<div class="v-align-wrapper countdown-page">
						<div class="row">
							<div class="large-6 columns small-centered">

								<div class="container">

									<?php while ( have_posts() ) : the_post(); ?>

										<?php reactor_page_before(); ?>

										<div class="text-content">

											<?php the_content(); ?>

										</div>

										<?php reactor_page_after(); ?>


									<?php endwhile; // end of the loop ?>

								</div>
							</div>
						</div>
					</div>

					<?php reactor_inner_content_after(); ?>

				</div>
				<!-- #column -->
			</div>
			<!-- #row -->
		</div>
		<!-- #content -->

		<?php reactor_content_after(); ?>

	</div><!-- #primary -->

<?php get_footer(); ?>