<?php
	// session_start();
	
	include("../php/login-NW.php");
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	 	$email = $_POST["email"];
		$password = $_POST["password"];
	
		$valid = login($email,$password);
		
		if ($valid == "1") {
			$_SESSION["loggedIn"] = '1';
			echo "<script type='text/javascript'>parent.jQuery.fancybox.close();</script>";
			exit();	
		} else {
			$error = "Login Failed. Please try again.";
		}
	}
	
	if(isset($_SESSION['resetPass']) && $_SESSION['resetPass'] === 1){
		$error = "We've emailed you instructions for resetting your password.";
		unset($_SESSION["resetPass"]);
	}
	
	// include("../header-lightbox.php");
?>

<h1 class="page-title">Login</h1>
<div class="inner-row">
	<div class="col-1">
		<span class="error"><?php if($error != ""){echo $error."</br>";}?></span>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" ><!--onsubmit="javascript:parent.jQuery.fancybox.close();"-->
    		<input placeholder="Email Address" type="text" name="email"/> </br>
        	<input placeholder="Password" type="password" name="password"/> </br>
        	<button class="btn" type="submit" name="btnLogin">Login</button>
    	</form>
    	<!-- <a class="btn" href="register-lightbox">Register</a> -->

    	<a class="btn black" href="forgot-password-lightbox">Forgot your password?</a>
        <script>
            function closeLightbox(){
                parent.closeFancyBox = function () {
                    $.fancybox.close();
                };
            }
        </script>
    </div>
</div>
    
 <?php // include('../footer-lightbox.php'); ?>