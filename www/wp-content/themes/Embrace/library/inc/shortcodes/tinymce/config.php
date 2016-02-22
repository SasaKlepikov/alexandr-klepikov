<?php
/**
 * Reactor Shortcodes Config
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @author ThemeZilla (@themezilla / themezilla.com)
 * @since 1.0.0
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Selection Config
/*-----------------------------------------------------------------------------------*/

$reactor_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => ''
);


/**
 * Alert Config
 */
$reactor_shortcodes['alert'] = array(
	'no_preview' => true,
	'params'     => array(
		'content' => array(
			'std'   => __('Alert Text', 'crum'),
			'type'  => 'text',
			'label' => __('Alert\'s Text', 'crum'),
			'desc'  => __('Add the alert\'s text', 'crum'),
		),
		'type' => array(
			'type'    => 'select',
			'label'   => __('Alert Style', 'crum'),
			'desc'    => __('Select the alert\'s style, ie the alert\'s colour', 'crum'),
			'options' => array(
				'secondary' => __('Standard', 'crum'),
				'success'   => __('Success', 'crum'),
				'alert'     => __('Alert', 'crum'),
				'warning' 	=> __('Warning', 'crum'),
			)
		),
		'shape' => array(
			'type'    => 'select',
			'label'   => __('Alert Type', 'crum'),
			'desc'    => __('Select the alert\'s type', 'crum'),
			'options' => array(
				''       => __('Square', 'crum'),
				'radius' => __('Radius', 'crum'),
				'round'  => __('Round', 'crum'),
			)
		),
		'close' => array(
			'type'    => 'select',
			'label'   => __('Closing X', 'crum'),
			'desc'    => __('Display a X on the alert to close it', 'crum'),
			'options' => array(
				'true'  => __('True', 'crum'),
				'false' => __('False', 'crum'),
			)
		)
	),
	'shortcode'   => '[alert shape="{{shape}}" type="{{type}}" close="{{close}}"] {{content}} [/alert]',
	'popup_title' => __('Insert Alert Shortcode', 'crum')
);

/**
 * Button Config
 */
$reactor_shortcodes['button'] = array(
	'no_preview' => false,
	'params'     => array(
		'content' => array(
			'std'   => __('Button Text', 'crum'),
			'type'  => 'text',
			'label' => __('Button\'s Text', 'crum'),
			'desc'  => __('Add the button\'s text', 'crum'),
		),
		'url' => array(
			'std'   => '',
			'type'  => 'text',
			'label' => __('Button URL', 'crum'),
			'desc'  => __('Add the button\'s url eg http://example.com', 'crum')
		),
		'size' => array(
			'type'    => 'select',
			'label'   => __('Button Size', 'crum'),
			'desc'    => __('Select the button\'s size', 'crum'),
			'options' => array(
				''       => __('Medium', 'crum'),
				'tiny'   => __('Tiny', 'crum'),
				'small'  => __('Small', 'crum'),
				'large'  => __('Large', 'crum'),
			)
		),
		'shape' => array(
			'type'    => 'select',
			'label'   => __('Button Type', 'crum'),
			'desc'    => __('Select the button\'s type', 'crum'),
			'options' => array(
				''       => __('Square', 'crum'),
				'radius' => __('Radius', 'crum'),
				'round'  => __('Round', 'crum'),
			)
		),
		'expand' => array(
			'type'    => 'select',
			'label'   => __('Expand', 'crum'),
			'desc'    => __('Expands the button to full width', 'crum'),
			'options' => array(
				'' 		=> __('Default', 'crum'),
				'true'  => __('Expand', 'crum'),
			)
		)
	),
	'size' => '',
	'style' => '',

	'shortcode' => '[button link="{{url}}" size="{{size}}" style="{{shape}}" full_width = "{{expand}}"]{{content}}[/button]',
	'popup_title' => __('Insert Button Shortcode', 'crum')
);

/**
 * Columns Config
 */
