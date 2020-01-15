<?php
/**
 * Emerdency-Live - unbooked-appointments.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 16/05/2018
 * Time: 20:30
 * Description :
 */


session_start();

include( "../php/appointments.php" );

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}
//check if the starting row variable was passed in the URL or not
if (!isset($_GET['row']) or !is_numeric($_GET['row'])) {
	//we give the value of the starting row to 0 because nothing was found in URL
	$startRow = 0;
//otherwise we take the value from the URL
} else {
	$startRow = (int)$_GET['row'];
}

$appts = getUnbookedAppointments($startRow);
include( '../header.php' );
?>
	<div class="main-content">
		<h1 class="page-title">Unbooked Appointments</h1>
		<div class="inner-row">
			<div class="col-1">
                <input class="btn back" type="button" value="Back" onclick="window.location.replace('admin-tel-appointments-menu')">
				<table class="adminAppt">
					<tr>
						<th>Dentist</th>
						<th>Date/Time</th>
					</tr>
					<?php
					if (mysqli_num_rows($appts) > 0){
						echo "<tr>";
						while ($row = mysqli_fetch_assoc($appts)){
							$disAccess = $row["dis_access"];
							if ($disAccess){
								$disAccess = "Yes";
							} else {
								$disAccess = "No";
							}
							$dateTime= date('F j, Y, g:i a', strtotime($row["start_date"]));
							echo "<tr>";
							echo "<td>{$row["dentist_name"]}</td>";
							echo "<td>{$dateTime}</td>";
							echo "</tr>";
						}

					}
					echo "</table>";

					echo '<a class="btn back next" href="'.$_SERVER['PHP_SELF'].'?row='.($startRow+100).'">Next</a>';
					$prev = $startRow - 100;
					//only print a "Back" link if a "Next" was clicked
					if ($prev >= 0)
						echo '<a class="btn back" href="'.$_SERVER['PHP_SELF'].'?row='.$prev.'">Back</a>';
					?>
			</div>
		</div>
	</div>
<?php include( '../footer.php' ); ?>