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
	if($_POST["select"]){
		$email = $_POST["email"];
		$details = getAssociatedMinorsByEmail($email);
	}
}

if ($details){
    if (mysqli_num_rows($details) == 0 ){
	    $error = "User was not found or has no associated children. Please try again.";
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
				Please enter the email address of the Parent:
				<input placeholder="Email Address" type="email" name="email" value="<?php echo $email ?>" required /> </br>
				<input class="btn" type="submit" value="Select" name="select" />
			</form>
			<div id="hidden_fields">
				<form class="appointment-form" method="post" action="<?php echo htmlspecialchars('edit-child-patient-details');?>">
                    <?php if ($details){
                    if (mysqli_num_rows($details) > 0 ){
                        echo "<form class='appointment-form' method='post' action='".htmlspecialchars($_SERVER["PHP_SELF"])."''>";
                        echo "<select class='customSelect black' name='minorId'>";

                        while ($row = mysqli_fetch_assoc($details)){
                            $minorId = $row["id"];
                            $minorName = $row["minorName"];
                            echo "<option value='".$minorId."'>".$minorName."</option>";
                            $dob = $row["dob"];
                        }

                        echo "</select>";
                        echo "<input class=\"btn\" type=\"submit\" value=\"Select Child\" name=\"selectChild\" />";
                    }
                    }
                    ?>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include( '../footer.php' ); ?>
