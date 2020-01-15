<?php
/**
 * Emerdency-Live - admin-book-appointment.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 17/05/2018
 * Time: 19:57
 * Description :
 */

session_start();

include( "../php/dentist.php" );
include( "../php/adminApptBook.php" );

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["select"]){
        $dentistId = $_POST["dentistId"];
        $dentistName = $_POST["dentistName"];
        $practiceSelect = getAssociatedPractices($dentistId);
    }
    if ($_POST["submit"]) {
        $dentistId = $_POST["dentistId"];
        $practiceId = $_POST["practiceId"];
	    $startDate = strtotime($_POST["startDate"]);
	    $startDate = date("Y-m-d H:i:s", $startDate);
	    $endDate = strtotime($_POST["endDate"]);
	    $endDate = date("Y-m-d H:i:s", $endDate);
	    $disAccess = $_POST["disAccess"];
        $email = $_POST["email"];

	    $success = createAppointment($dentistId, $practiceId, $startDate, $endDate, $disAccess);
	    if ($success){
	        $success2 = sendBookingEmail($dentistId, $practiceId, $startDate, $email);
		    $_SESSION["successMsg"] = "Appointment has been created for patient.";
		    header("location:admin-appointments-menu");
		    exit();
            }
    }
}

include( '../header.php' );
?>

	<div class="main-content">
	<h1 class="page-title">Admin - Book Appointment</h1>
	<div class="inner-row">
		<div class="col-1">
			<input class="btn back" type="button" value="Back" onclick="window.location.replace('admin-appointments-menu')">
            <div id="hidden_fields">
                <form method="POST" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="text" value="<?php echo $dentistName?>" required readonly>
                    <input type="hidden" value="<?php echo $dentistId?>" name="dentistId" >
                    <select class="customSelect" name="practiceId" required>
                        <option disabled selected>-- Practice --</option>
						<?php
						while ($row = mysqli_fetch_assoc($practiceSelect)){
							echo "<option value='{$row['id']}'>{$row['name']}</option>";
						} ?>
                    </select>
                    Start Date/Time of Appointment: <input class="postcode" type="datetime-local" name="startDate" required >
                    End Date/Time of Appointment: <input class="postcode" type="datetime-local" name="endDate" required >
                    Wheelchair Access needed: <label><input type="radio" name="disAccess" value="1" required>  Yes</label> <label><input type="radio" name="disAccess" value="0" checked="checked"> No</label>
                    <input placeholder="Patient Email Address" type="email" name="email" required />
                    <input class="btn" type="submit" name="submit" value="Submit" >
                </form>
            </div>
		</div>
	</div>
<?php include( '../footer.php' ); ?>


