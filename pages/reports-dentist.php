<?php
/**
 * Emerdency-Live - reports-dentist.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 02/05/2018
 * Time: 16:20
 * Description :
 */

include( "../includes/db_connect.php" );
include( "../php/listDentist.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

$letters = getLetters();
$dentists = getDentists();

if (isset($_GET["char"])) {
	$letter = $_GET["char"];
	$dentists = getDentistsByLetter($letter);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["income"]){
		$_SESSION["dentistId"] = $_POST["dentistId"];
		header( "location:report-dentist-income" );
		exit();
	}
	if ($_POST["bookings"]){
		$_SESSION["dentistId"] = $_POST["dentistId"];
		header( "location:report-dentist-booking" );
		exit();
	}
}

include( '../header.php' );
?>
	<h1 class="page-title">View Dentist</h1>
	<input class="btn back" type="button" value="Back" onclick="window.location.href = 'admin-account'">
<?php
if ($_SESSION["successMsg"]) {
	echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
	unset( $_SESSION["successMsg"] );
}
if ($letters){
	echo "<ul class='alphaSort'>
						<li class='sortLi'><a href='reports-dentist'>All</a></li>";
	while ($row = mysqli_fetch_assoc($letters)){
		$character = $row["firstCharacter"];
		$count = $row["count"];
		echo "<li class='sortLi'><a href='?char={$character}'>{$character} ({$count})</a></li>";
	}
	echo "</ul>";
} else {
	echo "<ul class='sort'>
						<li class='sortLi'>All</li>
		 			  </ul>";
}

if ($dentists){
	if(mysqli_num_rows($dentists) > 0){
		echo "</br>";
		while ( $row = mysqli_fetch_assoc($dentists) ) {
			echo "<div class='col-3'>";
			echo "<ul class='appointmentlist'>";
			echo "<li><h2>". $row['first_name'] . " " . $row['last_name'] . "</h2></li>";
			echo "<form method='POST' action='" . htmlspecialchars( $_SERVER["PHP_SELF"] ) . "'>";
			echo "<input name='dentistId' type='hidden' value='{$row['id']}' />";
			echo "<input type='submit' class='btn no-arrow' name='income' value='Income' />";
			echo "<input type='submit' class='btn no-arrow' name='bookings' value='Bookings' />";
			echo "</form>";
			echo "</ul>";
			echo "</div>";
		}
	} else {
		echo "<div class='inner-row'>";
		echo "<div class='col-1'>";
		echo "<span class='error'><h2>No Dentists.</h2></span>";
		echo "</div>";
		echo "</div>";
	}
}?>
<script src="../chartJS/Chart.min.js" async></script>
<? include( '../footer.php' );?>