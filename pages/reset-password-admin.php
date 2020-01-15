<?php
/**
 * Emerdency-Live - reset-password-admin.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 30/04/2018
 * Time: 19:32
 * Description :
 */

include("../php/forgotPassword.php");

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
		// Send Email
		$done = sendResetEmail($email);
		$_SESSION["successMsg"] = "Reset email has successfully been sent.";
		header("Location:admin-account");
		exit();
	} else {
		// Email is not in DB, display error
		$emailErr = "We were unable to identify the account. Please check and re-enter your email address.";
	}
}

include('../header.php');
?>
<div class="main-content">
	<h1 class="page-title">Administrator Account - Reset User/Dentist Password</h1>
	<div class="inner-row">
		<div class="col-1">
          <input class="btn back" type="button" value="Back" onclick="history.back()">
            <? if ($emailErr){
            echo "<span class='error'><p>{$emailErr}</p></span>";
            unset($emailErr);
            } ?>
		  <p>Please enter the email address of the account you wish to reset the password of: </p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input placeholder="Email" type="email" name="email" required /> </br>
                <input class="btn" type="submit" value="Reset Password" />
            </form>
		</div>
	</div>
<?php include('../footer.php'); ?>