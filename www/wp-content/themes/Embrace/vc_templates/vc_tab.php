<?php
$output = $title = $tab_id = '';
$atribs = $this->predefined_atts;
$atribs['icon'] = '';

extract(shortcode_atts($atribs, $atts));

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'content', $this->settings['base']);
$output .= "\n\t\t\t" . '<div id="tab-'. (empty($tab_id) ? sanitize_title( $title ) : $tab_id) .'" class="'.$css_class.'">';
$output .= ($content=='' || $content==' ') ? '<p>' . __("Empty section. Edit page to add content here.", "crum") . '</p>' : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_tab');

echo $output;