<?php
	include ("../php/availability.php");
	include ("../php/search.php");
	session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get Post Data
	$_SESSION["apptId"] = $_POST["apptId"];
	$_SESSION["apptTime"] = $_POST["apptTime"];
	$_SESSION["apptDate"] = $_POST["apptDate"];
}

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 1) {
	header("location:booking-payment");
	exit();
}

if (!isset($_SESSION["apptId"])){
    header("Location:search-results");
}

include('../header.php');
?>
<h1 class="page-title">Booking Confirmation</h1>
<div class="inner-row">
    <div class="col-1">
        <a class="btn back" onclick="history.back()">Back</a>
        <img class="imgProcess" src="../images/the-process-pay.png" style="display: inline">
        <br/>
		<?php
		echo "Date: " .$_SESSION["apptDate"]. "<br/>Time: " .$_SESSION["apptTime"];
		?>
        <br/> Price: £50
        <?php if ($_SESSION["minor"]){
            echo "<br/>Minor booking: <input type='checkbox' checked disabled>";
		}?>
        <p>Please login or register to continue with the booking process.</p>
        <input type='submit' data-fancybox data-type='iframe' data-src='login-lightbox.php' href='javascript:;' class='btn fancybox-refresh' data-small-btn='true' value='Login / Register' />
    </div>
</div>
<script>
    $(".fancybox-refresh").fancybox({
        afterClose : function() {
            //location.reload();
            window.location = "http://emerdency.co.uk/pages/booking-payment";
            return;
        }
    });
</script>