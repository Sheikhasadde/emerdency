<?php
/**
 * Emerdency-Live - edit-practic2.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/04/2018
 * Time: 13:35
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
	$_SESSION["practiceId"] = $_POST["practiceId"];
	header( "location:edit-practice-details" );
	exit();
}
include( '../header.php' );
?>

    <h1 class="page-title">Edit Practice</h1>
<?php
if (mysqli_num_rows($practices) > 0) {
	echo "<input class=\"btn back\" type=\"button\" value=\"Back\" onclick=\"window.location.href = 'admin-account'\">";
	if ($_SESSION["successMsg"]){
		echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
		unset($_SESSION["successMsg"]);
	}

	if ($letters){
		echo "<ul class='alphaSort'>
			<li class='sortLi'><a href='edit-practice'>All</a></li>";
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
		echo "<input class='btn' type='submit' name='edit' value='Edit' />";
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
<?php include( '../footer.php' ); ?>