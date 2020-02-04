<?php 	
	//include("../includes/functions.php");	
	
	
	 $email=$resetErr = $success = "";

	// If form has been submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {	
		
		
		$password = $_POST["password1"];
		$password2 = $_POST["password2"];
		
		// Check if passwords match
		if ($password == $password2){	
			$success = changePassword($userId,$password);
			
			if ($success) {
			    $_SESSION["successMsg"] = "Password has been successfully changed.";
			    // Is user a dentist
			    if ($_SESSION["gdcNo"]){
				    // Redirect to Dentist Account Page
				    header("Location:dentist-account");
				    exit();
                } else {
			        // User is patient
				    // Redirect to Login Page
				    header("Location:my-account");
				    exit();
                }
			} else {
				$resetErr = "An error has occurred. Please try again.";
			}
		} else {
			$resetErr = "Passwords do not match. Please try again.";
		}
	}
	
	
?>

<div class="main-content">

<h1 class="">Change Password</h1>
<div class="col-md-12">
<div class="col-md-8 col-md-offset-2">
	<span class="error"><?php echo $resetErr;?> </span>
    <p>Please enter your new password below :</p>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="col-md-6">
		<input placeholder="Password" type="password" name="password1" required /></div>
		<div class="col-md-6">
        <input placeholder="Confirm Password" type="password" name="password2" required  /></div>
		<div class="col-md-8 col-md-offset-2">
		<input class="btn bg-dark" type="submit" value="Reset Password" /></div>
   </form>
</div>
</div>

</div>

