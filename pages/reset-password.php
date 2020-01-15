<?php 	
	include("../includes/functions.php");
	
	$email = $resetErr = $success = "";

	$token = $_GET["token"];
	
	$email = verifyToken($token);
	
	if ($email === 0){
		$resetErr = "Invalid token. Please request to reset your password again.";
	}
	
	// If form has been submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {	
		$email = $_POST["email"];
	
		if($email) {
			$password = $_POST["password1"];
			$password2 = $_POST["password2"];
		
			// Check if passwords match
			if ($password == $password2){	
				$success = resetPassword($email,$password);
				if ($success){
				    // Redirect to Login Page
		            header("Location:reset-complete");
	            } else {
					$resetErr = "An error has occurred. Please attempt to reset your password again. If this issue persists please contact admin@emerdency.com.";
				}
			} else {
				$resetErr = "Passwords do not match. Please try again.";
			}
		} else {
			$resetErr = "Invalid token. Please request to reset your password again.";
		}
	}
	
	include('../header.php'); 
?>

<div class="main-content">

<h1 class="page-title">Reset Password</h1>
<div class="inner-row">
<div class="col-1">
	<span class="error"><?php echo $resetErr;?> </span>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    	<input type="hidden" name="email" value="<?php echo $email ?>" />
        <p>Please enter your new password below: </p>
        <input placeholder="Password" type="password" name="password1" required /> </br>
        <input placeholder="Confirm Password" type="password" name="password2" required  /> </br>
        <input class="btn" type="submit" value="Reset Password" />
   </form>
</div>
</div>

</div>
<?php include('../footer.php'); ?>
