<?php

require_once("db_connect.php");
include_once("postcode.php");

function testInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function generateToken() {
	//Generate a random string.
	$token = openssl_random_pseudo_bytes(10);
 
	//Convert the binary data into hexadecimal representation.
	$token = bin2hex($token);
	
	return $token;
}
//UK postcode validation check
function isPostcodeValid($postcode)
{
    //remove all whitespace
    $postcode = preg_replace('/\s/', '', $postcode);
 
    //make uppercase
    $postcode = strtoupper($postcode);
 
    if(preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/",$postcode)
        || preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/",$postcode)
        || preg_match("/^GIR0[A-Z]{2}$/",$postcode))
    {
        return true;
    }
    else {
        return false;
    }
}

function displayResults($result){
	//foreach 
}
function  outputResults($result){
    if ($result->num_rows > 0) {
        //echo "<table><tr><th>ID</th><th>Name</th></tr>";	
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "<tr><td>".$row["id"]."</td><td>".$row["time"]."</td></tr>";
    }
    //echo "</table>";
    } else {
        //echo "0 results";
    }    
};

// Get data from form
function getFormData(){

}

// Input parameters and search DB for appointments in future
function getAppointments($disAccess){
	//echo "<br>Get executed";
    $db = dbConnect();
	
	// If disability access required
	if ($disAccess == 1){
 		// Find appointments in future based on time and disability access
   	 	$sql = "SELECT Appointment.id, Appointment.start_date, Dentist.id AS 'dentist_id',  Dentist.rating, Practice.lat, Practice.lng, Practice.city AS 'practice_city'
			  	FROM Appointment 
					INNER JOIN PracticeDentist
						ON Appointment.practiceDentist_id = PracticeDentist.id
					INNER JOIN Practice
						ON PracticeDentist.practice_id = Practice.id 
					INNER JOIN Dentist
						ON PracticeDentist.dentist_id = Dentist.id	
				WHERE Appointment.dis_access = 1 AND Appointment.start_date > DATE_ADD(NOW(), INTERVAL 45 MINUTE) AND Appointment.timestamp <= NOW() AND Appointment.type = 0 AND (Appointment.status = 0 OR Appointment.status = 1)";
	// if disability access not required
	} else { 
		// Find appointments in future based on time and no disability access
   	 	$sql = "SELECT Appointment.id, Appointment.start_date, Dentist.id AS 'dentist_id', Dentist.rating, Practice.lat, Practice.lng, Practice.city AS 'practice_city'
			  	FROM Appointment 
					INNER JOIN PracticeDentist
						ON Appointment.practiceDentist_id = PracticeDentist.id
					INNER JOIN Practice
						ON PracticeDentist.practice_id = Practice.id 
					INNER JOIN Dentist
						ON PracticeDentist.dentist_id = Dentist.id
				WHERE (Appointment.status = 0 OR Appointment.status = 1) AND Appointment.start_date > DATE_ADD(NOW(), INTERVAL 45 MINUTE) AND Appointment.timestamp <= NOW() AND Appointment.type = 0";
	}
    // Execute Query
    $result = $db->query($sql);
    // Return Result Array  
    return $result;
}

// NEEDS WORK - TEMP ONLY -- Currently generates random number between 1 and max distance (number is divided by random number and rounded to 2 decimal places - give variation)
function TempCalculateDistances($postcode1, $postcode2,$maxDistance){
	$rand = rand(1,$maxDistance);
	$distance = rand(1,$maxDistance);
	$distance = $distance / $rand;
	$distance = round($distance, 2);
	return $distance;
};

