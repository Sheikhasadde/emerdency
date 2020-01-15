<?php
/**
 * Emerdency-Live - remove-dentist-practice.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 16/05/2018
 * Time: 18:47
 * Description :
 */

include( "../php/dentist.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$dentistId = $_SESSION["dentistId"];
	$practiceId = $_POST["practiceId"];
	$success = removeDentistPracticeAssociation($practiceId, $dentistId);
	if ($success){
		$_SESSION["successMsg"] = "Practice association has successfully been removed ";
		header("location:edit-dentist");
		exit();
	}
}

$dentistId = $_SESSION["dentistId"];
$practices = getAssociatedPractices($dentistId);

include( '../header.php' );
?>
<div class="main-content">
	<h1 class="page-title">Remove Dentist Practice Association</h1>
	<div class="inner-row">
		<div class="col-1">
			<input class="btn back" type="button" value="Back" onclick="window.location.href='edit-dentist'">
				<?php
				while ($row = mysqli_fetch_assoc($practices)){
					echo "<h2>{$row["name"]}</h2>";
					echo "<form method='POST' action='" . htmlspecialchars( $_SERVER["PHP_SELF"] ) . "'>";
					echo "<input name='practiceId' type='hidden' value='{$row['id']}' />";
					echo "<input class='btn black' type='submit' name='remove' value='Remove Association' />";
				}
				?>
		</div>
	</div>
</div>
<?php include( '../footer.php' ); ?>
