<?php
/**
 * Emerdency - create-dentist.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/03/2018
 * Time: 14:05
 * Description :
 */

session_start();

include( "../php/registerDentist.php" );
$practiceSelect = getPracticesForSelect();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$firstName  = $_POST["firstName"];
	$lastName   = $_POST["lastName"];
	$gdcNo      = $_POST["gdcNo"];
	$contactNo  = $_POST["contactNo"];
	$practiceId = $_POST["practiceId"];
	$telAdvice = $_POST["telAdvice"];
	$email      = $_POST["email"];
	$password1  = $_POST["password1"];
	$password2  = $_POST["password2"];

	$success = registerDentist( $firstName, $lastName, $contactNo, $gdcNo, $telAdvice, $email, $password1, $password2);

	if ( $success === 1 ) {
		$success2 = assignPractice($email, $practiceId);
		if ( $success2) {
			$_SESSION["successMsg"] = "Dentist has been successfully created.";
			header( "Location:admin-account" );
			exit();
		}
	}
}
include( '../header.php' );
?>
	<div class="main-content">
		<h1 class="page-title">Create Dentist</h1>
		<div class="inner-row">
			<div class="col-1">
                <input class="btn back" type="button" value="Back" onclick="history.back()">
				<form method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <span class="error"><?php if( $success != ""){echo $success . "</br>";}?></span>
                    Personal Details:
					<input placeholder="First Name" type="text" name="firstName" required autofocus />
					<input placeholder="Last Name" type="text" name="lastName" required />
                    <input placeholder="GDC Number" type="number" min="0" name="gdcNo" required />
                    <input placeholder="Contact Number" type="tel" pattern="[0-9]*" min="0" name="contactNo" required />
                    Practice Details: <br/>
                    <div class="autocomplete">
                        <input id="practiceName" type="text" name="practiceName" placeholder="Practice Name" required >
                    </div>
                    <input id="practiceId" type="hidden" name="practiceId">
					<!--<select class="customSelect" name="practiceId" required>
						<option disabled selected>-- Practice --</option>
						<?php
						//while ($row = mysqli_fetch_assoc($practiceSelect)){
						//	echo "<option value='{$row['id']}'>{$row['name']}</option>";
						//} ?>
					</select>-->
                    Telephone Advice: <label><input type="radio" name="telAdvice" value="1" required >&nbsp;Yes</label>&nbsp;
                    <label><input type="radio" name="telAdvice" value="0" checked>No</label></br>
                    <br/>
                    Login Details:
					<input placeholder="Email Address" type="email" name="email" required />
					<input placeholder="Password" type="password" name="password1" required />
					<input placeholder="Confirm Password" type="password" name="password2" required />
                    <input class="btn" type="submit" value="Create" />
				</form>
			</div>
		</div>
    <script>
        jQuery(document).ready(function($){
        $(document).ready(function(){
            $.ajax({
                url: "https://www.emerdency.co.uk/php/autocomplete.php?type=2",
                method: "GET",
                success: function (data) {
                    var practices = [];
                    var practiceId = [];
                    console.log(data);
                    for (var i in data) {
                        practices.push(data[i].practiceName);
                        practiceId.push(data[i].id);
                    }

                    function autocomplete(inp, inp2, arr, arr2) {
                        /*the autocomplete function takes two arguments,
						the text field element and an array of possible autocompleted values:*/
                        var currentFocus;
                        /*execute a function when someone writes in the text field:*/
                        inp.addEventListener("input", function(e) {
                            var a, b, c, i, val = this.value;
                            /*close any already open lists of autocompleted values*/
                            closeAllLists();
                            if (!val) { return false;}
                            currentFocus = -1;
                            /*create a DIV element that will contain the items (values):*/
                            a = document.createElement("DIV");
                            a.setAttribute("id", this.id + "autocomplete-list");
                            a.setAttribute("class", "autocomplete-items");
                            /*append the DIV element as a child of the autocomplete container:*/
                            this.parentNode.appendChild(a);
                            /*for each item in the array...*/
                            for (i = 0; i < arr.length; i++) {
                                /*check if the item starts with the same letters as the text field value:*/
                                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                                    /*create a DIV element for each matching element:*/
                                    b = document.createElement("DIV");
                                    /*make the matching letters bold:*/
                                    b.innerHTML = "<strong style='color :#e8541c'>" + arr[i].substr(0, val.length) + "</strong>";
                                    b.innerHTML += arr[i].substr(val.length);
                                    /*insert a input field that will hold the current array item's value:*/
                                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                                    c = document.createElement("DIV");
                                    b.innerHTML += "<input type='hidden' class='id' value='" + arr2[i] + "'>";
                                    /*execute a function when someone clicks on the item value (DIV element):*/
                                    b.addEventListener("click", function(e) {
                                        /*insert the value for the autocomplete text field:*/
                                        inp.value = this.getElementsByTagName("input")[0].value;
                                        inp2.value = this.getElementsByClassName("id")[0].value;
                                        /*close the list of autocompleted values,
										(or any other open lists of autocompleted values:*/
                                        closeAllLists();
                                    });
                                    a.appendChild(b);
                                }
                            }
                        });
                        /*execute a function presses a key on the keyboard:*/
                        inp.addEventListener("keydown", function(e) {
                            var x = document.getElementById(this.id + "autocomplete-list");
                            if (x) x = x.getElementsByTagName("div");
                            if (e.keyCode == 40) {
                                /*If the arrow DOWN key is pressed,
								increase the currentFocus variable:*/
                                currentFocus++;
                                /*and and make the current item more visible:*/
                                addActive(x);
                            } else if (e.keyCode == 38) { //up
                                /*If the arrow UP key is pressed,
								decrease the currentFocus variable:*/
                                currentFocus--;
                                /*and and make the current item more visible:*/
                                addActive(x);
                            } else if (e.keyCode == 13) {
                                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                                e.preventDefault();
                                if (currentFocus > -1) {
                                    /*and simulate a click on the "active" item:*/
                                    if (x) x[currentFocus].click();
                                }
                            }
                        });
                        function addActive(x) {
                            /*a function to classify an item as "active":*/
                            if (!x) return false;
                            /*start by removing the "active" class on all items:*/
                            removeActive(x);
                            if (currentFocus >= x.length) currentFocus = 0;
                            if (currentFocus < 0) currentFocus = (x.length - 1);
                            /*add class "autocomplete-active":*/
                            x[currentFocus].classList.add("autocomplete-active");
                        }
                        function removeActive(x) {
                            /*a function to remove the "active" class from all autocomplete items:*/
                            for (var i = 0; i < x.length; i++) {
                                x[i].classList.remove("autocomplete-active");
                            }
                        }
                        function closeAllLists(elmnt) {
                            /*close all autocomplete lists in the document,
							except the one passed as an argument:*/
                            var x = document.getElementsByClassName("autocomplete-items");
                            for (var i = 0; i < x.length; i++) {
                                if (elmnt != x[i] && elmnt != inp) {
                                    x[i].parentNode.removeChild(x[i]);
                                }
                            }
                        }
                        /*execute a function when someone clicks in the document:*/
                        document.addEventListener("click", function (e) {
                            closeAllLists(e.target);
                        });
                    }

                    /*initiate the autocomplete function on the "myInput" element, and pass along the array as possible autocomplete values:*/
                    autocomplete(document.getElementById("practiceName"),document.getElementById("practiceId"), practices, practiceId);
                }
            });
        });
        });
    </script>
<?php include( '../footer.php' ); ?>