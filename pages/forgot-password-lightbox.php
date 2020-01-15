<?php 
	session_start();
	
	include('../php/forgotPassword-lightbox.php');
	
	$email = $exist = $emailErr = "";
	
	// If form has been submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST["email"];
		// Check if email exists
		$exist = searchEmail($email);
			if($exist){
				// Send Email
				$done = sendResetEmail($email);
				$_SESSION["resetPass"] = 1;
				header("Location:login-lightbox");
			} else {
				// Email is not in DB, display error
				$emailErr = "We were unable to identify you. Please check and re-enter your email address.";
			}
	}
	include('../header-lightbox.php'); 
?>
<div class="main-content">
	<h1 class="page-title">Forgot Password</h1>
	<div class="inner-row">
		<div class="col-1">
            <input class="btn back" type="button" value="Back" onclick="window.location.replace('login-lightbox.php')">
			<span class="error"><?php echo $emailErr;?> </span>
			<p>Forgotten your password? Enter your email address below, and we'll email instructions for setting a new one.</p>
    		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
         		<input placeholder="Email" type="email" name="email" required /> </br>
        		<input class="btn" type="submit" value="Reset My Password" />
  			</form>
		</div>
	</div>
</div>
<?php include('../footer-lightbox.php'); ?>
