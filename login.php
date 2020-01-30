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

<div class="col-md-12 page-header" >

</div>
<div class="col-md-10 col-md-offset-2">
    <h1 class="page-title">Login</h1>
</div>
<div class="col-md-12">
	
<div class="col-md-8 col-md-offset-2 contact-form-container" >
<div class="col-md-12" style="height:35px;">
<!-- // Empty space -->

	</div>
	<div class="col-md-8" ">
    	<span class="error"><?php if($error != ""){echo $error."</br>";}?></span>
        <br/>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<div class="col-md-8 col-md-offset-2">
			<input placeholder="Email Address" type="text" name="email" class="form-control" style="text-align:left;"/>
		</div> </br>
		<div class="col-md-8 col-md-offset-2">
			<input placeholder="Password" type="password" name="password" class="form-control" style="text-align:left;" /> 
		</div>
		</br>
		<div class="col-md-8 col-md-offset-2">
			<button class="btn" type="submit" name="btnLogin">Login</button>
		</div>
		</form>
		<div class="col-md-4 col-md-offset-2" style="margin-top:20px">
		   <a class="ho" href="forgot-password">Forgot your password?</a>
		</div>
		<div class="col-md-4 col-md-offset-2" style="margin-top:20px">
		<a class="ho" href="register">Register</a>
		</div>
	</div>
     <div class="col-md-4">
		 <img src="images/loginb.png" class="img-responsive" />
	 </div>
	 <div class="col-md-12" style="height:35px;">
<!-- // Empty space -->

	</div>

</div>
</div>
 <?php include( 'footer.php' ); ?>