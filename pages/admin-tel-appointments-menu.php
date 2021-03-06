<?php
/**
 * Emerdency-Live - admin-appointments-menu.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 16/05/2018
 * Time: 19:55
 * Description :
 */

session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

include( '../header.php' );
?>
	<div class="main-content">
	<h1 class="page-title">Telephone Appointments</h1>
	<div class="inner-row">
		<div class="col-1">
			<?php
			if ($_SESSION["successMsg"]){
				echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
				unset($_SESSION["successMsg"]);
			}
			?>
            <input class="btn back" type="button" value="Back" onclick="window.location.replace('admin-account')">
			<a class="btn black" href="tel-available-appointments">Available Appointments</a>
			<a class="btn black" href="tel-booked-appointments">Booked Appointments</a>
			<a class="btn black" href="tel-unbooked-appointments">Unbooked Appointments</a>
            <a class="btn black" href="tel-appointments-by-date">Booked Appointments by Date</a>
		</div>
	</div>
<?php include( '../footer.php' ); ?>