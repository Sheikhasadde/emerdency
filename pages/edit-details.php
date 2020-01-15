<?php
/**
 * Emerdency-Live - edit-details.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 30/04/2018
 * Time: 17:29
 * Description :
 */

include ("../php/dentist.php");

session_start();

$userId = $_SESSION["userId"];

if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] !== '2'){
	header("Location:../dentist-login");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get POST Data
	$dentistId = $_POST["dentistId"];
	$firstName = $_POST["firstName"];
	$lastName = $_POST["lastName"];
	$contactNo = $_POST["contact_no"];
	$email = $_POST["email"];
	$gdcNo = $_POST["gdcNo"];

	$success = editDentist($dentistId, $firstName, $lastName, $contactNo, $email, $gdcNo);
	if ($success){
		$_SESSION["successMsg"] = "Your account details have successfully been edited.";
		header("location:dentist-account");
		exit();
	}
}

$details = getDentistDetails($userId);

while ($row = mysqli_fetch_assoc($details)){
	$firstName = $row["first_name"];
	$lastName = $row["last_name"];
	$contactNo = $row["contact_no"];
	$email = $row["email_address"];
	$gdcNo = $row["gdc_no"];
}

include('../header.php');
?>
<div class="main-content">
	<h1 class="page-title">My Account - Edit Details</h1>
	<div class="inner-row">
		<div class="col-1">
			<input class="btn back" type="button" value="Back" onclick="window.location.href='dentist-account'">
			<form class="appointment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<span class="error"><?php if($error != ""){echo "<br/>".$error."</br>";}?></span>
				<input type="hidden" name="dentistId" value="<?php echo $userId;?>" required />
				First Name:
				<input placeholder="First Name" type="text" name="firstName" value="<?php echo $firstName;?>" readonly />
				Last Name: 
				<input placeholder="Last Name" type="text" name="lastName" value="<?php echo $lastName;?>" readonly />
				GDC Number:
				<input placeholder="GDC Number" type="text" name="gdcNo" value="<?php echo $gdcNo;?>" readonly />
				Contact Number: 
				<input placeholder="Contact Number" type="text" name="contact_no" value="<?php echo $contactNo;?>" required autofocus />
				Email Address: 
				<input placeholder="Email Address" type="text" name="email" value="<?php echo $email;?>" required />
				<input class="btn" type="submit" value="Edit" />
			</form>
		</div>
	</div>
	<?php include('../footer.php'); ?>
