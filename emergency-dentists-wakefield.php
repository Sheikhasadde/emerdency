<?php // $cityloc = "Manchester";?>

<?php $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$numSegments = count($segments); 
$currentSegment = $segments[$numSegments - 1];

$urllocation = str_replace ("emergency-dentists-", "", ($currentSegment));
$urldashremove = str_replace ("-", " ", ($urllocation));

$cityloc = ucfirst($urldashremove); ?>

<?php

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



	<title>Emergency Dentists <?php echo $cityloc ?> | Emergency Dental Practice <?php echo $cityloc ?> | Emerdency</title>

    <meta name="description" content="Are you based in the <?php echo $cityloc ?> area and in need of an emergency dentist. Emerdency are the people to consult you on to who to choose for your local emergency dentist"/>



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

<div class="top-bar index">EMERGENCY DENTISTS <?php echo $cityloc ?> &middot; FIXED PRICE &middot; GDC CERTIFIED DENTISTS &middot; LIVE AVAILABILITY</div>

<div class="header">

    <div class="inner-row">

        <div class="logo">

            <a href="../"><img src="images/logo-web.jpg" width="403" height="199" alt="Emerdency - Emergency Dentist <?php echo $cityloc ?>" /> /></a>

        </div>



        <div class="sm-btns">

            <div class="facebook"><a href="https://www.facebook.com/Emerdency-2055938214617610/"><img src="images/facebook.jpg" width="45" height=45" alt="Facebook"/></a></div>

            <div class="twitter"><a href="https://twitter.com/emerdency"><img src="images/twitter.jpg" width="45" height=45"  alt="Twitter"/></a></div>

        </div>
        <div class="phonenumber">Call Now: <a href="tel:07549706263">07549 706 263</a></div>

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
                    <li><a href="https://www.emerdency.co.uk" />HOME</a></li>
                    <li><a href="https://www.emerdency.co.uk/about" />ABOUT US</a></li>
                    <li><a href="https://www.emerdency.co.uk/fees" />FEES</a></li>
                    <li><a href="https://www.emerdency.co.uk/faq" >FAQs</a></li>
                    <li><a href="https://www.emerdency.co.uk/reviews" />REVIEWS</a></li>
                    <li><a href="https://www.emerdency.co.uk/contact-form" />CONTACT FORM</a></li>
                    <li><a href="https://www.emerdency.co.uk/terms" />TERMS AND CONDITIONS</a></li>
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

			<!-- Added breadcrumbs -->
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
	                	<a href="https://www.emerdency.co.uk/emergency-dentists-leeds" itemprop="item"><span itemprop="name">Emergency Dentist Leeds</span></a>
	                    <meta content="2">
	                </li>
                    
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	                	<a href="https://www.emerdency.co.uk/emergency-dentists-<?php echo $urllocation; ?>" itemprop="item"><span itemprop="name"><?php echo $cityloc ?></span></a>
	                    <meta content="3">
	                </li>
	      
	            </ul>
	      
	        </nav>
	        
	    </div>
        <!-- EOF Added breadcrumbs -->
        
			<h1>Emergency Dentists <?php echo $cityloc ?></h1>

            <h2>How Emerdency Can Help</h2>

            <p>We are Emerdency and we are an emergency dentist service based in <?php echo $cityloc ?>. We provide a spectrum of emergency dental treatment to ensure optimal care of your dental health. We help you locate the number one emergency dentists in <?php echo $cityloc ?> who are highly-trained and a qualified group of dentists. We are the best emergency dentists <?php echo $cityloc ?> has to offer and we are constantly striving to maintain these high standards that we have set ourselves.</p>

            <p>Our services are provided to the highest calibre, ensuring that we treat you both swiftly and effectively to relieve pain as quickly as possible and allow you to continue with your daily activities pain free. We are passionate about bringing emergency dental treatment promptly to you, so you can live your day to day life without the worry of your dental pain. You can benefit from our service by booking an appointment with an emergency dentist in <?php echo $cityloc ?> via our booking form that is convenient to find and fill out for a hassle-free experience.</p>

            <h2>The Best Emergency Dentists In <?php echo $cityloc ?></h2>

			<p>If you are looking for emergency dental treatment in Leeds then look no further than Emerdency. We are able to provide the best and most efficient emergency dental treatments in the Leeds area. Not only that, we are also able to offer all of these services at an extremely competitive price, so be sure to take a look around our website to see what services we provide and to find out more about how we can help you in your time of need.</p>

		    <p>Our patients are seen on a first come, first serve basis to ensure fairness across the board. Our dentists give you their undivided attention when you need it the most, ensuring you are pain free in the time frame of your appointment without compromising on the quality of care and service.</p>

            <h2>Find Out More About Our Emergency Dentists <?php echo $cityloc ?></h2>

            <p>Our goal is to be as accessible to as many people as possible so that when you are in need of emergency dental treatment, you can receive it promptly and at a location convenient to you. Our service is available to everyone; those who are registered with a dentist and those that are not can both benefit by receiving emergency dental care at one of the dental practices in <?php echo $cityloc ?>.</p>

            <p>If you would like to be seen today and be part of this innovative and fast-growing service that provides emergency dentists in <?php echo $cityloc ?>, then feel free to book your appointment today. If you have any further questions or concerns please do get in touch with us via our <a href="contact-form">contact form</a> so we can help you find a swift resolution to your dental worries.</p>

        </div>

	<div class="row no-padding">

		<div class="inner-row">

			<div class="col-3 shift-right">

				<h2 style="padding-top: 50px">We Cover The </br>Following Areas</h2>

				<div class="col-2 no-padding">

					<ul>

						<li>Greater Manchester</li>

						<li>West Midlands</li>

						<li>West Yorkshire</li>

					</ul>

				</div>

				<div class="col-2 no-padding">

					<ul>

						<li>Merseyside</li>

						<li>South Yorkshire</li>

					</ul>

				</div>

			</div>

			<div class="col-2">

				<img src="images/map-pic.png" width="100%" height="auto"  alt="Emergency Dentist <?php echo $cityloc ?>" />>

			</div>

		</div>

	</div>



	<div class="row" style="background-color:#f2f2f2;">

		<div class="inner-row">

			<h2 style="text-align:center;">The Process</h2>

			<img src="images/the-process.png" width="100%" height="auto" alt="Emergency Dentist <?php echo $cityloc ?>" />

		</div>

	</div>



	<div class="row" style="background-image: url(images/emergency-treatments-bg.png); background-size: cover; background-repeat:no-repeat;">
		<div class="inner-row">
			<h2 style="text-align:center;">Our Emergency Dentist in <?php echo $cityloc ?> can help you with the following:</h2>
			<div class="col-2">
				<ul style="margin-left: 286px;">
