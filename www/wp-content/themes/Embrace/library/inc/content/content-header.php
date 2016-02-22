<?php
/**
 * Header Content
 * hook in the content for header.php
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */


/**
 * Site meta, title, and favicon
 * in header.php
 *
 * @since 1.0.0
 */
function reactor_do_reactor_head() { ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<!-- google chrome frame for ie -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--[if lte IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<!--[if lte IE 8]>
	<script src="<?php echo get_template_directory_uri() ?>/library/js/rem.min.js" type="text/javascript"></script>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php $responsive_mode = reactor_option( 'responsive_mode' ); ?>

	<!-- mobile meta -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<?php if ( $responsive_mode == '1' ) { ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php } ?>

	<?php $favicon_uri = reactor_option( 'favicon_image' ) ? reactor_option( 'favicon_image' ) : get_template_directory_uri() . '/favicon.ico'; ?>
	<link rel="shortcut icon" href="<?php echo $favicon_uri; ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">



<?php
}

add_action( 'wp_head', 'reactor_do_reactor_head', 1 );


function cr_insert_fb_in_head() {
	global $post;
	if ( ! is_singular() ) //if it is not a post or a page
	{
		return;
	}
	echo '<meta property="og:title" content="' . get_the_title() . '"/>';
	echo '<meta property="og:type" content="article"/>';
	echo '<meta property="og:url" content="' . get_permalink() . '"/>';
	if ( has_post_thumbnail( $post->ID ) ) { //the post does not have featured image, use a default image
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		echo '<meta property="og:image" content="' . theme_thumb( esc_attr( $thumbnail_src[0] ), '1200', '', false ) . '"/>';
	}
	echo "
";
}

add_action( 'wp_head', 'cr_insert_fb_in_head', 5 );


/**
 * Top bar
 * in header.php
 *
 * @since 1.0.0
 */
function reactor_do_top_bar() {
	if ( reactor_option( 'top_panel', false ) ) {
		$reactor_topbar_social = reactor_option( 'top_panel_social', false ) ? 'reactor_topbar_social' : false;
		$reactor_topbar_search = reactor_option( 'top_panel_search', false ) ? 'reactor_topbar_search' : false;
		$left_panel            = reactor_option( 'left-panel', false );
		$right_panel           = reactor_option( 'right-panel', false );


		function left_panel( $switch ) {
			switch ( $switch ) {
				case 'text':
					$switch = 'reactor_topbar_text_left';

					return $switch;
					break;

				case 'menu':
					$switch = 'reactor_top_bar_l';

					return $switch;
					break;

				case 'cart':
					$switch = 'reactor_minicart_l';

					return $switch;
					break;

				case 'wpml':
					$switch = 'reactor_toplang_l';

					return $switch;
					break;
				default:
					return false;
			}
		}


		function right_panel( $switch ) {
			switch ( $switch ) {
				case 'text':
					$switch = 'reactor_topbar_text_right';

					return $switch;
					break;
				case 'menu':
					$switch = 'reactor_top_bar_r';

					return $switch;
					break;
				case 'cart':
					$switch = 'reactor_minicart_r';

					return $switch;
					break;
				case 'wpml':
					$switch = 'reactor_toplang_r';

					return $switch;
					break;
				default:
					return false;
			}
		}


		$topbar_args = array(
			'reactor_topbar_social' => $reactor_topbar_social,
			'search'                => $reactor_topbar_search,
			'left_menu'             => left_panel( $left_panel ),
			'right_menu'            => right_panel( $right_panel ),
			'contained'             => reactor_option( 'top_panel_size', false )

		);
		reactor_top_bar( $topbar_args );

	}
}


add_action( 'reactor_header_before', 'reactor_do_top_bar', 1 );


function crum_mini_cart_right() {
	if ( reactor_option( 'header_cart', '' ) && class_exists( 'Woocommerce' ) ) {

		global $woocommerce; ?>

		<div id="cd-cart" class="smooth-animation">
			<a class="og-close" href="#"></a>

			<h2><?php _e( 'Cart', 'crum' ); ?></h2>

			<div id="cd-cart-inner">
				<ul class="cd-cart-items">

					<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

								$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								$thumbnail    = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								?>
								<li>
									<a href="<?php echo get_permalink( $product_id ); ?>">
										<?php echo str_replace( array(
												'http:',
												'https:'
											), '', $thumbnail ) . $product_name; ?>
									</a>
								</li>
							<?php
							}
						}
						?>

					<?php else : ?>

						<li class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>

					<?php endif; ?>

				</ul>
				<!-- end product list -->

				<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

					<div class="cd-cart-total">
						<p class="total"><strong><?php _e( 'Subtotal', 'woocommerce' ); ?>
								:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>
					</div> <!-- cd-cart-total -->
					<a href="<?php echo WC()->cart->get_checkout_url(); ?>"
					   class="checkout-btn"><?php _e( 'Checkout', 'woocommerce' ); ?></a>
					<p class="cd-go-to-cart">
						<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
					</p>

				<?php endif; ?>
			</div>
		</div>
	<?php }
}