$reactor_shortcodes['columns'] = array(
	'params'      => array(),
	'shortcode'   => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', 'crum'),
	'no_preview'  => true,
	
	'child_shortcode' => array(
		'params' => array(
			'first_last' => array(
				'type'    => 'select',
				'label'   => __('First or Last', 'crum'),
				'desc'    => __('Select if this column is the first or last in the row', 'crum'),
				'options' => array(
					''      => '',
					'first' => __('First', 'crum'),
					'last'  => __('Last', 'crum'),
				)
			),
			'large' => array(
				'type'    => 'select',
				'label'   => __('Large Grid', 'crum'),
				'desc'    => __('Select the number of columns for the large screen grid', 'crum'),
				'options' => array(
					'12' => '12',
					'11' => '11',
					'10' => '10',
					'9'  => '9',
					'8'  => '8',
					'7'  => '7',
					'6'  => '6',
					'5'  => '5',
					'4'  => '4',
					'3'  => '3',
					'2'  => '2',
					'1'  => '1',
				)
			),
			'small' => array(
				'type'    => 'select',
				'label'   => __('Small Grid', 'crum'),
				'desc'    => __('Select the number of columns for the small screen grid', 'crum'),
				'options' => array(
					'12' => '12',
					'11' => '11',
					'10' => '10',
					'9'  => '9',
					'8'  => '8',
					'7'  => '7',
					'6'  => '6',
					'5'  => '5',
					'4'  => '4',
					'3'  => '3',
					'2'  => '2',
					'1'  => '1',
				)
			),
			'content' => array(
				'std'   => '',
				'type'  => 'textarea',
				'label' => __('Column Content', 'crum'),
				'desc'  => __('Add the column content.', 'crum'),
			)
		),
		'shortcode'    => '[column large="{{large}}" small="{{small}}" first_last="{{first_last}}"] {{content}} [/column] ',
		'clone_button' => __('Add Column', 'crum')
	)
);

/**
 * Flex Video Config
 */
$reactor_shortcodes['flex_video'] = array(
	'no_preview' => true,
	'params'     => array(
		'widescreen' => array(
			'type'  => 'select',
			'label' => __('Widescreen', 'crum'),
			'desc'  => __('Select if the video widescreen', 'crum'),
			'options' => array(
				'true'  => __('True', 'crum'),
				'false' => __('False', 'crum'),
			)
		),
		'vimeo' => array(
			'type'  => 'select',
			'label' => __('Vimeo', 'crum'),
			'desc'  => __('Select if the video is vimeo to remove padding', 'crum'),
			'options' => array(
				'false' => __('False', 'crum'),
				'true'  => __('True', 'crum'),
			)
		),
		'content' => array(
			'std'   => '',
			'type'  => 'textarea',
			'label' => __('Video Embed Code', 'crum'),
			'desc'  => __('Enter the code to embed the video', 'crum'),
		)
	),
	'shortcode'   => '[flex_video widescreen="{{widescreen}}" vimeo="{{vimeo}}"] {{content}} [/flex_video]',
	'popup_title' => __('Insert Flex Video Shortcode', 'crum')
);

/**
 * Panel Config
 */
$reactor_shortcodes['panel'] = array(
	'no_preview' => true,
	'params'     => array(
		'callout'   => array(
			'type'  => 'select',
			'label' => __('Callout Style', 'crum'),
			'desc'  => __('Callout style is a brighter panel', 'crum'),
			'options' => array(
				'false' => __('False', 'crum'),
				'true'  => __('True', 'crum'),
			)
		),
		'shape' => array(
			'type'  => 'select',
			'label' => __('Label Type', 'crum'),
			'desc'  => __('Select the button\'s type', 'crum'),
			'options' => array(
				''       => __('Square', 'crum'),
				'radius' => __('Radius', 'crum'),
			)
		),
		'content' => array(
			'std'   => __('Panel Text', 'crum'),
			'type'  => 'textarea',
			'label' => __('Panel\'s Text', 'crum'),
			'desc'  => __('Add the panel\'s text', 'crum'),
		)
	),
	'shortcode' => '[panel shape="{{shape}}" callout="{{callout}}"] {{content}} [/panel]',
	'popup_title' => __('Insert Panel Shortcode', 'crum')
);

/**
 * Dropcaps Config
 */
$reactor_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'params'     => array(
		'style'   => array(
			'type'  => 'select',
			'label' => __('Dropcap Style', 'crum'),
			'desc'  => __('Styling of first letter in text', 'crum'),
			'options' => array(
				'' 					=> __('None', 'crum'),
				'dropcap-simple-1'  => __('Simple 1', 'crum'),
				'dropcap-simple-2'  => __('Simple 2', 'crum'),
				'dropcap-square-1'  => __('Square 1', 'crum'),
				'dropcap-square-2'  => __('Square 2', 'crum'),
				'dropcap-round-1'  	=> __('Rounded 1', 'crum'),
				'dropcap-round-2'  	=> __('Rounded 2', 'crum'),
			)
		),
		'content' => array(
			'std'   => __('Content', 'crum'),
			'type'  => 'textarea',
			'label' => __('Content', 'crum'),
			'desc'  => __('Add the content. Will accept HTML', 'crum'),
		),
	),

	'shortcode' => '[dropcap style="{{style}}" ] {{content}} [/dropcap]',
	'popup_title' => __('Insert Dropcap Shortcode', 'crum')
);


