<?php
/**
 * Emerdency - thank-you.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/03/2018
 * Time: 17:15
 * Description :
 */
	session_start();

// Check what type - if not correct/no type redirect to relevant page
/*switch ($_SESSION["apptType"]){
	case "1" :
		break;
	case "2" :
		header("Location:tel-booking-confirmation");
		exit();
		break;
	default :
		header("Location:../");
		exit();
		break;
}*/
    if ($_SESSION["appt"]) {
	    // Get Appt Data and assign to variable
	    $appt         = $_SESSION["appt"];
	    $practiceName = $appt[0];
	    $dentistName  = $appt[2];
	    $address      = $appt[3];
	    $date         = $appt[4];
	    $time         = $appt[5];
	    $contactNo    = $appt[7];
	    $disAccess    = $appt[8];
	    switch ( $disAccess ) {
		    case 0 :
			    $disAccess = "No";
			    break;
		    case 1 :
			    $disAccess = "Yes";
	    }

	    // Unset redundant Session Variables
	    //unset($_SESSION["authID"]);
	    unset($_SESSION["appt"]);
	    unset($_SESSION["apptId"]);
	    unset($_SESSION["apptTime"]);
	    unset($_SESSION["apptDate"]);
	    unset($_SESSION["apptType"]);
    } else {
        header("Location:booking-confirmation");
    }

	include( '../header.php' );
	?>

	<h1 class="page-title">Thank you</h1>
	<div class="inner-row">
		<div class="col-1">
            <img class="imgProcess" src="../images/the-process-details.png">
            <p>Thank you for your payment. Your transaction has been completed. Please check your email for the receipt. If you do not receive the email after a couple of minutes, please check the spam/junk mail.</p>
            <p>Below are your appointment details, they can also be viewed at any time in the <a class="orange-text">My Account</a> section.</p>
            <ul class="appointmentlist confirmation thank">
                <div class="col-3">
                    <h2>Date: </h2>  <?php echo $date; ?>
                </div>
                <div class="col-3">
                    <h2>Time: </h2>  <?php echo $time; ?>
                </div>
                <div class="col-3">
                    <h2> Dentist Name: </h2> Dr. <?php echo $dentistName; ?>
                </div>
                <div class="col-3">
                    <h2>Practice Name: </h2> <?php echo $practiceName; ?>
                </div>
                <div class="col-3 address">
                    <h2>Address: </h2><?php echo $address; ?>
                </div>
                <div class="col-3">
                    <h2> Contact Number: </h2> <?php echo $contactNo; ?>
                </div>
                <div class="col-3">
                    </br><label>Wheelchair Access required: </label> <?php echo $disAccess ?>
                </div>
            </ul>
			<a class="btn" href="my-account">My Account</a>
    </div></div>

<?php include( '../footer.php' ); ?>