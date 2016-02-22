<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $image
 * @var $img_size
 * @var $img_link_large
 * @var $link
 * @var $img_link_target
 * @var $alignment
 * @var $el_class
 * @var $css_animation
 * @var $style
 * @var $border_color
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Single_image
 */
$output = '';
$exact_size = false;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$animate = $animation_data = '';

if ( ! ($module_animation == '')){
	$animate = ' cr-animate-gen';
	$animation_data = 'data-animate-item = ".vc_single_image-img" data-animate-type = "'.$module_animation.'" ';
}

$style = ( '' !== $style ) ? $style : '';
$border_color = ( $border_color != '' ) ? ' vc_box_border_' . $border_color : '';
$img_id = preg_replace( '/[^\d]/', '', $image );
// Set rectangular.
if ( preg_match( '/_circle_2$/', $style ) ) {
	$style = preg_replace( '/_circle_2$/', '_circle', $style );
	$img_size = $this->getImageSquereSize( $img_id, $img_size );
}
$img = wpb_getImageBySize( array(
	'attach_id' => $img_id,
	'thumb_size' => $img_size,
	'class' => 'vc_single_image-img'
) );

if ( ! $img ) {
	$img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . vc_asset_url( 'vc/no_image.png' ) . '" '.$animation_data.' />';
}//' <small>'.__('This is image placeholder, edit your page to replace it.', 'js_composer').'</small>';
$el_class = $this->getExtraClass( $el_class );

$a_class = '';
if ( '' !== $el_class ) {
	$tmp_class = explode( ' ', strtolower( $el_class ) );
	$tmp_class = str_replace( '.', '', $tmp_class );
	if ( in_array( 'prettyphoto', $tmp_class ) ) {

		$a_class = ' class="zoom"';
		$el_class = str_ireplace( ' zoom', '', $el_class );
	}
}

$link_to = '';
if ( $img_link_large ) {
	$link_to = wp_get_attachment_image_src( $img_id, 'large' );
	$link_to = $link_to[0];
} else if ( strlen( $link ) > 0 ) {
	$link_to = $link;
} else if ( ! empty( $atts['img_link'] ) ) {
	// backward compatibility. will be removed in 4.7+
	$link_to = $atts['img_link'];
	if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link_to ) ) {
		$link_to = 'http://' . $link_to;
	}
}
//to disable relative links uncomment this..

$img_output = ( 'vc_box_shadow_3d' === $style ) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' : $img['thumbnail'];
$image_string = ! empty( $link_to ) ? '<a' . $a_class . ' href="' . $link_to . '"' . ' target="' . $img_link_target . '"' . '><div class="vc_single_image-wrapper ' . $style . ' ' . $border_color . ' '.$animate.' " '.$animation_data.'>' . $img_output . '</div></a>' : '<div class="vc_single_image-wrapper ' . $style . ' ' . $border_color . ''.$animate.' " '.$animation_data.'>' . $img_output . '</div>';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image wpb_content_element' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
if ( isset($css_animation) && !empty($css_animation) ) {
	$css_class .= $this->getCSSAnimation( $css_animation );
}

$css_class .= ' vc_align_' . $alignment;

$output .= "\n\t" . '<div class="' . esc_attr( $css_class ) . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper ">';
if ( isset($title) && !empty($title) ) {
	$output .= "\n\t\t\t" . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) );
}
$output .= "\n\t\t\t" . $image_string;
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( $this->getShortcode() );

echo $output;