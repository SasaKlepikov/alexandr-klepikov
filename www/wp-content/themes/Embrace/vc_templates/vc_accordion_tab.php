<?php
$output = $title = $icon = '';

extract(shortcode_atts(array(
	'title' => __("Section", "crum"),
	'icon'	=> '',
), $atts));

$output .= '<dd>';
$output .= "\n\t\t\t\t" . '<i class="'.$icon.'"></i><a href="#'.sanitize_title($title).'">'.$title.' <i class="crumicon crumicon-plus"></i><i class="crumicon crumicon-minus"></i></a>';
$output .= "\n\t\t\t\t" . '<div class="content clearfix">';
$output .= ($content=='' || $content==' ') ? '<p>'. __("Empty section. Edit page to add content here.", "crum") .'</p>' : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.content') . "\n";
$output .= '</dd>';
echo $output;
