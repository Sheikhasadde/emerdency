<?php
/**
 * Emerdency-Live - report-practice-booking.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 03/05/2018
 * Time: 14:35
 * Description :
 */

include( "../php/reports.php" );

session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index.php");
}
if ($_GET["month"]){
    $month = strtotime($_GET["month"]);
	$month = date("Y-m-d", $month);
} else {
	$month = date("Y-m-d", time());
}
$practiceId = $_SESSION["practiceId"];
$labels     = getNumOfMonthlyBookingsPractice($practiceId);
$appts      = getPracticeAppointmentsByMonth($month,$practiceId);

include( '../header.php' );
?>
	<h1 class="page-title">Reports - Bookings</h1>
    <input class="btn back" type="button" value="Back" onclick="history.back()">
    <br/>
<?php
	if ( mysqli_num_rows($labels) > 0 ){
		echo "<ul class='alphaSort'>";
		while ($row = mysqli_fetch_assoc($labels)){
			$character = $row["date"];
			$count = $row["count"];
			echo "<li class='sortLi'><a href='?month={$character}'>{$character} ({$count})</a></li>";
		}
		echo "</ul>";
		echo "<br/>";
		echo "<br/>";
			if (mysqli_num_rows($appts) > 0) {
				while ( $appt = mysqli_fetch_assoc( $appts ) ) {
					$dateStr   = strtotime( $appt["start_date"] );
					$date      = date( 'l jS F Y', $dateStr );
					$time      = date( 'g:i A', $dateStr );
					$apptType  = $appt["type"];
					$apptId    = $appt["appointmentId"];
					$patientId = $appt["patientId"];
					echo "<div class='col-3'>";
					echo "<ul class='appointmentlist'>";
					echo "<li>Patient: " .$appt["patientName"]. "</li>";
					echo "<li>Dentist: Dr. " . $appt["dFirstName"] . " " . $appt["dLastName"];
					echo "<li>Date: " . $date . "</li>";
					echo "<li>Time: " . $time . "</li>";
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
					echo "</div>";
				}
			} else {
				echo "<div class='inner-row'>";
				echo "<h2>No Bookings have been made this month. Please select a month.</h2>";
				echo "</div>";
            }

	} else {
		echo "<div class='inner-row'>";
		echo "<h2>No Bookings have been made at this practice.</h2>";
		echo "</div>";
	}
    include( '../footer.php' );
?>