/**
 * Dropcaps Config
 */
$reactor_shortcodes['lists'] = array(
	'no_preview' => true,
	'params'     => array(
		'callout'   => array(
			'type'  => 'select',
			'label' => __('Lists Style', 'crum'),
			'desc'  => __('Styling of non numbered lists', 'crum'),
			'options' => array(
				'false' => __('None', 'crum'),
				'lists-style-1'  => __('Style 1', 'crum'),
				'lists-style-2'  => __('Style 2', 'crum'),
				'lists-style-3'  => __('Style 3', 'crum')
			),
			'content' => array(
				'std'   => __('Content', 'crum'),
				'type'  => 'textarea',
				'label' => __('Content', 'crum'),
				'desc'  => __('Add the content. Will accept HTML', 'crum'),
			),
		)
	),

	'shortcode' => '[style_list style="{{style}}" ] {{content}} [/style_list]',
	'popup_title' => __('Insert Styled Lists Shortcode', 'crum')
);

/**
 * Reveal Modal Config
 */
$reactor_shortcodes['reveal_modal'] = array(
	'no_preview' => true,
	'params' => array(
		'text' => array(
			'type'  => 'text',
			'label' => __('Open Modal Text', 'crum'),
			'desc'  => __('Add the link that will open the modal window', 'crum'),
			'std'   => __('Click here', 'crum'),
		),
		'size' => array(
			'type'    => 'select',
			'label'   => __('Modal Size', 'crum'),
			'desc'    => __('Select the size of the modal window', 'crum'),
			'options' => array(
				''       => __('Medium', 'crum'),
				'tiny'   => __('Tiny', 'crum'),
				'small'  => __('Small', 'crum'),
				'Large'  => __('Large', 'crum'),
				'xlarge' => __('X-Large', 'crum'),
			)
		),
		'button' => array(
			'type'  => 'select',
			'label' => __('Button Link', 'crum'),
			'desc'  => __('Select if the link that opens the modal is a button', 'crum'),
			'options' => array(
				'false' => __('False', 'crum'),
				'true'  => __('True', 'crum'),
			)
		),
		'content' => array(
			'std'   => __('Content', 'crum'),
			'type'  => 'textarea',
			'label' => __('Modal Content', 'crum'),
			'desc'  => __('Add the content for the modal. Will accept HTML', 'crum'),
		),
		
	),
	'shortcode'   => '[reveal_modal text="{{text}}" size="{{size}}" button="{{button}}"] {{content}} [/reveal_modal]',
	'popup_title' => __('Insert Reveal Modal Shortcode', 'crum')
);

/**
 * Tooltip Config
 */
$reactor_shortcodes['tooltip'] = array(
	'no_preview' => true,
	'params' => array(
		'text' => array(
			'type'  => 'text',
			'label' => __('Tip Text', 'crum'),
			'desc'  => __('Add the text that will be in the tooltip', 'crum'),
			'std'   => __('Add tooltip text here', 'crum'),
		),
		'position' => array(
			'type'    => 'select',
			'label'   => __('Tooltip Position', 'crum'),
			'desc'    => __('Select where the tooltip should be displayed', 'crum'),
			'options' => array(
				''      => __('Bottom', 'crum'),
				'top'   => __('Top', 'crum'),
				'right' => __('Right', 'crum'),
				'left'  => __('Left', 'crum'),
			)
		),
		'width' => array(
			'type'  => 'text',
			'label' => __('Tooltip Width', 'crum'),
			'desc'  => __('Add a specific width for the tip. Only a number.', 'crum'),
		),
		'content' => array(
			'std'   => __('Content', 'crum'),
			'type'  => 'text',
			'label' => __('Modal Content', 'crum'),
			'desc'  => __('Add the content for the modal. Will accept HTML', 'crum'),
		),
		
	),
	'shortcode'   => '[tooltip text="{{text}}" position="{{position}}" width="{{width}}"] {{content}} [/tooltip]',
	'popup_title' => __('Insert a Tooltip Shortcode', 'crum')
);

/**
 * SignUp Config
 */
$reactor_shortcodes['sign_in_form'] = array(
	'no_preview' => true,
	'params' => array(
		'redirect' => array(
			'type'  => 'text',
			'label' => __( 'Redirect address', 'crum' ),
			'desc'  => __( 'Type page to redirect user after login', 'crum' ),
		),
	),
	'shortcode'   => '[sign_in_form redirect="{{redirect}}"][/sign_in_form]',
	'popup_title' => __('Insert a SignIn form Shortcode', 'crum')
);
