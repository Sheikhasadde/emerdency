<?php 
	include( "php/register-page.php" );

	session_start();
	
	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] =='1'){
		header("Location:pages/my-account");
	}

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

		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dob)) {
			if ($postcodeValid) {
				// User is registering for a minor, collect extra data and create row in MinorPatient table
				if ($minor == "on"){
					$mFirstName = $_POST["m_firstName"];
					$mLastName = $_POST["m_lastName"];
					$mDOB = $_POST["m_dob"];
					if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$mDOB)) {
						$type = 1;
						$error = registerUser($first_name,$last_name,$house_no_name,$address_line_1,$address_line_2,$town_city,$postcode,$dob,$contact_no,$email_address,$password1,$password2,$type,$marketing);
						registerMinor($mFirstName,$mLastName,$mDOB,$email_address);
						$_SESSION["minor"] = 2;
					} else {
						$error = "Please enter a valid date of birth.";
                    }
					// User is registering for an adult
				} else {
					$type = 0;
					$error = registerUser($first_name,$last_name,$house_no_name,$address_line_1,$address_line_2,$town_city,$postcode,$dob,$contact_no,$email_address,$password1,$password2,$type,$marketing);
				}
			} else {
				$error = "Please enter a valid postcode.";
			}
		} else {
			$error = "Please enter a valid date of birth.";
		}

		if($error === 1){
			$userId = getUserId($email_address);
			$_SESSION["userId"] = $userId;
			$_SESSION["loggedIn"] = 1;
			$_SESSION["confirmed"] = 0;
			header("Location:pages/register-complete");
			exit();
		}
	}
$title = "Register For Your Emerdency Dental Account | Emerdency";
$description = "Here you can register and benefit from booking appointments online. Just follow the steps and alleviate your dental concerns.";

include ("header.php");
?>
<div class="main-content">
<div class="col-md-12 page-header" >

</div>
<div class="col-md-10 col-md-offset-2">
    <h1 class="page-title">Register</h1>
</div>

<div class="col-md-12">
<div class="col-md-8 col-md-offset-2 contact-form-container" >
    <h1 class="cw">Create Your Account</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <br/>
    	<span class="error"><?php if($error != ""){echo $error."<br/>";}?></span>
            <div class="col-md-12 register-page">
                <label class="cw">  <input type="checkbox" id="trigger" name="minor"/>  I am registering on behalf of a child (16 years and under)</label> <br/>
                <br/>
                <div class="col-md-12">
                <label class="orange-text" id="pDetails" style="font-size:22px;">Personal Details:</label>
                </div>
                <div class="col-md-6">
                <input placeholder="First Name" type="text"  name="first_name" required  /> </br>
                </div>
                <div class="col-md-6">
                <input placeholder="Last Name" type="text" name="last_name" required /> </br>
                </div>
                <div class="col-md-6">
                <input placeholder="House Number/Name" type="text" name="house_no_name" required /> </br>
                </div>
                <div class="col-md-6">
                <input placeholder="Street/Road" type="text" name="address_line_1" required /> </br>
                </div>
                <div class="col-md-12">
                <input placeholder="Address 2" type="text" name="address_line_2" />
                </div>
            </br>
            <div class="col-md-6">
                <input placeholder="Town/City" type="text" name="town_city" required />
            </div>
            </br>
            <div class="col-md-6">
                <input placeholder="Postcode" type="text" name="postcode" required />
            </div> </br>
            <div class="col-md-12">
                <label class="ho" style="font-size:22px;">Date of Birth:</label>
            </div>
                <div class="col-md-6">
                <input class="dob" placeholder="yyyy-mm-dd" type="date" name="dob" required min="1900-01-01" max="<?php echo $dateMinus16;?>" /> </br>
                </div>
                <div class="col-md-6">
                <input placeholder="Mobile Number" type="tel" pattern="[0-9]*" min="0" name="contact_no" required /> </br>
                </div>
            </div>

            <div class="col-md-6 register-page">
                
                <div id="hidden_fields">
                    <label class="orange-text">Child Details:</label>
                    <input type="text" placeholder="First Name" id="m_firstName" name="m_firstName" />
                    <input type="text" placeholder="Last Name" id="m_lastName" name="m_lastName" />
                    <label>Date of Birth:</label>
                    <input placeholder="yyyy-mm-dd" type="date" name="m_dob" min="<?php echo $dateMinus16;?>" max="<?php echo $dateToday;?>" />
                </div>
                <label class="orange-text" style="font-size:22px;">Login Details:</label>
                <input placeholder="Email Address" type="email" name="email_address" required /> </br>
                <input placeholder="Password" type="password" name="password1" id="password1" required /> </br>
                <input placeholder="Confirm Password" type="password" name="password2" id="password2" required  /> </br>
               
            </div>
            
            <div class="col-md-6">
            <div class="register-checkbox">
                    <input class="reg-check" name="terms" type="checkbox" required /><label class="regCheck ho">I accept the <a href="terms" target="_blank">terms and conditions</a> </label><br/>
                    <input class="reg-check" name="details" type="checkbox" required /><label class="regCheck ho">I confirm I have read and understood section 5.2 of the terms and conditions and agree for my personal data to be shared with dentists carrying out my treatment 			</label><br/>
                    <input class="reg-check" name="marketing" type="checkbox" /><label class="regCheck ho">I would like to receive information about products and services by email/telephone/text message </label><br/>
                
                </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
            <input class="btn" type="submit" value="Register" />
            <br></br><br><br><br>
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
</script>
<?php include( 'footer.php' ); ?>
