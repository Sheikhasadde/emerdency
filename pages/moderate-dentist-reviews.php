<?php
/**
 * Emerdency - moderate-dentist-reviews.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/03/2018
 * Time: 20:51
 * Description :
 */

include( "../php/reviews.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

$reviews = getDentistReviews();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["approve"]){
        $success = approveDentistReview($_POST["reviewId"]);
	    $avg = updateRatingAvg($_POST["dentistId"]);
	    $_SESSION["successMsg"] = "Review has successfully been approved.";
	    header("Location:moderate-dentist-reviews");
	    exit();
        }

    if ($_POST["decline"]) {
	    deleteDentistReview( $_POST["reviewId"] );
	    header( "Location:moderate-dentist-reviews" );
	    exit();
    }
}

include( '../header.php' );
?>
    <h1 class="page-title">Dentist Reviews</h1>
        <?php
        if(mysqli_num_rows($reviews) > 0){
	        echo "<form><input class=\"btn back\" type=\"button\" value=\"Back\" onclick=\"window.location.href = 'moderate-reviews'\"></form>";
	        while ( $row = mysqli_fetch_assoc( $reviews ) ) {
	            echo "<div class-'col-1>";
		        if ($_SESSION["successMsg"]){
			        echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
			        unset($_SESSION["successMsg"]);
		        }
		        echo "</div>";
		        echo "<div class='col-3'>";
		        $dateStr = strtotime( $row["start_date"] );
		        $date    = date( 'jS F Y', $dateStr );
		        echo "<ul class='appointmentlist'>";
		        echo "<li>";
		        echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$row["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
		        echo "</li>";
		        echo "<li><br/><p>" . $row["text"] . "</p></li>";
		        echo "<li>" . $date . " - Dr. " . $row["name"] . " - " . $row['first_name'] . " " . $row['last_name'] . "</li>";
		        echo "<form method='POST' action='" . htmlspecialchars( $_SERVER["PHP_SELF"] ) . "'>";
		        echo "<input name='reviewId' type='hidden' value='{$row['id']}' />";
		        echo "<input name='dentistId' type='hidden' value='{$row['dentistId']}' />";
		        echo "<input class='btn' type='submit' name='approve' value='Approve' />";
		        echo "<input class='btn' type='submit' name='decline' value='Decline' />";
		        echo "</form>";
		        echo "</ul>";
		        echo "</div>";
	        }
        } else {
	        echo "<div class='inner-row'>";
             echo "<div class='col-1'>";
	        echo "<form><input class=\"btn back\" type=\"button\" value=\"Back\" onclick=\"history.back()\"></form>";
	        if ($_SESSION["successMsg"]){
		        echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
		        unset($_SESSION["successMsg"]);
	        }
	            echo "<span class='error'><h2>No reviews left to moderate.</h2></span>";
	         echo "</div>";
	        echo "</div>";
        }?>
<?php include( '../footer.php' ); ?>