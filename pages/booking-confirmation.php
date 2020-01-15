<?php
/**
 * Emerdency-Live - booking-payment.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 11/05/2018
 * Time: 16:43
 * Description :
 */

// Start Session
session_start();

include ("../php/availability.php");
include ("../php/search.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["booking"]){
		// Get Post Data
		$_SESSION["apptId"] = $_POST["apptId"];
		$_SESSION["apptTime"] = $_POST["apptTime"];
		// NW Added
		$_SESSION["apptcity"] = $_POST["apptcity"];
		$_SESSION["apptmiles"] = $_POST["apptmiles"];
		// EOF NW Added
		$_SESSION["apptDate"] = $_POST["apptDate"];
		$_SESSION["apptType"] = $_POST["apptType"];
		$_SESSION["disAccess"] = $_POST["disAccess"];
	}

	if ($_POST["patientSelect"]){
		$patientId = $_POST["patientId"];
		if ($patientId[0] == "m") {
		    $_SESSION["minorId"] = $patientId = substr($patientId, 1);

        } else {
		    unset($_SESSION["minorId"]);
		    unset($_SESSION["minor"]);
        }
	}

	if ($_POST["cancel"]){
		$userId = $_SESSION["userId"];
		$success = clearUserHold($userId);
		if ($success){
			unset($_SESSION["errUnavailable"]);
			unset($_SESSION["incompleteBooking"]);
			unset($_SESSION["timestamp"]);
			// Re-Perform Search and re-direct to search results
			$_SESSION["availAppts"] = performSearch( $_SESSION["searchParams"] );
			// Redirect to Search Results
			header("Location:search-results");
			exit();
		}
	}
}

$apptId = $_SESSION["apptId"];

switch ($_SESSION["disAccess"]){
    case 0 :
        $disAccess = "No";
        break;
    case 1 :
        $disAccess = "Yes";
}
// Check if user is logged in
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1') {
	$userId = $_SESSION["userId"];
	// Get Patient Name
    $patientName = getPatientName($userId);
	// Check If minors associated to account
	$minors = hasMinors($userId);
	// Check if appointment is available
	$available = checkIfAvailable( $apptId, $userId );
	if ($available === 0 ) {
		unset( $_SESSION["incompleteBooking"] );
		$_SESSION["errUnavailable"] = "Sorry, the selected appointment is no longer available.";

		// Re-Perform Search and re-direct to search results
		$_SESSION["availAppts"] = performSearch( $_SESSION["searchParams"] );
		header( "Location:search-results" );
		exit();
	}
}
// Check what type - if not correct/no type redirect to relevant page
switch ($_SESSION["apptType"]){
	case "1" :
		break;
	case "2" :
		header("Location:tel-booking-confirmation");
		exit();
		break;
	default :
		header("Location:../index");
		exit();
		break;
}
include('../header.php');
?>
<?php
   // error_reporting(E_ALL);
   // ini_set('display_errors', 1);
