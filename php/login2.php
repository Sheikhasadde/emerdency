<?php
require("includes/db_connect.php");

session_start();

function login($email,$password){
	$db = dbConnect();
	$hash = '';
	$sql = "SELECT id, email_address, password, type, confirmed FROM Users WHERE `email_address` = '".$email."';";
	$result = $db->query($sql);
	$stmt = $db->prepare("SELECT id, email_address, password, type, confirmed FROM Users WHERE `email_address` = ?;");
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		foreach ($result as $row){
			$hash = $row["password"];
			$hash = substr( $hash, 0, 60 );
			$userId = $row["id"];
			$_SESSION["confirmed"] = $row["confirmed"];
		}

		if (password_verify($password, $hash)) {
			$minor = checkIfMinorAccount($userId);
			if (mysqli_num_rows($minor) > 0 ){
				$_SESSION["minor"] = 1;
			}
			$_SESSION["loggedIn"] = "1";
			$_SESSION["userId"] = $userId;
			$userType = $row["type"];
		} else { $userType = 0; }
	} else { $userType = 0; }

	return $userType;
}

function getPracticeId($userId){
	$db = dbConnect();
	$sql = "SELECT practice_id FROM Dentist WHERE id = '{$userId}';";

	$result = $db->query($sql);

	if ($result->num_rows > 0) {
		foreach ($result as $row){
			$dentistId = $row["practice_id"];

		}
	}
	return $dentistId;
}

function getGDCNo($userId){
	$db = dbConnect();
	$sql = "SELECT gdc_no FROM Dentist WHERE id = '{$userId}';";

	$result = $db->query($sql);

	while($row = mysqli_fetch_assoc($result)){
		$gdcNo = $row["gdc_no"];
	}

	return $gdcNo;
}

function checkIfMinorAccount($userId){
	$db = dbConnect();
	$sql = "SELECT id FROM MinorPatient WHERE parent_id = {$userId}";
	$result = $db->query($sql);
	return $result;
}

function checkIfTelAdvice($userId){
	$db = dbConnect();
	$sql = "SELECT tel_advice FROM Dentist WHERE id = {$userId}";
	$result = $db->query($sql);
	$row = mysqli_fetch_assoc($result);
	$telAdvice = $row["tel_advice"];
	if ($telAdvice ){
		return 1;
	} else {
		return 0;
	}
}