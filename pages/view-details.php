<?php
/**
 * Emerdency-Live - view-details.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 21/05/2018
 * Time: 17:45
 * Description :
 */

include( "../php/patients.php" );

session_start();

$details = getPatientDetailsById($_SESSION["userId"]);
$minor = getAssociatedMinors($_SESSION["userId"]);

if ($details) {
	if ( mysqli_num_rows( $details ) > 0 ) {
		while ( $row = mysqli_fetch_assoc( $details ) ) {
			$patientId      = $row["id"];
			$first_name     = $row["first_name"];
			$last_name      = $row["last_name"];
			$address = $row["house_no_name"]. " ".$row["address_line_1"];
			if($row["address_line_2"]){
				$address .= ", ".$row["address_line_2"];
			}
			$address .= ", ".$row["town_city"].", ".$row["postcode"];
			$dob = date( 'd/m/y', strtotime( $row["dob"] ) );
			$contact_no     = $row["contact_no"];
			$email          = $row["email_address"];
		}
	}
}

include( '../header.php' );
?>

<div class="main-content">
	<h1 class="page-title">View Details</h1>
	<div class="inner-row">
		<div class="col-1">
            <input class="btn back" type="button" value="Back" onclick="window.history.back();">
            <div class="details-list">
                <h2>Your Details: </h2>
                <ul class="appointmentlist details patient-account">
                    <div class="col-3"><h4>Name: </h4><? echo $first_name ." ".$last_name?></div>
                    <div class="col-3"><h4>Date of Birth: </h4><?php echo $dob?></div>
                    <div class="col-3"><h4>Email Address:</h4><?php echo $email ?></div>
                    <div class="col-3"><h4>Address:</h4><?php echo $address ?></div>
                    <div class="col-3"><h4>Contact Number:</h4><?php echo $contact_no ?></div>
                </ul>
	            <?php if ($minor){
		            if (mysqli_num_rows($minor) > 0 ){
		                $row = mysqli_num_rows($minor);
		                $height = $row * 100;
			            $heightM = $row * 400;
			            echo "<h2>Associated Children: </h2>";
			            echo "<ul style='@media only screen and (max-width: 1050px) { min-height : ".$heightM."px; } @media only screen and (min-width: 1050px) { min-height: ".$height."px; } ' class='appointmentlist details'>";
			            while ($row = mysqli_fetch_assoc($minor)){
				            $dob = date( 'd/m/y', strtotime( $row["dob"] ) );
				            echo "<div class='col-2'><h4>Child Name: </h4>".$row["minorName"]."</div>";
				            echo "<div class='col-2'><h4>Date of Birth:</h4>".$dob."</div>";
			            }
			            echo "</ul>";
		            }
	            }
	            ?>

            </div>
		</div>
	</div>
<?php include( '../footer.php' ); ?>