?>
<h1 class="page-title">Booking Confirmation</h1>
<div class="inner-row">
	<div class="col-1">
		<a class="btn back" onclick="history.back()">Back</a>
		<!-- <img class="imgProcess" src="../images/the-process-pay.png" style="display: inline">-->
		<br/>
    </div>
    
    <?php
		switch ($_SESSION["loggedIn"]){
			case "0" : ?>
            
            <div class="col-33 greyback">
        <!-- <ul id="confirmation" class="appointmentlist confirmation"> -->
        <div class='inner-row appointmenttitle'>
            <h3>Appointment Details <?php echo "in <strong> " .$_SESSION["apptcity"]. " - ".$_SESSION["apptmiles"]." miles</strong> from your location"?></h3>
            </div>
        <ul class="appointmentlist">
            <div class="col-2">
				<li><h2>Details: </h2></li>
				<li>Full Address of Dental Pratice shown upon booking.</li>
		<?php
		echo "  
		<li><strong>City:</strong> " .$_SESSION["apptcity"]. "</li>
		<li><strong>Distance:</strong> " .$_SESSION["apptmiles"]. " miles away.</li>
		<li><strong>Date:</strong> " .$_SESSION["apptDate"]. "</li>
                <li><strong>Time:</strong> " .$_SESSION["apptTime"]. "</li>
				<li><br/><h2>Price:</h2><strong>£50</strong><p>An initial booking fee of <b>£15</b> is charged online when the booking is made followed by the remaining amount of <b>£35</b> taken at the dental practice.</p></li>
				<li>Wheelchair Access Required: $disAccess</li>"; ?>
        	</div>
            <div class="col-2">
            	<li><h2>Payment</h2></li>
                <li>- £15 reservation fee</li>
                <li>- £35 fee due on arrival</li>
                <li>&nbsp;</li>
                <li><h2>Total</h2></li>
                <hr style="border-color:#e8541c;" />
                <li>£15</li>
                <hr style="border-color:#e8541c;" />
                <li><img src='../images/payment-logos.png' width="100%" style="max-width:237px;"></li>
            </div>
        </ul>  
    </div>
    
    <div class="col-3">
     <!-- Right column -->
		<?
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
		    echo "<form method=\"POST\" action=".htmlspecialchars('booking-confirmation').">";
		    echo "<div class='col-3 access' id='bookconfirm'><br/>";
		    echo "<a class='orange-text'>Please choose the patient name from the drop-down menu below and press select</a><br/>";
            echo "<label>The appointment is for: </label>";
			echo "<select class='patientSelect' name='patientId'>";
                echo "<option value='{$userId}' selected>{$patientName}</option>";
                if (mysqli_num_rows($minors) > 0){
		                while ($row = mysqli_fetch_assoc($minors)){
		                    echo "<option value='m".$row["id"]."'";
		                    if ($_SESSION["minor"] == 2){
				                echo "selected";
		                    } elseif ($patientId == $row["id"]){
			                    echo "selected";
		                    }
                            echo ">".$row["first_name"]." ".$row["last_name"]."</option>";
                        }

                }
			echo "<input class='btn selectBtn2' type='submit' name='patientSelect' value='Select' />";
            echo "</select></form>";
            echo "</div>";
			echo "<div class='col-3 access'> <p>This appointment will be reserved for ";
				echo "<span id=\"clockdiv\"><span class=\"minutes\"></span>:<span class=\"seconds\"></span> minutes</span>";

			echo " </ul>";
			echo "Please click on the PayPal button below to make the payment.<br/><br/>   ";
			echo "<h2 class='important'> IMPORTANT:</h2>";
			echo "Once payment has been completed please allow PayPal to redirect you back to the Emerdency site in order to receive the appointment details.";
			echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>
<input type='hidden' name='cmd' value='_s-xclick'>
<input type='hidden' name='hosted_button_id' value='KD2LJ554K8D7C'>
<input type='image' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' name='submit' alt='PayPal – The safer, easier way to pay online!'>
<img alt='' border='0' src='https://www.paypalobjects.com/en_GB/i/scr/pixel.gif' width='1' height='1'>
</form>";
			echo "<form method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
                        <input class='btn' type='submit' value='Cancel Booking' name='cancel' />
                  </form>";
		} else {
			echo " </ul>";
			echo "<div class='mobile'><p style='height:60px;'>&nbsp;</p><hr/></div>";
			echo "<h1>Booking Section</h1>";
			echo "Existing customers <a href='https://www.emerdency.co.uk/login'>login</a><br/><br/>";
			echo "<strong>New Customers fill in the form to secure your appointment.</strong><br/><br/>";
			// echo "<input type='submit' data-fancybox data-type='iframe' data-src='login-lightbox.php' href='javascript:;' class='btn fancybox-refresh' data-small-btn='true' value='Login' />";
			// include('login-lightbox-NW.php');
			include('register-lightbox-NW.php');
		}
		?>
     <!-- EOF right column -->   
    </div>
            
			<?	break;
			case "1" :
				if ($_SESSION["incompleteBooking"]) {
					if ($_SESSION["timestamp"]){
						$timeNow = time();
						$timestamp = strtotime($_SESSION["timestamp"]);
						if ($timeNow > $timestamp){
							unset($_SESSION["incompleteBooking"]);
							unset($_SESSION["timestamp"]);
							unset($_SESSION["availAppts"]);
						} else { ?>
                        
                        <div class="col-1">
     <!-- Right column -->
		<?
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
		    echo "<form method=\"POST\" action=".htmlspecialchars('booking-confirmation').">";
		    echo "<div class='col-3 access' id='bookconfirm'><br/>";
		    echo "<a class='orange-text'>Please choose the patient name from the drop-down menu below and press select</a><br/>";
            echo "<label>The appointment is for: </label>";
			echo "<select class='patientSelect' name='patientId'>";
                echo "<option value='{$userId}' selected>{$patientName}</option>";
                if (mysqli_num_rows($minors) > 0){
		                while ($row = mysqli_fetch_assoc($minors)){
		                    echo "<option value='m".$row["id"]."'";
		                    if ($_SESSION["minor"] == 2){
				                echo "selected";
		                    } elseif ($patientId == $row["id"]){
			                    echo "selected";
		                    }
                            echo ">".$row["first_name"]." ".$row["last_name"]."</option>";
                        }

                }
			echo "<input class='btn selectBtn2' type='submit' name='patientSelect' value='Select' />";
            echo "</select></form>";
            echo "</div>";
			echo "<div class='col-3 access'> <p>This appointment will be reserved for ";
				echo "<span id=\"clockdiv\"><span class=\"minutes\"></span>:<span class=\"seconds\"></span> minutes</span>";

			echo " </ul>";
			echo "Please click on the PayPal button below to make the payment.<br/><br/>   ";
			echo "<h2 class='important'> IMPORTANT:</h2>";
			echo "Once payment has been completed please allow PayPal to redirect you back to the Emerdency site in order to receive the appointment details.";
			echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>
<input type='hidden' name='cmd' value='_s-xclick'>
<input type='hidden' name='hosted_button_id' value='KD2LJ554K8D7C'>
<input type='image' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' name='submit' alt='PayPal – The safer, easier way to pay online!'>
<img alt='' border='0' src='https://www.paypalobjects.com/en_GB/i/scr/pixel.gif' width='1' height='1'>
</form";
			echo "<form method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
                        <input class='btn' type='submit' value='Cancel Booking' name='cancel' />
                  </form>";
		} else {
			echo " </ul>";
			echo "<div class='mobile'><p style='height:60px;'>&nbsp;</p><hr/></div>";
			echo "<h1>Booking Section</h1>";
			echo "Existing customers <a href='https://www.emerdency.co.uk/login'>login</a><br/><br/>";
			echo "<strong>New Customers fill in the form to secure your appointment.</strong><br/><br/>";
			// echo "<input type='submit' data-fancybox data-type='iframe' data-src='login-lightbox.php' href='javascript:;' class='btn fancybox-refresh' data-small-btn='true' value='Login' />";
			// include('login-lightbox-NW.php');
			include('register-lightbox-NW.php');
		}
		?>
     <!-- EOF right column -->   
    </div>
							       
					<?	}
					}
				}
				break;
			case "2" : 
				break; ?>
                
                <div class="col-33 greyback">
        <!-- <ul id="confirmation" class="appointmentlist confirmation"> -->
        <div class='inner-row appointmenttitle'>
            <h3>Appointment Details <?php echo "in <strong> " .$_SESSION["apptcity"]. " - ".$_SESSION["apptmiles"]." miles</strong> from your location"?></h3>
            </div>
        <ul class="appointmentlist">
            <div class="col-2">
				<li><h2>Details: </h2></li>
				<li>Full Address of Dental Pratice shown upon booking.</li>
		<?php
		echo "  
		<li><strong>City:</strong> " .$_SESSION["apptcity"]. "</li>
		<li><strong>Distance:</strong> " .$_SESSION["apptmiles"]. " miles away.</li>
		<li><strong>Date:</strong> " .$_SESSION["apptDate"]. "</li>
                <li><strong>Time:</strong> " .$_SESSION["apptTime"]. "</li>
				<li><br/><h2>Price:</h2><strong>£50</strong><p>An initial booking fee of <b>£15</b> is charged online when the booking is made followed by the remaining amount of <b>£35</b> taken at the dental practice.</p></li>
				<li>Wheelchair Access Required: $disAccess</li>"; ?>
        	</div>
            <div class="col-2">
            	<li><h2>Payment</h2></li>
                <li>- £15 reservation fee</li>
                <li>- £35 fee due on arrival</li>
                <li>&nbsp;</li>
                <li><h2>Total</h2></li>
                <hr style="border-color:#e8541c;" />
                <li>£15</li>
                <hr style="border-color:#e8541c;" />
                <li><img src='../images/payment-logos.png' width="100%" style="max-width:237px;"></li>
            </div>
        </ul>  
    </div>
    
    <div class="col-3">
     <!-- Right column -->
		<?
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
		    echo "<form method=\"POST\" action=".htmlspecialchars('booking-confirmation').">";
		    echo "<div class='col-3 access' id='bookconfirm'><br/>";
		    echo "<a class='orange-text'>Please choose the patient name from the drop-down menu below and press select</a><br/>";
            echo "<label>The appointment is for: </label>";
			echo "<select class='patientSelect' name='patientId'>";
                echo "<option value='{$userId}' selected>{$patientName}</option>";
                if (mysqli_num_rows($minors) > 0){
		                while ($row = mysqli_fetch_assoc($minors)){
		                    echo "<option value='m".$row["id"]."'";
		                    if ($_SESSION["minor"] == 2){
				                echo "selected";
		                    } elseif ($patientId == $row["id"]){
			                    echo "selected";
		                    }
                            echo ">".$row["first_name"]." ".$row["last_name"]."</option>";
                        }

                }
			echo "<input class='btn selectBtn2' type='submit' name='patientSelect' value='Select' />";
            echo "</select></form>";
            echo "</div>";
			echo "<div class='col-3 access'> <p>This appointment will be reserved for ";
				echo "<span id=\"clockdiv\"><span class=\"minutes\"></span>:<span class=\"seconds\"></span> minutes</span>";

			echo " </ul>";
			echo "Please click on the PayPal button below to make the payment.<br/><br/>   ";
			echo "<h2 class='important'> IMPORTANT:</h2>";
			echo "Once payment has been completed please allow PayPal to redirect you back to the Emerdency site in order to receive the appointment details.";
			echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>
