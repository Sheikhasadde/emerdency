<?php
	require("../includes/db_connect.php");

	// Start Session & get User ID
	session_start();
	$userId = $_SESSION["userId"];
	$confirmed = $_SESSION["confirmed"];

	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
	} else {
		header("Location:../login");
	}
	
	include('../header.php');
?>

<div class="main-content">
	<h1 class="page-title">My Account</h1>
	<div class="inner-row">
		<div class="col-1">
            <?php
            if ($_SESSION["successMsg"]){
					echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
					unset($_SESSION["successMsg"]);
				}
            switch ($confirmed){
	            case "0" :
            	  echo "<h2>Please confirm your account.</h2>";
	              echo "<a class=\"btn black \" href=\"appointments\">Appointments</a> </br>";
	              echo "<a class=\"btn black \" href=\"add-child\">Add Child Patient to Account</a> </br>";
                  echo "<a class=\"btn black \" href=\"change-password\">Change my Password</a> </br>";
                  echo "<a class=\"btn black \" href=\"view-details\">View Details</a> </br>";
                  echo "<a class=\"btn black \" href=\"edit-account-details\">Edit Details</a> </br>";
                  echo "<a class=\"btn\" href=\"../php/logout.php\">Logout</a>";
                  break;
                case "1" :
                    echo "<a class=\"btn black\" href=\"appointments\">Appointments</a> </br>";
	              echo "<a class=\"btn black\" href=\"add-child\">Add Child Patient to Account</a> </br>";
                  echo "<a class=\"btn black\" href=\"change-password\">Change my Password</a> </br>";
                  echo "<a class=\"btn black\" href=\"view-details\">View Details</a> </br>";
                  echo "<a class=\"btn black\" href=\"edit-account-details\">Edit Details</a> </br>";
                  echo "<a class=\"btn\" href=\"../php/logout.php\">Logout</a>";
                    break;
                case "2" :
                    echo "<h2>There is a problem with this account. Please use the contact form to request support.</h2>";
                    break;
            }?>
		</div>
	</div>
</div>
<?php include('../footer.php'); ?>