<?php
$output = $title = $interval = $el_class = $collapsible = $active_tab = $module_animation = '';
//
extract(shortcode_atts(array(
    'title' => '',
    'interval' => 0,
    'el_class' => '',
    'collapsible' => 'no',
    'active_tab' => '1',
	'module_animation' => '',
), $atts));

$el_class = $this->getExtraClass($el_class);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_content_element '.$el_class, $this->settings['base']);
$css_class .= $collapsible !='yes' ? ' open-first ' : '';

$animate = $animation_data = '';

if ( ! ($module_animation == '')){
	$animate = ' cr-animate-gen';
	$animation_data = 'data-animate-type = "'.$module_animation.'" ';
}

$css_class .= $animate;

$output .= "\n\t".'<dl class="accordion '.$css_class.'" data-accordion '.$animation_data.'>';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t".'</dl> '.$this->endBlockComment('.accordion');

echo $output;