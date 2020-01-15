<?php
/**
 * Emerdency-Live - email-booking-confirmation.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 18/05/2018
 * Time: 17:09
 * Description :
 */

// Start Session
session_start();

include ("../php/availability.php");
include ("../php/adminApptBook.php");

$apptId = base64_decode($_GET["id"]);
$appt = getAppointment($apptId);
if ($appt){
	if (mysqli_num_rows($appt) > 0 ){
		while ($row = mysqli_fetch_assoc($appt)){
		    if ($row["type"] == 3 && $row["status"] == 0){
			    $_SESSION["apptId"] = $apptId;
			    $dateStr = strtotime($row["start_date"]);
			    $_SESSION["apptDate"]  = $date = date('l jS F Y',$dateStr);
			    $_SESSION["apptTime"] = $time = date('g:i A',$dateStr);
			    $_SESSION["apptType"] = "1";
			    $_SESSION["disAccess"] = $row["dis_access"];
            } else {
		        header("Location:.../index");
            }

		}
	} else {
		header("Location:../index");
	}
} else {
	header("Location:../index");
}

switch ($_SESSION["disAccess"]){
	case 0 :
		$disAccess = "No";
		break;
	case 1 :
		$disAccess = "Yes";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["patientSelect"]){
		$patientId = $_POST["patientId"];
		if ($patientId[0] == "m") {
			$_SESSION["minor"] = 2;
			$_SESSION["minorId"] = $patientId = substr($patientId, 1);
		} else {
			unset($_SESSION["minorId"]);
			unset($_SESSION["minor"]);
		}
	}
}

// Check if user is logged in
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1') {
	$userId = $_SESSION["userId"];
	// Get Patient Name
	$patientName = getPatientName($userId);
	// Check If minors associated to account
	$minors = hasMinors($userId);
	// Check if appointment is available
	$available = checkIfAvailableEmail( $apptId );

	if ($available == 0) {

		unset( $_SESSION["incompleteBooking"] );
		$_SESSION["errUnavailable"] = "Sorry, the selected appointment is no longer available.";
		header( "Location:search-results" );
		exit();

	}
}

include('../header.php');
?>
    <h1 class="page-title">Booking Confirmation</h1>
    <div class="inner-row">
        <div class="col-1">
            <a class="btn back" onclick="history.back()">Back</a>
            <img class="imgProcess" src="../images/the-process-pay.png" style="display: inline">
            <br/>
            <ul id="confirmation" class="appointmentlist confirmation">
		        <?php
		        echo "<div class=\"col-3\">
                <li><h2>Date: </h2>" .$_SESSION["apptDate"]. "</li>
            </div>
            <div class=\"col-3\">
                <li><h2>Time: </h2>" .$_SESSION["apptTime"]. "</li>
            </div>";
		        ?>
                <div class="col-3">
                    <li><h2>Price:</h2>£50<p>An initial booking fee of <b>£15</b> is charged online when the booking is made followed by the remaining amount of <b>£35</b> taken at the dental practice.</p></li>
                </div>
                <div class="col-3 access">
                    <li>Wheelchair Access Required: <?php echo $disAccess ?></li>
                </div>
		        <?
		        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
			        echo "<form method=\"POST\" action=".htmlspecialchars('email-booking-confirmation?id='.$_GET["id"]).">";
			        echo "<div class='col-3 access'><br/>";
			        echo "<a class='orange-text'>Please choose the patient name from the drop-down menu below and press select</a><br/>";
			        echo "<label>The appointment is for: </label>";
			        echo "<select class='patientSelect' name='patientId'>";
			        echo "<option value='{$userId}' selected>{$patientName}</option>";
			        if (mysqli_num_rows($minors) > 0){
				        while ($row = mysqli_fetch_assoc($minors)){
					        echo "<option value='m".$row["id"]."'";
					        if ($_SESSION["minorId"] == $row["id"]){
						        echo "selected";
					        } elseif ($patientId == $row["id"]){
						        echo "selected";
					        }
					        echo ">".$row["first_name"]." ".$row["last_name"]."</option>";
				        }

			        }
			        echo "<input class='btn selectBtn' type='submit' name='patientSelect' value='Select' />";
			        echo "</select></form>";
			        echo "</div>";

			        echo "<div class='col-3 access'> <p>This appointment will be reserved for <b>";
			        echo "<span id=\"clockdiv\"><span class=\"minutes\"></span>:<span class=\"seconds\"></span></b> minutes</span>";

			        echo " </ul>";
			        echo "Please click on the PayPal button below to make the payment.<br/><br/>   ";
			        echo "<h2 class='important'> IMPORTANT:</h2>";
			        echo "Once payment has been completed please allow PayPal to redirect you back to the Emerdency site in order to receive the appointment details.";
			        echo "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\">
                    <input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">
                    <input type=\"hidden\" name=\"hosted_button_id\" value=\"KD2LJ554K8D7C\">
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
    var loggedIn = <?php echo json_encode($_SESSION["loggedIn"]); ?>;
    if (loggedIn == 1){
        document.getElementById("confirmation").classList.add('select');
    }
    var id = <?php echo json_encode($_GET["id"]); ?>;
    $(".fancybox-refresh").fancybox({
        afterClose : function() {
            window.location.replace("https://www.emerdency.co.uk/pages/email-booking-confirmation?id="+id);
            return;
        }
    });

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
                window.location.replace("https://www.emerdency.co.uk/php/booking-timeout")
            }
        }

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
    }

    var endTime = new Date(<?php echo json_encode($available);?>.replace(' ', 'T'));
    initializeClock('clockdiv', endTime);
</script>
<?php
include('../footer.php');
?>