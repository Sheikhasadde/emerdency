<?php
/**
 * Emerdency - leave-review.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 16/03/2018
 * Time: 14:50
 * Description :
 */

include ("../includes/db_connect.php");
include ("../includes/functions.php");

function saveReviews($apptId,$siteReview, $dentistReview, $ratingSite, $ratingDentist){
	$db = dbConnect();

	$sql = "INSERT INTO Review (id, text, rating) VALUES ($apptId,'$siteReview',$ratingSite);";
	$sql2 = "INSERT INTO DentistReview (id, text, rating) VALUES ($apptId,'$dentistReview',$ratingDentist);";
	$sql3 = "UPDATE `Appointment` SET `status`= 4 WHERE id = {$apptId};";
	$result1 = $db->query($sql);
	$result2 = $db->query($sql2);
	$result3 = $db->query($sql3);

	return $result3;
}
	$reviewToken = $_GET["appointment"];

	// If form has been submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$apptId = base64_decode($_POST["apptId"]);
		$siteReview = nl2br($_POST["siteReview"]);
		$dentistReview = nl2br($_POST["dentistReview"]);
		$ratingSite = $_POST["ratingSite"];
		$ratingDentist = $_POST["ratingDentist"];
		$result = saveReviews($apptId,$siteReview, $dentistReview, $ratingSite, $ratingDentist);
		if ($result){
			header("location:review-success");
			exit();
		} else {
			$error = "A review has already been submitted.";
        }
	}
include('../header.php');
?>
	<div class="main-content">
	    <h1 class="page-title">Review</h1>
	<div class="inner-row">
		<div class="col-1">
            <?php if ($error) { echo "<br/><span class='error'>";echo $error."</br></span>";}?>
			<h2>Your Feedback is greatly appreciated. </h2>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h3>Emerdency Website Review</h3> <br/>
                <div class="rateit tooth" id="rateitSite" data-rateit-resetable="false" data-rateit-starwidth="64" data-rateit-starheight="64" data-rateit-value="2.5" data-rateit-ispreset="true"></div><br/><br/>
				<input type="hidden" name="apptId" value="<?php echo $reviewToken ?>" />
                <input type="hidden" id="ratingSite" name="ratingSite" />
				<textarea class="postcode" rows="16" maxlength="2000" style="resize:none" name="siteReview" placeholder="Describe your experience..." required></textarea><br/>

            <h3>Your Dentist Review</h3> <br/>
                <div class="rateit tooth" id="rateitDentist" data-rateit-resetable="false" data-rateit-starwidth="64" data-rateit-starheight="64" data-rateit-value="2.5" data-rateit-ispreset="true"></div><br/><br/>
                <input type="hidden" id="ratingDentist" name="ratingDentist" />
                <textarea class="postcode" rows="16" maxlength="2000" style="resize:none" name="dentistReview" placeholder="Describe your experience..." required></textarea><br/>
                <button class="btn black" type="submit" id="btnClick" name="btnSubmit">Submit Reviews</button>
            </form>
        </div>
    </div>
	</div>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $(function(){
                $('#btnClick').click(function(){
                    var ratingValue;
                    ratingValue = $('#rateitSite').rateit('value');
                    document.getElementById("ratingSite").value = ratingValue;
                });
            });

            $(function(){
                $('#btnClick').click(function(){
                    var ratingValue;
                    ratingValue = $('#rateitDentist').rateit('value');
                    document.getElementById("ratingDentist").value = ratingValue;
                });
            });
        });

    </script>
<?php include('../footer.php'); ?>