<?php 
	
	include( 'php/forgotPassword.php' );

	$email = $exist = $emailErr = "";
	
	// If form has been submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST["email"];
		// Check if email exists
		$exist = searchEmail($email);
			if($exist){
				// Send Email
				$done = sendResetEmail($email);
				header("Location:pages/reset-sent");
				exit();
			} else {
				// Email is not in DB, display error
				$emailErr = "We were unable to identify you. Please check and re-enter your email address.";
			}
	}

	$title = "Forgot Your Password? | Emerdency ";
	$description = "Have you forgotten your password? No need to panic, just enter your email address follow the instructions to recover your account at Emerdency.";

	include ("header.php");
?>
<div class="main-content">
	<h1 class="page-title">Forgot Your Password?</h1>
	<div class="inner-row">
		<div class="col-1">
			<span class="error"><?php echo $emailErr;?> </span>
			<p>Forgot your password? Enter your email address below and follow the instructions in the email to set up a new password. </p>
    		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
         		<input placeholder="Email" type="email" name="email" required /> </br>
        		<input class="btn" type="submit" value="Reset My Password" />
  			</form>
		</div>
	</div>
</div>
<?php include( 'footer.php' ); ?>