<li>» Toothache</li>
<li>» Sensitivity</li>
<li>» Broken filling/tooth</li>
<li>» Swelling/Abscess</li>
<li>» Wisdom tooth pain</li>
				</ul>
			</div>
			<div class="col-2">
				<ul>
<li>» Dry socket</li>
<li>» Denture adjustments</li>
<li>» Re-cement Crowns/Onlays/Veneers/Bridges</li>
<li>» Dental Trauma</li>
<li>» Painful gums</li>
				</ul>
			</div>
		</div>
	</div>





	<div class="row orange">

		<div class="inner-row specials-wrap">

			<div class="col-3 slash">

				<h3 class="specials">Fixed Price</h3>

			</div>

			<div class="col-3 slash">

				<h3 class="specials">GDC Certified Dentists</h3>

			</div>

			<div class="col-3">

				<h3 class="specials">Live Availability</h3>

			</div>

		</div>

	</div>

<?php include("inc/leeds-locations.php"); ?>

</div>

<div class="footer">

	<div class="row">

		<div class="inner-row">
        
        <div class="col-3">
			<div style='text-align: left;'>
				<img src="../images/logo-transparent.png" width="254" height="127" alt="Emerdency - Emergency Dentist <?php echo $cityloc ?>"/><br/>
				<a class="privacy" href="../privacy-policy">Privacy Policy</a> |
                <a class="privacy" href="../cookie-policy">Cookie Policy</a>
			</div>
        </div>
        
        <div class="col-3">
        
        <p><strong>Locations Covered:</strong></p>
        <ul>
        <li><a href="https://www.emerdency.co.uk/emergency-dentists-manchester">Manchester</a></li>
        <li><a href="https://www.emerdency.co.uk/emergency-dentists-leeds">Leeds</a></li>
        <li><a href="https://www.emerdency.co.uk/emergency-dentists-liverpool">Liverpool</a></li>
        <li><a href="https://www.emerdency.co.uk/emergency-dentists-birmingham">Birmingham</a></li>
        </ul>
        
        </div>
            
		</div>

	</div>

</div>

<script>

    /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */

    function openNav() {

        document.getElementById("mySidenav").style.width = "250px";

        document.getElementById("main").style.marginLeft = "250px";

    }



    /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */

    function closeNav() {

        document.getElementById("mySidenav").style.width = "0";

        document.getElementById("main").style.marginLeft = "0";

    }

</script>

<!--Start of Tawk.to Script-->

<script type="text/javascript">

    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();

    (function(){

        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];

        s1.async=true;

        s1.src='https://embed.tawk.to/5acf26b94b401e45400e9096/default';

        s1.charset='UTF-8';

        s1.setAttribute('crossorigin','*');

        s0.parentNode.insertBefore(s1,s0);

    })();

</script>

<!--End of Tawk.to Script-->

<script src="js/jquery-3.3.1.min.js"></script>

<script src="js/cookiepopup.js"></script>

<script >

    var options = {

        "title": "This website uses cookies",

        "text": "By using this site, you agree to our use of cookies.",

        "theme": "dark",

        "learnMore": true,

        "position": "bottomleft"

    };

    $.acceptCookies(options);

</script>

</body>

</html>