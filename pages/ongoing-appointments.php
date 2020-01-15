<?php
/**
 * Emerdency - ongoing-appointments.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 14/03/2018
 * Time: 15:53
 * Description :
 */
include("../includes/db_connect.php");
include("../php/appointments.php");

session_start();

if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] !== '2'){
    header("Location:dentist-login");
}

$appts = getFutureAppointments($_SESSION["userId"]);
if ($appts){
    if (mysqli_num_rows($appts) == 0) {
        $err = "No Appointments upcoming.";
    }
}
include('../header.php');
?>
    <h1 class="page-title">My Account - On-going Appointments</h1>
    <div class="inner-row">
        <div class="col-1">
            <a class="btn back" type="button" value="Back" href="dentist-account">Back</a>
            </br>
            <span class="error"><h2><?php echo $err;?></h2></span>
			<?php
            if ($appts){
                if (count($appts) ) {
                    foreach ($appts as $appt) {
                        $dateStr = strtotime($appt["start_date"]);
                        $date = date('l jS F Y',$dateStr);
                        $time = date('g:i A',$dateStr);
	                    $apptType = $appt["type"];
                        $apptId = $appt["appointmentId"];
                        $patientId = $appt["patientId"];
                        $disAccess = $appt["dis_access"];
                        if ($disAccess){
                            $disAccess = "Yes";
                        } else {
                            $disAccess = "No";
                        }

                        echo "<ul class='appointmentlist dentist'>";
                        echo "<li>Patient: ".$appt['patientName']."</li>";
                        echo "<li>Date: ".$date."</li>";
                        echo "<li>Time: ".$time."</li>";
	                    if ($apptType == 2){
                            echo "<li>Telephone Booking</li>";
	                    } else {
		                    $practiceName = $appt["practiceName"];
		                    echo "<li>Practice: ".$practiceName."</li>";
		                    echo "<li>Wheelchair Access required: ".$disAccess."</li>";
                        }

                        echo "<form method='post' action='";echo htmlspecialchars('appointment-details')."'>";
	                    echo "<input name='date' type='hidden' value='{$date}' />";
	                    echo "<input name='time' type='hidden' value='{$time}' />";
	                    echo "<input name='type' type='hidden' value='{$apptType}' />";
	                    echo "<input name='disAccess' type='hidden' value='{$disAccess}' />";
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
            }
			?>
        </div>
    </div>
<?php include('../footer.php'); ?>