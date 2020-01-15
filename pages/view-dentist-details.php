<?php
/**
 * Emerdency-Live - view-dentist-details.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 16/05/2018
 * Time: 18:12
 * Description :
 */

include( "../php/dentist.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

$dentistId = $_SESSION["dentistId"];
$details = getDentistDetails($dentistId);
$practices = getAssociatedPractices($dentistId);

while ($row = mysqli_fetch_assoc($details)){
	$firstName = $row["first_name"];
	$lastName = $row["last_name"];
	$contactNo = $row["contact_no"];
	$email = $row["email_address"];
	$gdcNo = $row["gdc_no"];
	$termsDate = date('F j, Y, g:i a', strtotime($row["terms-timestamp"]));
	if ($row["marketing"]) {
	    $marketingConfirmation = "Yes";
    } else {
	    $marketingConfirmation = "No";
    }
}

include( '../header.php' );
?>
<div class="main-content">
	<h1 class="page-title">View Dentist Details</h1>
	<div class="inner-row">
		<div class="col-1">
			<input class="btn back" type="button" value="Back" onclick="window.location.href='edit-dentist'">
			<p>First Name: <?php echo $firstName;?><br/>
				Last Name: <?php echo $lastName;?><br/>
				GDC Number: <?php echo $gdcNo;?><br/>
			Contact Number: <?php echo $contactNo;?><br/>
			Email Address: <?php echo $email;?><br/>
            Terms and Condition accepted on : <?php echo $termsDate ?><br/>
            Agreed to being contacted for marketing : <?php echo $marketingConfirmation ?></p>
			<p>Associated Practices:
				<ul>
				<?php
				while ($row = mysqli_fetch_assoc($practices)){
					echo "<li>{$row["name"]}</li>";
				}
				?>
			</ul>
			</p>
			</form>
		</div>
	</div>
</div>
<?php include( '../footer.php' ); ?>
