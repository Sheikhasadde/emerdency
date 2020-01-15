<?php
	session_start();
	
	include( "php/user-login.php" );

	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
		header("Location:pages/my-account");
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	 	$email = $_POST["email"];
		$password = $_POST["password"];

		$success = login($email,$password);

		if ($success) {
		    if ($success == "1") {
			    $_SESSION["loggedIn"] = '1';
			    header( "Location:pages/my-account" );
			    exit();
		    }
		} else {
			$error = "Login Failed. Please try again.";
		}
	}

	$title = "Login To Your Emergency Patient Account | Emerdency";
	$description = "This is the patient login portal at Emerdency. A returning patient? Enter your email address and password to login to your Emerdency account.";

    include ("header.php");
?>
<h1 class="page-title">Login</h1>
<div class="inner-row">
	<div class="col-1">
    	<span class="error"><?php if($error != ""){echo $error."</br>";}?></span>
        <br/>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    		<input placeholder="Email Address" type="text" name="email"/> </br>
        	<input placeholder="Password" type="password" name="password"/> </br>
        	<button class="btn" type="submit" name="btnLogin">Login</button>
    	</form>
   		<a class="btn" href="forgot-password">Forgot your password?</a>
    	<a class="btn black" href="register">Register</a>
    </div>
</div>
 <?php include( 'footer.php' ); ?>