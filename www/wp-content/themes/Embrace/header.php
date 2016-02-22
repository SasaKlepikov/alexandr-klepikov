<!DOCTYPE html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if ( IE 7 )&!( IEMobile )]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if ( IE 8 )&!( IEMobile )]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if ( IE 9 )]><html <?php language_attributes(); ?> class="ie"><![endif]-->

<head>
	<?php

	$favicon_ico = reactor_option('custom_favicon');

	if ( isset($favicon_ico['url']) && !($favicon_ico['url'] == '') ) {
		echo '<link rel="icon" type="image/x-icon" href="'.$favicon_ico['url'].'">';
	}?>
    <?php reactor_head(); ?>
    <?php wp_head(); ?>

</head>
<?php
$responsive_mode = reactor_option('responsive_mode');

if ( $responsive_mode == '0' ) {
    $responsive_off = 'style="min-width:1200px"';
    $no_responsive = 'no-responsive';
}else{
    $responsive_off = '';
    $no_responsive = '';
}

$has_stunning = reactor_option('st_header');

if ($has_stunning == '0'){
    $no_stunning_class = ' no-stunning-header';
}else{
    $no_stunning_class = '';
}

$boxed_body = reactor_option( 'switch-boxed', '' );
$meta_boxed_body = reactor_option('','','_page_boxed_layout');
if(isset($meta_boxed_body) && !($meta_boxed_body == 'default') && !($meta_boxed_body == '')){
	if ( $meta_boxed_body == 'on' ) {
		$boxed_body = '1';
	} elseif($meta_boxed_body == 'off') {
		$boxed_body = '0';
	}
}
if(isset($boxed_body) && ($boxed_body == '1')){
	$boxed_class = 'boxed';
}else{
	$boxed_class = '';
}

?>
<body <?php body_class($no_responsive.$no_stunning_class); ?><?php echo $responsive_off;?>>

	<?php reactor_body_inside(); ?>

	<div id="main-wrapper" class="hfeed site <?php echo $boxed_class; ?>">

        <?php reactor_header_before(); ?>

		<?php
		$custom_header_color = reactor_option('','','meta_header_color_bg');
		$custom_header_opacity = reactor_option('','','meta_header_opacity_bg');
		$custom_header_font_color = reactor_option('','','meta_header_color_font');
		$custom_header_template = reactor_option('','','meta_header_style');
		$custom_header_style = 'style="';

		$opacity = '1';

		if (!($custom_header_opacity == '')){
			if ($custom_header_opacity >= 100){
				$custom_header_opacity = 1;
			}elseif($custom_header_opacity <= 0){
				$custom_header_opacity = 0;
			}elseif(($custom_header_opacity < 10) && ($custom_header_opacity > 0 ) ){
				$custom_header_opacity = '0.0'.$custom_header_opacity;
			}else{
				$custom_header_opacity = '0.'.$custom_header_opacity;
			}
			$opacity = $custom_header_opacity;
		}

		if (isset($custom_header_color) && !($custom_header_color == '') && !($custom_header_template == '')) {
			$custom_header_style .= 'background-color:'.ultimate_hex2rgb($custom_header_color,$opacity).';';
		}

		if (isset($custom_header_font_color) && !($custom_header_font_color == '')){
			$custom_header_style .= 'color:'.$custom_header_font_color.';';
		}

		$custom_header_style .= '"';
		?>

        <div id="top-header">
            <header id="header" class="site-header  smooth-animation" role="banner" <?php echo $custom_header_style;?>>
                <div class="header-inside">
                    <div class="row <?php if (!reactor_option('header_size', '')): echo 'full-width-row'; endif; ?>">

                        <?php reactor_header_inside(); ?>

                    </div>
                    <!-- .row -->
                </div>
            </header>
        </div>
        <!-- #header -->

        <?php reactor_header_after(); ?>