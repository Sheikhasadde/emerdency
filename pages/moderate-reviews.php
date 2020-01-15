<?php
/**
 * Emerdency - moderate-reviews.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/03/2018
 * Time: 20:51
 * Description :
 */

session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index.php");
}

include( "../php/reviews.php" );

$reviews = getSiteReviews();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["approve"]){
        approveSiteReview($_POST["reviewId"]);
        header("Location:moderate-reviews");
        exit();
    }
    if ($_POST["decline"]){
	    deleteSiteReview($_POST["reviewId"]);
	    header("Location:moderate-reviews");
	    exit();
    }

}
include( '../header.php' );
?>
    <h1 class="page-title">Reviews</h1>
	        <?php
            if(mysqli_num_rows($reviews) > 0) {
	            echo "<form><input class=\"btn back\" type=\"button\" value=\"Back\" onclick=\"history.back()\"></form>";

	            while ( $row = mysqli_fetch_assoc( $reviews ) ) {
		            echo "<div class='col-3'>";
		            $dateStr = strtotime( $row["start_date"] );
		            $date    = date( 'jS F Y', $dateStr );
		            echo "<ul class='appointmentlist'>";
		            echo "<li>";
		            echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$row["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
		            echo "</li>";
		            echo "<li><br/><p>" . $row["text"] . "</p></li>";
		            echo "<li>" . $date . " - " . $row['name'] . " - " . $row['first_name'] . " " . $row['last_name'] . "</li>";
		            echo "<form method='POST' action='";
		            echo htmlspecialchars( $_SERVER["PHP_SELF"] );
		            echo "'>";
		            echo "<input name='reviewId' type='hidden' value='" . $row['id'] . "' />";
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
	            echo "<span class='error'><h2>No reviews left to moderate.</h2></span>";
	            echo "</div>";
	            echo "</div>";
            }
	        ?>
<?php include( '../footer.php' ); ?>