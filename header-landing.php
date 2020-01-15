<?php

$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$numSegments = count($segments);
$currentSegment = $segments[$numSegments - 1];

$urllocation = str_replace ("emergency-dentists-", "", ($currentSegment));
$urldashremove = str_replace ("-", " ", ($urllocation));

$cityloc = ucfirst($urldashremove);

// Custom Functions
include("includes/functions.php");
include("php/search.php");

// Start Session and initialise variables
session_start();

//if session variable is empty or does not exist user has not logged in, create variable and set to false
if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != ''){
	$_SESSION['loggedIn'] = "0";
}

?>
<!DOCTYPE html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/accept-cookies.css">

    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $description; ?>"/>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TPQ3J8C');</script>
    <!-- End Google Tag Manager -->
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Dentist",
        "name": "Emerdency",
        "image": "https://www.emerdency.co.uk/images/logo-web.jpg",
        "@id": "",
        "url": "https://www.emerdency.co.uk",
        "telephone": "+4407549706263",
        "priceRange": "££",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Office 115 275 Deansgate, Manchester , M3 4EL ",
            "addressLocality": "Manchester",
            "addressRegion": "Manchester",
            "postalCode": "M3 4EL",
            "addressCountry": "UK"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 33.2102434,
            "longitude": -96.63625300000001
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday"
            ],
            "opens": "09:00",
            "closes": "17:00"
        },
        "sameAs": [
            "https://www.facebook.com/Emerdency-2055938214617610/",
            "https://twitter.com/emerdency"
        ]
    }
    </script>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TPQ3J8C"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="top-bar index">EMERGENCY DENTISTS <?php echo $cityloc ?> &middot; FIXED PRICE &middot; GDC CERTIFIED DENTISTS &middot; LIVE AVAILABILITY</div>
<div class="header">
    <div class="inner-row">
        <div class="logo">
            <a href="../"><img src="images/logo-web.jpg" width="403" height="199" alt="Emerdency - Emergency Dentist <?php echo $cityloc ?>" /></a>
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
        <div class="phonenumber">Call Now: <a href="tel:07864614694">07864 614 694</a><br/><a class="phonenumber" href="mailto:info@emerdency.co.uk">info@emerdency.co.uk</a></div>
		<?php
		echo "<div class='login-wrapper'>";
		switch ($_SESSION["loggedIn"]){
			case "0" :
				echo "<div class='patient-login'><a href='login.php' >PATIENT LOGIN</a></div>";
				echo "<div class='dentist-login'><a href='dentist-login.php' >DENTIST LOGIN</a></div>";
				echo "<div class='register'><a href='register.php' >REGISTER</a></div>";
				break;
			case "1" :
				echo "<div class='dentist-login'><a href='php/logout.php'>LOG OUT</a></div>";
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
				echo "<div class='dentist-login long'><a href='pages/dentist-account.php' >DENTIST ACCOUNT</a></div>";
				break;
			case "3" :
				echo "<div class='dentist-login'><a href='php/logout.php' >LOG OUT</a></div>";
				echo "<div class='register'><a href='pages/admin-account.php' >ADMIN ACCOUNT</a></div>";
				break;
			default:
				echo "<div class='patient-login'><a href='login.php' >PATIENT LOGIN</a></div>";
				echo "<div class='dentist-login'><a href='dentist-login.php' >DENTIST LOGIN</a></div>";
				echo "<div class='register'><a href='register.php' >REGISTER</a></div>";
				break;
		}
		echo "<span class='open' onclick=\"openCloseNav()\"><img class='menu-icon' id='menu-btn' src='images/menu.png' alt='Menu'/></span>
            <div id=\"mySidenav\" class=\"sidenav\">
                    <a href=\"../\" />HOME</a>
					<a href=\"about.php\" />ABOUT US</a>
					<a href=\"fees.php\" />FEES</a>
					<a href=\"faq.php\" >FAQs</a>
					<a href=\"reviews.php\" />REVIEWS</a>
					<a href=\"contact-form.php\" />CONTACT FORM</a>
					<a href=\"terms.php\" />TERMS AND CONDITIONS</a>
					<a href=\"blog.php\" />BLOG</a>
            </div>";
		echo "</div>";
		?>
        <div class="main-navigation">
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
    </div>
</div>
<div class="main-content">
    <div class="hero-shot row">
        <div class="inner-row">
            <div class="col-2 home-video">
                <iframe class="youtube" width="530" height="275" src="https://www.youtube.com/embed/zx4-mOiXqSE?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <h1><span class="hero-text"><strong>Emergency Dentist <?php echo $cityloc ?></strong></span></h1>
                <h2><span class="hero-text">Emergency</br> <span class="second-line">dental care at</span> </br> <span class="third-line">your fingertips</span></span></h2>
            </div>

            <div class="col-2">
                <div class="form-holder">
                    <h2 style="margin-bottom:0px;">Appointment with a Dentist <?php echo $cityloc ?></h2>
                    <form class="appointment-form" method="post" action="<?php echo htmlspecialchars('php/search.php');?>">
                        <input class="postcode" type="text" name="postcode" placeholder="Postcode" required >
                        <select class="distance" name="distance" required>
                            <option value="" disabled selected>Distance willing to travel</option>
                            <option value="10">10 miles</option>
                            <option value="20">20 miles</option>
                            <option value="30">30 miles</option>
                            <option value="40">40 miles</option>
                            <option value="50">50 miles</option>
                        </select>
                        <label>Wheelchair access needed:</label> <label><input type="radio" name="disAccess" value="1" required >&nbsp;Yes</label>&nbsp;
                        <label><input type="radio" name="disAccess" value="0" checked="checked">&nbsp;No</label></br>
                        <input class="btn" type="submit" name="search" value="Next">
                    </form>
                </div>

                <div class="form-holder2">
                    <h2>Telephone Consultation</h2>
                    <a class="btn-tel" href="tel-search-results" name="tel-search" >Next</a>
                </div>
                <img src="images/price.png" width="100%" height="auto" alt="Emergency Dentist <?php echo $cityloc ?>"/>
            </div>
        </div>
    </div>
    <div class="row no-padding">
        <div class="inner-row">
            <!-- Added breadcrumbs
            <div class="BreadcrumbsWrapper">
                <nav class="BreadcrumbsContainer">
                    <ul class="breadcrumbs" itemscope itemtype=
                    "http://schema.org/BreadcrumbList">
                        <li>You are here:</li>
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a href="https://www.emerdency.co.uk" itemprop="item"><span itemprop="name">Home</span></a>
                            <meta content="1">
                        </li>
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a href="https://www.emerdency.co.uk/emergency-dentists-<?php echo $urllocation; ?>" itemprop="item"><span itemprop="name">Emergency Dentist <?php echo $cityloc ?></span></a>
                            <meta content="3">
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- EOF Added breadcrumbs -->
