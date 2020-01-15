<?php
/**
 * Emerdency - delete-dentist-review.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/04/2018
 * Time: 16:42
 * Description :
 */

include("../php/reviews.php");
include ("../php/listDentist.php");

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["delete"]){
	    $reviewId = $_POST["reviewId"];
	    $dentistId = $_POST["dentistId"];
	    $success = deleteDentistReview($reviewId);
	    $success = updateRatingAvg($dentistId);
    }
}

$reviews = getApprovedDentistReviews();

include('../header.php');
?>
    <h1 class="page-title">Delete Dentist Review</h1>
    <input class="btn back" type="button" value="Back" onclick="window.location.href = 'admin-account'">
<?php
if ($success){
	echo "<span style='text-align: center;' class='error'><h2>Review successfully deleted.</h2></span>";
	unset($success);
}
if ($reviews){
	if(mysqli_num_rows($reviews) > 0){
		echo "</br>";
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
			echo "<input name='dentistId' type='hidden' value='{$row['dentistId']}' />";
			echo "<input name='reviewId' type='hidden' value='{$row['id']}' />";
			echo "<input class='btn no-arrow' type='submit' name='delete' value='Delete' />";
			//echo "<input onClick=\"javascript: return confirm('This process cannot be undone. Please confirm if you wish to permanently delete this review.');\" class='btn' type='submit' name='edit' value='Delete' />";
			echo "</form>";
			echo "</ul>";
			echo "</div>";
		}
	} else {
		echo "<div class='inner-row'>";
		echo "<div class='col-1'>";
		echo "<span class='error'><h2>No reviews.</h2></span>";
		echo "</div>";
		echo "</div>";
	}
}

    include('../footer.php');
 ?>