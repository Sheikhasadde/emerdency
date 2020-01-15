<?php
/**
 * Emerdency - admin-login.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/03/2018
 * Time: 13:32
 * Description :
 */

session_start();

include( "../php/login.php" );

if($_SESSION['loggedIn'] == 3){
	header("Location:../pages/admin-account");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST["email"];
	$password = $_POST["password"];

	$type = login($email,$password);

	if ($type == '3') {
		$_SESSION["loggedIn"] = 3;
		header( "Location:../pages/admin-account" );
		exit();
	} else {
		$error = "Login Failed. Please try again.";
	}
}

include( '../header.php' );
?>

	<div class="main-content">
	<h1 class="page-title">Administrator Login</h1>
	<div class="inner-row">
		<div class="col-1">
			<span class="error"><?php if($error != ""){echo $error."</br>";}?></span>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<input placeholder="Username" type="text" name="email"/> </br>
				<input placeholder="Password" type="password" name="password"/> </br>
				<button class="btn" type="submit" name="btnLogin">Login</button>
			</form>
		</div>
	</div>
<?php include( '../footer.php' ); ?>