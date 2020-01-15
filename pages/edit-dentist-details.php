<?php
/**
 * Emerdency - edit-dentist-details.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 06/04/2018
 * Time: 13:35
 * Description :
 */

include( "../php/dentist.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get POST Data
    $dentistId = $_POST["dentistId"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $contactNo = $_POST["contact_no"];
    $email = $_POST["email"];
    $gdcNo = $_POST["gdcNo"];
    $telAdvice = $_POST["telAdvice"];

    $success = editDentistAdmin($dentistId, $firstName, $lastName, $contactNo, $email, $gdcNo, $telAdvice);
    if ($success){
	    $_SESSION["successMsg"] = "Dentist details have successfully been edited.";
        header("location:edit-dentist");
        exit();
    }
}

$dentistId = $_SESSION["dentistId"];
$details = getDentistDetails($dentistId);

while ($row = mysqli_fetch_assoc($details)){
	$firstName = $row["first_name"];
	$lastName = $row["last_name"];
	$contactNo = $row["contact_no"];
	$email = $row["email_address"];
	$gdcNo = $row["gdc_no"];
	$telAdvice = $row["tel_advice"];
}

include( '../header.php' );
?>
<div class="main-content">
	<h1 class="page-title">Edit Dentist Details</h1>
	<div class="inner-row">
		<div class="col-1">
            <input class="btn back" type="button" value="Back" onclick="window.location.href='edit-dentist'">
            <form class="appointment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <span class="error"><?php if($error != ""){echo "<br/>".$error."</br>";}?></span>
                <input type="hidden" name="dentistId" value="<?php echo $dentistId;?>" required />
                First Name:
                <input placeholder="First Name" type="text" name="firstName" value="<?php echo $firstName;?>" required autofocus />
                Last Name:
                <input placeholder="Last Name" type="text" name="lastName" value="<?php echo $lastName;?>" required />
                GDC Number:
                <input placeholder="GDC Number" type="text" name="gdcNo" value="<?php echo $gdcNo;?>" required  />
                Contact Number:
                <input placeholder="Contact Number" type="text" name="contact_no" value="<?php echo $contactNo;?>" required/>
                Email Address:
                <input placeholder="Email Address" type="text" name="email" value="<?php echo $email;?>" required />
                Telephone Advice: <label><input type="radio" name="telAdvice" value="1" required <?php if ($telAdvice == 1) { echo "checked='checked'"; } ?> >&nbsp;Yes</label>&nbsp;
                <label><input type="radio" name="telAdvice" value="0" <?php if ($telAdvice == 0) { echo "checked='checked'"; } ?> >No</label></br>
                <input class="btn" type="submit" value="Edit" />
            </form>
		</div>
	</div>
</div>
<?php include( '../footer.php' ); ?>
