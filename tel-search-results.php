<?php
/**
 * Emerdency-Live - tel-search-results.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 01/05/2018
 * Time: 13:47
 * Description :
 */

include( "php/tel-search.php" );
include( "php/contact-form.php" );

session_start();

// Perform Search
$appts = performTelSearch();

?>
<head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/rateit.css">
    <link rel="stylesheet" href="css/accept-cookies.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">

    <script src="js/jquery-3.3.1.min.js" ></script>
    <script src="js/jquery.fancybox.min.js" ></script>
    <script src="js/jquery.rateit.min.js"></script>

    <title>Emerdency Dentist Telephone Appointment | Emerdency</title>
    <meta name="description" content="Ideal for those who are unsure if they need to be seen by a dentist and are seeking advice, reassurance or a second opinion.  You are just one call away from putting your mind at ease.  "/>

    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WD3L53T');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WD3L53T"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="top-bar index">FIXED PRICE • GDC CERTIFIED DENTISTS • LIVE AVAILABILITY</div>
<div class="header">
    <div class="inner-row">
        <div class="logo">
            <a href="../"><img src="images/logo-web.jpg" width="403" height="199" /></a>
        </div>

        <div class="sm-btns">
            <div class="facebook"><a href="https://www.facebook.com/Emerdency-2101936376749425/"><img src="images/facebook.jpg" width="45" height=45"/></a></div>
            <div class="twitter"><a href="https://twitter.com/emerdency"><img src="images/twitter.jpg" width="45" height=45"/></a></div>
        </div>
		<?php
		echo "<div class='login-wrapper'>";
		switch ($_SESSION["loggedIn"]){
			case "0" :
				echo "<div class='patient-login'><a href='login' >PATIENT LOGIN</a></div>";
				echo "<div class='dentist-login'><a href='dentist-login' >DENTIST LOGIN</a></div>";
				echo "<div class='register'><a href='register' >REGISTER</a></div>";
				break;
			case "1" :
				echo "<div class='dentist-login'><a href='php/logout.php'>LOG OUT</a></div>";
				echo "<div class='patient-login'><a href='pages/my-account' >MY ACCOUNT</a></div>";
				if ($_SESSION["incompleteBooking"]) {
					if ($_SESSION["timestamp"]){
						$timeNow = time();
						$timestamp = strtotime($_SESSION["timestamp"]);
						if ($timeNow > $timestamp){
							unset($_SESSION["incompleteBooking"]);
							unset($_SESSION["timestamp"]);
							unset($_SESSION["availAppts"]);
						} else {
							echo "<div class='confirm'><a class='confirm' href='pages/booking-confirmation'>COMPLETE BOOKING</a></div>";
						}
					}
				}
				break;
			case "2" :
				echo "<div class='patient-login'><a href='php/logout.php' >LOG OUT</a></div>";
				echo "<div class='dentist-login long'><a href='pages/dentist-account' >DENTIST ACCOUNT</a></div>";
				break;
			case "3" :
				echo "<div class='dentist-login'><a href='php/logout.php' >LOG OUT</a></div>";
				echo "<div class='register'><a href='pages/admin-account' >ADMIN ACCOUNT</a></div>";
				break;
			default:
				echo "<div class='patient-login'><a href='login' >PATIENT LOGIN</a></div>";
				echo "<div class='dentist-login'><a href='dentist-login' >DENTIST LOGIN</a></div>";
				echo "<div class='register'><a href='register' >REGISTER</a></div>";
				break;
		}
		echo "<span class='open' onclick=\"openCloseNav()\"><img class='menu-icon' id='menu-btn' src='images/menu.png'/></span>
            <div id=\"mySidenav\" class=\"sidenav\">
                    <a href=\"../\" />HOME</a>
					<a href=\"about\" />ABOUT US</a>
					<a href=\"fees\" />FEES</a>
					<a href=\"faq\" >FAQs</a>
					<a href=\"reviews\" />REVIEWS</a>
					<a href=\"contact-form\" />CONTACT FORM</a>
					<a href=\"terms\" />TERMS AND CONDITIONS</a>
            </div>";
		echo "</div>";
		?>
        <div class="main-navigation">
            <ul>
                <ul>
                    <li><a href="../" />HOME</a></li>
                    <li><a href="about" />ABOUT US</a></li>
                    <li><a href="fees" />FEES</a></li>
                    <li><a href="faq" >FAQs</a></li>
                    <li><a href="reviews" />REVIEWS</a></li>
                    <li><a href="contact-form" />CONTACT FORM</a></li>
                    <li><a href="terms" />TERMS AND CONDITIONS</a></li>
                </ul>
            </ul>
        </div>
    </div>
