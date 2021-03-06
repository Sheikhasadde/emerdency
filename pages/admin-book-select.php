<?php
/**
 * Emerdency-Live - admin-book-select.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 18/05/2018
 * Time: 12:24
 * Description :
 */

session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

include( '../header.php' );
?>

	<div class="main-content">
	<h1 class="page-title">Admin - Book Appointment</h1>
	<div class="inner-row">
		<div class="col-1">
			<input class="btn back" type="button" value="Back" onclick="window.location.replace('admin-appointments-menu')">
            <h3>Please enter the name of the dentist: </h3>
            <form method="POST" autocomplete="off" action="<?php echo htmlspecialchars('admin-book-appointment');?>">
                <div class="autocomplete">
                    <input id="dentistName" type="text" name="dentistName" placeholder="Dentist Name" required >
                </div>
				<input id="dentistId" type="hidden" name="dentistId">
                <input class="btn" type="submit" name="select" value="Select" />
            </form>
		</div>
	</div>
       <script>
           jQuery(document).ready(function($){
            $(document).ready(function(){
                $.ajax({
                    url: "https://www.emerdency.co.uk/php/autocomplete.php?type=1",
                    method: "GET",
                    success: function (data) {
                        var dentists = [];
                        var dentistsId = [];
						console.log(data);
                        for (var i in data) {
                            dentists.push(data[i].dentistName);
                            dentistsId.push(data[i].id);
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
                        autocomplete(document.getElementById("dentistName"),document.getElementById("dentistId"), dentists, dentistsId);
                    }
                });
            });
           });
        </script>
<?php include( '../footer.php' ); ?>


