<?php
// Custom Functions
include("includes/functions.php");
include("php/search-NEW.php");

// Start Session and initialise variables
session_start();

//if session variable is empty or does not exist user has not logged in, create variable and set to false
if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] != ''){
	$_SESSION['loggedIn'] = "0";
}
?>
<?php $cityloc = "Manchester";?>
<?php $cityloc = "";?>
<!DOCTYPE html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/accept-cookies.css">

	<title>Emerdency Dentists</title>
    <meta name="description" content="Get affordable and professional emergency dental care across Manchester from Emerdency. Book your appointment today with the number one emergency dentist."/>
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
					<form class="appointment-form" method="post" action="<?php echo htmlspecialchars('php/search-NEW.php');?>">
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
    <!-- New HP Content -->
		<div class="inner-row">
	           
			<h1>Emergency Dental Care Within Your Reach</h1>

	        <p>Severe dental pain could be a serious condition that needs urgent attention and shouldn't be taken lightly. Emerdency dental service is designed to flawlessly relieve dental pain, swelling, bleeding, or even prevent your dental from deteriorating. Emerdency is the solution you've been waiting for!</p>
			<p>Regardless of how cautious you are; dental emergencies can occur at any time. Whether you are having toothache, unusual sensitivity in your mouth, or a facial swelling, you will undoubtedly get the best emergency dental service that will help you alleviate your symptoms. Our emergency dental treatments have the following benefits:
				<ul>
					<li>Helps to ease severe dental pain that requires immediate attention</li>
					<li>Ensures that the affected teeth and surrounding tissue are stabilised to prevent further damage</li>
					<li>Offers temporary pain relieve, allowing more time for a permanent treatment to be performed later</li>
				</ul>
			</p>

			<p><strong>Now, be truthful to yourself:</strong>
				<ul>
					<li>Is your mouth in severe pain?</li>
					<li>Can you feel a swelling on your gums?</li>
					<li>Did you sustain an injury resulting in a broken tooth?</li>
					<li>Do you have any painful loose teeth?</li>
					<li>Is there a swelling on your face or near your mouth?</li>
				</ul>
			</p>

			<p>If you answer YES to any of the questions above, then you may likely need to get emergency dental help from a reputable dentist in a clinic near you. Don't know where to go?  Emerdency Dentists have you covered, book an emergency dental appointment with us now!</p>

        </div>
        
        <div class="row" style="background-color:#f2f2f2;">
	        <div class="inner-row">
	            <h2 style="text-align:center;">The Process</h2>
	            <img src="images/the-process.png" width="100%" height="auto" alt="Emergency Dentist <?php echo $cityloc ?> Process"/>
	        </div>
		</div>
        <div class="inner-row">

			<h2>Why Choose Emerdency Dentists?</h2>

			<p>Don't trust anyone but our dentists with your dental emergency. Check out the important reasons why you should book with one of our dentists.</p>

			<p><strong>Excellent Patient Care</strong></p>
			<p>Emerdency puts you first! We care about your dental health and offer a comfortable experience in a relaxed atmosphere. Our team of professional dentists is super-friendly, and always strive to meet your urgent oral needs.</p>

			<p><strong>Transparency and Integrity</strong></p>
			<p>Emerdency dental service is open and transparent. We will always make sure you are satisfied with the service we provide you. If you need urgent help, we will offer you a quick and direct appointment. Emerdency will make you feel comfortable and in safe hands.</p>

			<p><strong>GDC Certified Specialists</strong></p>
			<p>All our dentists are duly registered and certified by the General Dental Council, giving you the confidence that they are very capable of providing emergency dental care in accordance with the latest guidleines.</p>

			<p><strong>Wheel Chair Access</strong></p>
			<p>Are you a patient with mobility concerns? Rejoice, we have you covered! Emerdency offers complete wheelchair access in a number of our clinics.</p>

			<p><strong>Fixed Competitive Price</strong></p>
			<p>Here at Emerdency, our price is fixed. No price uncertainty, no fluctuations, no hidden charges, or additional fees. We stand by our promise and maintain our excellent reputation. Our payment procedure is simple and straightforward.</p>
			<p>Our Emergency Dental Services Present:
			<ul>
				<li>Experienced and Professional Dentists</li>
				<li>No Price Fluctuations – Fixed Price</li>
				<li>Nervous Patients Are Welcome</li>
				<li>Comprehensive Telephone Consultation</li>
				<li>Fast and Easy Appointments</li>
			</ul>
			<br>
		</div>
    <!-- EOF New HP Content -->

		<div class="inner-row">
            <div class="col-3 shift-right">
				<h2 style="padding-top: 0px">We Cover The </br>Following Areas</h2>

			<!-- Areas Covered -->
            <?php include("inc/manchester-locations-HP.php"); ?>
            <!-- EOF Areas covered -->
			</div>
			<div class="col-2">
				<img src="images/map-pic-Northwest.png" width="100%" height="auto" alt="<?php echo $cityloc ?> Emergency Dentist map"/>
			</div>
			<div class="col-2">
				<br>
			</div>
		</div>

		<div class="inner-row">
			<div style="width: 100%; float:left;">
				<h2>Say Goodbye to Dental Pains and Welcome Your Lovely Smiles</h2>
				<h2>Book an Emergency Dental Appointment with Us TODAY!</h2>
			</div>
		</div>
	</div>
    
    </div>
    
    <!-- Extra Search Facility -->
    <div class="row no-padding" style="background-color:#f2f2f2;">
    	<div class="inner-row">
        
        <div class="col-2">
				<div class="form-holder2">
					<h2 style="margin-bottom:0px;">Appointment with a Dentist <?php echo $cityloc ?></h2>
					<form class="appointment-form" method="post" action="<?php echo htmlspecialchars('php/search-NEW.php');?>">
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
         </div>
         <div class="col-2">
                <div class="form-holder2">
                    <h2>Telephone Consultation</h2>
                    <a class="btn-tel" href="tel-search-results" name="tel-search" >Next</a>
                </div>

				<img src="images/price.png" width="100%" height="auto" alt="Emergency Dentist <?php echo $cityloc ?>"/>
			</div>
        
        </div>    
    </div>
    <!-- Extra Search Facility -->
   

	<div class="row no-padding">

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
</div>
<div class="footer">
	<div class="row">
		<div class="inner-row">
        
        <div class="col-3">
			<div class="footer-logo">
				<img src="../images/logo-transparent.png" width="254" height="127" alt="Emerdency - Emergency Dentist <?php echo $cityloc ?>"/><br/>
				<a class="privacy" href="../privacy-policy">Privacy Policy</a> |
                <a class="privacy" href="../cookie-policy">Cookie Policy</a>
			</div>
        </div>

        <div class="col-2">
            <div class="contact-form">
                <form method="post" action="contact-form.php">
                    <input placeholder="Email Address" type="email" name="email_address" required />
                    <input placeholder="Contact Number" type="number" name="contact_no" min="0" required />
                    <textarea class="postcode contactForm" rows="8" maxlength="2000" style="resize:none; white-space: pre-wrap;" name="message" placeholder="Type your message..."></textarea>
                    <input class="btn" type="submit" value="Contact Us" />
                </form>
            </div>
        </div>
            
		</div>
	</div>
</div>
</body>
<script>
    /* Set the width of the side navigation to 500px */
    function openCloseNav() {
        var nav = document.getElementById("mySidenav");
        if (nav.style.width === '500px') {
            nav.style.width = '0';
            document.getElementById("menu-btn").src="images/menu.png";
        } else {
            nav.style.width = "500px";
            document.getElementById("menu-btn").src="images/cancel.png";
        }
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

</html>