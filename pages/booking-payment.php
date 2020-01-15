<?php
/**
 * Emerdency-Live - booking-payment.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 11/05/2018
 * Time: 16:43
 * Description :
 */

session_start();

include ("../php/availability.php");
include ("../php/search.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get Post Data
	$_SESSION["apptId"] = $_POST["apptId"];
	$_SESSION["apptTime"] = $_POST["apptTime"];
	$_SESSION["apptDate"] = $_POST["apptDate"];
	$_SESSION["type"] = $_POST["type"];

	if ($_POST["cancel"]){
		$userId = $_SESSION["userId"];
		$success = clearUserHold($userId);
		if ($success){
			unset($_SESSION["errUnavailable"]);
			unset($_SESSION["incompleteBooking"]);
			unset($_SESSION["timestamp"]);
			// Re-Perform Search and re-direct to search results
			$_SESSION["availAppts"] = performSearch( $_SESSION["searchParams"] );
			// Redirect to Search Results
			header("Location:search-results");
			exit();
		}
	}
}
if (isset($_SESSION["type"]) && $_SESSION["type"] !== "tel"){
	header("location:booking-confirmation");
	exit();
}
$apptId = $_SESSION["apptId"];
// Check if user is logged in
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1') {
	$userId    = $_SESSION["userId"];
	$available = checkIfAvailable( $apptId, $userId );

	if ( $available == 0 ) {
		unset($_SESSION["incompleteBooking"]);
		$_SESSION["errUnavailable"] = "Sorry, the selected appointment is no longer available.";

		// Re-Perform Search and re-direct to search results
		$_SESSION["availAppts"] = performSearch( $_SESSION["searchParams"] );
		header( "Location:search-results" );
		exit();
	} // Appt is available - hold for user
	elseif ( $available == 1 ) {
		$_SESSION["incompleteBooking"] = 1;
		// Clear any previous appointments held by user
		clearUserHold($userId);
		// Hold appointment for user
		$timestamp = holdAppointment( $userId, $apptId );
		// Store timestamp in SESSION
		if ($timestamp){
			$_SESSION["authID"] = crypt($apptId);
			$_SESSION["timestamp"] = $timestamp;
			$hold = "5:00";
		}
	} else {
		// Calculate time remaining
		$timeNow = time();
		$hold = ($available - $timeNow) / 60;
		$minutes = floor($hold);
		$seconds = ($hold - $minutes) * 60;
		$timeLeft = $minutes .":".$seconds;
	}
} else {
	header("Location:booking-confirmation");
}

include('../header.php');
?>
<h1 class="page-title">Booking Confirmation</h1>
<div class="inner-row">
	<div class="col-1">
		<a class="btn back" onclick="history.back()">Back</a>
		<img class="imgProcess" src="../images/the-process-pay.png" style="display: inline">
		<br/>
		<?php
		echo "Date: " .$_SESSION["apptDate"]. "<br/>Time: " .$_SESSION["apptTime"];
		?>
		<br/> Price: £50
		<?
		if ($_SESSION["minor"]){
			echo "<br/>Minor booking: <input type='checkbox' checked disabled>";
		}
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
			if ($hold){
				echo "<p><b>This appointment is being held for you for the next ";
				if ($timeLeft) {
					echo $timeLeft." minutes.";
				}
				else {
					echo "5:00 minutes</b></p>";
				}
			}
			echo "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\">
                    <input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">
                    <input type=\"hidden\" name=\"hosted_button_id\" value=\"KD2LJ554K8D7C\">
                    <input type=\"image\" src=\"https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif\" border=\"0\" name=\"submit\" alt=\"PayPal – The safer, easier way to pay online!\">
                    <img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_GB/i/scr/pixel.gif\" width=\"1\" height=\"1\">
                </form>";

			echo "<form method='post' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
                        <input class='btn' type='submit' value='Cancel Booking' name='cancel' />
                  </form>";
		} else {
			echo "<p>Please login or register to continue with the booking process.</p>";
			echo "<input type='submit' data-fancybox data-type='iframe' data-src='login-lightbox.php' href='javascript:;' class='btn fancybox-refresh' data-small-btn='true' value='Login / Register' />";
		}
		?>
	</div>
</div>
<script>
    $(".fancybox-refresh").fancybox({
        afterClose : function() {
            location.reload();
            return;
        }
    });
</script>