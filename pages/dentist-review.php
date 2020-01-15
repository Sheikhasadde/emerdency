<?php
/**
 * Emerdency - dentist-review.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 26/03/2018
 * Time: 12:29
 * Description :
 */

include ("../includes/db_connect.php");

function getReviews($dentistId){
	$db = dbConnect();
	$sql        = "SELECT DentistReview.text, DentistReview.rating, Appointment.start_date, Patient.first_name, Appointment.practiceDentist_id FROM DentistReview 
                INNER JOIN Appointment ON Appointment.id = DentistReview.id 
                INNER JOIN PracticeDentist ON Appointment.practiceDentist_id = PracticeDentist.id
                INNER JOIN Dentist ON PracticeDentist.dentist_id = Dentist.id
                INNER JOIN Patient ON Appointment.patient_id = Patient.id
                WHERE DentistReview.status = 1 AND Dentist.id = $dentistId 
                ORDER BY Appointment.start_date DESC";

	$result = $db->query($sql);

	return $result;
}

function getOverallRating($dentistId){
	$db = dbConnect();
	$sql = "SELECT rating FROM Dentist WHERE id = {$dentistId}";
	$result = $db->query($sql);
	return $result;
}
$dentistId      = $_GET["dentistId"];
$dentistRating = getOverallRating($dentistId);
$reviews        = getReviews($dentistId);
$countReview    = mysqli_num_rows($reviews);

include('../header-lightbox.php');
?>
	<h1 class="page-title">Dentist Review (<?php echo $countReview ?>)</h1>
	<div class="inner-row">
		<div class="col-1">
			<?php
			echo "<h2>Overall Rating : ";
			 while ($row = mysqli_fetch_assoc($dentistRating)) {
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