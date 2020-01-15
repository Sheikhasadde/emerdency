<?php
    include( "php/user-login.php" );

    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '2'){
	    header("Location:pages/dentist-account");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    $email    = $_POST["email"];
	    $password = $_POST["password"];

	    $type = login( $email, $password );

	    if ( $type == "2" ) {
		    $_SESSION["loggedIn"]   = '2';
		    $_SESSION["telAdvice"]  = checkIfTelAdvice( $_SESSION["userId"] );
		    $_SESSION["gdcNo"]      = getGDCNo( $_SESSION["userId"] );
		    $_SESSION["practiceId"] = getPracticeId( $_SESSION["userId"] );
		    header( "Location:pages/dentist-account" );
		    exit();
	    } else {
		    $error = "Login Failed. Please try again.";
	    }
    }
    $title = "Login To Your Emergency Dental Account | Emerdency";
    $description = "This is the dentist login portal at Emerdency. Enter your email address and password to login to the Dentists portal. ";

    include ("header.php");
?>
<div class="main-content">
    <h1 class="page-title">Dentist Login</h1>
    <div class="inner-row">
        <div class="col-1">
            <span class="error"><?php if($error != ""){echo $error."</br>";}?></span>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input placeholder="Email Address" type="text" name="email"/> </br>
                <input placeholder="Password" type="password" name="password"/> </br>
                <button class="btn" type="submit" name="btnLogin">Login</button>
            </form>
            <a class="btn" href="forgot-password">Forgot your password?</a>
        </div>
    </div>
<?php include( 'footer.php' ); ?>