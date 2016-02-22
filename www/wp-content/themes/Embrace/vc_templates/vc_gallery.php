<?php
$output = $title = $type = $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = $interval = '';
extract(shortcode_atts(array(
			'title' => '',
			'type' => 'flexslider',
			'onclick' => 'link_image',
			'custom_links' => '',
			'custom_links_target' => '',
			'img_size' => 'full',
			'images' => '',
			'el_class' => '',
			'interval' => '5',
			'module_animation' => '',
		), $atts));
$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

$el_class = $this->getExtraClass($el_class);


if ( $onclick == 'link_image' ) {
	$pretty_rel_random = ' magnific-gallery-several';
} else {
	$pretty_rel_random = '';
}
$uniue_id = uniqid('_slider');
$type = ' vc-galley-slider'.$uniue_id.'';

	$el_start = '<div>';
	$el_end = '</div>';
	$slides_wrap_start = '<div class="slides'.$pretty_rel_random.''.$type.'">';
	$slides_wrap_end = '</div>';


$flex_fx = '';

	$flex_fx = ' data-flex_fx="fade"';
$post_thumbnail = '';


if ( $images == '' ) $images = '-1,-2,-3';

if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }
$images = explode( ',', $images);
$i = -1;

foreach ( $images as $attach_id ) {
	$i++;
	if ($attach_id > 0) {
		$post_thumbnail = wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ));
	}

	$thumbnail = $post_thumbnail['thumbnail'];
	$p_img_large = $post_thumbnail['p_img_large'];
	$link_start = $link_end = '';

	if ( $onclick == 'link_image' ) {
		$link_start = '<a href="'.$p_img_large[0].'">';
		$link_end = '</a>';
	}
	else if ( $onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
		$link_start = '<a href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '>';
		$link_end = '</a>';
	}

	$gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;

}

$animate = $animation_data = '';

if ( ! ($module_animation == '')){
	$animate = ' cr-animate-gen';
	$animation_data = 'data-animate-type = "'.$module_animation.'" ';
}

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery '.$el_class.' clearfix', $this->settings['base']);
$css_class .= $animate;
$output .= "\n\t".'<div class="'.$css_class.'" '.$animation_data.'>';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= '<div class="wpb_gallery_slides">'.$slides_wrap_start.$gal_images.$slides_wrap_end.'</div>';
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_gallery');
$output .= '<script type="text/javascript">';
$output .= 'jQuery(document).ready(function () {';
$output .= 'jQuery(\'.vc-galley-slider'.$uniue_id.'\').slick({';
if ( !($interval == '0') ) {
	$output .= 'autoplay: true,';
} else {
	$output .= 'autoplay: false,';
}
$output .= 'dots: false,';
$output .= 'infinite: true,';
$output .= 'speed: 500,';
if ( !($interval == '0') ) {
	$output .= 'autoplaySpeed:'.$interval.'000';
}
$output .= '});';
$output .= '});';
$output .= '</script>';

echo $output;