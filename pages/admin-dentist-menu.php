<?php
/**
 * Emerdency-Live - admin-dentist-menu.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 18/04/2018
 * Time: 16:15
 * Description :
 */
session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

include( '../header.php' );
?>
<div class="main-content">
	<h1 class="page-title">Practice/Dentist</h1>
	<div class="inner-row">
		<div class="col-1">
			<?php
			if ($_SESSION["successMsg"]){
				echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
				unset($_SESSION["successMsg"]);
			}
			?>
            <input class="btn back" type="button" value="Back" onclick="window.location.replace('admin-account')">
			<h2>Practice</h2>
				<a class="btn black" href="create-practice">Create Practice</a>
				<a class="btn black" href="edit-practice">Edit Practice</a>
			<h2>Dentist</h2>
				<a class="btn black" href="create-dentist">Create Dentist</a>
				<a class="btn black" href="edit-dentist">Edit Dentist</a>
                <a class="btn black" href="suspend-dentist">Suspend Dentist Account</a>
		</div>
	</div>
<?php include( '../footer.php' ); ?>