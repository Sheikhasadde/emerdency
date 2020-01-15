<?php
/**
 * Emerdency-Live - edit-patient.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 17/05/2018
 * Time: 18:13
 * Description :
 */

include( "../php/patients.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if($_POST["select"]){
		$email = $_POST["email"];
		$details = getPatientDetailsByEmail($email);
	}
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
			$_SESSION["successMsg"] = "Patient account details have successfully been edited.";
			header("location:admin-patient-menu");
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

include( '../header.php' );
?>
<div class="main-content">
	<h1 class="page-title">Edit Patient Details</h1>
	<div class="inner-row">
		<div class="col-1">
			<input class="btn back" type="button" value="Back" onclick="window.location.href='admin-patient-menu'">
			<span class="error"><?php if($error != ""){echo "<br/>".$error."</br>";}?></span>
			<form class="appointment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				Please enter the email address of the Patient:
				<input placeholder="Email Address" type="email" name="email" required /> </br>
				<input class="btn" type="submit" value="Select" name="select" />
			</form>
			<div id="hidden_fields">
				<form class="appointment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="hidden" name="id" value="<?php echo $patientId;?>" required />
					First Name:
					<input placeholder="First Name" type="text" name="first_name" required value="<? echo $first_name?>" /> </br>
					Last Name:
					<input placeholder="Last Name" type="text" name="last_name" required value="<? echo $last_name?>" /> </br>
					House Number/Name:
					<input placeholder="House Number/Name" type="text" name="house_no_name" required value="<? echo $house_no_name?>" /> </br>
					Street/Road:
					<input placeholder="Street/Road" type="text" name="address_line_1" required value="<? echo $address_line_1?>" /> </br>
					Address Line 2:
					<input placeholder="Address Line 2" type="text" name="address_line_2" value="<? echo $address_line_2?>" /> </br>
					Town/City:
					<input placeholder="Town/City" type="text" name="town_city" required value="<? echo $town_city?>" /> </br>
					Postcode:
					<input placeholder="Postcode" type="text" name="postcode" required value="<? echo $postcode?>" /> </br>
					Contact Number:
					<input placeholder="Mobile Number" type="number" name="contact_no" min="0" value="<?php echo $contact_no ?>" required /> </br>
					<p>Date of Birth:</p>
					<input class="dob" placeholder="Date of Birth" type="date" name="dob" required min="1900-01-01" max="<?php echo $dateMinus16;?>" value="<?php echo $dob?>" /> </br>
					Email Address:
					<input placeholder="Email Address" type="email" name="email" value="<?php echo $email ?>" required /> </br>
					<input class="btn" type="submit" value="Edit" name="edit" />
				</form>
			</div>
		</div>
	</div>
</div>
<?php include( '../footer.php' ); ?>
