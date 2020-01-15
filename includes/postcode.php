<?php
/**
 * Emerdency - postcode.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 27/03/2018
 * Time: 21:09
 * Description :
 */

// Get Geocodes via Google Geocode API from Postcode
function getGeocodes($postcode){
	// Strip spaces in Postcode (for Google API)
	$postcode = str_replace(' ', '', $postcode);

	$apiKey = "AIzaSyDq-sf-w8fuJlKWUNFVAMG2dG1KbMdbFBM";
	$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$postcode}&key=".$apiKey;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$geoloc = json_decode(curl_exec($ch), true);

	if ($geoloc['results'][0]){
		$lat = $geoloc['results'][0]['geometry']['location']['lat'];
		$lng = $geoloc['results'][0]['geometry']['location']['lng'];

		$geocodes = [$lat,$lng];
	} else {
		$geocodes = "0";
	}

	return $geocodes;
}

/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
function getDistanceBetweenTwoPoints($point1 , $point2){
	// array of lat-long i.e  $point1 = [lat,long]
	$earthRadius = 3959;  // earth radius in km
	$point1Lat = $point1[0];
	$point2Lat =$point2[0];
	$deltaLat = deg2rad($point2Lat - $point1Lat);
	$point1Long =$point1[1];
	$point2Long =$point2[1];
	$deltaLong = deg2rad($point2Long - $point1Long);
	$a = sin($deltaLat/2) * sin($deltaLat/2) + cos(deg2rad($point1Lat)) * cos(deg2rad($point2Lat)) * sin($deltaLong/2) * sin($deltaLong/2);
	$c = 2 * atan2(sqrt($a), sqrt(1-$a));

	$distance = $earthRadius * $c;
	return $distance;    // in km
}
