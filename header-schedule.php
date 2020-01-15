<?php
/**
 * Emerdency - header-schedule.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 07/03/2018
 * Time: 16:25
 * Description :
 */
?>
<html>
<head>
    <script src="/js/jquery-3.3.1.min.js" ></script>
	<script src="/js/jquery.fancybox.min.js" ></script>

    <script src="../scheduler/dhtmlxscheduler.js" type="text/javascript"></script>
    <script src="../scheduler/ext/dhtmlxscheduler_quick_info.js" type="text/javascript"></script>
    <script src="../scheduler/ext/dhtmlxscheduler_editors.js"></script>

    <link rel="stylesheet" href="../scheduler/dhtmlxscheduler_material.css" type="text/css">

    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/jquery.fancybox.min.css">

    <link rel="stylesheet" href="../css/style.css">

	<title>Welcome to Emerdency - Emergency Dentist Search</title>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WD3L53T');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WD3L53T"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="top-bar home">FIXED PRICE • GDC CERTIFIED DENTISTS • LIVE AVAILABILITY</div>
<div class="header">
    <div class="inner-row">
        <div class="logo">
            <a href="../"><img src="../images/logo-web.jpg" width="403" height="199" /></a>
        </div>

        <div class="sm-btns">
            <div class="instagram"><a href="https://www.instagram.com/emerdencyuk/"><img src="../images/instagram.png" width="45" height=45"/></a></div>
            <div class="facebook"><a href="https://www.facebook.com/Emerdency-2055938214617610/"><img src="images/facebook-logo.png" width="45" height="45" alt="Facebook" /> </a> </div>
            <div class="twitter"><a href="https://twitter.com/emerdency"><img src="images/twitter-logo.png" width="45" height="45" alt="Twitter"/></a></div>
            <div class="contact-details">
                <a href="tel:07864614694">07864 614 694</a><br/>
                <a href="mailto:info@emerdency.co.uk">info@emerdency.co.uk</a>
            </div>
        </div>
		<?php
		echo "<div class='login-wrapper'>";
		switch ($_SESSION["loggedIn"]){
			case "0" :
				echo "<div class='patient-login'><a href='../login' >PATIENT LOGIN</a></div>";
				echo "<div class='dentist-login'><a href='../dentist-login' >DENTIST LOGIN</a></div>";
				echo "<div class='register'><a href='../register' >REGISTER</a></div>";
				break;
			case "1" :
				echo "<div class='patient-login'><a href='my-account' >MY ACCOUNT</a></div>";
				echo "<div class='dentist-login'><a href='../php/logout.php'>LOG OUT</a></div>";
				if ($_SESSION["incompleteBooking"]) {
					if ($_SESSION["timestamp"]){
						$timeNow = time();
						$timestamp = strtotime($_SESSION["timestamp"]);
						if ($timeNow > $timestamp){
							unset($_SESSION["incompleteBooking"]);
							unset($_SESSION["timestamp"]);
							unset($_SESSION["availAppts"]);
						} else {
							echo "<div class='confirm'><a class='confirm' href='booking-confirmation'>COMPLETE BOOKING</a></div>";
						}
					}
				}
				break;
			case "2" :
				echo "<div class='patient-login'><a href='../php/logout.php' >LOG OUT</a></div>";
				echo "<div class='dentist-login long'><a href='dentist-account' >DENTIST ACCOUNT</a></div>";
				break;
			case "3" :
				echo "<div class='register'><a href='admin-account' >ADMIN ACCOUNT</a></div>";
				echo "<div class='dentist-login'><a href='../php/logout.php' >LOG OUT</a></div>";
				break;
			default:
				echo "<div class='patient-login'><a href='../login' >PATIENT LOGIN</a></div>";
				echo "<div class='dentist-login'><a href='../dentist-login' >DENTIST LOGIN</a></div>";
				echo "<div class='register'><a href='../register' >REGISTER</a></div>";
				break;
		}
		echo "<span class='open' onclick=\"openCloseNav()\"><img class='menu-icon' id='menu-btn' src='../images/menu.png'/></span>
            <div id=\"mySidenav\" class=\"sidenav\">
                    <a href=\"../\" />HOME</a>
					<a href=\"../about\" />ABOUT US</a>
					<a href=\"../fees\" />FEES</a>
					<a href=\"../faq\" >FAQs</a>
					<a href=\"../reviews\" />REVIEWS</a>
					<a href=\"../contact-form\" />CONTACT FORM</a>
					<a href=\"../terms\" />TERMS AND CONDITIONS</a>
            </div>";
		echo "</div>";
		?>
        <div class="main-navigation">
            <ul>
                <ul>
                    <li><a href="../" />HOME</a></li>
                    <li><a href="../about" />ABOUT US</a></li>
                    <li><a href="../fees" />FEES</a></li>
                    <li><a href="../faq" >FAQs</a></li>
                    <li><a href="../reviews" />REVIEWS</a></li>
                    <li><a href="../contact-form" />CONTACT FORM</a></li>
                    <li><a href="../terms" />TERMS AND CONDITIONS</a></li>
                </ul>
            </ul>
        </div>
    </div>
</div>