add_action( 'reactor_header_after', 'crum_mini_cart_right', 10 );

/**
 * Site title, tagline, logo, and nav bar
 * in header.php
 *
 * @since 1.0.0
 */
function reactor_do_title_logo() {

	echo '<div class="logo  large-2 medium-2 small-12 columns">';

	reactor_do_logo();

	echo '</div>';

}


function reactor_do_logo() {

	$logo   = reactor_option( 'custom_logo_media', get_template_directory_uri() . '/library/img/logo.png' );
	$logo2x = reactor_option( 'custom_logo_retina', get_template_directory_uri() . '/library/img/logo@2x.png' );

	if ( $logo['url'] == 'h' ) {
		$logo['url'] = get_template_directory_uri() . '/library/img/logo.png';
	}
	if ( $logo2x['url'] == 'h' ) {
		$logo2x['url'] = get_template_directory_uri() . '/library/img/logo@2x.png';
	}

	?>
	<?php if ( $logo['url'] || $logo2x['url'] ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
		   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">

			<img data-interchange='[<?php echo $logo['url']; ?>, (default)], [<?php echo $logo2x['url']; ?>, (retina)]'
			     alt="" class="hideie">
			<img src="<?php echo $logo['url']; ?>" alt="" class="ie">
			<noscript>
				<img src='<?php echo $logo['url']; ?>'
				     alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
			</noscript>
		</a>
	<?php else: ?>

		<div class="title-area">
			<p class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
				   rel="home"><?php bloginfo( 'name' ); ?></a>
			</p>

			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
		</div>
	<?php endif;

}

add_action( 'reactor_header_inside', 'reactor_do_title_logo', 1 );

/**
 * Text or banner  in right of logo
 * in header.php
 *
 * @since 1.0.0
 */
function reactor_do_header_text() {

	if ( reactor_option( '', '', 'meta_header_banner_code' ) && ( reactor_option( '', '', 'meta_header_style' ) == 'header-style-2' ) ) {
		?>

		<div class="top-text <?php reactor_columns( '10' ); ?>">
			<?php echo do_shortcode( reactor_option( '', '', 'meta_header_banner_code' ) ); ?>
		</div>

	<?php } elseif ( reactor_option( 'header-top-text', '' ) && ( reactor_option( 'header-style', '' ) == 'header-style-2' ) && ( reactor_option( '', '', 'meta_header_style' ) == '' ) ) { ?>

		<div class="top-text <?php reactor_columns( '10' ); ?>">
			<?php echo do_shortcode( reactor_option( 'header-top-text', '' ) ); ?>
		</div>

	<?php
	}
}

add_action( 'reactor_header_inside', 'reactor_do_header_text', 2 );


/**
 * Nav bar and mobile nav button
 * in header.php
 *
 * @since 1.0.0
 */
function reactor_do_nav_bar() {
	if ( has_nav_menu( 'main-menu' ) ) {
		?>

		<div class="main-nav large-10 medium-10 small-12 columns smooth-animation">
			<nav id="menu" data-name="<?php _e( 'MENU', 'crum' ); ?>" role="navigation">

				<?php

				if ( reactor_option( 'header_search', '' ) || ( reactor_option( 'header_cart', '' ) && class_exists( 'Woocommerce' ) ) || reactor_option( 'header_side_menu', '' ) ) {

					$output = '<ul class="menu-additional-navigation">';
					if ( reactor_option( 'header_search', '' ) ) {
						$output .= '<li class="has-form search-form">';
						$output .= '<a href="#"><i class="crumicon-search"></i></a>';
						$output .= '<form role="search" method="get" id="menu-searchform" action="' . home_url() . '"><div class="row collapse">';
						$output .= '<div class="large-12 small-12 columns">';
						$output .= '<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search', 'crum' ) . '" />';
						$output .= '<input class="button prefix hide" type="submit" id="searchsubmit" value="" />';
						$output .= '<a class="close" href="#"><i class="crum-icon crum-close"></i></a>';
						$output .= '</div>';
						$output .= '</div></form>';
						$output .= '</li>';
					}

					if ( reactor_option( 'header_cart', '' ) && class_exists( 'Woocommerce' ) ) {
						global $woocommerce;
						$output .= '<li id="cd-cart-trigger">';
						$output .= '<a class="cd-img-replace" href="#cart"><i class="crumicon-bag"></i><span class="count">' . $woocommerce->cart->cart_contents_count . '</span></a>';
						$output .= '</li>';
					}

					if ( reactor_option( 'header_side_menu', '' ) ) {

						$output .= '<li id="cd-menu-trigger"><a href="#side-menu"><i class="crumicon-list2"></i></a></li>';
					}

					$output .= '</ul>';

					echo $output;
				}

				?>
				<?php reactor_main_menu(); ?>
			</nav>
		</div><!-- .main-nav -->

	<?php
	}
}

