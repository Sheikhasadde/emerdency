<?php
    include( "../includes/functions.php" );
	// include( "../php/search.php" );
	// include( "../php/contact.php" );

	session_start();

	if (!is_string($_SESSION["availAppts"][0])) {
        $appts = array();
        $appts = $_SESSION["availAppts"];
        $searchParams = $_SESSION['searchParams'];
        //unset($_SESSION['searchParams']);
        //unset($_SESSION['availAppts']);
	} else {
	    $error = $_SESSION["availAppts"][0];
        $searchParams = $_SESSION['searchParams'];
        unset($_SESSION['searchParams']);
        //unset($_SESSION['availAppts']);
	}

	include( 'header.php' );
?>

<div class="col-md-12 page-header-2" >

</div>
<div class="col-md-12">
<h2 class="text-left ho">Appointment with a Dentist</h2>
</div>
<div class="col-md-12">
<div class="col-md-8 col-md-offset-2 bg-dark">
    <?php
    /*
    echo "<pre>";
    var_dump($appts);
    echo "</pre>";*/
    if (count($appts[0])) {
			foreach ($appts[0] as $appt) {
				$dateStr = strtotime($appt["time"]);
				$date = date('l jS F Y',$dateStr);
				$time = date('g:i A',$dateStr);
				echo "<br/>";
				echo " <ul class='appointmentlist'>";
				  echo "<div class='inner-row appointmenttitle'>";
				  echo "<h3>Appointment Available in <strong>".$appt["practice_city"]." - ".$appt["distance"]." miles</strong> from your location</h3>";
				  echo "</div>"	;
				    echo "<div class='col-3'>";
						echo "<h2>Details</h2>";
						// NW Added 
						echo "<li>Location: ".$appt["practice_city"]."</li>";
						// EOF NW added
					    echo "<li>Date: ".$date."</li>";
					    echo "<li>Time: ".$time."</li>";
					    echo "<li>Distance: ".$appt["distance"]." miles</li>";
						echo "<div class='fulladdress'><p>Full address of Dental Pratice shown upon booking.</p></div>";
				    echo "</div>";
				    echo "<div class='col-3'>";
				        echo "<h2>Reviews</h2>";
						echo "Dentist Rating: ";
				        echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$appt["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
				        echo "<a data-fancybox data-type='iframe' data-src='dentist-review.php?dentistId={$appt["dentist_id"]}' href='javascript:;' class='btnreview review' data-small-btn='true'>See Reviews</a>";
				    echo "</div>";
					echo "<div class='col-3'>";
				        // echo "<h2>Price</h2>";
				        echo "<div class='bigprice'>Only<br/>£50</div>";
					    echo "<p>An initial booking fee of <strong>£15</strong> is charged online when the booking is made, followed by the remaining amount of <strong>£35</strong> taken at the dental practice.</p>";
				    echo "</div>";

					echo "<form method='post' action='booking-confirmation'>";
					echo "<input name='apptTime' type='hidden' value='".$time."' />";
					// NW Added
					echo "<input name='apptcity' type='hidden' value='".$appt["practice_city"]."' />";
					echo "<input name='apptmiles' type='hidden' value='".$appt["distance"]."' />";
					// EOF NW Added
					echo "<input name='apptDate' type='hidden' value='".$date."' />";
    				echo "<input name='apptId' type='hidden' value='".$appt["id"]."' />";
				    echo "<input name='disAccess' type='hidden' value='".$searchParams[2]."' />";
				    echo "<input name='apptType' type='hidden' value='1' />";
    				//echo $appt["id"];
        			echo "<input class='btnappointment book desktop' type='submit' name='booking' value='Reserve Appointment Now for just £15' />";
					echo "<input class='btnappointment book mobile' type='submit' name='booking' value='Reserve Now for £15' />";
    				echo "</form>";
  				echo "</ul>";
			}

			if (count($appts[1])){
			    echo "<h2>Sorry, there are no appointments available within your search area. We have found the following appointments outside of your search area.</h2>";
			    foreach ($appts[1] as $appt){
				    $dateStr = strtotime($appt["time"]);
				    $date = date('l jS F Y',$dateStr);
				    $time = date('g:i A',$dateStr);
				    echo "<br/>";
				    echo " <ul class='appointmentlist'>";
				    echo "<div class='inner-row appointmenttitle'>";
				    echo "<h3>Appointment Available in <strong>".$appt["practice_city"]." - ".$appt["distance"]." miles</strong> from your location</h3>";
				    echo "</div>"	;
				    echo "<div class='col-3'>";
				    echo "<h2>Details</h2>";
				    // NW Added
				    echo "<li>Location: ".$appt["practice_city"]."</li>";
				    // EOF NW added
				    echo "<li>Date: ".$date."</li>";
				    echo "<li>Time: ".$time."</li>";
				    echo "<li>Distance: ".$appt["distance"]." miles</li>";
				    echo "<div class='fulladdress'><p>Full address of Dental Pratice shown upon booking.</p></div>";
				    echo "</div>";
				    echo "<div class='col-3'>";
				    echo "<h2>Reviews</h2>";
				    echo "Dentist Rating: ";
				    echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$appt["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
				    echo "<a data-fancybox data-type='iframe' data-src='dentist-review.php?dentistId={$appt["dentist_id"]}' href='javascript:;' class='btnreview review' data-small-btn='true'>See Reviews</a>";
				    echo "</div>";
				    echo "<div class='col-3'>";
				    // echo "<h2>Price</h2>";
				    echo "<div class='bigprice'>Only<br/>£50</div>";
				    echo "<p>An initial booking fee of <strong>£15</strong> is charged online when the booking is made, followed by the remaining amount of <strong>£35</strong> taken at the dental practice.</p>";
				    echo "</div>";

				    echo "<form method='post' action='booking-confirmation'>";
				    echo "<input name='apptTime' type='hidden' value='".$time."' />";
				    // NW Added
				    echo "<input name='apptcity' type='hidden' value='".$appt["practice_city"]."' />";
				    echo "<input name='apptmiles' type='hidden' value='".$appt["distance"]."' />";
				    // EOF NW Added
				    echo "<input name='apptDate' type='hidden' value='".$date."' />";
				    echo "<input name='apptId' type='hidden' value='".$appt["id"]."' />";
				    echo "<input name='disAccess' type='hidden' value='".$searchParams[2]."' />";
				    echo "<input name='apptType' type='hidden' value='1' />";
				    //echo $appt["id"];
				    echo "<input class='btnappointment book desktop' type='submit' name='booking' value='Reserve Appointment Now for just £15' />";
				    echo "<input class='btnappointment book mobile' type='submit' name='booking' value='Reserve Now for £15' />";
				    echo "</form>";
				    echo "</ul>";
                }
            }

		} elseif (count($appts[1])){
	    echo "<h2>Sorry, there are no appointments available within your search area. We have found the following appointments outside of your search area.</h2>";
	    foreach ($appts[1] as $appt){
		    $dateStr = strtotime($appt["time"]);
		    $date = date('l jS F Y',$dateStr);
		    $time = date('g:i A',$dateStr);
		    echo "<br/>";
		    echo " <ul class='appointmentlist'>";
		    echo "<div class='inner-row appointmenttitle'>";
		    echo "<h3>Appointment Available in <strong>".$appt["practice_city"]." - ".$appt["distance"]." miles</strong> from your location</h3>";
		    echo "</div>"	;
		    echo "<div class='col-3'>";
		    echo "<h2>Details</h2>";
		    // NW Added
		    echo "<li>Location: ".$appt["practice_city"]."</li>";
		    // EOF NW added
		    echo "<li>Date: ".$date."</li>";
		    echo "<li>Time: ".$time."</li>";
		    echo "<li>Distance: ".$appt["distance"]." miles</li>";
		    echo "<div class='fulladdress'><p>Full address of Dental Pratice shown upon booking.</p></div>";
		    echo "</div>";
		    echo "<div class='col-3'>";
		    echo "<h2>Reviews</h2>";
		    echo "Dentist Rating: ";
		    echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$appt["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
		    echo "<a data-fancybox data-type='iframe' data-src='dentist-review.php?dentistId={$appt["dentist_id"]}' href='javascript:;' class='btnreview review' data-small-btn='true'>See Reviews</a>";
		    echo "</div>";
		    echo "<div class='col-3'>";
		    // echo "<h2>Price</h2>";
		    echo "<div class='bigprice'>Only<br/>£50</div>";
		    echo "<p>An initial booking fee of <strong>£15</strong> is charged online when the booking is made, followed by the remaining amount of <strong>£35</strong> taken at the dental practice.</p>";
		    echo "</div>";

		    echo "<form method='post' action='booking-confirmation'>";
		    echo "<input name='apptTime' type='hidden' value='".$time."' />";
		    // NW Added
		    echo "<input name='apptcity' type='hidden' value='".$appt["practice_city"]."' />";
		    echo "<input name='apptmiles' type='hidden' value='".$appt["distance"]."' />";
		    // EOF NW Added
		    echo "<input name='apptDate' type='hidden' value='".$date."' />";
		    echo "<input name='apptId' type='hidden' value='".$appt["id"]."' />";
		    echo "<input name='disAccess' type='hidden' value='".$searchParams[2]."' />";
		    echo "<input name='apptType' type='hidden' value='1' />";
		    //echo $appt["id"];
		    echo "<input class='btnappointment book desktop' type='submit' name='booking' value='Reserve Appointment Now for just £15' />";
		    echo "<input class='btnappointment book mobile' type='submit' name='booking' value='Reserve Now for £15' />";
		    echo "</form>";
		    echo "</ul>";
	    }
    } elseif ($appts[0] == 0){
        if ($searchParams){
            echo "<h2 class='ho'>Sorry</h2>";
            echo "<p class='cw'>We were unable to find you an appointment. Please try again by adjusting the search parameters or submit your email address and contact number below. We shall contact you as soon as an appointment becomes available.</p>";
            //echo "<button class='btn black'>Contact</button>";
            if($error2){echo "<span class='error'>{$error2}</br></span>";}
            echo "<form method='post' action=".htmlspecialchars('../php/contact.php').">";
            echo "<input type='hidden' name='postcode' value='{$searchParams[0]}' />";
            echo "<input type='hidden' name='distance' value='{$searchParams[1]}' />";
            echo "<input type='hidden' name='disAccess' value='{$searchParams[2]}' />";
            echo "<div class='col-2'>";
            echo "<input type='number' name='contactNo' placeholder='Phone Number' /> ";
            echo "</div>";
            echo "<div class='col-2'>";
            echo "<input placeholder='Email Address' type='email' name='email' required />";
			echo "</div>";
			echo '<div class="col-md-6 col-md-offset-3">';
            echo "<input class='btn ' style='background:#e8541c; color:white' type='submit' name='searchContact' value='Submit' />";
		   echo '</div>';
			echo "</form>";
        }
    }
	?>
</div>
<!-- <div class="col-3">
	<?php 
// 	if (count($appts)) {
// 	    echo "<img class='imgProcess' src='../images/the-process-select.png'><h3 class='text-centre'>Practice and dentist details will be revealed once the booking has been confirmed</h3>";
//     } else {
// 	    echo "<img class='imgProcess' src='../images/the-process-search.png'>";
//     }
//  if($error){echo "<span class='error'>{$error}</br></span>";}
//     if($_SESSION["errUnavailable"]){
//         echo "<span class='error'>{$_SESSION["errUnavailable"]}</br></span>"; unset($_SESSION["errUnavailable"]);}
	
	?>
    <form class="appointment-form" method="post" action="<?php // echo htmlspecialchars('../php/search.php');?>">
        <input class="postcode" type="text" placeholder="Postcode" name="postcode" value="<?php // echo $searchParams[0] ?>" required >
        <select class="customSelect distance" name="distance" required>
            <option value="" disabled selected>Distance willing to travel</option>
            <option value="10" <?php // if ($searchParams[1] == '10') { echo "selected"; } ?>>10 miles</option>
            <option value="20" <?php // if ($searchParams[1] == '20') { echo "selected"; } ?>>20 miles</option>
            <option value="30" <?php //if ($searchParams[1] == '30') { echo "selected"; } ?>>30 miles</option>
            <option value="40" <?php //if ($searchParams[1] == '40') { echo "selected"; } ?>>40 miles</option>
            <option value="50" <?php //if ($searchParams[1] == '50') { echo "selected"; } ?>>50 miles</option>
        </select>
        Wheelchair Access needed: <label><input type="radio" name="disAccess" value="1" required <?php // if ($searchParams[2] == '1') { echo "checked='checked'"; } ?> > Yes</label> <label><input type="radio" name="disAccess" value="0" <?php if ($searchParams[2] !== '1') { echo "checked=\"checked\"";}?>> No</label>
        <input class="btn" type="submit" name="search" value="Search Again">
    </form>
</div> -->
</div>
    <script src="../js/jquery.rateit.min.js"></script>
<?php include( 'footer.php' ); ?>
