<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Custom Functions
include("includes/db_connect.php");
include("includes/functions.php");
include("php/search-NEW.php");

// Start Session and initialise variables
session_start();

//if session variable is empty or does not exist user has not logged in, create variable and set to false
if(isset($_SESSION['loggedIn'])){
	if($_SESSION['loggedIn'] != ''){
		$_SESSION['loggedIn'] = "0";
	}
}
?>

<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="/css/reset.css">
		<link rel="stylesheet" href="/css/boostrap-4.min.css">
		<link rel="stylesheet" href="/css/fonts.css">
		<link rel="stylesheet" href="/css/style-new.css">
	    <link rel="stylesheet" href="/css/accept-cookies.css">

	    <script src="js/jquery-3.3.1.min.js"></script>
	    <script src="js/jquery-ui.1.12.1.min.js"></script>
	    <script src="js/jquery.rateit.min.js"></script>
	    <script src="js/script.js"></script>

		<title><?php echo $meta_title; ?></title>
	    <meta name="description" content="<?php echo $meta_description; ?>"/>
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
