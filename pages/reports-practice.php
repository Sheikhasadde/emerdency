<?php
/**
 * Emerdency-Live - reports-practice.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 02/05/2018
 * Time: 16:19
 * Description :
 */

include( "../includes/db_connect.php" );
include( "../php/listPractice.php" );

session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index.php");
}

$letters = getLetters();
$practices = getPractices();

if (isset($_GET["char"])) {
	$letter = $_GET["char"];
	$practices = getPracticesByLetter($letter);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST["income"]){
		$_SESSION["practiceId"] = $_POST["practiceId"];
		header( "location:report-practice-income" );
		exit();
	}
	if ($_POST["bookings"]){
		$_SESSION["practiceId"] = $_POST["practiceId"];
		header( "location:report-practice-booking" );
		exit();
	}
}
include( '../header.php' );
?>

	<h1 class="page-title">Reports - Practice</h1>
<?php
if (mysqli_num_rows($practices) > 0) {
	echo "<input class=\"btn back\" type=\"button\" value=\"Back\" onclick=\"window.location.href = 'admin-account'\">";
	if ($_SESSION["successMsg"]){
		echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
		unset($_SESSION["successMsg"]);
	}

	if ($letters){
		echo "<ul class='alphaSort'>
			<li class='sortLi'><a href='reports-practice'>All</a></li>";
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
	echo "<br/>";
	echo "<br/>";

	while ( $row = mysqli_fetch_assoc( $practices ) ) {
		echo "<div class='col-3'>";
		echo "<ul class='appointmentlist'>";
		echo "<li><h2>{$row["name"]}</h2></li>";
		echo "<form method='POST' action='" . htmlspecialchars( $_SERVER["PHP_SELF"] ) . "'>";
		echo "<input name='practiceId' type='hidden' value='{$row['id']}' />";
		echo "<input type='submit' class='btn no-arrow' name='income' value='Income' />";
		echo "<input type='submit' class='btn no-arrow' name='bookings' value='Bookings' />";
		echo "</form>";
		echo "</ul>";
		echo "</div>";
	}
} else {
	echo "<div class='inner-row'>";
	echo "<div class='col-1'>";
	echo "<input class=\"btn back\" type=\"button\" value=\"Back\" onclick=\"window.location.href = 'admin-dentist-menu'\">";
	echo "<span class='error'><h2>No Practices.</h2></span>";
	echo "</div>";
	echo "</div>";
}

?>
    <script src="../chartJS/Chart.min.js" async></script>
<?php include( '../footer.php' ); ?>