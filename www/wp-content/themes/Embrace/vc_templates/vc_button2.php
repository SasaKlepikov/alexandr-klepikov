<?php
$icon_type = $icon = $title = $link = $color = $button_bg_color = $button_text_color = $nofollow_enable =  $style = $module_animation = '';
extract( shortcode_atts( array(
	'link' => '',
	'title' => __( 'Text on the button', "js_composer" ),
	'color' => '',
	'button_bg_color' => '',
	'button_text_color' => '',
    'icon_type' => '',
	'icon' => '',
	'size' => '',
	'style' => '',
	'nofollow_enable' => '',
	'el_class' => '',
	'module_animation' => '',
), $atts ) );

$class = 'vc_btn';
//parse link
$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

if (isset($button_text_color) && !($button_text_color == '') && !($button_text_color == '#FFF')){
	$text_color = $button_text_color;
}else{
	$text_color = '#FFF';
}

if ($nofollow_enable == 'enable'){
	$no_follow = 'rel="nofollow"';
}else{
	$no_follow = '';
}

$custom_style = '';

if ( !($color == 'custom') ) {
	if ( $color == 'main_site_color' ) {
		if ( !(reactor_option('main_site_color') == '' )){
			$main_site_color = reactor_option('main_site_color');
		}else{
			$main_site_color = '#6ABCE3';
		}
		$class .= ' vc_btn_custom';
		if ( $style == 'outlined' || $style == 'square_outlined') {
			$custom_style = 'style="color:' . $main_site_color . '; border-color:' . $main_site_color . '"';
		} else {
			$custom_style = 'style="color:#FFF; background-color:' . $main_site_color . '"';
		}
	} else {
		$class .= ( $color != '' ) ? ' vc_btn_' . $color : '';
	}
	$class .= ( $size != '' ) ? ' vc_btn_' . $size : '';
	$class .= ( $style != '' ) ? ' vc_btn_' . $style : '';
} else {
	$class .= ' vc_btn_custom';
	$class .= ( $size != '' ) ? ' vc_btn_' . $size : '';
	$class .= ( $style != '' ) ? ' vc_btn_' . $style : '';
	if ( $style == 'outlined' || $style == 'square_outlined') {
		$custom_style = 'style="color:' . $text_color . '; border-color:' . $button_bg_color . '"';
	} else {
		$custom_style = 'style="color:'.$text_color.'; background-color:' . $button_bg_color . '"';
	}
}
$el_class = $this->getExtraClass( $el_class );

$animate = $animation_data = '';

if ( ! ($module_animation == '')){
	$animate = ' cr-animate-gen';
	$animation_data = 'data-animate-type = "'.$module_animation.'" ';
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . $class . $el_class, $this->settings['base'], $atts );
$css_class .= $animate;
if ($icon_type !=''){

    $icon = '<i class="'.$icon.' '.$icon_type.'"></i>';
}
?>
<a class="<?php echo esc_attr( trim( $css_class ) ); ?>" href="<?php echo $a_href; ?> "
   title="<?php echo esc_attr( $a_title ); ?>" target="<?php echo $a_target; ?>" <?php echo $animation_data;?> <?php echo $custom_style;?> <?php echo $no_follow;?>>
	<?php if($icon_type == 'icon_left') {
    if($icon) echo  $icon; echo $title;
    }elseif ($icon_type == 'icon_right') {
    echo $title; if($icon) echo  $icon; }
    else {
        echo $title;
    }
    ?>
</a>
<?php echo $this->endBlockComment( 'vc_button' ) . "\n";