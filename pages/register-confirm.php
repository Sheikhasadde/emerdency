<?php 
	include("../includes/functions.php");
	include ("../php/account.php");
	$error = "";
	
	$token = $_GET["token"];
	
	$email = verifyToken($token);
	
	$error = confirmAccount($email);
	
	include('header.php');
    ?>

    <div class="main-content">
    <div class="col-md-12 page-header" >

</div>
<div class="col-md-10 col-md-offset-2">
<h1 class="page-title">My Account</h1>
</div>
	
	<div class="col-md-12" style="height:600px; margin-bottom:40px;">
	<div class="col-md-8 col-md-offset-2" style="background:#2A2930; border-radius:20px; height:100%;">
	<br><br><br><br><br><br>
       
       
            <div class="col-md-6 col-md-offset-3">
                <span class="error"><?php echo $error ?></span>
                <h2 class="cw">Thank you for confirming your email address.</h2>
                <p class="cw">Registration is now complete. </p>
                <a class="btn" href="../login">Login</a>
            </div>
        </div>
    </div>
<?php include('footer.php'); ?>