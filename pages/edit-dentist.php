<?php
/**
 * Emerdency - edit-dentist.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 06/04/2018
 * Time: 13:35
 * Description :
 */

include( "../includes/db_connect.php" );
include( "../php/listDentist.php" );

session_start();

// Check if Admin
if($_SESSION['loggedIn'] !== 3) {
	header( "Location:../index" );
	exit();
}

$letters = getLetters();
$dentists = getDentists();

if (isset($_GET["char"])) {
	$letter = $_GET["char"];
	$dentists = getDentistsByLetter($letter);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ( $_POST["edit"] ) {
		$_SESSION["dentistId"] = $_POST["dentistId"];
		header( "location:edit-dentist-details" );
		exit();
	}
	if ( $_POST["assign"] ) {
		$_SESSION["dentistId"] = $_POST["dentistId"];
		header( "location:assign-practice" );
		exit();
	}
	if ( $_POST["view"] ) {
		$_SESSION["dentistId"] = $_POST["dentistId"];
		header( "location:view-dentist-details" );
		exit();
	}
	if ( $_POST["remove"] ) {
		$_SESSION["dentistId"] = $_POST["dentistId"];
		header( "location:remove-dentist-practice" );
		exit();
	}
}

include( '../header.php' );
?>
<h1 class="page-title">View Dentist</h1>
<input class="btn back" type="button" value="Back" onclick="window.location.href = 'admin-account'">
<?php
if ($letters){
	echo "<ul class='alphaSort'>
						<li class='sortLi'><a href='edit-dentist'>All</a></li>";
	while ($row = mysqli_fetch_assoc($letters)){
		$character = $row["firstCharacter"];
		$count = $row["count"];
		echo "<li class='sortLi'><a href='?char={$character}'>{$character} ({$count})</a></li>";
	}
	echo "</ul>";
} else {
	echo "<ul class='sort'>
						<li class='sortLi'>All</li>
		 			  </ul>";
}
if ($_SESSION["successMsg"]) {
	echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
	unset( $_SESSION["successMsg"] );
}
if ($dentists){
	if(mysqli_num_rows($dentists) > 0){
		echo "</br>";
		while ( $row = mysqli_fetch_assoc($dentists) ) {
			echo "<div class='col-2'>";
			    echo "<ul class='dentistList'>";
			    //echo "<li>";
			    echo "<div class='col-2 title rate'>";
			        echo "<h2>". $row['first_name'] . " " . $row['last_name'] ;

			        if ($row["confirmed"] == 2){
			            echo " - Suspended";
                    }
			        echo "</h2>";
			    echo "</div>";
			    echo "<div class='col-2 rate'>";
			        echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$row["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
			    echo "</div>";
			    echo "<div class='col-2 buttons'>";
			            echo "<form method='POST' action='" . htmlspecialchars( $_SERVER["PHP_SELF"] ) . "'>";
			            echo "<input name='dentistId' type='hidden' value='{$row['id']}' />";
			            echo "<input class='btn' type='submit' name='view' value='View Details' />";
			            echo "<input class='btn' type='submit' name='edit' value='Edit Details' />";
			    echo "</div>";
			        echo "<div class='col-2 buttons'>";
			            echo "<input class='btn' type='submit' name='assign' value='Assign Practice' />";
			            echo "<input class='btn' type='submit' name='remove' value='Remove Practice' />";
			        echo "</div>";
			//echo "<input onClick=\"javascript: return confirm('This process cannot be undone. Please confirm if you wish to permanently delete this review.');\" class='btn' type='submit' name='edit' value='Delete' />";
			echo "</form>";
			//echo "</li>";
			    echo "</ul>";
			echo "</div>";
	}
	} else {
		echo "<div class='inner-row'>";
		echo "<div class='col-1'>";
		echo "<span class='error'><h2>No Dentists.</h2></span>";
		echo "</div>";
		echo "</div>";
	}
}
include( '../footer.php' );
?>