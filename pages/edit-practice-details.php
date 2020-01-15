<?php
/**
 * Emerdency - edit-practice-details.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/04/2018
 * Time: 21:55
 * Description :
 */

include( "../includes/functions.php" );
include( "../php/createPractice.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

 $practiceId = $_SESSION["practiceId"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get POST Data
	$practiceName = $_POST["practiceName"];
	$address1 = $_POST["address1"];
	$address2 = $_POST["address2"];
	$city = $_POST["city"];
	$county = $_POST["county"];
	$postcode = $_POST["postcode"];
	$contactNo = $_POST["contactNo"];
	$postcodeValid = isPostcodeValid($postcode);

if ($postcodeValid){
	$success = editPractice($practiceId ,$practiceName,$address1, $address2, $city, $county, $postcode,$contactNo);
	if ($success){
		$_SESSION["successMsg"] = "Practice details have successfully been edited.";
		header("location:edit-practice");
		exit();
	}
} else {
	$error = "An invalid postcode was entered. Please enter a valid postcode.";
}

}

function getPracticeDetails($practiceId){
    $db = dbConnect();

    $sql = "SELECT * FROM Practice WHERE id = {$practiceId}";

    $results = $db->query($sql);

    return $results;
}

$counties = array("--- England ---","Bedfordshire","Buckinghamshire","Cambridgeshire","Cheshire","Cleveland","Cornwall","Cumbria","Derbyshire","Devon","Dorset", "Durham","East Sussex","Essex","Gloucestershire","Greater London","Greater Manchester","Hampshire","Hertfordshire",
	"Kent","Lancashire","Leicestershire","Lincolnshire","Merseyside","Norfolk","North Yorkshire","Northamptonshire","Northumberland","Nottinghamshire","Oxfordshire","Shropshire","Somerset","South Yorkshire","Staffordshire","Suffolk","Surrey","Tyne and Wear",
	"Warwickshire","West Berkshire","West Midlands","West Sussex","West Yorkshire","Wiltshire","Worcestershire",
	"--- Wales ---","Flintshire","Glamorgan","Merionethshire","Monmouthshire","Montgomeryshire","Pembrokeshire","Radnorshire","Anglesey","Breconshire","Caernarvonshire","Cardiganshire","Carmarthenshire","Denbighshire",
	"--- Scotland ---","Aberdeen City","Aberdeenshire","Angus","Argyll and Bute", "City of Edinburgh","Clackmannanshire","Dumfries and Galloway","Dundee City","East Ayrshire","East Dunbartonshire","East Lothian","East Renfrewshire","Eilean Siar","Falkirk",
	"Fife","Glasgow City","Highland","Inverclyde","Midlothian","Moray","North Ayrshire","North Lanarkshire","Orkney Islands","Perth and Kinross","Renfrewshire","Scottish Borders","Shetland Islands","South Ayrshire","South Lanarkshire","Stirling","West Dunbartonshire","West Lothian",
	"--- Northern Ireland ---","Antrim","Armagh","Down","Fermanagh","Derry and Londonderry","Tyrone");

$details = getPracticeDetails($practiceId);

include( '../header.php' );
?>
<div class="main-content">
	<h1 class="page-title">Edit Practice Details</h1>
	<div class="inner-row">
		<div class="col-1">
            <form>
                <input class="btn back" type="button" value="Back" onclick="window.location.href = 'edit-practice'">
            </form>
            <?php
                while ($row = mysqli_fetch_assoc($details)){
	                $practiceId = $row["id"];
	                $practiceName = $row["name"];
	                $firstLine = $row["address_line_1"];
	                $secondLine = $row["address_line_2"];
	                $city = $row["city"];
	                $countyDb = $row["state"];
	                $postcode = $row["postcode"];
	                $contactNo = $row["contact_no"];
                }
            ?>
            <form class="appointment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <span class="error"><?php if($error != ""){echo $error."</br>";}?></span>
                <input placeholder="Practice Name" type="text" name="practiceName" value="<?php echo $practiceName;?>" required autofocus />
                <input placeholder="First Line of Address" type="text" name="address1" value="<?php echo $firstLine;?>" required />
                <input placeholder="Second Line of Address" type="text" name="address2" value="<?php echo $secondLine;?>" />
                <input placeholder="City" type="text" name="city" value="<?php echo $city;?>" required />
                <select class="customSelect" name="county">
	                <?php
	                foreach($counties as $county) {
		                if($countyDb == $county) {
			                echo '<option selected="selected" value="'.$county.'">'.$county.'</option>';
		                } else {
			                echo '<option value="'.$county.'">'.$county.'</option>';
		                }
	                }?>
                </select>
                <input placeholder="Postcode" type="text" name="postcode" value="<?php echo $postcode;?>" required />
                <input placeholder="Contact Number" type="tel" pattern="[0-9]*" min="0" value="<?php echo $contactNo?>" name="contactNo" required />
                <input class="btn" type="submit" value="Edit" />
            </form>
		</div>
	</div>
</div>
<?php include( '../footer.php' ); ?>
