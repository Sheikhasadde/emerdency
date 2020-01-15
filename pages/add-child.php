<?php
/**
 * Emerdency-Live - add-minor.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 15/05/2018
 * Time: 19:36
 * Description :
 */

require("../includes/db_connect.php");
include ("../php/registerUser.php");

session_start();

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
} else {
	header("Location:login");
	exit();
}
$userId = $_SESSION["userId"];
$email = getEmailAddress($userId);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$mFirstName = $_POST["m_firstName"];
	$mLastName = $_POST["m_lastName"];
	$mDOB = $_POST["m_dob"];
	$email_address = $_POST["email"];
	$result = registerMinor($mFirstName,$mLastName,$mDOB,$email_address);
	if ($result){
		$_SESSION["successMsg"] = "Child has successfully been added to Account";
		header("Location:my-account");
		exit();
	}
}
// Get today's date -18 years for max date picker and for minor picker
$dateToday = date('Y-m-d');
$time = strtotime("-16 year", time());
$dateMinus16 = date("Y-m-d", $time);

include "../header.php";

?>
	<h1 class="page-title">Add Child Patient</h1>
	<div class="inner-row">
		<div class="col-1">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<p>Child Details:</p>
			<input type="hidden" name="email" value="<?php echo $email;?>">
			<input type="text" placeholder="First Name" id="m_firstName" name="m_firstName" />
			<input type="text" placeholder="Last Name" id="m_lastName" name="m_lastName" />
            <label>Date of Birth: </label><br/>
			<input placeholder="YYYY-MM-DD" type="date" name="m_dob" min="<?php echo $dateMinus16;?>" max="<?php echo $dateToday;?>" />
			<input class="btn" type="submit" value="Register" />
			</form>
		</div>
	</div>
<?php include('../footer.php'); ?>