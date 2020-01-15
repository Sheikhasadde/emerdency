<?php
/**
 * Emerdency - dentist-account.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/03/2018
 * Time: 12:56
 * Description :
 */

    session_start();
    $userId = $_SESSION["userId"];
    $confirmed = $_SESSION["confirmed"];

    if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] !== '2'){
        header("Location:dentist-login");
    }

    include('../header.php');
?>
	<div class="main-content">
		<h1 class="page-title">My Account - <?php echo $_SESSION["gdcNo"]?></h1>
		<div class="inner-row">
			<div class="col-1">
				<?php
				if ($_SESSION["successMsg"]){
					echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
					unset($_SESSION["successMsg"]);
				}
            switch ($confirmed){
	            case "0" :
	              echo "<h2>Please confirm your account to gain access to the dentist portal.</h2>";
                  break;
                case "1" :
                    echo "<a class=\"btn black\" href=\"appointment-slots\">Appointment Slots</a>";
                    echo "<a class=\"btn black\" href=\"ongoing-appointments\">On-going Appointments</a>";
                    echo "<a class=\"btn black\" href=\"previous-appointments\">Previous Appointments</a>";
                    echo "<a class=\"btn black\" href=\"edit-details\">Edit Details</a>";
                    echo "<a class=\"btn black\" href=\"change-password\">Change Password</a>";
                    echo "<a class=\"btn\" href=\"../php/logout.php\">Logout</a>";
                    break;
                case "2" :
                    echo "<h2>There is a problem with this account. Please contact us at    info@emerdency.co.uk .</h2>";
                    break;
             }?>
			</div>
		</div>
    <script src="../scheduler/dhtmlxscheduler.js" type="text/javascript" async></script>
<?php include('../footer.php'); ?>