<input type='hidden' name='cmd' value='_s-xclick'>
<input type='hidden' name='hosted_button_id' value='KD2LJ554K8D7C'>
<input type='image' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' name='submit' alt='PayPal – The safer, easier way to pay online!'>
<img alt='' border='0' src='https://www.paypalobjects.com/en_GB/i/scr/pixel.gif' width='1' height='1'>
</form";
			echo "<form method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
                        <input class='btn' type='submit' value='Cancel Booking' name='cancel' />
                  </form>";
		} else {
			echo " </ul>";
			echo "<div class='mobile'><p style='height:60px;'>&nbsp;</p><hr/></div>";
			echo "<h1>Booking Section</h1>";
			echo "Existing customers <a href='https://www.emerdency.co.uk/login'>login</a><br/><br/>";
			echo "<strong>New Customers fill in the form to secure your appointment.</strong><br/><br/>";
			// echo "<input type='submit' data-fancybox data-type='iframe' data-src='login-lightbox.php' href='javascript:;' class='btn fancybox-refresh' data-small-btn='true' value='Login' />";
			// include('login-lightbox-NW.php');
			include('register-lightbox-NW.php');
		}
		?>
     <!-- EOF right column -->   
    </div>
                
            <? case "3" :
				break; ?>
                
                <div class="col-33 greyback">
        <!-- <ul id="confirmation" class="appointmentlist confirmation"> -->
        <div class='inner-row appointmenttitle'>
            <h3>Appointment Details <?php echo "in <strong> " .$_SESSION["apptcity"]. " - ".$_SESSION["apptmiles"]." miles</strong> from your location"?></h3>
            </div>
        <ul class="appointmentlist">
            <div class="col-2">
				<li><h2>Details: </h2></li>
				<li>Full Address of Dental Pratice shown upon booking.</li>
		<?php
		echo "  
		<li><strong>City:</strong> " .$_SESSION["apptcity"]. "</li>
		<li><strong>Distance:</strong> " .$_SESSION["apptmiles"]. " miles away.</li>
		<li><strong>Date:</strong> " .$_SESSION["apptDate"]. "</li>
                <li><strong>Time:</strong> " .$_SESSION["apptTime"]. "</li>
				<li><br/><h2>Price:</h2><strong>£50</strong><p>An initial booking fee of <b>£15</b> is charged online when the booking is made followed by the remaining amount of <b>£35</b> taken at the dental practice.</p></li>
				<li>Wheelchair Access Required: $disAccess</li>"; ?>
        	</div>
            <div class="col-2">
            	<li><h2>Payment</h2></li>
                <li>- £15 reservation fee</li>
                <li>- £35 fee due on arrival</li>
                <li>&nbsp;</li>
                <li><h2>Total</h2></li>
                <hr style="border-color:#e8541c;" />
                <li>£15</li>
                <hr style="border-color:#e8541c;" />
                <li><img src='../images/payment-logos.png' width="100%" style="max-width:237px;"></li>
            </div>
        </ul>  
    </div>
    
    <div class="col-3">
     <!-- Right column -->
		<?
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
		    echo "<form method=\"POST\" action=".htmlspecialchars('booking-confirmation').">";
		    echo "<div class='col-3 access' id='bookconfirm'><br/>";
		    echo "<a class='orange-text'>Please choose the patient name from the drop-down menu below and press select</a><br/>";
            echo "<label>The appointment is for: </label>";
			echo "<select class='patientSelect' name='patientId'>";
                echo "<option value='{$userId}' selected>{$patientName}</option>";
                if (mysqli_num_rows($minors) > 0){
		                while ($row = mysqli_fetch_assoc($minors)){
		                    echo "<option value='m".$row["id"]."'";
		                    if ($_SESSION["minor"] == 2){
				                echo "selected";
		                    } elseif ($patientId == $row["id"]){
			                    echo "selected";
		                    }
                            echo ">".$row["first_name"]." ".$row["last_name"]."</option>";
                        }

                }
			echo "<input class='btn selectBtn2' type='submit' name='patientSelect' value='Select' />";
            echo "</select></form>";
            echo "</div>";
			echo "<div class='col-3 access'> <p>This appointment will be reserved for ";
				echo "<span id=\"clockdiv\"><span class=\"minutes\"></span>:<span class=\"seconds\"></span> minutes</span>";

			echo " </ul>";
			echo "Please click on the PayPal button below to make the payment.<br/><br/>   ";
			echo "<h2 class='important'> IMPORTANT:</h2>";
			echo "Once payment has been completed please allow PayPal to redirect you back to the Emerdency site in order to receive the appointment details.";
			echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>
