<?php
/**
 * Emerdency-Live - tel-search-results.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 01/05/2018
 * Time: 13:47
 * Description :
 */

include( "php/tel-search.php" );
include( "php/contact-form.php" );

session_start();

// Perform Search
$appts = performTelSearch();
include('header.php');
?>
<div class="col-md-12 page-header" >

</div>
<div class="col-md-10 col-md-offset-2">
<h1 class="page-title">Telephone Consultation</h1>
</div>

<div class="col-md-12">
	<div class="col-md-8 col-md-offset-2 bg-dark" style="border-radius: 20px">
		<?php
		if (mysqli_num_rows($appts) > 0 ) {
		   
				if($error){echo "<span class='error'>{$error}</br></span>";}
				if($_SESSION["errUnavailable"]){
			          echo "<br/><h2 class='error'>{$_SESSION["errUnavailable"]}</br></h2>"; unset($_SESSION["errUnavailable"]);
				}
			foreach ($appts as $appt) {
				$dateStr = strtotime($appt["start_date"]);
				$date = date('l jS F Y',$dateStr);
				$time = date('g:i A',$dateStr);

				echo " <ul class='appointmentlist'>";
				echo "<div class='col-2'>";
				echo "<li>Date: ".$date."</li>";
				echo "<li>Time: ".$time."</li>";
				echo "</div>";
				echo "<div class='col-2'>";
				echo "Dentist Rating: ";
				echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$appt["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
				echo "<a data-fancybox data-type='iframe' data-src='pages/dentist-review.php?dentistId={$appt["dentist_id"]}' href='javascript:;' class='btn review' data-small-btn='true'>See Reviews</a>";
				echo "</div>";

				echo "<form method='post' action='pages/tel-booking-confirmation'>";
				echo "<input name='apptTime' type='hidden' value='".$time."' />";
				echo "<input name='apptDate' type='hidden' value='".$date."' />";
				echo "<input name='apptId' type='hidden' value='".$appt["id"]."' />";
				echo "<input name='apptType' type='hidden' value='2' />";
				echo "<input class='btn book' type='submit' value='Book Appointment' />";
				echo "</form>";
				echo "</ul>";
			}
		} else {
		        if($error){echo "<span class='error'>{$error}</br></span>";}
				if($_SESSION["errUnavailable"]){
			          echo "<br/><span class='error'>{$_SESSION["errUnavailable"]}</br></span>"; unset($_SESSION["errUnavailable"]);
				}
		      
				echo "<h2 class='ho'>Sorry</h2>";
				echo "<p class='cw'>No telephone bookings are currently available. Please enter your email address and contact number below and we shall contact you as soon as an appointment becomes available.</p>";
				//echo "<button class='btn black'>Contact</button>";
				if($error2){echo "<span class='error'>{$error2}</br></span>";}
				echo "<form method='post' action=".htmlspecialchars('php/contact.php').">";
				echo "<input type='hidden' name='type' value='tel' />";
				echo "<div class='col-2'>";
				echo "<input type='number' name='contactNo' placeholder='Phone Number' /> ";
				echo "</div>";
				echo "<div class='col-2'>";
				echo "<input placeholder='Email Address' type='email' name='email' required />";
				echo "</div>";
				echo '<div class="col-md-6 col-md-offset-3" >';
				echo "<input class='btn' style='background:#e8541c; margin-bottom:50px;' type='submit' name='searchContact' value='Submit' />";
				echo "</div><br><br><br><br><br>";
				echo "</form>";
		}
		?>
	</div>
</div>
<?php include( 'footer.php' ); ?>
