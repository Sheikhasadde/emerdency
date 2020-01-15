<?php
/**
 * Emerdency-Live - tel-thank-you.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 01/05/2018
 * Time: 16:08
 * Description :
 */

session_start();
// Check what type - if not correct/no type redirect to relevant page
switch ($_SESSION["apptType"]){
	case "1" :
		header("Location:tel-booking-confirmation");
		exit();
		break;
	case "2" :
		break;
	default :
		header("Location:../index");
		exit();
		break;
}
if ($_SESSION["appt"]){
	// Get Appt Data and assign to variable
	$appt = $_SESSION["appt"];
	$dentistName = $appt[1];
	$date = $appt[2];
	$time = $appt[3];
	$patientContactNo = $appt[5];

// Unset redundant Session Variables
	unset($_SESSION["authID"]);
	unset($_SESSION["appt"]);
	unset($_SESSION["apptId"]);
	unset($_SESSION["apptTime"]);
	unset($_SESSION["apptDate"]);
	unset($_SESSION["apptType"]);
} else {
	header("Location:tel-booking-confirmation");
}

include( '../header.php' );
?>

	<h1 class="page-title">Thank you</h1>
	<div class="inner-row">
		<div class="col-1">
            <img class="imgProcess" src="../images/the-process-details.png">
            <p>Thank you for your payment. Your transaction has been completed. Please check your email for the receipt. If you do not receive the email after a couple of minutes, please check the spam/junk mail.</p>
            <p>Below are your appointment details, they can also be viewed at any time in the <a class="orange-text">My Account</a> section.</p>
            <ul class="appointmentlist confirmation thank tel">
                <div class="col-3"><h2>Dentist Name:</h2>  Dr. <?php echo $dentistName; ?> </div>
                <div class="col-3"><h2>Date: </h2> <?php echo $date; ?> </br></div>
                <div class="col-3"><h2>Time: </h2> <?php echo $time; ?> </br></p></div>
                <div class="col-3 access"><br/><p>The Dentist will contact you at the given time on the following number: <b><?php echo $patientContactNo;?></b></p></div>
            </ul>
			<a class="btn" href="my-account">My Account</a>
		</div></div>

<?php include( '../footer.php' ); ?>