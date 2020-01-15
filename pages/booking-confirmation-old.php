<?php
/**
 * Emerdency-Live - tel-booking-confirmation.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 01/05/2018
 * Time: 15:01
 * Description :
 */

include ("../php/availability.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get Post Data
	$_SESSION["apptId"] = $_POST["apptId"];
	$_SESSION["apptTime"] = $_POST["apptTime"];
	$_SESSION["apptDate"] = $_POST["apptDate"];

	if ($_POST["cancel"]){
		$userId = $_SESSION["userId"];
		$success = clearUserHold($userId);
		if ($success){
			unset($_SESSION["errUnavailable"]);
			unset($_SESSION["incompleteBooking"]);
			unset($_SESSION["timestamp"]);
			// Redirect to Search Results
			header("Location:tel-search-results");
			exit();
		}
	}
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
}

include('../header.php');
?>
	<h1 class="page-title">Booking Confirmation</h1>
	<div class="inner-row">
		<div class="col-1">
			<form>
				<input class="btn back" type="button" value="Back" onclick="history.back()">
			</form>
			<?php
			echo "Date: " .$_SESSION["apptDate"]. "<br/>Time: " .$_SESSION["apptTime"];
			?>
			<br/> Price: £15

			<? if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
				if ($hold){
					echo "<p><b>This appointment is being held for you for the next ";
					if ($timeLeft) {
						echo $timeLeft." minutes.";
					}
					else {
						echo "5:00 minutes</b></p>";
					}
				}
				echo "<div id='paypal-button'></div>";
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
	<script>(".fancybox-refresh").fancybox({
            afterClose : function() {
                location.reload();
                return;
            }
        });
	</script>
	<script>
        // Get php variable and convert to JSON for JS usage
        var authID = <?php echo json_encode($_SESSION["authID"]); ?>;
        var paymentURL = "../php/tel-payment-complete.php?authID="+authID;
        console.log(paymentURL);
        // Render the PayPal button
        paypal.Button.render({
            // Set your environment
            env: 'production', // sandbox | production

            // Specify the style of the button
            style: {
                label: 'pay',
                size:  'responsive', // small | medium | large | responsive
                shape: 'rect',   // pill | rect
                color: 'gold'   // gold | blue | silver | black
            },

            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                //sandbox: 'AQ_ZTUVd2Wpsmb1FEMQ4cgvyvpssF2aGxVYdfgcwpyk_PV38MxJ4sNHYA8p5xhbXjZHmDTOciJSBYkQx'
                production: 'ATSQck3pzPqLljygod-ray1x4Qpc07nkzKy_IjvG8qXKHHYFuMS3q6vNGwscLnPGd2PftNji_SUbMmV7'
            },

            // Wait for the PayPal button to be clicked
            payment: function(data, actions) {
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: { total: '15.00', currency: 'GBP' }
                            }
                        ]
                    }
                });
            },
            commit : true,

            // Wait for the payment to be authorized by the customer
            onAuthorize: function(data, actions) {
                return actions.payment.execute().then(function() {
                    //window.alert('Payment Complete!');
                    window.location.href = paymentURL;
                });
            }

        }, '#paypal-button');

        $(".fancybox-refresh").fancybox({
            type: 'iframe',
            afterClose: function () {
                parent.location.reload(true);
            }
        });

	</script>
<?php include('../footer.php'); ?>