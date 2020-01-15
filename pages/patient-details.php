<?php
/**
 * Emerdency - patient-details.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 15/03/2018
 * Time: 21:18
 * Description :
 */

include ("../includes/db_connect.php");
include("../php/appointments.php");

// Start session
session_start();
// Get POST Data
if ($_POST["btnDetails"]) {
	$date = $_POST["date"];
	$time = $_POST["time"];
	$patientId = $_POST["patientId"] ;
	$practiceName = $_POST["practiceName"];
	$apptId = $_POST["apptId"];
	$type = $_POST["type"];

    if ($type == 1){
	    $details = getMinorPatientDetails($apptId);
    } else {
	    $details = getPatientDetails($patientId);
    }

	$details2 = getAppointmentDetails($apptId);

    $disAccess = $details2[3];
    if ($disAccess){
        $disAccess = "Yes";
    } else {
        $disAccess = "No";
    }

	foreach ($details as $detail) {
		$patientName = $detail["first_name"]. " ".$detail["last_name"];
		$address = $detail["house_no_name"]. " ".$detail["address_line_1"];
		if($detail["address_line_2"]){
			$address .= ", ".$detail["address_line_2"];
		}
		$address .= ", ".$detail["town_city"].", ".$detail["postcode"];
		$dateStr = strtotime($detail["dob"]);
		$dob = date('jS F Y',$dateStr);
		$contact = $detail["contact_no"];
		$email = $detail["email_address"];
	}
}

include('../header.php');
?>
    <div class="main-content">
		<h1 class="page-title">Patient Details</h1>
		<div class="inner-row">
			<div class="col-1">
                <a class="btn back" type="button" onclick="history.back()">Back</a>
                <br/>
                <?php if ($details) {
	                $practiceName = $details2[0];
	                $date = $details2[1];
	                echo "<ul class='appointmentlist details'>";
	                echo "<div class='col-3'>";
	                echo "<h4>Date:</h4> ".$date."</div>";
	                echo "<div class='col-3'>";
	                echo "<h4>Time:</h4> ".$time."</div>";
	                if ($type == 2){
		                echo "<div class='col-3'>";
		                echo "<h4>Telephone Booking</h4></div>";
	                } else {
		                echo "<div class='col-3'>";
		                echo "<h4>Dental Practice:</h4> " . $practiceName . "</div>";
		                echo "<div class='col-3'>";
		                echo "<h4>Wheelchair Access required:</h4> " . $disAccess     . "</div>";
	                }
	                echo "</ul>";
	                echo "<ul class='appointmentlist patient'>";
	                echo "<div class='col-3'>";
	                echo "<h4>Patient Name:</h4> ".$patientName."</div>";
	                echo "<div class='col-3'>";
	                echo "<h4>Date of Birth:</h4> ".$dob."</div>";
	                if ($type == 1){
		                echo "<div class='col-3'>";
		                echo "<h4>Patient Type:</h4>Child</div>";
	                } else {
		                echo "<div class='col-3'>";
		                echo "<h4>Patient Type:</h4>Adult</div>";
	                }
	                echo "<div class='col-3'>";
	                echo "<h4>Address:</h4> ".$address."</div>";
	                echo "<div class='col-3'>";
	                echo "<h4>Contact Number: </h4>".$contact."</div>";
	                echo "<div class='col-3'>";
	                echo "<h4>Email:</h4>".$email."</div>";
	                echo "</ul>";
                } else {
                    echo "<h2>No patient selected.</h2>";
                }
                ?>
			</div>
		</div>
<?php include('../footer.php'); ?>