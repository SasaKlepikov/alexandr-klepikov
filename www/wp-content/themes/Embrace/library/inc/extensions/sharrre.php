<?php
header('content-type: application/json');
//Sharrre by Julien Hany
$json = array('url'=>'','count'=>0);
$json['url'] = $_GET['url'];
$url = urlencode($_GET['url']);
$type = urlencode($_GET['type']);

if(filter_var($_GET['url'], FILTER_VALIDATE_URL)){
	if($type == 'googlePlus'){  //source http://www.helmutgranda.com/2011/11/01/get-a-url-google-count-via-php/
		$contents = parse('https://plusone.google.com/u/0/_/+1/fastbutton?url=' . $url . '&count=true');

		preg_match( '/window\.__SSR = {c: ([\d]+)/', $contents, $matches );

		if(isset($matches[0])){
			$json['count'] = (int)str_replace('window.__SSR = {c: ', '', $matches[0]);
		}
	}
	else if($type == 'stumbleupon'){
		$content = parse("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url");

		$result = json_decode($content);
		if (isset($result->result->views))
		{
			$json['count'] = $result->result->views;
		}

	}
}
echo str_replace('\\/','/',json_encode($json));

function parse($encUrl){
	$options = array(
		'timeout'     => 10,
		'redirection' => 3,
		'user-agent'  => 'sharrre',
		'headers'     => false,
		'cookies'     => false,
		'sslverify'   => false,
	);

	$response = wp_remote_get( $encUrl, $options );

	if ( is_wp_error( $response ) ) {
		$content = '';
	} else {
		$content = $response['body'];
	}

	return $content;
}
