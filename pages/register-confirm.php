<?php 
	include("../includes/functions.php");
	include ("../php/account.php");
	$error = "";
	
	$token = $_GET["token"];
	
	$email = verifyToken($token);
	
	$error = confirmAccount($email);
	
	include('../header.php');
    ?>

    <div class="main-content">
        <h1 class="page-title">My Account</h1>
        <div class="inner-row">
            <div class="col-1">
                <span class="error"><?php echo $error ?></span>
                <h2>Thank you for confirming your email address.</h2>
                <p>Registration is now complete. </p>
                <a class="btn" href="../login">Login</a>
            </div>
        </div>
    </div>
<?php include('../footer.php'); ?>