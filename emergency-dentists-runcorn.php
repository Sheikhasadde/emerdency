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
	                	<a href="https://www.emerdency.co.uk/emergency-dentists-liverpool" itemprop="item"><span itemprop="name">Emergency Dentist Liverpool</span></a>
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

			<p>At Emerdency we pride ourselves in providing quick and convenient emergency dental treatment in the <?php echo $cityloc ?> area at a competitive price and with exceptional levels of customer service. We are confident in our service as we work with experienced emergency dentists <?php echo $cityloc ?> has to offer. We are constantly striving to improve our service by partnering with dentists that are among the best when it comes to providing emergency dental care in the city of <?php echo $cityloc ?>.</p>

			<p>Our service is here for those who are suffering from dental pain or discomfort and are in need of urgent relief. At Emerdency, we do the hard work for you by helping you find a local dentist in <?php echo $cityloc ?> for your emergency dental treatment.</p>

			<p>We hand pick the dentists to ensure you get the best emergency dental care in <?php echo $cityloc ?>.</p>

            <p>Register now to find an emergency dentist in <?php echo $cityloc ?> that is waiting to help you.</p>

            <h2>What does Emergency Dental Treatment Involve?</h2>

			<p>At Emerdency we provide a speedy solution to your dental concerns so that you can have peace of mind that your dental emergency will be dealt with both promptly and professionally. If you are experiencing any pain or discomfort do not hesitate to book an appointment with our emergency dentists in <?php echo $cityloc ?>. At Emerdency we will help to resolve you dental pain together with our experienced and friendly dentists.</p>

			<p>Our emergency dentists are vastly experienced in dealing with a myriad of different dental problems. The dentists will carry out an assessment along with any investigations to help diagnose the problem. Once they have determined the diagnosis, treatment options will be discussed and the consented treatment will be carried out.  </p>

            <h2>The Very Best Emergency Dentists in <?php echo $cityloc ?></h2>

			<p>We pride ourselves on our customer service, excellent value and effective solutions to your dental problems. We constantly strive in making sure we provide the best emergency dentists <?php echo $cityloc ?> has to offer. We provide dental care for all patients whether it’s someone who has their own general dental practitioner or not. Emerdency works towards improving access to dental care, ensuring that everybody can be seen for emergency dental care when they need it most.</p>

			<p>You will be able to book appointments on a first come first served basis to ensure that the process is both fair and efficient for all. We will endeavor to treat you as soon as possible, ideally on the same day.</p>

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

				<img src="images/map-pic.png" width="100%" height="auto"  alt="Emergency Dentist <?php echo $cityloc ?>" />

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

<?php include("inc/liverpool-locations.php"); ?>

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