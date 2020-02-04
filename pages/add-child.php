<?php


// require("../includes/db_connect.php");
 include ("../php/registerUser.php");

// session_start();

// if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
// } else {
// 	header("Location:login");
// 	exit();
//}
//$userId = $_SESSION["userId"];
$email = getEmailAddress($userId);


// if ($_SERVER["REQUEST_METHOD"] == "POST") {
// 	$mFirstName = $_POST["m_firstName"];
// 	$mLastName = $_POST["m_lastName"];
// 	$mDOB = $_POST["m_dob"];
// 	$email_address = $_POST["email"];
// 	$result = registerMinor($mFirstName,$mLastName,$mDOB,$email_address);
// 	if ($result){
// 		$_SESSION["successMsg"] = "Child has successfully been added to Account";
// 		header("Location:my-account");
// 		exit();
// 	}
// }
// Get today's date -18 years for max date picker and for minor picker
// $dateToday = date('Y-m-d');
// $time = strtotime("-16 year", time());
// $dateMinus16 = date("Y-m-d", $time);



?>
	<h1 class="">Add Child Patient</h1>
	<div class="col-md-12">
		<div class="col-md-8 col-md-offset-2">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<p>Child Details:</p>
			<input type="hidden" name="email" value="<?php echo $email;?>">
			<div class="col-md-6">
			<input type="text" placeholder="First Name" id="m_firstName" name="m_firstName" />
</div>
<div class="col-md-6">
			<input type="text" placeholder="Last Name" id="m_lastName" name="m_lastName" /></div>
		   <div class='col-md-12'>
			<label>Date of Birth: </label><br/>
			<input placeholder="YYYY-MM-DD" type="date" name="m_dob" min="<?php echo $dateMinus16;?>" max="<?php echo $dateToday;?>" /></div>
			<div class="col-md-6 col-md-offset-3">
			<input class="btn bg-dark" type="submit" value="Register" />
			</div>
			<br><br><br><br><br><br>
			</form>
		</div>
	</div>