add_action( 'reactor_header_inside', 'reactor_do_nav_bar', 5 );


/**
 * Stunning header
 * in header.php
 *
 * @since 1.0.0
 */
function crumina_stunning_header() {
	global $crum_theme_option;

	if ( ( isset( $crum_theme_option['st_header'] ) && $crum_theme_option['st_header'] ) ) {
		if ( ! is_page_template( 'page-templates/no-stunning.php' ) ) {

			$height          = isset( $crum_theme_option['st-header-height'] ) ? $crum_theme_option['st-header-height'] : '';
			$style           = isset( $crum_theme_option['st-header-style'] ) ? $crum_theme_option['st-header-style'] : '';
			$st_header_image = isset( $crum_theme_option['st-header-bg-image'] ) ? $crum_theme_option['st-header-bg-image']['url'] : '';
			$st_header_bg    = isset( $crum_theme_option['st-header-bg-color'] ) ? $crum_theme_option['st-header-bg-color'] : '';
			$st_text_color   = isset( $crum_theme_option['st-header-text-color'] ) ? $crum_theme_option['st-header-text-color'] : '';
			$breadcrumbs     = isset( $crum_theme_option['breadcrumbs'] ) ? $crum_theme_option['breadcrumbs'] : false;

			//custom post settings
			if ( ! ( is_search() ) ) {
				$custom_st_header_image  = get_post_meta( get_the_ID(), 'single_post_header_bg', true );
				$custom_st_header_color  = get_post_meta( get_the_ID(), 'single_post_color_bg', true );
				$custom_st_header_font   = get_post_meta( get_the_ID(), 'single_post_color_font', true );
				$custom_st_header_height = get_post_meta( get_the_ID(), 'single_post_header_height', true );
				$custom_st_header_style  = get_post_meta( get_the_ID(), 'single_post_header_style', true );
			}

			//custom page settings
			if ( ! ( is_search() ) ) {
				$custom_page_st_header_image  = get_post_meta( get_the_ID(), 'single_page_header_bg', true );
				$custom_page_st_header_color  = get_post_meta( get_the_ID(), 'single_page_color_bg', true );
				$custom_page_st_header_font   = get_post_meta( get_the_ID(), 'single_page_color_font', true );
				$custom_page_st_header_height = get_post_meta( get_the_ID(), 'single_page_header_height', true );
				$custom_page_st_header_style  = get_post_meta( get_the_ID(), 'single_page_header_style', true );
			}

			if ( ! is_search() ) {
				if ( function_exists( 'is_product_category' ) && is_product_category() ) {
					$product_category = get_query_var( 'product_cat' );
					if ( isset( $product_category ) && ! ( is_wp_error( $product_category ) ) ) {
						$category               = get_term_by( 'slug', $product_category, 'product_cat' );
						$cat_id                 = $category->term_id;
						$custom_bg_img          = get_option( "taxonomy_$cat_id" );
						$custom_category_bg_img = $custom_bg_img['custom_category_bg_image'];
					}
				} else {
					$category = get_category( get_query_var( 'cat' ) );
					if ( isset( $category ) && ! ( is_wp_error( $category ) ) ) {
						$cat_id                 = $category->cat_ID;
						$custom_bg_img          = get_option( "taxonomy_$cat_id" );
						$custom_category_bg_img = $custom_bg_img['custom_category_bg_image'];
					}
				}
			}

			$add_class = $header_style = '';

			if ( ! empty ( $custom_category_bg_img ) ) {
				$header_style = 'background: url(' . $custom_category_bg_img . ');';
			} elseif ( ! empty ( $custom_st_header_image ) ) {
				$header_style = 'background: url(' . $custom_st_header_image . ');';
			} elseif ( ! empty ( $custom_st_header_color ) ) {
				$header_style = 'background-color:' . $custom_st_header_color . ';';
			} elseif ( ! empty ( $custom_page_st_header_image ) ) {
				$header_style = 'background: url(' . $custom_page_st_header_image . ');';
			} elseif ( ! empty ( $custom_page_st_header_color ) ) {
				$header_style = 'background-color:' . $custom_page_st_header_color . ';';
			} elseif ( ! empty( $st_header_image ) ) {
				$header_style = 'background: url(' . $st_header_image . ');';
			} elseif ( ! empty( $st_header_bg ) ) {
				$header_style = 'background-color:' . $st_header_bg . ';';
			}

			if ( ! empty ( $custom_st_header_font ) ) {
				$st_text_color = $custom_st_header_font;
			} elseif ( ! empty ( $custom_page_st_header_font ) ) {
				$st_text_color = $custom_page_st_header_font;
			}
			if ( $st_text_color ): $header_style .= 'color:' . $st_text_color . ';';
			$add_class = 'class="inherit-color"';
			endif;
			if ( ! empty ( $custom_st_header_height ) ) {
				$height = $custom_st_header_height;
			} elseif ( ! empty ( $custom_page_st_header_height ) ) {
				$height = $custom_page_st_header_height;
			}
			if ( ! empty ( $custom_st_header_style ) && ! ( $custom_st_header_style == '' ) ) {
				$style = $custom_st_header_style;
			} elseif ( ! empty ( $custom_page_st_header_style ) && ! ( $custom_page_st_header_style == '' ) ) {
				$style = $custom_page_st_header_style;
			}
			?>

			<div id="stunning-header" style="
			<?php
			echo $header_style;
			?> background-position:50%;background-repeat:no-repeat;background-size: cover;" <?php echo $add_class ?>>

				<div class="row">
					<div class="<?php reactor_columns( 12 ) ?>">
						<header <?php if ( $height ) { ?> style="height: <?php echo $height; ?>px;"<?php } ?>>
							<div class="st-wrap <?php echo $style ?>">
								<?php if ( is_single() && is_singular( 'post' ) ) {
									global $post;
									$category = get_the_category( $post->ID );
									echo '<div class="page-title">' . $category[0]->name;
									echo '</div>';
								} elseif ( is_tag() ) {
									echo '<span class="page-title">';
									printf( __( 'Tag: %s', 'crum' ), '</span><h1 class="page-title">' . single_tag_title( '', false ) );
									echo '</h1>';
								} elseif ( is_category() ) {
									echo '<span class="page-title">';
									printf( __( 'Category: %s', 'crum' ), '</span><h1 class="page-title">' . single_cat_title( '', false ) . '</h1>' );
								} elseif ( category_description() ) {
									echo '<span class="page-title">';
									printf( __( 'Category: %s', 'crum' ), '</span><h1 class="page-title">' . single_cat_title( '', false ) . '</h1>' );
								} elseif ( category_description() ) {
									echo '<span class="page-title">';
									printf( __( 'Tag: %s', 'crum' ), '</span><h1 class="page-title">' . single_cat_title( '', false ) );
									echo '</h1>';
								} elseif ( is_author() ) {
									echo '<span class="page-title">';
									printf( __( 'Author: %s', 'crum' ), '</span><h1 class="page-title">' . get_the_author() );
									echo '</h1>';
								} elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
									echo '<h1 class="header-title">' . get_the_title() . '</h1>';
								} elseif ( ( function_exists( 'is_woocommerce' ) ) && ( is_woocommerce() || is_page( 'store' ) || is_shop() || is_product_category() || is_product() || is_cart() || is_checkout() || is_post_type_archive( 'product' ) ) ) { ?>

									<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

								<?php } elseif ( is_archive() || ( is_post_type_archive( 'product' ) ) ) {
									if ( is_day() ) {
										echo '<h1 class="page-title">';
										printf( __( 'Daily Archives: %s', 'crum' ), '<span>' . get_the_date() . '</span>' );
										echo '</h1>';
									} elseif ( is_month() ) {
										echo '<h1 class="page-title">';
										printf( __( 'Monthly Archives: %s', 'crum' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'crum' ) ) . '</span>' );
										echo '</h1>';
									} elseif ( is_year() ) {
										echo '<h1 class="page-title">';
										printf( __( 'Yearly Archives: %s', 'crum' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'crum' ) ) . '</span>' );
										echo '</h1>';
									} elseif ( is_post_type_archive( 'product' ) ) {
										echo '<h1 class="page-title">';
										_e( 'Shop', 'crum' );
										echo '</h1>';
									} elseif ( is_tax( 'portfolio-category' ) ) {
										echo '<span class="page-title">';
										printf( __( 'Category: %s', 'crum' ), '</span> <h1 class="page-title">' . single_cat_title( '', false ) . '</h1>' );
									} elseif ( is_tax( 'portfolio-category' ) ) {
										echo '<span class="page-title">';
										printf( __( 'Category: %s', 'crum' ), '</span> <h1 class="page-title">' . single_cat_title( '', false ) . '</h1>' );
									} else {
										echo '<span class="page-title">';
										_e( 'Archives', 'crum' );
										echo '</span>';
									}

								} else {

									echo '<h1 class="page-title">' . get_the_title() . '</h1>';

								} ?>

								<?php if ( $breadcrumbs ): reactor_breadcrumbs(); endif; ?>
							</div>
						</header>
					</div>
				</div>
			</div>

		<?php
		}
	}
}

add_action( 'reactor_header_after', 'crumina_stunning_header', 1 );


/**
 * Pages without top menu
 * in header.php
 *
 * @since 1.0.0
 */

function reactor_remove_header() {
	if ( is_page_template( 'page-templates/coming-soon.php' ) || is_page_template( 'page-templates/page-blank.php' ) ):

		remove_action( 'reactor_header_before', 'reactor_do_top_bar', 1 );
		remove_action( 'reactor_header_inside', 'reactor_do_title_logo', 1 );
		remove_action( 'reactor_header_inside', 'reactor_do_nav_bar', 2 );
		remove_action( 'reactor_header_inside', 'reactor_do_mobile_nav', 3 );
		remove_action( 'reactor_header_after', 'crumina_stunning_header', 1 );

	endif;
}

add_action( 'get_header', 'reactor_remove_header' );

