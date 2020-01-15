<?php
/**
 * Emerdency - admin-account.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/03/2018
 * Time: 13:35
 * Description :
 */

session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

include( '../header.php' );
?>
	<div class="main-content">
	    <h1 class="page-title">Administrator Account</h1>
	<div class="inner-row">
		<div class="col-1">
            <?php
            if ($_SESSION["successMsg"]){
	            echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
	            unset($_SESSION["successMsg"]);
            }
            ?>
            <a class="btn black" href="admin-appointments-menu">Appointments</a>
            <a class="btn black" href="admin-tel-appointments-menu">Telephone Appointments</a>
            <a class="btn black" href="admin-patient-menu">Patient</a>
            <a class="btn black" href="admin-dentist-menu">Practice & Dentist</a>
            <a class="btn black" href="admin-review-menu">Reviews</a>
            <a class="btn black" href="reports">Reports</a>
            <a class="btn black" href="reset-password-admin">Reset Patient/Dentist Password</a>
            <a class="btn" href="../php/logout.php">Logout</a>
		</div>
	</div>
<?php include( '../footer.php' ); ?>