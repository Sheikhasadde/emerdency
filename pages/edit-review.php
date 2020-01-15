<?php
/**
 * Emerdency - edit-review.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/04/2018
 * Time: 19:17
 * Description :
 */

include( "../php/reviews.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

echo $reviewId = $_SESSION["reviewId"];

getReviewDetails($reviewId);

include( '../header.php' );
?>
<div class="main-content">
	<h1 class="page-title">Edit Emerdency Review</h1>
	<div class="inner-row">
		<div class="col-1">

		</div>
	</div>
</div>
<?php include( '../footer.php' ); ?>
