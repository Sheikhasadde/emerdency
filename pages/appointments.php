<?php
/**
 * Emerdency - appointments.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/04/2018
 * Time: 10:48
 * Description :
 */

// require("../includes/db_connect.php");
// include ("../php/appointments.php");

// session_start();

// if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
// 	$userId = $_SESSION["userId"];
//     $results = getDetails($userId);
// } else {
// 	header("Location:../login");
// }


// include "../header.php";

?>
	<h1 class="">Appointments</h1>
	<div class="inner-row">
		<div class="col-1">
			<?php
			if (mysqli_num_rows($results)) {
				echo "<h2>Your appointment  bookings are as follows: </h2><br/>";
				foreach ($results as $row){
				    $patientName = $row["patientName"];
                    $minorName = $row["minorName"];
				    $apptType = $row["type"];
					$practiceName = $row["practiceName"];
					$dentistName = $row["first_name"]." ".$row["last_name"];
					$time = $row["time"];
					$address = $row["address_line_1"];
					if($row["address_line_2"]){
						$address .= ", ".$row["address_line_2"];
					}
					$address .= ", ".$row["city"].", ".$row["postcode"]." ";
					$contactNo = $row["contact_no"];
					$dateStr = strtotime($row["start_date"]);
					$date = date('l jS F Y',$dateStr);
					$time = date('g:i A',$dateStr);
					echo "	<div class='panel panel-default'>
					<div class='panel-heading'><h2>Your Details: </h2></div>
				  
					<div class='panel-body'>";
						    if ($apptType == 2){
							    echo "<ul class='appointmentlist account tel'>";
							    echo "<div class='col-1'>";
							    if ($minorName){
								    echo "<h3>".$minorName."</h3>";
							    } else {
								    echo "<h3>".$patientName."</h3>";
							    }
							    echo "</div>";
							    echo "<div class='col-3'>
                                    <h4>Dentist Name: </h4> Dr. ".$dentistName."
                                  </div>
						          <div class='col-3'>
						            <h4>Date: </h4>".$date."
						          </div>
            			          <div class='col-3'>
            			            <h4>Time: </h4>".$time."
            			          </div>";
							     echo "<div class='col-3'>
            			            <h4 class='orange-text telh4'>Telephone Appointment</h4>
            			          </div>";
						    } else {
							    echo "<ul class='appointmentlist account'>";
							    echo "<div class='col-1'>";
							    if ($minorName){
								    echo "<h3>".$minorName."</h3>";
							    } else {
								    echo "<h3>".$patientName."</h3>";
							    }
							    echo "</div>";
						        echo "<div class='col-3-row'>";
						            echo "<div class='col-3'>
                                     <h4>Practice Name:</h4>".$practiceName."
                                    </div>";
						            echo "<div class='col-3'>
                                        <h4>Address: </h4> ".$address."
                                    </div>";
						            echo " <div class='col-3'> 
                                        <h4>Contact Number: </h4>".$contactNo."
                                   </div>";
							    echo "</div>";
							    echo "<div class='col-3-row'>";
            			            echo "<div class='col-3'>
                                        <h4>Dentist Name: </h4> Dr. ".$dentistName."
                                    </div>
						            <div class='col-3'>
						                <h4>Date: </h4>".$date."
						            </div>
            			            <div class='col-3'>
            			                <h4>Time: </h4>".$time."
            			            </div>";
            			        echo "</div>";
						    }
						if (($row["status"] == 3 || $row["status"] == 4)){
            			    echo "<div class='col-3'><h4 class='orange-text'>Completed Appointment</h4></div>";
            			    if ($row["status"] == 3){
            			        $token = base64_encode($row["appointmentId"]);
            			        echo "<a class='btn' href='leave-review.php?appointment=".$token."'>Leave Review</a>";
                        	}
                        }
					    echo "</ul>";
					echo "</div></div>";
                    }
			} else{
				echo "<h2 class='cw'>No Appointments have been booked.</h2>";
			} ?>
		</div>
	</div>
<?php // include('../footer.php'); ?>