</div>
<h1 class="page-title">Telephone Consultation</h1>
<div class="inner-row">
	<div class="col-1">
		<?php
		if (mysqli_num_rows($appts) > 0 ) {
		    echo "<img class='imgProcess' src='images/the-process-select.png'>";

				if($error){echo "<span class='error'>{$error}</br></span>";}
				if($_SESSION["errUnavailable"]){
			          echo "<br/><h2 class='error'>{$_SESSION["errUnavailable"]}</br></h2>"; unset($_SESSION["errUnavailable"]);
				}
			foreach ($appts as $appt) {
				$dateStr = strtotime($appt["start_date"]);
				$date = date('l jS F Y',$dateStr);
				$time = date('g:i A',$dateStr);

				echo " <ul class='appointmentlist'>";
				echo "<div class='col-2'>";
				echo "<li>Date: ".$date."</li>";
				echo "<li>Time: ".$time."</li>";
				echo "</div>";
				echo "<div class='col-2'>";
				echo "Dentist Rating: ";
				echo "<div class='rateit toothS' id='rateit' data-rateit-resetable='false' data-rateit-starwidth='32' data-rateit-starheight='32' data-rateit-value='{$appt["rating"]}' data-rateit-ispreset=\"true\" data-rateit-readonly=\"true\"></div>";
				echo "<a data-fancybox data-type='iframe' data-src='pages/dentist-review.php?dentistId={$appt["dentist_id"]}' href='javascript:;' class='btn review' data-small-btn='true'>See Reviews</a>";
				echo "</div>";

				echo "<form method='post' action='pages/tel-booking-confirmation'>";
				echo "<input name='apptTime' type='hidden' value='".$time."' />";
				echo "<input name='apptDate' type='hidden' value='".$date."' />";
				echo "<input name='apptId' type='hidden' value='".$appt["id"]."' />";
				echo "<input name='apptType' type='hidden' value='2' />";
				echo "<input class='btn book' type='submit' value='Book Appointment' />";
				echo "</form>";
				echo "</ul>";
			}
		} else {
		        if($error){echo "<span class='error'>{$error}</br></span>";}
				if($_SESSION["errUnavailable"]){
			          echo "<br/><span class='error'>{$_SESSION["errUnavailable"]}</br></span>"; unset($_SESSION["errUnavailable"]);
				}
		        echo "<img class='imgProcess' src='images/the-process-search.png'>";
				echo "<h2>Sorry</h2>";
				echo "<p>No telephone bookings are currently available. Please enter your email address and contact number below and we shall contact you as soon as an appointment becomes available.</p>";
				//echo "<button class='btn black'>Contact</button>";
				if($error2){echo "<span class='error'>{$error2}</br></span>";}
				echo "<form method='post' action=".htmlspecialchars('php/contact.php').">";
				echo "<input type='hidden' name='type' value='tel' />";
				echo "<div class='col-2'>";
				echo "<input type='number' name='contactNo' placeholder='Phone Number' /> ";
				echo "</div>";
				echo "<div class='col-2'>";
				echo "<input placeholder='Email Address' type='email' name='email' required />";
				echo "</div>";
				echo "<input class='btn black' type='submit' name='searchContact' value='Submit' />";
				echo "</form>";
		}
		?>
	</div>
</div>
<?php include( 'footer.php' ); ?>
