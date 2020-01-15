<?php
/**
 * Emerdency - reviews.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/03/2018
 * Time: 21:00
 * Description :
 */

include( "includes/db_connect.php" );
session_start();

function getReviews(){
	$db = dbConnect();
	$sql = "SELECT Review.text, Review.rating, Appointment.start_date, Patient.first_name FROM `Review` 
                INNER JOIN Appointment ON Appointment.id = Review.id 
                INNER JOIN Patient ON Patient.id = Appointment.patient_id
                WHERE Review.status = 1 ORDER BY `Appointment`.`start_date` DESC";

	$result = $db->query($sql);

	return $result;
}
$reviews = getReviews();

$description = "Learn what our customers are speaking about us right here. Let our grateful customers tell you why we are the best Emergency Dentist in Manchester. ";
$title = "Patients reviewing our services | Emerdency ";

include ("header.php");

?>
<h1 class="page-title">Reviews</h1>
<br/>

<?php while ($row = mysqli_fetch_assoc($reviews)){
    echo"<div class='col-3'>";
    $dateStr = strtotime($row["start_date"]);
    $date = date('jS F Y',$dateStr);
    echo "<ul class='appointmentlist'>";
    echo "<li>";
    echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$row["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
    echo "</li>";
    echo "<li><p>"; echo $row["text"];echo "</p></li>";
    echo "<li><p>".$row['first_name']."</p></li>";
    //echo "<li>".$date."</li>";
    echo "</ul>";
    echo "</div>";
}?>

<?php include( 'footer.php' ); ?>