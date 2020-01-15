<?php
/**
 * Emerdency-Live - practice-bookings.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 02/05/2018
 * Time: 17:47
 * Description :
 */

session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index.php");
}
include( '../header.php' );
?>
	<div class="main-content">
		<h1 class="page-title">Reports - Practice Bookings</h1>
		<div class="inner-row">
			<input class="btn back" type="button" value="Back" onclick="history.back()">

			<a class="btn black" href="reports-practice">Practice</a>
			<a class="btn black" href="reports-dentist">Dentist</a>
		</div>
<?php include( '../footer.php' ); ?>