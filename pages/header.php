<?php
    session_start();

    //if session variable is empty or does not exist user has not logged in, create variable and set to false
    if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != ''){
        $_SESSION['loggedIn'] = "0";
    }

    if (!isset($title)){
	    $title = "Emergency Dentist | Emergency Dental Care & Treatment | Emerdency";
    }

    if (!isset($description)){
        $description = "Get affordable and professional emergency dental care across Manchester from Emerdency. Book your appointment today with the number one emergency dentist.";
    }
?>
<head>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery.fancybox.min.js" ></script>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/rateit.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
	<link rel="stylesheet" href="../css/bootstrap3.css"> 


    <link rel="stylesheet" href="../css/accept-cookies.css">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TPQ3J8C');</script>
    <!-- End Google Tag Manager -->

    <title><?php echo $title;?></title>
    <meta name="description" content="<?php echo $description;?>"/>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TPQ3J8C"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="col-md-12 col-sm-12 hide-xs top-bar index">
	
<div class="col-md-6 phonenumber"><span class="glyphicon glyphicon-earphone"></span> &nbsp&nbsp&nbsp           07864 614 694  &nbsp &nbsp &nbsp
<span class="glyphicon glyphicon-envelope"> </span>     &nbsp &nbsp &nbsp      info@emerdency.co.uk
</div>
<div class="col-md-6 sm-btns">
            <div class="instagram"><a href="https://www.instagram.com/emerdencyuk/"><span class="fa fa-instagram"></span></a></div>
            <div class="facebook"><a href="https://www.facebook.com/Emerdency-2055938214617610/"><span class="fa fa-facebook"></span> </a> </div>
            <div class="twitter"><a href="https://twitter.com/emerdency"><span class="fa fa-twitter"></span></a></div>
            <!-- <div class="contact-details">
                <a href="tel:07864614694">07864 614 694</a><br/>
                <a href="mailto:info@emerdency.co.uk">info@emerdency.co.uk</a>
            </div> -->
        </div>
</div>
<div class="header">
	<div class="inner-row col-md-12">
		<div class="logo col-md-2">
			<a href="../"><img src=" ../images/logo-web.jpg" width="200px" height="100px" alt="Emerdency - Emergency Dentist <?php echo $cityloc ?>" /></a>
		</div>
       
        <div class="main-navigation col-md-6">
			<ul>
				<ul>
					<li><a href="../" />HOME</a></li>
					<li><a href="about.php" />ABOUT US</a></li>
					<li><a href="fees.php" />FEES</a></li>
					<li><a href="faq.php" >FAQs</a></li>
					<li><a href="reviews.php" />REVIEWS</a></li>
					<li><a href="contact-form.php" />CONTACT</a></li>
					<li><a href="terms.php" />TERMS AND CONDITIONS</a></li>
					<li><a href="blog.php" />BLOG</a></li>
				</ul>
			</ul>
		</div>
       
		<?php
		echo "<div class='login-wrapper col-md-4'>";
		switch ($_SESSION["loggedIn"]){
			case "0" :
				echo "<div class='patient-login'><a href='login.php' >LOGIN</a></div>";
				// echo "<div class='dentist-login'><a href='dentist-login.php' >DENTIST LOGIN</a></div>";
				echo "<div class='register'><a href='register.php' >REGISTER</a></div>";
				break;
			case "1" :
				echo "<div class='patient-login'><a href='php/logout.php'>LOG OUT</a></div>";
				echo "<div class='patient-login'><a href='pages/my-account.php' >MY ACCOUNT</a></div>";
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
				echo "<div class='patient-login long'><a href='pages/dentist-account.php' >DENTIST ACCOUNT</a></div>";
				break;
			case "3" :
				echo "<div class='patient-login'><a href='php/logout.php' >LOG OUT</a></div>";
				echo "<div class='register'><a href='pages/admin-account.php' >ADMIN ACCOUNT</a></div>";
				break;
			default:
				echo "<div class='patient-login'><a href='login.php' >LOGIN</a></div>";
				// echo "<div class='dentist-login'><a href='dentist-login.php' >DENTIST LOGIN</a></div>";
				echo "<div class='register'><a href='register.php' >REGISTER</a></div>";
				break;
		}
		echo "<span class='open' onclick=\"openCloseNav()\"><img class='menu-icon' id='menu-btn' src='images/menu.png' alt='Menu'/></span>
            <div id=\"mySidenav\" class=\"sidenav\">
                    <a href=\"../\" />HOME</a>
					<a href=\"about\" />ABOUT US</a>
					<a href=\"fees\" />FEES</a>
					<a href=\"faq\" >FAQs</a>
					<a href=\"reviews\" />REVIEWS</a>
					<a href=\"contact-form\" />CONTACT FORM</a>
					<a href=\"terms\" />TERMS AND CONDITIONS</a>
					<a href=\"blog\" />BLOG</a>
            </div>";
		echo "</div>";
		?>
		
	</div>
</div>
<div class="introline">
<p>EMERGENCY DENTISTS . FIXED PRICE . GDC CERTIFIED DENTISTS . LIVE AVAILABLITY</p>
</div>