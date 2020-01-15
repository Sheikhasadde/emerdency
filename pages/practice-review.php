<?php
/**
 * Emerdency - practice-review.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 26/03/2018
 * Time: 12:29
 * Description :
 */

include ("../includes/db_connect.php");

function getReviews($practiceId){
	$db = dbConnect();
	$sql = "SELECT PracticeReview.text, PracticeReview.rating, Appointment.start_date, Patient.first_name FROM `PracticeReview` 
                INNER JOIN Appointment ON Appointment.id = PracticeReview.id 
                INNER JOIN Practice ON Appointment.practice_id = Practice.id
                INNER JOIN Patient ON Appointment.patient_id = Patient.id
                WHERE PracticeReview.status = 1 AND Practice.id = $practiceId 
                ORDER BY Appointment.start_date DESC";

	$result = $db->query($sql);

	return $result;
}

function getOverallRating($practiceId){
	$db = dbConnect();
	$sql = "SELECT rating FROM Practice WHERE id = {$practiceId}";
	$result = $db->query($sql);
	return $result;
}
$practiceId = $_GET["practiceId"];
$practiceRating = getOverallRating($practiceId);
$reviews = getReviews($practiceId);
$countReview = mysqli_num_rows($reviews);

include('../header-lightbox.php');
?>
	<h1 class="page-title">Dentist Review (<?php echo $countReview ?>)</h1>
	<div class="inner-row">
		<div class="col-1">
			<?php
			echo "<h2>Overall Rating : ";
			 while ($row = mysqli_fetch_assoc($practiceRating)) {
				 echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$row["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
			 }
		echo "</div>";
	echo "</div>";
			echo "</h2>";
			echo "<br/>";
			while ($row = mysqli_fetch_assoc($reviews)){
				$dateStr = strtotime($row["start_date"]);
				$date = date('jS F Y',$dateStr);
				echo "<div class=\"col-3\">";
				echo "<ul class='appointmentlist'>";
				echo "<li>";
				echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$row["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
				echo "</li>";
				echo "<li><br/><p>".$row["text"]."</p></li>";
				echo "<li>".$date."</li>";
				echo "<li><p>".$row['first_name']."</p></li>";
				echo "</ul>";
				echo "</div>";
			}?>
		</div>
	</div>
<?php include('../footer-lightbox.php'); ?>