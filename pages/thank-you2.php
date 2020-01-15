<?php
/**
 * Created by PhpStorm.
 * User: Aamir
 * Date: 07/05/2018
 * Time: 00:39
 */
session_start();

// Get Appt Data and assign to variable
$appt = $_SESSION["appt"];
$practiceName = $appt[0];
$dentistName = $appt[2];
$address = $appt[3];
$date = $appt[4];
$time = $appt[5];

// Unset redundant Session Variables
unset($_SESSION["appt"]);
unset($_SESSION["apptId"]);
unset($_SESSION["apptTime"]);
unset($_SESSION["apptDate"]);

include('../header.php');
?>

    <h1 class="page-title">Thank you</h1>
    <div class="inner-row">
        <div class="col-1">
            <br/>
            Thank you for your payment. Below are your appointment details, they can also be viewed at any time in the My Account section. </br></br>
            Practice Name: <?php echo $practiceName; ?>  </br>
            Dentist Name:  Dr. <?php echo $dentistName; ?> </br>
            Address:  <?php echo $address; ?> </br>
            Date:  <?php echo $date; ?> </br>
            Time:  <?php echo $time; ?> </br>
            <a class="btn black" href="my-account">My Account</a>
        </div></div>

<?php include('../footer.php'); ?>