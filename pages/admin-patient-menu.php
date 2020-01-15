<?php
/**
 * Emerdency-Live - admin-patient-menu.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 27/04/2018
 * Time: 19:52
 * Description :
 */
session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

include( '../header.php' );
?>
	<div class="main-content">
	<h1 class="page-title">Patient</h1>
	<div class="inner-row">
		<div class="col-1">
            <input class="btn back" type="button" value="Back" onclick="window.location.replace('admin-account')">
			<?php
			if ($_SESSION["successMsg"]){
				echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
				unset($_SESSION["successMsg"]);
			}
			?>
            <a class="btn black" href="patient-list">Patient List</a>
            <a class="btn black" href="edit-patient">Edit Patient Details</a>
            <a class="btn black" href="edit-child-patient">Edit Child Patient Details</a>
            <a class="btn black" href="suspend-account">Suspend Patient Account</a>
		</div>
	</div>
<?php include( '../footer.php' ); ?>