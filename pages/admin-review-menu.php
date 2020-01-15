<?php
/**
 * Emerdency-Live - admin-review-menu.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 18/04/2018
 * Time: 16:20
 * Description :
 */
session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

include( '../header.php' );
?>
	<div class="main-content">
	<h1 class="page-title">Administrator Account- Reviews</h1>
	<div class="inner-row">
		<div class="col-1">
			<?php
			if ($_SESSION["successMsg"]){
				echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
				unset($_SESSION["successMsg"]);
			}
			?>
            <input class="btn back" type="button" value="Back" onclick="history.back()">

			<a class="btn black" href="delete-review">Delete Emerdency Review</a>
			<a class="btn black" href="moderate-reviews">Moderate Emerdency Reviews</a>
			<a class="btn black" href="delete-dentist-review">Delete Dentist Review</a>
			<a class="btn black" href="moderate-dentist-reviews">Moderate Dentist Reviews</a>
		</div>
	</div>
<?php include( '../footer.php' ); ?>