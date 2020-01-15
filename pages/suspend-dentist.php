<?php
/**
 * Emerdency-Live - suspend-dentist.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 21/05/2018
 * Time: 14:06
 * Description :
 */

include( "../php/forgotPassword.php" );
include( "../php/dentist.php" );

session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST["email"];
	// Check if email exists
	$exist = searchEmail($email);
	if($exist){
		if ($_POST["suspend"]){
			suspendAccount($email);
			$_SESSION["successMsg"] = "Account has successfully been suspended.";
			header("Location:admin-account");
			exit();
		}
		if ($_POST["unsuspend"]){
			reactivateAccount($email);
			$_SESSION["successMsg"] = "Account has successfully been un-suspended.";
			header("Location:admin-account");
			exit();
		}
	} else {
		// Email is not in DB, display error
		$emailErr = "We were unable to identify the account. Please check and re-enter your email address.";
	}
}

include( '../header.php' );
?>
	<div class="main-content">
	<h1 class="page-title">Administrator Account - Suspend Dentist Account</h1>
	<div class="inner-row">
		<div class="col-1">
			<input class="btn back" type="button" value="Back" onclick="history.back()">
			<? if ($emailErr){
				echo "<span class='error'><p>{$emailErr}</p></span>";
				unset($emailErr);
			} ?>
			<p>Please enter the email address of the account:</p>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<input placeholder="Email" type="email" name="email" required /> </br>
				<input class="btn" type="submit" name="suspend" value="Suspend Account" />
				<input class="btn" type="submit" name="unsuspend" value="Un-suspend Account" />
			</form>
		</div>
	</div>
<?php include( '../footer.php' ); ?>