<input type='hidden' name='cmd' value='_s-xclick'>
<input type='hidden' name='hosted_button_id' value='KD2LJ554K8D7C'>
<input type='image' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' name='submit' alt='PayPal – The safer, easier way to pay online!'>
<img alt='' border='0' src='https://www.paypalobjects.com/en_GB/i/scr/pixel.gif' width='1' height='1'>
</form";
			echo "<form method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
                        <input class='btn' type='submit' value='Cancel Booking' name='cancel' />
                  </form>";
		} else {
			echo " </ul>";
			echo "<div class='mobile'><p style='height:60px;'>&nbsp;</p><hr/></div>";
			echo "<h1>Booking Section</h1>";
			echo "Existing customers <a href='https://www.emerdency.co.uk/login'>login</a><br/><br/>";
			echo "<strong>New Customers fill in the form to secure your appointment.</strong><br/><br/>";
			// echo "<input type='submit' data-fancybox data-type='iframe' data-src='login-lightbox.php' href='javascript:;' class='btn fancybox-refresh' data-small-btn='true' value='Login' />";
			// include('login-lightbox-NW.php');
			include('register-lightbox-NW.php');
		}
		?>
     <!-- EOF right column -->   
    </div>
                
            <? default: ?>
            
            <div class="col-33 greyback">
        <!-- <ul id="confirmation" class="appointmentlist confirmation"> -->
        <div class='inner-row appointmenttitle'>
            <h3>Appointment Details <?php echo "in <strong> " .$_SESSION["apptcity"]. " - ".$_SESSION["apptmiles"]." miles</strong> from your location"?></h3>
            </div>
        <ul class="appointmentlist">
            <div class="col-2">
				<li><h2>Details: </h2></li>
				<li>Full Address of Dental Pratice shown upon booking.</li>
		<?php
		echo "  
		<li><strong>City:</strong> " .$_SESSION["apptcity"]. "</li>
		<li><strong>Distance:</strong> " .$_SESSION["apptmiles"]. " miles away.</li>
		<li><strong>Date:</strong> " .$_SESSION["apptDate"]. "</li>
                <li><strong>Time:</strong> " .$_SESSION["apptTime"]. "</li>
				<li><br/><h2>Price:</h2><strong>£50</strong><p>An initial booking fee of <b>£15</b> is charged online when the booking is made followed by the remaining amount of <b>£35</b> taken at the dental practice.</p></li>
				<li>Wheelchair Access Required: $disAccess</li>"; ?>
        	</div>
            <div class="col-2">
            	<li><h2>Payment</h2></li>
                <li>- £15 reservation fee</li>
                <li>- £35 fee due on arrival</li>
                <li>&nbsp;</li>
                <li><h2>Total</h2></li>
                <hr style="border-color:#e8541c;" />
                <li>£15</li>
                <hr style="border-color:#e8541c;" />
                <li><img src='../images/payment-logos.png' width="100%" style="max-width:237px;"></li>
            </div>
        </ul>  
    </div>
    
    <div class="col-3">
     <!-- Right column -->
		<?
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
		    echo "<form method=\"POST\" action=".htmlspecialchars('booking-confirmation').">";
		    echo "<div class='col-3 access' id='bookconfirm'><br/>";
		    echo "<a class='orange-text'>Please choose the patient name from the drop-down menu below and press select</a><br/>";
            echo "<label>The appointment is for: </label>";
			echo "<select class='patientSelect' name='patientId'>";
                echo "<option value='{$userId}' selected>{$patientName}</option>";
                if (mysqli_num_rows($minors) > 0){
		                while ($row = mysqli_fetch_assoc($minors)){
		                    echo "<option value='m".$row["id"]."'";
		                    if ($_SESSION["minor"] == 2){
				                echo "selected";
		                    } elseif ($patientId == $row["id"]){
			                    echo "selected";
		                    }
                            echo ">".$row["first_name"]." ".$row["last_name"]."</option>";
                        }

                }
			echo "<input class='btn selectBtn2' type='submit' name='patientSelect' value='Select' />";
            echo "</select></form>";
            echo "</div>";
			echo "<div class='col-3 access'> <p>This appointment will be reserved for ";
				echo "<span id=\"clockdiv\"><span class=\"minutes\"></span>:<span class=\"seconds\"></span> minutes</span>";

			echo " </ul>";
			echo "Please click on the PayPal button below to make the payment.<br/><br/>   ";
			echo "<h2 class='important'> IMPORTANT:</h2>";
			echo "Once payment has been completed please allow PayPal to redirect you back to the Emerdency site in order to receive the appointment details.";
			echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_top'>
