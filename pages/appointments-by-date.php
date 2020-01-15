<?php
/**
 * Created by PhpStorm.
 * User: Aamir
 * Date: 21/05/2018
 * Time: 00:50
 */

session_start();

include ("../php/appointments.php");

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$startDate = strtotime( $_POST["date"] );
	$startDate = date( "Y-m-d H:i:s", $startDate );
	$appts = getBookedAppointmentsByDate($startDate);
}

include('../header.php');
?>
    <div class="main-content">
        <h1 class="page-title">Appointments by Date</h1>
        <div class="inner-row">
            <div class="col-1">
                <input class="btn back" type="button" value="Back" onclick="window.location.replace('admin-appointments-menu')">
                <br/>Please enter the date for which you wish to see a report:
                <form class="appointment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="date" name="date">
                    <input type="submit" class="btn" value="View">
                </form>
					<?php
                    if ($appts){
	                    if (mysqli_num_rows($appts) > 0){
	                        echo "<table class=\"adminAppt\">
                    <tr>
						<th>Practice</th>
						<th>City</th>
						<th>Dentist</th>
						<th>Date/Time</th>
                        <th>Wheelchair Access</th>
                        <th>Patient</th>
                        <th>Type</th>
						<th>Status</th>
                    </tr>";
		                    echo "<tr>";
		                    while ($row = mysqli_fetch_assoc($appts)) {
			                    $disAccess = $row["dis_access"];
			                    if ($disAccess){
				                    $disAccess = "Yes";
			                    } else {
				                    $disAccess = "No";
			                    }
			                    $dateTime = date( 'F j, Y, g:i a', strtotime( $row["start_date"] ) );
			                    if ( $row["minorPatientName"] ) {
				                    $patientName = $row["minorPatientName"];
			                    } else {
				                    $patientName = $row["patientName"];
			                    }
			                    echo "<tr>";
			                    echo "<td>{$row["name"]}</td>";
			                    echo "<td>{$row["city"]}</td>";
			                    echo "<td>{$row["dentist_name"]}</td>";
			                    echo "<td>{$dateTime}</td>";
			                    echo "<td>{$disAccess}</td>";
			                    echo "<td>{$patientName}</td>";
			                    switch ( $row["type"] ) {
				                    case 0 :
					                    echo "<td>Adult</td>";
					                    break;
				                    case 1 :
					                    echo "<td>Child</td>";
					                    break;
				                    case 2 :
					                    echo "<td>Telephone</td>";
					                    break;
			                    }
			                    switch ( $row["status"] ) {
				                    case 2 :
					                    echo "<td>Booked</td>";
					                    break;
				                    case 3 :
					                    echo "<td>Seen</td>";
					                    break;
				                    case 4 :
					                    echo "<td>Left Review</td>";
					                    break;
			                    }
			                    echo "</tr>";
		                    }
	                    }
	                    echo "</table>";
                    }
					?>
            </div>
        </div>
    </div>
<?php include('../footer.php'); ?>