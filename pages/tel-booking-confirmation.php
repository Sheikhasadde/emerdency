<?php
/**
 * Emerdency-Live - tel-booking-confirmation.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 01/05/2018
 * Time: 15:01
 * Description :
 */

include( "../php/availability.php" );
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["cancel"]){
		$userId = $_SESSION["userId"];
		$success = clearUserHold($userId);
		if ($success){
			unset($_SESSION["errUnavailable"]);
			unset($_SESSION["incompleteBooking"]);
			unset($_SESSION["timestamp"]);
			// Redirect to Search Results
			header("Location:../tel-search-results");
			exit();
		}
	}
	// Get Post Data
	$_SESSION["apptId"] = $_POST["apptId"];
	$_SESSION["apptTime"] = $_POST["apptTime"];
	$_SESSION["apptDate"] = $_POST["apptDate"];
	$_SESSION["apptType"] = $_POST["apptType"];
}
// Check what type - if not correct/no type redirect to relevant page
switch ($_SESSION["apptType"]){
	case "1" :
		header("Location:booking-confirmation");
		exit();
		break;
	case "2" :
		break;
	default :
		header("Location:../index");
		exit();
		break;
}
$apptId = $_SESSION["apptId"];
// Check if user is logged in
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1') {
	$userId    = $_SESSION["userId"];
	$available = checkIfAvailable( $apptId, $userId );

	if ($available === 0 ) {
		unset( $_SESSION["incompleteBooking"] );
		$_SESSION["errUnavailable"] = "Sorry, the selected appointment is no longer available.";

		// Re-Perform Search and re-direct to search results
		$_SESSION["availAppts"] = performSearch( $_SESSION["searchParams"] );
		header( "Location:search-results" );
		exit();
	}
}

include( '../header.php' );
?>
	<h1 class="page-title">Booking Confirmation</h1>
	<div class="inner-row">
		<div class="col-1">
            <a class="btn back" onclick="history.back()">Back</a>
            <img class="imgProcess" src="../images/the-process-pay.png" style="display: inline">
            <br/>
            <ul class="appointmentlist confirmation tel">
	            <?php
	            echo "<div class=\"col-3\">
                <li><h2>Date: </h2>" .$_SESSION["apptDate"]. "</li>
            </div>
            <div class=\"col-3\">
                <li><h2>Time: </h2>" .$_SESSION["apptTime"]. "</li>
            </div>";
	            ?>
                <div class="col-3">
                    <li><h2>Price:</h2>£15</li>
                </div>
			<? if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
				echo "<div class='col-3 access'> <p>This appointment will be reserved for <b>";
				echo "<span id=\"clockdiv\"><span class=\"minutes\"></span>:<span class=\"seconds\"></span></b> minutes</span>";
				echo " </ul>";
				echo "Please click on the PayPal button below to make the payment.<br/><br/>   ";
				echo "<h2 class='important'> IMPORTANT:</h2>";
				echo "Once payment has been completed please allow PayPal to redirect you back to the Emerdency site in order to receive the appointment details.";
				echo "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\">
                    <input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">
                    <input type=\"hidden\" name=\"hosted_button_id\" value=\"UZNFNK4KMZVAW\">
                    <input type='image' class='paypal-btn center' src=\"https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png\" alt=\"Check out with PayPal\" />
                    <img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_GB/i/scr/pixel.gif\" width=\"1\" height=\"1\">
                </form>";
				echo "<form method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
                        <input class='btn' type='submit' value='Cancel Booking' name='cancel' />
                  </form>";
			} else {
				echo " </ul>";
				echo "<p>Please login or register to continue with the booking process.</p>";
				echo "<input type='submit' data-fancybox data-type='iframe' data-src='login-lightbox.php' href='javascript:;' class='btn fancybox-refresh' data-small-btn='true' value='Login / Register' />";
			}
			?>
		</div>
	</div>
	<script>
        function getTimeRemaining(endtime) {
            var t = Date.parse(endtime) - Date.parse(new Date());
            var seconds = Math.floor((t / 1000) % 60);
            var minutes = Math.floor((t / 1000 / 60) % 60);
            var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
            var days = Math.floor(t / (1000 * 60 * 60 * 24));
            return {
                'total': t,
                'days': days,
                'hours': hours,
                'minutes': minutes,
                'seconds': seconds
            };
        }

        function initializeClock(id, endtime) {
            var clock = document.getElementById(id);
            var minutesSpan = clock.querySelector('.minutes');
            var secondsSpan = clock.querySelector('.seconds');

            function updateClock() {
                var t = getTimeRemaining(endtime);
                minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                if (t.total <= 0) {
                    clearInterval(timeinterval);
                    window.location.replace("https://www.emerdency.co.uk/php/booking-timeout");
                }
            }

            updateClock();
            var timeinterval = setInterval(updateClock, 1000);
        }
        var id = <?php echo json_encode($_GET["id"]); ?>;
        $(".fancybox-refresh").fancybox({
            afterClose : function() {
                window.location = "https://www.emerdency.co.uk/pages/tel-booking-confirmation";
                return;
            }
        });
        var endTime = new Date(<?php echo json_encode($available); ?>.replace(' ', 'T'));
        initializeClock('clockdiv', endTime);


        var endTime = new Date(<?php echo json_encode($available); ?>.replace(' ', 'T'));
        initializeClock('clockdiv', endTime);
	</script>
<?php include( '../footer.php' ); ?>