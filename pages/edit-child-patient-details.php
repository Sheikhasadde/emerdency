<?php
/**
 * Emerdency-Live - edit-patient.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 17/05/2018
 * Time: 18:13
 * Description :
 */

include( "../php/patients.php" );

session_start();

$dateToday = date('Y-m-d');
$time = strtotime("-16 year", time());
$dateMinus16 = date("Y-m-d", $time);

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if($_POST["selectChild"]){
		$minorId = $_POST["minorId"];
		$details = getAssociatedMinorsById($minorId);
	}
	if ($_POST["edit"]){
	    $id         = $_POST["id"];
		$first_name = $_POST["first_name"];
		$last_name  = $_POST["last_name"];
		$dob        = $_POST["dob"];

		$success = editMinorPatient($id, $first_name, $last_name, $dob);
		if ($success){
			$_SESSION["successMsg"] = "Patient account details have successfully been edited.";
			header("location:admin-patient-menu");
			exit();
		}
	}

	if ($details) {
		if ( mysqli_num_rows( $details ) > 0 ) {
			while ( $row = mysqli_fetch_assoc( $details ) ) {
				$first_name = $row["first_name"];
				$last_name  = $row["last_name"];
				$dob        = $row["dob"];
			}
		} else {
			echo "Error";
		}
	}
}

include( '../header.php' );
?>
<div class="main-content">
	<h1 class="page-title">Edit Patient Details</h1>
	<div class="inner-row">
		<div class="col-1">
			<input class="btn back" type="button" value="Back" onclick="window.location.href='admin-patient-menu'">
			<span class="error"><?php if($error != ""){echo "<br/>".$error."</br>";}?></span>
            <form class="appointment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="hidden" name="id" value="<?php echo $minorId?>" required />
                <p>First Name:</p>
                <input placeholder="First Name" type="text" name="first_name" required value="<?php echo $first_name?>" /> </br>
                <p>Last Name:</p>
                <input placeholder="Last Name" type="text" name="last_name" required value="<?php echo $last_name?>" /> </br>
                <p>Date of Birth:</p>
                <input placeholder="Date of Birth" type="date" name="dob" min="<?php echo $dateMinus16?>" max="<?php echo $dateToday?>" value="<?php echo $dob?>"/> </br>
                <input class="btn" type="submit" value="Edit" name="edit" />
            </form>
			</div>
		</div>
	</div>
</div>
<?php include( '../footer.php' ); ?>
