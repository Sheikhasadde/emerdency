<?php
/**
 * Emerdency - create-practice.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 27/03/2018
 * Time: 15:51
 * Description :
 */

include( "../php/createPractice.php" );
include( "../includes/functions.php" );

session_start();

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

//$practiceSelect = getPracticesForSelect();

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
	    $success = createPractice($practiceName,$address1, $address2, $city, $county, $postcode, $contactNo);
	    if ($success){
		    $_SESSION["successMsg"] = "Practice has been successfully created.";
		    header("Location:admin-account.php");
		    exit();
	    }
    } else {
	    $error = "An invalid postcode was entered. Please enter a valid postcode.";
    }
}
include( '../header.php' );
?>
<div class="main-content">
	<h1 class="page-title">Create Practice</h1>
	<div class="inner-row">
		<div class="col-1">
            <form><input class="btn back" type="button" value="Back" onclick="history.back()"></form>
			<form class="appointment-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<span class="error"><?php if($error != ""){echo $error."</br>";}?></span>
				<input placeholder="Practice Name" type="text" name="practiceName" required autofocus />
				<input placeholder="First Line of Address" type="text" name="address1" required />
				<input placeholder="Second Line of Address" type="text" name="address2" />
				<input placeholder="City" type="text" name="city" required />
				<select class="customSelect" name="county">
					<option disabled selected >County</option>
					<option disabled >--- England ---</option>
					<option value="Bedfordshire">Bedfordshire</option>
					<option value="Buckinghamshire">Buckinghamshire</option>
					<option value="Cambridgeshire">Cambridgeshire</option>
					<option value="Cheshire">Cheshire</option>
					<option value="Cleveland">Cleveland</option>
					<option value="Cornwall">Cornwall</option>
					<option value="Cumbria">Cumbria</option>
					<option value="Derbyshire">Derbyshire</option>
					<option value="Devon">Devon</option>
					<option value="Dorset">Dorset</option>
					<option value="Durham">Durham</option>
					<option value="East Sussex">East Sussex</option>
					<option value="Essex">Essex</option>
					<option value="Gloucestershire">Gloucestershire</option>
					<option value="Greater London">Greater London</option>
					<option value="Greater Manchester">Greater Manchester</option>
					<option value="Hampshire">Hampshire</option>
					<option value="Hertfordshire">Hertfordshire</option>
					<option value="Kent">Kent</option>
					<option value="Lancashire">Lancashire</option>
					<option value="Leicestershire">Leicestershire</option>
					<option value="Lincolnshire">Lincolnshire</option>
					<option value="Merseyside">Merseyside</option>
					<option value="Norfolk">Norfolk</option>
					<option value="North Yorkshire">North Yorkshire</option>
					<option value="Northamptonshire">Northamptonshire</option>
					<option value="Northumberland">Northumberland</option>
					<option value="Nottinghamshire">Nottinghamshire</option>
					<option value="Oxfordshire">Oxfordshire</option>
					<option value="Shropshire">Shropshire</option>
					<option value="Somerset">Somerset</option>
					<option value="South Yorkshire">South Yorkshire</option>
					<option value="Staffordshire">Staffordshire</option>
					<option value="Suffolk">Suffolk</option>
					<option value="Surrey">Surrey</option>
					<option value="Tyne and Wear">Tyne and Wear</option>
					<option value="Warwickshire">Warwickshire</option>
					<option value="West Berkshire">West Berkshire</option>
					<option value="West Midlands">West Midlands</option>
					<option value="West Sussex">West Sussex</option>
					<option value="West Yorkshire">West Yorkshire</option>
					<option value="Wiltshire">Wiltshire</option>
					<option value="Worcestershire">Worcestershire</option>
					<option disabled value="--- Wales ---">--- Wales ---</option>
					<option value="Flintshire">Flintshire</option>
					<option value="Glamorgan">Glamorgan</option>
					<option value="Merionethshire">Merionethshire</option>
					<option value="Monmouthshire">Monmouthshire</option>
					<option value="Montgomeryshire">Montgomeryshire</option>
					<option value="Pembrokeshire">Pembrokeshire</option>
					<option value="Radnorshire">Radnorshire</option>
					<option value="Anglesey">Anglesey</option>
					<option value="Breconshire">Breconshire</option>
					<option value="Caernarvonshire">Caernarvonshire</option>
					<option value="Cardiganshire">Cardiganshire</option>
					<option value="Carmarthenshire">Carmarthenshire</option>
					<option value="Denbighshire">Denbighshire</option>
					<option disabled value="--- Scotland ---">--- Scotland ---</option>
					<option value="Aberdeen City">Aberdeen City</option>
					<option value="Aberdeenshire">Aberdeenshire</option>
					<option value="Angus">Angus</option>
					<option value="Argyll and Bute">Argyll and Bute</option>
					<option value="City of Edinburgh">City of Edinburgh</option>
					<option value="Clackmannanshire">Clackmannanshire</option>
					<option value="Dumfries and Galloway">Dumfries and Galloway</option>
					<option value="Dundee City">Dundee City</option>
					<option value="East Ayrshire">East Ayrshire</option>
					<option value="East Dunbartonshire">East Dunbartonshire</option>
					<option value="East Lothian">East Lothian</option>
					<option value="East Renfrewshire">East Renfrewshire</option>
					<option value="Eilean Siar">Eilean Siar</option>
					<option value="Falkirk">Falkirk</option>
					<option value="Fife">Fife</option>
					<option value="Glasgow City">Glasgow City</option>
					<option value="Highland">Highland</option>
					<option value="Inverclyde">Inverclyde</option>
					<option value="Midlothian">Midlothian</option>
					<option value="Moray">Moray</option>
					<option value="North Ayrshire">North Ayrshire</option>
					<option value="North Lanarkshire">North Lanarkshire</option>
					<option value="Orkney Islands">Orkney Islands</option>
					<option value="Perth and Kinross">Perth and Kinross</option>
					<option value="Renfrewshire">Renfrewshire</option>
					<option value="Scottish Borders">Scottish Borders</option>
					<option value="Shetland Islands">Shetland Islands</option>
					<option value="South Ayrshire">South Ayrshire</option>
					<option value="South Lanarkshire">South Lanarkshire</option>
					<option value="Stirling">Stirling</option>
					<option value="West Dunbartonshire">West Dunbartonshire</option>
					<option value="West Lothian">West Lothian</option>
					<option disabled value="--- Northern Ireland ---">--- Northern Ireland ---</option>
					<option value="Antrim">Antrim</option>
					<option value="Armagh">Armagh</option>
					<option value="Down">Down</option>
					<option value="Fermanagh">Fermanagh</option>
					<option value="Derry and Londonderry">Derry and Londonderry</option>
					<option value="Tyrone">Tyrone</option>
					<option value=""></option>
				</select>
                <input placeholder="Contact Number" type="tel" pattern="[0-9]*" min="0" name="contactNo" required />
				<input placeholder="Postcode" type="text" name="postcode" required />
				<input class="btn" type="submit" value="Create" />
			</form>
		</div>
	</div>
	<?php include( '../footer.php' ); ?>
