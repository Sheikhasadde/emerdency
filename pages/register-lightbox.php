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

	// Check if DOB in valid format -- does not check validity of date
	if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dob)) {
		if ($postcodeValid) {
			// User is registering for a minor, collect extra data and create row in MinorPatient table
			if ($minor == "on"){
				$mFirstName = $_POST["m_firstName"];
				$mLastName = $_POST["m_lastName"];
				$mDOB = $_POST["m_dob"];
				// Check if DOB in valid format -- does not check validity of date
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
		echo "<script type='text/javascript'>parent.jQuery.fancybox.close();</script>";
		exit();
	}
}

include('../header-lightbox.php');


    error_reporting(E_ALL);
	ini_set('display_errors', 1);


?><div class="main-content" >
    <h1 class="page-title">Register</h1>
    <div class="inner-row" >
        <div class="col-1 register-lightbox">
            <input class="btn back" type="button" value="Back" onclick="window.location.replace('login-lightbox.php')">
            <form name="regForm" id="regForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <span id="error" class="error"><?php if($error != ""){echo $error."<br/>";}?></span>
                <span id="error2" class="error"></span><br/>
                <!-- One "tab" for each step in the form: -->
                <div class="tab">
                    <label>I am registering on behalf of a child (16 years and under): <input type="checkbox" id="trigger" name="minor"/> </label> <br/>
                    <br/>
                    <label class="orange-text" id="pDetails">Personal Details:</label>
                    <input class="required" oninput="this.className = ''" placeholder="First Name" type="text" name="first_name" required /> </br>
                    <input class="required" oninput="this.className = ''" placeholder="Last Name" type="text" name="last_name" required /> </br>
                    <label>Date of Birth:</label>
                    <input class="required" id="dob" oninput="this.className = ''" class="dob" placeholder="YYYY-MM-DD" type="date" name="dob" required min="1900-01-01" max="<?php echo $dateMinus16;?>" onblur="validateDOB()" /> </br>
                    <div id="hidden_fields">
                        <label class="orange-text">Child Details:</label>
                        <input type="text" placeholder="First Name" id="m_firstName" name="m_firstName" />
                        <input type="text" placeholder="Last Name" id="m_lastName" name="m_lastName" />
                        <label>Date of Birth:</label>
                        <input placeholder="YYYY-MM-DD" id="minorDob" type="date" name="m_dob" min="<?php echo $dateMinus16;?>" max="<?php echo $dateToday;?>" onblur="validateMDOB()" />
                    </div>
                </div>

                <div class="tab">
                    <label class="orange-text" id="pDetails">Contact Details:</label>
                    <input class="required" oninput="this.className = ''" placeholder="House Number/Name" type="text" name="house_no_name" required /> </br>
                    <input class="required" oninput="this.className = ''" placeholder="Street/Road" type="text" name="address_line_1" required /> </br>
                    <input oninput="this.className = ''" placeholder="Address 2" type="text" name="address_line_2" /> </br>
                    <input class="required" oninput="this.className = ''" placeholder="Town/City" type="text" name="town_city" required /> </br>
                    <input class="required" oninput="this.className = ''" placeholder="Postcode" type="text" name="postcode" required /> </br>
                    <input class="required" oninput="this.className = ''" placeholder="Mobile Number" type="tel" pattern="[0-9]*" min="0" name="contact_no" required /> </br>
                </div>

                <div class="tab">
                    <label class="orange-text">Login Details:</label>
                    <input class="required" placeholder="Email Address" type="email" name="email_address" required /> </br>
                    <input class="required" placeholder="Password (minimum 6 characters)" type="password" name="password1" id="password1" required /> </br>
                    <input class="required" placeholder="Confirm Password" type="password" name="password2" id="password2" required  /> </br>
                    <div class="register-checkbox">
                        <input class="reg-check required" name="terms" type="checkbox" required /><label class="regCheck">I accept the <a href="terms" target="_blank">terms and conditions</a> </label><br/>
                        <input class="reg-check required" name="details" type="checkbox" required /><label class="regCheck">I confirm I have read and understood section 5.2 of the terms and conditions and agree for my personal data to be shared with dentists carrying out my treatment</label><br/>
                        <input class="reg-check required" name="marketing" type="checkbox" /><label class="regCheck">I would like to receive information about products and services by email/telephone/text message </label><br/>
                        <input class="btn" type="submit" value="Register" />
                    </div>
                </div>
                <div style="overflow:auto;">
                    <div style="float:right;">
                        <button class="btn black prev" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                        <button class="btn next black" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                    </div>
                </div>

                <!-- Circles which indicates the steps of the form: -->
                <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function changeDateFormat(inputDate){  // expects Y-m-d
        var splitDate = inputDate.split('-');
        if(splitDate.count == 0){
            return null;
        }

        var year = splitDate[0];
        var month = splitDate[1];
        var day = splitDate[2];

        return day + '.' + month + '.' + year;
    }

    function validateDOB() {
        var input = document.getElementById("dob");
        var dateMinus16 = <?php echo json_encode($dateMinus16); ?>;
        var min = changeDateFormat(dateMinus16);
        var dateToday = <?php echo json_encode($dateToday); ?>;
        var max = changeDateFormat(dateToday);

        if (input.value > dateMinus16) {
            document.getElementById("error").textContent = "Date of birth must be before " + min;
            document.getElementById("error").style.display = "block";
            input.className += " invalid";
            //valid = false;
        } else {
            document.getElementById("error").style.display = "none";
            input.removeClass("invalid");
        }
    }

    function validateMDOB() {
        var input = document.getElementById("minorDob");
        var dateMinus16 = <?php echo json_encode($dateMinus16); ?>;
        var min = changeDateFormat(dateMinus16);
        var dateToday = <?php echo json_encode($dateToday); ?>;
        var max = changeDateFormat(dateToday);

        if (input.value < dateMinus16){
            document.getElementById("error2").textContent = "Child date of birth must be after "+min;
            document.getElementById("error2").style.display = "block";
            input.className += " invalid";
        } else {
            document.getElementById("error2").style.display = "none";
            input.removeClass("invalid");
        }
    }


    function validateDOB2() {
        //var valid = true;
        console.log(input.value);
        var dateMinus16 = <?php echo json_encode($dateMinus16); ?>;
        console.log(dateMinus16);
        var dateToday = <?php echo json_encode($dateToday); ?>;
        console.log(dateToday);
        console.log(input.value);
        var name = input.getAttribute("name");
        if (name == "dob"){
            if (input.value > dateMinus16){
                document.getElementById("error").textContent="Date of Birth is invalid";
                document.getElementById("error").style.display = "block";
                input.className += " invalid";
                //valid = false;
            }
        } else if (name == "m_dob"){
            if (input.value < dateMinus16 && input.value > dateToday){
                var string = "Date of Birth must be before".dateMinus16;
                document.getElementById("error").textContent=string;
                document.getElementById("error").style.display = "block";
                //valid = false;
            }
        }

        // return valid;
    }

    function showTab(n) {
        // This function will display the specified tab of the form ...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        // ... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").style.display = "none";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
            document.getElementById("nextBtn").style.display = "inline";
        }
        // ... and run a function that displays the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form... :
        /*if (currentTab >= x.length) {
			//...the form gets submitted:
			document.getElementById("regForm").submit();
			return false;
		}*/
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByClassName("required");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false:
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class to the current step:
        x[n].className += " active";
    }

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
                    firstName.addClass("required");
                    lastName.addClass("required");
                    dob.addClass("required");
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
                    firstName.removeClass("required");
                    lastName.removeClass("required");
                    dob.removeClass("required");
                    //if hidden.hidden{

                    //}
                }
            });
        });
    });
</script>