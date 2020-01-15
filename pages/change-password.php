<?php 	
	include("../includes/functions.php");
	
	session_start();
	
	$email = $resetErr = $success = "";

	// If form has been submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {	
		$userId = $_SESSION["userId"];
		
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
	
	include('../header.php'); 
?>

<div class="main-content">

<h1 class="page-title">Change Password</h1>
<div class="inner-row">
<div class="col-1">
	<span class="error"><?php echo $resetErr;?> </span>
    <p>Please enter your new password below :</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input placeholder="Password" type="password" name="password1" required /> </br>
        <input placeholder="Confirm Password" type="password" name="password2" required  /> </br>
        <input class="btn" type="submit" value="Reset Password" />
   </form>
</div>
</div>

</div>
<?php include('../footer.php'); ?>
