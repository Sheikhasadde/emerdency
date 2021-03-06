<?php
require("../php/registerUser.php");

session_start();

// Get today's date -18 years for max date picker and for minor picker
$dateToday = date('Y-m-d');
$time = strtotime("-16 year", time());
$dateMinus16 = date("Y-m-d", $time);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$house_no_name = $_POST["house_no_name"];
	$address_line_1 = $_POST["address_line_1"];
	$address_line_2 = $_POST["address_line_2"];
	$town_city = $_POST["town_city"];
	$postcode = $_POST["postcode"];
	$dob = $_POST["dob"];
	$contact_no =$_POST["contact_no"];
	$email_address = $_POST["email_address"];
	$password1 = $_POST["password1"];
	$password2 = $_POST["password2"];
	$minor = $_POST["minor"];
    if ($_POST["marketing"]){
        $marketing = 1;
    } else {
        $marketing = 0;
    }
	if (isset($_POST['postcode'])){
		$postcode = testInput($_POST["postcode"]);
		// Test is postcode valid (RegEx)
		$postcodeValid = isPostcodeValid($postcode);
	}

	if ($postcodeValid) {
		// User is registering for a minor, collect extra data and create row in MinorPatient table
		if ($minor == "on"){
			$mFirstName = $_POST["m_firstName"];
			$mLastName = $_POST["m_lastName"];
			$mDOB = $_POST["m_dob"];
			$type = 1;
			$error = registerUser($first_name,$last_name,$house_no_name,$address_line_1,$address_line_2,$town_city,$postcode,$dob,$contact_no,$email_address,$password1,$password2,$type, $marketing);
			registerMinor($mFirstName,$mLastName,$mDOB,$email_address);
			$_SESSION["minor"] = "2";
			// User is registering for an adult
		} else {
			$type = 0;
			$error = registerUser($first_name,$last_name,$house_no_name,$address_line_1,$address_line_2,$town_city,$postcode,$dob,$contact_no,$email_address,$password1,$password2,$type, $marketing);
		}
	} else {
		$error = "Please enter a valid postcode.";
	}

	if($error === 1){
		$userId = getUserId($email_address);
		$_SESSION["userId"] = $userId;
		$_SESSION["loggedIn"] = 1;
		$_SESSION["confirmed"] = 0;
		echo "<script type='text/javascript'>parent.jQuery.fancybox.close();</script>";
		exit();
	}
}

include('../header-lightbox.php');
?>

<div class="main-content">
    <h1 class="page-title">Register</h1>
    <div class="inner-row">
        <div class="col-1">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <br/>
                <span class="error"><?php if($error != ""){echo $error."<br/>";}?></span>
                <div class="col-2 register-page">
                    <label>I am registering on behalf of a child (16 years and under): <input type="checkbox" id="trigger" name="minor"/> </label> <br/>
                    <br/>
                    <label class="orange-text" id="pDetails">Personal Details:</label>
                    <input placeholder="First Name" type="text" name="first_name" required /> </br>
                    <input placeholder="Last Name" type="text" name="last_name" required /> </br>
                    <input placeholder="House Number/Name" type="text" name="house_no_name" required /> </br>
                    <input placeholder="Street/Road" type="text" name="address_line_1" required /> </br>
                    <input placeholder="Address 2" type="text" name="address_line_2" /> </br>
                    <input placeholder="Town/City" type="text" name="town_city" required /> </br>
                    <input placeholder="Postcode" type="text" name="postcode" required /> </br>
                    <label>Date of Birth:</label>
                    <input class="dob" placeholder="Date of Birth" type="text" name="dob"  /> </br>
                    <input placeholder="Mobile Number" type="tel" pattern="[0-9]*" min="0" name="contact_no" required /> </br>
                </div>

                <div class="col-2 register-page">
                    <br/>
                    <br/>
                    <div id="hidden_fields">
                        <label class="orange-text">Child Details:</label>
                        <input type="text" placeholder="First Name" id="m_firstName" name="m_firstName" />
                        <input type="text" placeholder="Last Name" id="m_lastName" name="m_lastName" />
                        <label>Date of Birth:</label>
                        <input placeholder="Date of Birth" type="text" name="m_dob"  />
                    </div>
                    <label class="orange-text">Login Details:</label>
                    <input placeholder="Email Address" type="email" name="email_address" required /> </br>
                    <input placeholder="Password" type="password" name="password1" id="password1" minlength="6" required /> </br>
                    <input placeholder="Confirm Password" type="password" name="password2" id="password2" minlength="6" required  /> </br>
                    <div class="register-checkbox">
                        <input class="reg-check" name="terms" type="checkbox" required /><label class="regCheck">I accept the <a href="terms" target="_blank">terms and conditions</a> </label><br/>
                        <input class="reg-check" name="details" type="checkbox" required /><label class="regCheck">I confirm I have read and understood section 5.2 of the terms and conditions and agree for my personal data to be shared with dentists carrying out my treatment</label><br/>
                        <input class="reg-check" name="marketing" type="checkbox" /><label class="regCheck">I would like to receive information about products and services by email/telephone/text message </label><br/>
                        <input class="btn" type="submit" value="Register" />
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $(function() {
            // Get the form fields and hidden div
            var checkbox = $("#trigger");
            var hidden = $("#hidden_fields");
            var firstName = $("#m_firstName");
            var lastName = $("#m_lastName");
            var dob = $("#m_dob");
            // Hide the fields.
            // Use JS to do this in case the user doesn't have JS
            // enabled.
            hidden.hide();

            // Setup an event listener for when the state of the
            // checkbox changes.
            checkbox.change(function() {
                // Check to see if the checkbox is checked.
                // If it is, show the fields and populate the input.
                // If not, hide the fields.
                if (checkbox.is(':checked')) {
                    // Show the hidden fields.
                    hidden.show();
                    document.getElementById("pDetails").innerHTML = "Parent/Legal Guardian Details:";
                    firstName.setAttribute('required', '');
                    lastName.setAttribute('required', '');
                    dob.setAttribute('required', '');
                    // Populate the input.
                    //populate.val("Dude, this input got populated!");
                } else {
                    // Make sure that the hidden fields are indeed
                    // hidden.
                    hidden.hide();
                    document.getElementById("pDetails").innerHTML = "Personal Details:";
                    // You may also want to clear the value of the
                    // hidden fields here. Just in case somebody
                    // shows the fields, enters data to them and then
                    // unticks the checkbox.
                    //
                    // This would do the job:
                    //

                    $("#hidden_field").val("");
                    //if hidden.hidden{

                    //}
                }
            });
        });
    });
</script><?php include('../footer-lightbox.php'); ?>
