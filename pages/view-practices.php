<?php
/**
 * Emerdency - view-practices.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/04/2018
 * Time: 19:22
 * Description :
 */

include( "../php/reviews.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

$reviews = getAllSiteReviews();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$_SESSION["reviewId"] = $_POST["reviewId"];
	header("location:edit-review");
	exit();
}

include( '../header.php' );
?>
<h1 class="page-title">View/Edit Practices</h1>
<?php
if(mysqli_num_rows($reviews) > 0){

	while ( $row = mysqli_fetch_assoc( $reviews ) ) {
		echo "<div class='col-3'>";
		$dateStr = strtotime( $row["start_date"] );
		$date    = date( 'jS F Y', $dateStr );
		echo "<ul class='appointmentlist'>";
		echo "<li>";
		echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$row["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
		echo "</li>";
		echo "<li><br/><p>" . $row["text"] . "</p></li>";
		echo "<li>" . $date . " - " . $row["name"] . " - " . $row['first_name'] . " " . $row['last_name'] . "</li>";
		echo "<form method='POST' action='" . htmlspecialchars( $_SERVER["PHP_SELF"] ) . "'>";
		echo "<input name='reviewId' type='hidden' value='{$row['id']}' />";
		echo "<input name='practiceId' type='hidden' value='{$row['practiceId']}' />";
		echo "<input class='btn' type='submit' name='edit' value='Edit' />";
		echo "</form>";
		echo "</ul>";
		echo "</div>";
	}
} else {
	echo "<div class='inner-row'>";
	echo "<div class='col-1'>";
	echo "<span class='error'><h2>No Practices.</h2></span>";
	echo "</div>";
	echo "</div>";
}?>

