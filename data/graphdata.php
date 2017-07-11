<?php
header('Content-Type: application/json');
$assoc = [
	'audio' 	   => 'https://mainproject-c2cfb.firebaseio.com/audio.json',
	'heartBeat'    => 'https://mainproject-c2cfb.firebaseio.com/heartBeat.json',
	'humidity'	   => 'https://mainproject-c2cfb.firebaseio.com/humidity.json',
	'lightIntensity'  => 'https://mainproject-c2cfb.firebaseio.com/lightIntensity.json',
    'temperature'  => 'https://mainproject-c2cfb.firebaseio.com/temperature.json',
];

foreach ($assoc as $sensortype => $url) {
	$data[$sensortype] = minify(array_values(json_decode(file_get_contents($url), 1)));
}

echo json_encode($data, JSON_PRETTY_PRINT);

	

function minify($json_values)
{
    $result = array();

    $last_val = null;
    foreach ($json_values as $index => $current_value) {
        if ($current_value !== $last_val) {
            $result[$index] = $current_value;
        }

        $last_val = $current_value;
    }

    return $result;
}