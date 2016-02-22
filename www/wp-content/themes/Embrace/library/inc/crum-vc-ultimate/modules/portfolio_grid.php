<?php
if ( ! class_exists( 'Crum_Portfolio_Grid' ) ) {
	class Crum_Portfolio_Grid {
		function __construct() {
			add_action( 'admin_init', array( &$this, 'crum_portfolio_grid_init' ) );
			add_shortcode( 'portfolio_grid', array( &$this, 'crum_portfolio_gird_form' ) );

			//Transient deleting

			add_action( 'save_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'deleted_post', array( &$this, 'crum_delete_transient' ) );
			add_action( 'switch_theme', array( &$this, 'crum_delete_transient' ) );
		}

		function generate_id() {
			$uniue_id = uniqid( 'recent_posts_id' );

			return $uniue_id;
		}

		function update_id_option( $transient_id ) {


			if ( get_option( 'crum_cached_folio_grid' ) ) {

				$tmp = get_option( 'crum_cached_folio_grid' );

				// The option already exists, so we just update it.
				$tmp = $tmp . ',crum_grid_folio_transient' . $transient_id;
				update_option( 'crum_cached_folio_grid', $tmp );

			} else {

				// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
				$new_value = 'crum_grid_folio_transient' . $transient_id;

				add_option( 'crum_cached_folio_grid', $new_value );
			}
		}

		protected function getLoop( $loop ) {

			list( $this->loop_args, $this->query ) = vc_build_loop_query( $loop, get_the_ID() );
		}

		function crum_delete_transient() {

			$tmp = get_option( 'crum_cached_folio_grid' );

			if ( $tmp !== false ) {

				// The option already exists, so we just update it.
				$temp = explode( ',', $tmp );

			} else {

				return;
			}

			foreach ( $temp as $transient ) {
				delete_transient( $transient );
			}

			delete_option( 'crum_cached_folio_grid' );
		}

		function crum_portfolio_grid_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __( "Main Options", "crum" );

				vc_map(
					array(
						"name"        => __( "Portfolio Grid", "crum" ),
						"base"        => "portfolio_grid",
						"icon"        => "portfolio_grid_icon",
						"category"    => __( "Content", "crum" ),
						"description" => __( "Add block with portfolio grid", "crum" ),
						"params"      => array(
							array(
								"type"        => "loop",
								"heading"     => __( "Loop parameters", "crum" ),
								"param_name"  => "loop",
								'settings'    => array(
									'post_type'  => array( 'hidden' => true, 'value' => 'portfolio' ),
									'size'       => array( 'hidden' => false, 'value' => 12 ),
									'order_by'   => array( 'value' => 'date' ),
									'categories' => array( 'hidden' => true, 'value' => '' ),
									'tags'       => array( 'hidden' => true, 'value' => '' ),
									'tax_query'  => array( 'hidden' => false, 'value' => '' ),
									'by_id'      => array( 'hidden' => true, 'value' => '' ),
									'authors'    => array( 'hidden' => false, 'value' => '' )
								),
								"group"       => $group,
								"description" => __( "Number of posts, Order parameters, Select category, Tags, Author, etc.", "crum" )
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Portfolio select template", "crum" ),
								"param_name"  => "folio_grid_style",
								"value"       => array(
									"Grid+Sorting" => "grid_sort",
									"Grid+Inline box" => "grid_inline_box",
								),
								"group"       => $group,
								"description" => __( "Select template of grid for portfolio displaying", "crum" ),
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Portfolio columns", "crum" ),
								"param_name"  => "folio_grid_columns",
								"value"       => array(
									'Two'   => '2',
									'Three' => '3',
									'Four'  => '4',
									'Five'  => '5',
									'Six'   => '6',
								),
								"group"       => $group,
								"description" => __( "Number of porfolio posts columns", "crum" )
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Item spacing", "crum" ),
								"param_name"  => "folio_grid_spacing",
								"value"       => array(
									'Enable'  => 'enable',
									'Disable' => 'disable',
								),
								"group"       => $group,
								"description" => __( "Display space gap between grid items", "crum" )
							),
							array(
								"type"        => "checkbox",
								"class"       => "",
								"heading"     => __( "Panel for items sorting  ", "crum" ),
								"param_name"  => "folio_grid_panel",
								"value"       => array(
									'Enabled' => 'enable',
								),
								"group"       => $group,
								"description" => __( "Display panel for portfolio isotope items sorting by category", "crum" ),
								"dependency"  => Array(
									"element" => "folio_grid_style",
									"value"   => array( "grid_sort" )
								),
							),
							array(
								"type"       => "checkbox",
								"class"      => "",
								"heading"    => __( "Title / description under item ", "crum" ),
								"param_name" => "folio_grid_description",
								"value"      => array(
									'Hide' => 'enable',
								),
								"group"      => $group,
								"dependency" => Array(
									"element" => "folio_grid_style",
									"value"   => array( "grid_sort" )
								),
							),
							array(
								"type"       => "checkbox",
								"class"      => "",
								"heading"    => __( "Show \"Read more\" button", "crum" ),
								"param_name" => "folio_grid_read_more",
								"value"      => array(
									'Enabled' => 'enable',
								),
								"group"      => $group,
								"dependency" => Array(
									"element" => "folio_grid_style",
									"value"   => array( "grid_inline_box" )
								),
							),
							array(
								"type"       => "dropdown",
								"param_name" => "transient_id",
								"group"      => $group,
								"value"      => array( $this->generate_id() ),
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Animation", "crum" ),
								"param_name"  => "module_animation",
								"value"       => array(
									__( "No Animation", "crum" )       => "",
									__( "FadeIn", "crum" )             => "transition.fadeIn",
									__( "FlipXIn", "crum" )            => "transition.flipXIn",
									__( "FlipYIn", "crum" )            => "transition.flipYIn",
									__( "FlipBounceXIn", "crum" )      => "transition.flipBounceXIn",
									__( "FlipBounceYIn", "crum" )      => "transition.flipBounceYIn",
									__( "SwoopIn", "crum" )            => "transition.swoopIn",
									__( "WhirlIn", "crum" )            => "transition.whirlIn",
									__( "ShrinkIn", "crum" )           => "transition.shrinkIn",
									__( "ExpandIn", "crum" )           => "transition.expandIn",
									__( "BounceIn", "crum" )           => "transition.bounceIn",
									__( "BounceUpIn", "crum" )         => "transition.bounceUpIn",
									__( "BounceDownIn", "crum" )       => "transition.bounceDownIn",
									__( "BounceLeftIn", "crum" )       => "transition.bounceLeftIn",
									__( "BounceRightIn", "crum" )      => "transition.bounceRightIn",
									__( "SlideUpIn", "crum" )          => "transition.slideUpIn",
									__( "SlideDownIn", "crum" )        => "transition.slideDownIn",
									__( "SlideLeftIn", "crum" )        => "transition.slideLeftIn",
									__( "SlideRightIn", "crum" )       => "transition.slideRightIn",
									__( "SlideUpBigIn", "crum" )       => "transition.slideUpBigIn",
									__( "SlideDownBigIn", "crum" )     => "transition.slideDownBigIn",
									__( "SlideLeftBigIn", "crum" )     => "transition.slideLeftBigIn",
									__( "SlideRightBigIn", "crum" )    => "transition.slideRightBigIn",
									__( "PerspectiveUpIn", "crum" )    => "transition.perspectiveUpIn",
									__( "PerspectiveDownIn", "crum" )  => "transition.perspectiveDownIn",
									__( "PerspectiveLeftIn", "crum" )  => "transition.perspectiveLeftIn",
									__( "PerspectiveRightIn", "crum" ) => "transition.perspectiveRightIn",
								),
								"description" => __( "", "crum" ),
								"group"       => "Animation Settings",
							),

						),
					)
				);
			}
		}

		function crum_portfolio_gird_form( $atts, $content = null ) {

			$loop = $folio_grid_style = $folio_grid_columns = $folio_grid_spacing = $folio_grid_panel = $folio_grid_description = $folio_grid_read_more = $transient_id = $module_animation = '';

			extract(
				shortcode_atts(
					array(
						"loop"                   => "",
						"folio_grid_style"       => "grid_sort",
						"folio_grid_columns"     => "",
						"folio_grid_spacing"     => "enable",
						"folio_grid_panel"       => "",
						"folio_grid_description" => "",
						"folio_grid_read_more"   => "",
						"transient_id"           => "",
						"module_animation"       => "",
					), $atts
				)
			);

			if ( empty( $loop ) ) {
				return;
			}

			$folio_grid_space    = ( $folio_grid_spacing == 'enable' ) ? '' : 'no-margin';
			$folio_grid_titles   = ( $folio_grid_description == 'enable' ) ? 'inline-titles' : '';
			$folio_grid_readmore = ( $folio_grid_read_more == 'enable' ) ? '' : 'no-read-more-button';

			$html = '';

			$parse_args = explode( '|', $loop );
			foreach ( $parse_args as $parse_arg ) {
				$parsing = explode( ':', $parse_arg );
				if ( ! ( $parsing[1] == '' ) ) {
					$parse_index[] = $parsing[0];
					$parse_value[] = $parsing[1];
				}
				$args = array_combine( $parse_index, $parse_value );
			}
			if ( isset( $args['tax_query'] ) && ! ( $args['tax_query'] == '' ) ) {
				$tax_ids = explode( ',', $args['tax_query'] );

				$args['tax_query'] = array(
					array(
						'taxonomy' => 'portfolio-category',
						'field'    => 'id',
						'terms'    => $tax_ids,
					)
				);

			}

			$args['posts_per_page'] = $args['size'];
			$args['size']           = null;

			if ( ( ! isset( $args['post_type'] ) ) || $args['post_type'] == '' ) {
				$args['post_type'] = 'portfolio';
			}

			$animate = $animation_data = '';
			if ( ! ( $module_animation == '' ) ) {
				$animate        = ' cr-animate-gen';
				$animation_data = 'data-animate-item = ".type-portfolio" data-animate-type = "' . $module_animation . '" ';
			}

			if ( false === ( $the_query = get_transient( 'crum_grid_folio_transient' . $transient_id ) ) ) {

				$the_query = new WP_Query( $args );

				set_transient( 'crum_grid_folio_transient' . $transient_id, $the_query );
				$this->update_id_option( $transient_id );
			}

			ob_start();

			if ( $folio_grid_style == "grid_sort" ) {
				if ( $folio_grid_panel ) {
					reactor_category_submenu( array( 'taxonomy' => 'portfolio-category', 'quicksand' => true ) );
				}
				if ( $the_query->have_posts() ) :




					echo '<ul class="portfolio-sortable multi-column small-block-grid-2  large-block-grid-' . $folio_grid_columns . ' ' . $folio_grid_space . ' ' . $animate . '" ' . $animation_data . '>';

					reactor_loop_before();
					while ( $the_query->have_posts() ) : $the_query->the_post();
						global $more;
						$more = 0; ?>

						<?php // get the categories for data-type storting
						$port_cats   = '';
						$the_id      = get_the_ID();
						$the_terms   = get_the_terms( $the_id, 'portfolio-category' );
						$cat_array   = array();
						$cat_array[] = 'isotope-item';
						$cat_array[] = $folio_grid_titles;

						if ( $the_terms && ! is_wp_error( $the_terms ) ) :

							foreach ( $the_terms as $the_term ) {

								if ( ! ( $the_term->parent == '' ) ) {
									$parent_terms = get_term( $the_term->parent, 'portfolio-category' );
									if ( ! is_wp_error( $parent_terms ) ) {
										$cat_array[] = $parent_terms->slug;
									}
								} else {
									$cat_array[] = $the_term->slug;
								}

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

									echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

								} else {

									$image_url = '';

									$thumb = get_template_directory_uri() . '/library/img/no-image/no-portfolio-item-small.jpg';

									echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

								} ?>

								<div class="overlay"></div>

								<div class="links">

									<a href="<?php the_permalink(); ?>" class="link"><i
											class="embrace-forward2"></i></a>

								</div>

							</div>
							<div class="item-grid-title">
								<h5 class="entry-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h5>
								<?php the_terms( $the_id, 'portfolio-category', '<div class="categories">', ',  ', '</div>' ); ?>
							</div>
						</li>

						<?php reactor_loop_after();

					endwhile; // end of the portfolio loop

					echo '</ul>';

// if no posts are found
				else : reactor_loop_else();

				endif; // end have_posts() check
			} else {
				if ( $the_query->have_posts() ) :
					echo '<ul class="multi-column small-block-grid-2 with-inline-desc large-block-grid-' . $folio_grid_columns . ' ' . $folio_grid_space . ' ">';
					reactor_loop_before();

					while ( $the_query->have_posts() ) : $the_query->the_post();
						global $more;
						$more = 0;
						global $post;

						$my_product_image_gallery = '';
						$embed_url                = get_post_meta( $post->ID, '_folio_embed', true );
						$self_hosted_url_mp4      = get_post_meta( $post->ID, '_folio_self_hosted_mp4', true );
						$self_hosted_url_webm     = get_post_meta( $post->ID, 'folio_self_hosted_webm', true );


						if ( metadata_exists( 'post', $post->ID, '_my_product_image_gallery' ) ) {
							$my_product_image_gallery = get_post_meta( $post->ID, '_my_product_image_gallery', true );

							$attachments = array_filter( explode( ',', $my_product_image_gallery ) );

							?>

							<?php // get the categories for data-type storting
							$port_cats   = '';
							$the_id      = get_the_ID();
							$the_terms   = get_the_terms( $the_id, 'portfolio-category' );
							$cat_array   = array();
							$cat_array[] = 'isotope-item';
							//$cat_array[] = $folio_item_separate_titles;  TODO: make layout with hidden titles
							$cat_array[] = $folio_grid_readmore;

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

									echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

								} else {

									$image_url = '';

									$thumb = get_template_directory_uri() . '/library/img/no-image/no-portfolio-item-small.jpg';

									echo '<img src = "' . $thumb . '" alt= "' . get_the_title() . '" />';

								} ?>

								<div class="overlay"></div>

								<div class="links">

									<?php

									$inline_grid_button_text = reactor_option( '_folio_inline_grid_read_more' );
									if ( isset( $inline_grid_button_text ) && ! ( $inline_grid_button_text == '' ) ) {
										$button_text = $inline_grid_button_text;
									} else {
										$button_text = __( 'View full project', 'crum' );
									}

									$folio_meta_description = get_post_meta( get_the_ID(), '_folio_description', true );

									if ( isset( $folio_meta_description ) && ! ( $folio_meta_description == '' ) ) {
										$folio_item_description = $folio_meta_description;
									} else {
										$folio_item_description = strip_shortcodes( get_post_field( 'post_content', $post->ID ) );
									}
									$folio_item_description = apply_filters( 'the_content', $folio_item_description );
									$folio_item_description = str_replace( array( '<p>', '</p>' ), array(
										'',
										'<br /><br />'
									), $folio_item_description );
									?>

									<a href="<?php the_permalink(); ?>" data-largesrc="<?php echo $thumb; ?>"
									   data-buttontext="<?php echo $button_text;?>"
									   data-title="<?php the_title(); ?>"
									   data-description="<?php echo str_replace( '"', "'", htmlspecialchars( $folio_item_description ) ); ?>"
									   class="link"><i class="embrace-info2"></i></a>


								</div>
							</div>
							<div class="item-grid-title">
								<h5 class="entry-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h5>
								<?php the_terms( get_the_ID(), 'portfolio-category', '<div class="categories">', ',  ', '</div>' ); ?>
							</div>
							<div class="full-media">

							<?php if ( $attachments ) {

								echo '<div class="mini-gallery">';

								foreach ( $attachments as $attachment_id ) {

									$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array

									$thumb_image = theme_thumb( $image_attributes[0], 554, 390, true );

									echo '<div class="gallery-item"><div class="entry-thumb">';

									echo '<img src="' . $thumb_image . '" alt="' . get_the_title( $post->ID ) . '"><div class="overlay"></div>';

									echo '<div class="links"><a href="' . $image_attributes[0] . '" class="zoom" >';

									echo '<i class="embrace-diagonal_navigation"></i>';

									echo '</a></div></div></div>';
								}
								echo '</div>'; ?>
							<?php } ?>
						<?php } ?>

						<div class="embedd-video"><?php $embed_url = get_post_meta( $post->ID, '_folio_embed', true );

							if ( $embed_url ):

								$embed_code = wp_oembed_get( $embed_url );

								echo '<div class="single-folio-video flex-video">' . $embed_code . '</div>';

							endif;

							if ( ( ( get_post_meta( $post->ID, '_folio_self_hosted_mp4', true ) != '' ) || ( get_post_meta( $post->ID, 'folio_self_hosted_webm', true ) != '' ) ) && has_post_thumbnail() ) {

								$thumb         = get_post_thumbnail_id();
								$img_url       = wp_get_attachment_url( $thumb, 'full' ); //get img URL
								$article_image = theme_thumb( $img_url, 800, 600, true ); ?>



								<link href="https://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
								<script src="https://vjs.zencdn.net/c/video.js"></script>

								<video id="video-post<?php the_ID(); ?>" class="video-js vjs-default-skin" controls
								       preload="auto"
								       width="800"
								       height="600"
								       poster="<?php echo $article_image ?>"
								       data-setup="{}">

									<?php if ( get_post_meta( $post->ID, '_folio_self_hosted_mp4', true ) ): ?>
										<source
											src="<?php echo get_post_meta( $post->ID, '_folio_self_hosted_mp4', true ) ?>"
											type='video/mp4'>
									<?php endif; ?>
									<?php if ( get_post_meta( $post->ID, '_folio_self_hosted_webm"', true ) ): ?>
										<source
											src="<?php echo get_post_meta( $post->ID, '_folio_self_hosted_webm"', true ) ?>"
											type='video/webm'>
									<?php endif; ?>
								</video>

							<?php } ?></div>


						</div>
						</li>


						<?php reactor_loop_after();
					endwhile; // end of the portfolio loop
					echo '</ul>';
				else : reactor_loop_else();
				endif; // end have_posts() check
				?>
				<script>
					jQuery(document).ready(function () {
						Grid.init();
					});
				</script>
			<?php }

			wp_reset_postdata();

			$html .= ob_get_clean();

			return $html;

		}

	}
}
if ( class_exists( 'Crum_Portfolio_Grid' ) ) {
	$Crum_Portfolio_Grid = new Crum_Portfolio_Grid;
}