<input type='hidden' name='cmd' value='_s-xclick'>
<input type='hidden' name='hosted_button_id' value='KD2LJ554K8D7C'>
<input type='image' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' name='submit' alt='PayPal – The safer, easier way to pay online!'>
<img alt='' border='0' src='https://www.paypalobjects.com/en_GB/i/scr/pixel.gif' width='1' height='1'>
</form";
			echo "<form method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
                        <input class='btn' type='submit' value='Cancel Booking' name='cancel' />
                  </form>";
		} else {
			echo " </ul>";
			echo "<div class='mobile'><p style='height:60px;'>&nbsp;</p><hr/></div>";
			echo "<h1>Booking Section</h1>";
			echo "Existing customers <a href='https://www.emerdency.co.uk/login'>login</a><br/><br/>";
			echo "<strong>New Customers fill in the form to secure your appointment.</strong><br/><br/>";
			// echo "<input type='submit' data-fancybox data-type='iframe' data-src='login-lightbox.php' href='javascript:;' class='btn fancybox-refresh' data-small-btn='true' value='Login' />";
			// include('login-lightbox-NW.php');
			include('register-lightbox-NW.php');
		}
		?>
     <!-- EOF right column -->   
    </div>


		<? } ?> 
    
    
</div> 

<script>
    function getTimeRemaining(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    }

    function initializeClock(id, endtime) {
        var clock = document.getElementById(id);
        var minutesSpan = clock.querySelector('.minutes');
        var secondsSpan = clock.querySelector('.seconds');

        function updateClock() {
            var t = getTimeRemaining(endtime);
            minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
            secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

            if (t.total <= 0) {
                clearInterval(timeinterval);
                window.location.replace("https://www.emerdency.co.uk/php/booking-timeout");
            }
        }

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
    }

    var loggedIn = <?php echo json_encode($_SESSION["loggedIn"]); ?>;
	    if (loggedIn == 1){
        document.getElementById("confirmation").classList.add('select');
    }
    var id = <?php echo json_encode($_GET["id"]); ?>;
        window.location.replace("https://www.emerdency.co.uk/pages/booking-confirmation");
            return;
        }
    });
	
    var endTime = new Date(<?php echo json_encode($available); ?>.replace(' ', 'T'));
    initializeClock('clockdiv', endTime);
</script>


<?php include("../footer.php");