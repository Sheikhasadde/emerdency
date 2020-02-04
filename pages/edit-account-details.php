<?php
/**
 * Emerdency-Live - edit-account-detials.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 21/05/2018
 * Time: 18:27
 * Description :
 */

session_start();

$details = getPatientDetailsById($_SESSION["userId"]);
function editPatient($patientId, $first_name,$last_name,$house_no_name,$address_line_1,$address_line_2,$town_city,$postcode,$dob,$contact_no,$email_address){
	$db = dbConnect();

	$sql = "UPDATE `Patient` SET `first_name`= '{$first_name}',`last_name`= '{$last_name}',`house_no_name`= '{$house_no_name}',`address_line_1`= '{$address_line_1}',`address_line_2`= '{$address_line_2}',`town_city`= '{$town_city}',`postcode`= '{$postcode}',`dob`='{$dob}',`contact_no`='{$contact_no}' WHERE id = {$patientId};";
	$sql .= "UPDATE Users SET email_address = '{$email_address}' WHERE id = {$patientId}";

	$result = $db->multi_query($sql);

	return $result;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["edit"]){
		$p_patientId = $_POST["id"];
		$p_first_name = $_POST["first_name"];
		$p_last_name = $_POST["last_name"];
		$p_house_no_name = $_POST["house_no_name"];
		$p_address_line_1 = $_POST["address_line_1"];
		$p_address_line_2 = $_POST["address_line_2"];
		$p_town_city = $_POST["town_city"];
		$p_postcode = $_POST["postcode"];
		$p_dob = $_POST["dob"];
		$p_contact_no =$_POST["contact_no"];
		$p_email_address = $_POST["email"];

		$success = editPatient($p_patientId, $p_first_name,$p_last_name,$p_house_no_name,$p_address_line_1,$p_address_line_2,$p_town_city,$p_postcode,$p_dob,$p_contact_no,$p_email_address);
		if ($success){
			$_SESSION["successMsg"] = "Your account details have successfully been edited.";
			header("location:my-account");
			exit();
		}
	}
}

if ($details){
	if (mysqli_num_rows($details) > 0 ){
		while ($row = mysqli_fetch_assoc($details)){
			$patientId = $row["id"];
			$first_name = $row["first_name"];
			$last_name = $row["last_name"];
			$house_no_name = $row["house_no_name"];
			$address_line_1 = $row["address_line_1"];
			$address_line_2 = $row["address_line_2"];
			$town_city = $row["town_city"];
			$postcode = $row["postcode"];
			$dob = $row["dob"];
			$contact_no = $row["contact_no"];
			$email = $row["email_address"];
		}
	} else {
		$error = "User was not found. Please try again.";
	}
}


?>
<div class="main-content">
	<h1 class="">Edit Patient Details</h1>
	<div class="col-md-12">
		<div class="col-md-10 col-md-offset-1">
			<!-- <input class="btn back" type="button" value="Back" onclick="window.history.back();"> -->
			<span class="error"><?php if($error != ""){echo "<br/>".$error."</br>";}?></span>
			<div id="hidden_fields">
				<form class="appointment-form" autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					
				<input type="hidden" name="id" value="<?php echo $patientId;?>" required />
			<div class="col-md-6">
				First Name:
					<input placeholder="First Name" type="text" name="first_name" readonly value="<?php echo $first_name ?>" /> </div>
					<div class="col-md-6">
					Last Name:
					<input placeholder="Last Name" type="text" name="last_name" readonly value="<?php echo $last_name?>" /> </div>
					<div class="col-md-6">
					Contact Number:
					<input placeholder="Mobile Number" type="number" name="contact_no" min="0" value="<?php echo $contact_no ?>" required />
					</div>
					<div class="col-md-6">
					Date of Birth:
					<input class="dob" placeholder="YYYY-MM-DD" type="date" name="dob" readonly min="1900-01-01" max="<?php echo $dateMinus16;?>" value="<?php echo $dob?>" />
					</div>
					<div class="col-md-6">
					House Number/Name:
					<input placeholder="House Number/Name" type="text" name="house_no_name" required value="<?php echo $house_no_name?>" />
					</div>
					 <div class='col-md-6'>
					Street/Road:
					<input placeholder="Street/Road" type="text" name="address_line_1" required value="<?php echo $address_line_1?>" />
					 </div>
					 <div class="col-md-12">
					Address Line 2:
					<input placeholder="Address Line 2" type="text" name="address_line_2" value="<?php echo $address_line_2?>" /> </div>
					<div class="col-md-12">
					Town/City:
					
					<input placeholder="Town/City" type="text" name="town_city" required value="<?php echo $town_city?>" /> </div>
					<div class="col-md-6">
					Postcode:
					<input placeholder="Postcode" type="text" name="postcode" required value="<?php echo $postcode?>" /> </br>
					</div>
					<div class="col-md-6">
					Email Address:
					<input placeholder="Email Address" type="email" name="email" value="<?php echo $email ?>" required /></div>
					<div class="col-md-6 col-md-offset-3">
					<input class="btn bg-dark" type="submit" value="Edit" name="edit" />
					<br><br><br>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

