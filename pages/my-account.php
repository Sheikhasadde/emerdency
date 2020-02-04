<?php
	require("../includes/db_connect.php");

	// Start Session & get User ID
	session_start();
  $userId = $_SESSION["userId"];
  //$email = getEmailAddress($userId);
	$confirmed = $_SESSION["confirmed"];
  



	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == '1'){
	} else {
		header("Location:../login");
	}
	
	include('header.php');
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
ul li{
	list-style: none !important;
}
</style>
<div class="main-content">
<div class="col-md-12 page-header-2" >

</div>
	<h1 class="text-center" >My Account</h1>
	<div class="col-md-12">
		<?php  
		if ($_SESSION["successMsg"]){
			echo "<span class='error'><h2>{$_SESSION["successMsg"]}</h2></span>";
			unset($_SESSION["successMsg"]);
		}
		switch($confirmed){
			case "0":
			echo "<h2 >Please confirm your account.</h2>";
		}
		?>
		<div class="col-md-10 col-md-offset-1" style="background:#e8541c" >
		<ul class="nav nav-tabs">
			
            <?php
            
            switch ($confirmed){
	            case "0" :
            	 
                echo "<li class='active'>
                <a data-toggle='tab' href='#appointment'>
                <img src='../images/appointmentic.png' class='tabic' style='vertical-align:middlen' width='42' height='42' />
                <span>Appointments</span> </a>
                </li> ";
                echo " <li><a data-toggle='tab' href='#add-child'>
                 <img src='../images/ac.png' class='tabic' style='vertical-align:middlen' width='42' height='42' />
                <span>Add Child Patient To Account</span></a></li> ";
                  echo "<li><a data-toggle='tab' href='#change-password'>
                  <img src='../images/cp.png' class='tabic' style='vertical-align:middlen' width='42' height='42' />
                  <span>Change Password</span>
                  </a></li> ";
                  echo "<li><a data-toggle='tab' href='#view-details'>
                  <img src='../images/md.png' class='tabic' style='vertical-align:middlen' width='42' height='42' />
                  View Details
                  </a></li>";
                  echo "<li><a data-toggle='tab' href='#edit-account-details'>
                  <img src='../images/ed.png' class='tabic' style='vertical-align:middlen' width='42' height='42' />
                  Edit Details</a></li>";
                  echo "<li><a class=\"\" href=\"../php/logout.php\">
                  <img src='../images/lg.png' class='tabic' style='vertical-align:middlen' width='42' height='42' />
                  Logout</a></li>";
                  break;
                case "1" :
                    echo "<a class=\"btn black\" href=\"appointments\">Appointments</a> </br>";
	              echo "<a class=\"btn black\" href=\"add-child\">Add Child Patient to Account</a> </br>";
                  echo "<a class=\"btn black\" href=\"change-password\">Change my Password</a> </br>";
                  echo "<a class=\"btn black\" href=\"view-details\">View Details</a> </br>";
                  echo "<a class=\"btn black\" href=\"edit-account-details\">Edit Details</a> </br>";
                  echo "<a class=\"btn\" href=\"../php/logout.php\">Logout</a>";
                    break;
                case "2" :
                    echo "<h2>There is a problem with this account. Please use the contact form to request support.</h2>";
                    break;
            }?>

  </ul>

  <div class="tab-content" style="height:auto; margin-bottom:30px; min-height:300px;">
    <div id="appointment" class="tab-pane fade in active">
     
      
    <?php  include ("appointments.php"); ?>
    </div>
    <div id="add-child" class="tab-pane fade">
     
    
      <?php  include ("add-child.php"); ?>
    </div>
    <div id="change-password" class="tab-pane fade">
    <?php  include ("change-password.php"); ?>
    </div>
    <div id="view-details" class="tab-pane fade">
    <?php  include ("view-details.php"); ?>
    </div>
	<div id="edit-account-details" class="tab-pane fade">
  <?php  include ("edit-account-details.php"); ?>
    </div>

  </div>
</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>