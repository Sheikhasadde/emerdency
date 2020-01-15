<?php
/**
 * Emerdency - previous-appointments.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 14/03/2018
 * Time: 15:54
 * Description :
 */
include("../includes/db_connect.php");
include("../php/appointments.php");

session_start();

if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] !== '2'){
    header("Location:dentist-login");
}
// Get User ID
$userId = $_SESSION["userId"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["search"]){
	    $appts = getPreviousAppointments($userId,$_POST["search"]);
	    if (mysqli_num_rows($appts) == 0) {
		    $err = "Patient was not found. Please try again.";
	    }
    } else {
        $err = "Please enter search parameters.";
    }
} else {
	$appts = getRecentPreviousAppointments($userId);
}

include('../header.php');
?>
		<h1 class="page-title">My Account - Previous Appointments</h1>
		<div class="inner-row">
			<div class="col-1">
                <a class="btn back" type="button" value="Back" href="dentist-account.php">Back</a>
                </br>
                <span class="error"><?php echo $err;?> </span>
                <form class="appointment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="text" placeholder="Patient Name" name="search" value="<?php echo $_POST["search"] ?>" >
                    <input class="btn" type="submit" value="Search">
                </form>
                <?php if (count($appts)) {
					foreach ($appts as $appt) {
						$dateStr = strtotime($appt["start_date"]);
						$date = date('l jS F Y',$dateStr);
						$time = date('g:i A',$dateStr);
						$apptType = $appt["type"];
						$apptId = $appt["appointmentId"];
						$patientId = $appt["patientId"];

						echo "<ul class='appointmentlist dentist'>";
						echo "<li>Patient: ".$appt["patientName"]."</li>";
						echo "<li>Date: ".$date."</li>";
						echo "<li>Time: ".$time."</li>";
						if ($apptType == 2){
							echo "<li>Telephone Booking</li>";
						} else {
							$practiceName = $appt["practiceName"];
							echo "<li>Practice: ".$practiceName."</li>";
						}
						echo "<form method='post' action='";echo htmlspecialchars('patient-details')."'>";
						echo "<input name='date' type='hidden' value='{$date}' />";
						echo "<input name='time' type='hidden' value='{$time}' />";
						echo "<input name='type' type='hidden' value='{$apptType}' />";
						echo "<input name='practiceName' type='hidden' value='{$practiceName}' />";
						echo "<input name='patientId' type='hidden' value='{$patientId}' />";
						echo "<input name='apptId' type='hidden' value='{$apptId}' />";
						echo "<input class='btn' type='submit' name='btnDetails' value='View Details' />";
						echo "</form>";
						echo "</ul>";
					}
				} else {
					$err = "Patient was not found. Please try again.";
				}
				?>
			</div>
		</div>
<?php include('../footer.php'); ?>