<?php
/**
 * Emerdency-Live - all-patients.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 17/05/2018
 * Time: 15:11
 * Description :
 */

session_start();

include( "../php/patients.php" );

if($_SESSION['loggedIn'] !== 3){
	header("Location:../index");
}

//check if the starting row variable was passed in the URL or not
if (!isset($_GET['row']) or !is_numeric($_GET['row'])) {
	//we give the value of the starting row to 0 because nothing was found in URL
	$startRow = 0;
//otherwise we take the value from the URL
} else {
	$startRow = (int)$_GET['row'];
}
$letters = getLetters();

if (isset($_GET["char"])) {
	$letter = $_GET["char"];
	$patients = getPatientsByLetter($startRow, $letter);
} else {
	$patients = getAllPatients($startRow);
}

include( '../header.php' );
?>
	<div class="main-content">
		<h1 class="page-title">Patient List</h1>
				<input class="btn back" type="button" value="Back" onclick="window.location.replace('admin-patient-menu')">
		<?if ($letters){
		echo "<ul class='alphaSort'>
			<li class='sortLi'><a href='patient-list'>Most Recent</a></li>";
			while ($row = mysqli_fetch_assoc($letters)){
			$character = $row["firstCharacter"];
			$count = $row["count"];
			echo "<li class='sortLi'><a href='?char={$character}'>{$character} ({$count})</a></li>";
			}
			echo "</ul>";
		} else {
		echo "<ul class='alphaSort'>
			<li class='sortLi'>All</li>
		</ul>";
		}?>
				<table class="adminAppt">
					<tr>
						<th>Name</th>
						<th>D.O.B</th>
						<th>Address</th>
						<th>Town/City</th>
						<th>Postcode</th>
						<th>Contact No</th>
						<th>Email Address</th>
                        <th>Terms accepted on</th>
                        <th>Marketing consent</th>
						<th>Status</th>
					</tr>
					<?php
					if (mysqli_num_rows($patients) > 0) {
						echo "<tr>";
						while ( $row = mysqli_fetch_assoc($patients) ) {
						    if ($row["marketing"]){
						        $marketing = "Yes";
                            } else {
						        $marketing = "No";
                            }
							$termsDate = date('F j, Y, g:i a', strtotime($row["terms-timestamp"]));
							$dateTime = date( 'd/m/y', strtotime( $row["dob"] ) );
							$address = $row["house_no_name"].", ";
							$address .= $row["address_line_1"]  ;
							if($row["address_line_2"]){
								$address .= ", ".$row["address_line_2"];
							}
							echo "<tr>";
							echo "<td>{$row["patientName"]}</td>";
							echo "<td>{$dateTime}</td>";
							echo "<td>{$address}</td>";
							echo "<td>{$row["town_city"]}</td>";
							echo "<td>{$row["postcode"]}</td>";
							echo "<td>{$row["contact_no"]}</td>";
							echo "<td>{$row["email_address"]}</td>";
							echo "<td>{$termsDate}</td>";
							echo "<td>{$marketing}</td>";
							switch ( $row["confirmed"] ) {
								case 0 :
									echo "<td>Unconfirmed</td>";
									break;
								case 1 :
									echo "<td>Confirmed</td>";
									break;
								case 2 :
									echo "<td>Suspended</td>";
									break;
							}
							echo "</tr>";
						}
							echo "</tr>";
					}
				echo "</table>";

					echo '<a class="btn back next" href="?char='.$letter.'?row='.($startRow+100).'">Next</a>';
					$prev = $startRow - 100;
					//only print a "Back" link if a "Next" was clicked
					if ($prev >= 0)
						echo '<a class="btn back" href="'.$_SERVER['PHP_SELF'].'?row='.$prev.'">Back</a>';
					?>
			</div>
<?php include( '../footer.php' );?>