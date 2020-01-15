<?php
	require("../includes/db_connect.php");

function getDetails ($apptId) {
	$db  = dbConnect();
	$sql = "SELECT Appointment.id AS 'appointmentId', Appointment.start_date, Practice.id AS 'practiceId', Practice.name AS 'practiceName', Practice.address_line_1, 
			Practice.address_line_2, Practice.city, Practice.postcode, Dentist.id AS 'dentistId', Dentist.first_name, Dentist.last_name 
			FROM Appointment INNER JOIN Practice INNER JOIN Dentist ON Appointment.practice_id = Practice.id WHERE Appointment.id = '{$apptId}';";

	$results = $db->query( $sql );

	return $results;
}
    // Start session
	session_start();
	$apptId = $_SESSION["apptId"];

	$results = getDetails($apptId);

    foreach ($results as $row){
	    $practiceName = $row["practiceName"];
	    $dentistName = $row["firstname"]." ".$row["last_name"];
	    $dateStr = strtotime($row["start_date"]);
	    $date = date('l jS F Y',$dateStr);
    	$time = date('g:i A',$dateStr);
    	$address = $row["address_line_1"]." ".$row["address_line_2"]."</br>".$row["city"]."</br>".$row["postcode"];
    }

	 include('../header.php');
?>

<div class="main-content">
	<h1 class="page-title">Dentist Details</h1>
	<div class="inner-row">
		<div class="col-1">
        	<p>Thank you for booking an Appointment with Emerdency. Your appointment details have been sent via email and can be accessed through the "Patient Login" at any time. Your appointment  details are as follows: </p>
        	Practice Name: <?php echo $practiceName; ?>  </br>
            Dentist Name:  Dr. <?php echo $dentistName; ?> </br>
            Address:  <?php echo $address; ?> </br>
            Date:  <?php echo $date; ?> </br>
            Time:  <?php echo $time; ?> </br>
            <a class="btn black" href="my-account.php">Go to my Account</a>
		</div>
	</div>
</div>
<?php include('../footer.php'); ?>