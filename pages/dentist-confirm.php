<?php
/**
 * Emerdency - dentist-confirm.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/03/2018
 * Time: 15:38
 * Description :
 */

session_start();

include("../includes/functions.php");
include ("../php/account.php");

$email = $error = $success = "";

$token = $_GET["token"];

$email = verifyToken($token);

if ($email === 0){
	$error = "Invalid token.";
}
// If form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST["email"];
	if ($_POST["marketing"]) {
	    $marketing = 1;
	} else {
	    $marketing = 0;
	}

	if($email) {
		$password = $_POST["password1"];
		$password2 = $_POST["password2"];

		// Check if passwords match
		if ($password == $password2){
			$success = resetPassword($email,$password);
			if ($success) {
				confirmDentistAccount($email,$marketing);
				header("Location:account-confirm-complete");
				exit();
			}
		} else {
			$_SESSION["error"] = "Passwords do not match. Please try again.";
			header('Location: dentist-confirm?token='.$_POST["token"]);
		}
	} else {
		$error = "Invalid token.";
	}
}

include('../header.php');
?>
    <div class="main-content" xmlns="http://www.w3.org/1999/html">
	<h1 class="page-title">Confirm Account</h1>
	<div class="inner-row">
		<div class="col-1">
            <br/>
			<h3>We require you to setup a new password, please enter this below:</h3>
			<span class="error"><?php echo $_SESSION["error"]; ?> </span>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="hidden" name="token" value="<?php echo $token ?>" />
				<input type="hidden" name="email" value="<?php echo $email ?>" />
				<input placeholder="Password" type="password" name="password1" required /> </br>
				<input placeholder="Confirm Password" type="password" name="password2" required  /> </br>
                <div class="register-checkbox">
                    <input class="reg-check" name="terms" type="checkbox" required /><label class="regCheck">I accept the <a href="../dentist-terms" target="_blank">terms and conditions</a> </label><br/>
                    <input class="reg-check" name="details" type="checkbox" required /><label class="regCheck">I have read and understood section 7 of the terms and conditions and confirm that the data shared by Emerdency will be managed in accordance with the GDPR guidelines </label><br/>
                    <input class="reg-check" name="marketing" type="checkbox" /><label class="regCheck">I would like to receive information about products and services by email/telephone/text message </label><br/>
                </div>
				<input class="btn" type="submit" value="Register" />
			</form>
		</div>
	</div>
<?php include('../footer.php'); ?>