function compareDistances($result, $postcode1, $uDistance){
	$appts = array();

	// Get Geocodes from Google API
	$userGeocodes = getGeocodes($postcode1);

	// if valid lat & long is found
	if ($userGeocodes) {
		if ( $result->num_rows > 0 ) {
			// Go through each row
			foreach ( $result as $row ) {
				// Initialise variable with value
				$id               = $row["id"];
				$dentist_id      = $row["dentist_id"];
				// Added NW
				$practice_city      = $row["practice_city"];
				// EOF Added NW
				$time             = $row["start_date"];
				$rating           = $row["rating"];
				$lat              = $row["lat"];
				$lng              = $row["lng"];
				$practiceGeocodes = [ $lat, $lng ];
				// Calculate distances between practice and patient postcode
				$distance = getDistanceBetweenTwoPoints( $userGeocodes, $practiceGeocodes );
				$distance = round( $distance, 2 );
				//echo $distance;
				// If calculated distance is less than user distance limit add appointment details to array
				if ( $uDistance >= $distance ) {
					$appts[0][] = array( 'id'          => $id,
					                  'dentist_id' => $dentist_id,
									  'practice_city' => $practice_city,
					                  'time'        => $time,
					                  'distance'    => $distance,
					                  'rating'      => $rating
					);
				}
				// NEW - show all appts beyond search criteria
				if ($distance >= $uDistance ){
					$appts[1][] = array( 'id'          => $id,
							                  'dentist_id' => $dentist_id,
							                  'practice_city' => $practice_city,
							                  'time'        => $time,
							                  'distance'    => $distance,
							                  'rating'      => $rating
					);
				}
			}
		}
	// Invalid Postcode
	} else {
		$appts[0] = 2;
 	}

	return $appts; 
}

function sortResults($masterArray,$key){
	// Initialise variable
	$toSort = array ();
	
	// Create array of values
	foreach ($masterArray as $array2) { 
		$toSort[] = $array2["$key"];
	}
		
	// Sort array 
	array_multisort($toSort, SORT_ASC, $masterArray);
	
	return $masterArray;
}

function sortResultsByDistanceTime($appts){
	// Create array of values
	foreach ($appts as $appt) { 
		$times[] = $appt["time"];
		$distances[] = $appt["distance"];
	}
	
	// Find closest and earliest 
	array_multisort($distances, SORT_ASC, $times, SORT_ASC, $appts);

	// Slice top result
	$closest = array_shift($appts);
	
	// Sort rest by time
	$appts = sortResults($appts, "time");
	
	// Add closest to top of Array
	array_unshift($appts, $closest);	
	
	return $appts;
}

function search($postcode, $distance, $disAccess){
	$appts = array();

    $results = getAppointments($disAccess);

    if (mysqli_num_rows($results) > 0)  {
	    $appts = compareDistances($results, $postcode, $distance);
	    if (count($appts[0])) {
	    	if ($appts[0] !== 2){
		        $appts[0] = sortResultsByDistanceTime( $appts[0] );
		        $appts[1] = sortResultsByDistanceTime( $appts[1] );
		        // Show only top 5 results
		        //$appts = array_slice($appts,0,5);
		    } else {
	    		$appts[0] = 2;
		    }
	    }
    }

	return $appts;	
}

function resetPassword($email,$password) {
	$db = dbConnect();
		
	// Create Hash 	
	$password = password_hash($password,PASSWORD_DEFAULT);
	
	// Execute SQL
	$sql = "UPDATE Users SET `password` = '$password	' WHERE email_address = '".$email."'";
	$result = $db->query($sql);
	if ($result) {
		// Replace token to prevent abuse
		$token   = generateToken();
		$sql2    = "UPDATE Users SET `token` = '" . $token . "' WHERE email_address = '" . $email . "'";
		$result2 = $db->query( $sql2 );

		$success = 1;
	}
	else
	{
		$success = 0;
	}
	return $success;
}

function changePassword($userId,$password) {
	$db = dbConnect();
		
	// Create Hash 	
	$password = password_hash($password,PASSWORD_DEFAULT);
	
	// Execute SQL
	$sql = "UPDATE Users SET `password` = '$password	' WHERE id = '".$userId."'";
	
	$result = $db->query($sql);
	
	return $result;
}

function verifyToken($token){
	$db = dbConnect();
	
	$sql = "SELECT email_address FROM Users WHERE token = '".$token."'";
	
	$result = $db->query($sql);
	
	if ($result->num_rows > 0) { 
		foreach ($result as $row){
			$email = $row["email_address"];	
		}
	} else {
		$email = 0;
	}
	return $email;
}
?>