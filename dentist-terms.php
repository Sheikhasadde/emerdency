<?php
/**
 * Emerdency - dentist-terms.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 19/03/2018
 * Time: 15:54
 * Description :
 */

session_start();
?>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/accept-cookies.css">

        <script src="js/jquery-3.3.1.min.js" ></script>
        <script src="js/jquery.rateit.min.js"></script>

        <title>Dentist Terms And Conditions | Emerdency</title>
        <meta name="description" content="Emerdency is an emergency dental site, we help you find the emergency dentist for you. Get in touch today to find out more about what we do"/>

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
	<div class="main-content">
		<h1 class="page-title">Terms and Conditions</h1>
		<div class="inner-row">
			<div class="col-1">
                <p>These are the Terms of Services and binding agreement between Emerdency and the Dental Provider (“Dentist”).   The following terms of service provide the scope of Services offered by the Dentist.</p>
                <h2>1. Engagement and Services</h2>
                    <h3>1.1 Engagement:</h3>
                        <p> Emerdency at this moment engages the Dentist in providing and performing the Services set out within this agreement (the “Services”), and the Dentist at this moment accepts the engagement.</p>
                    <h3>1.2 Standard of Services:</h3>
                        <p>All Services to be provided by the Dentist shall be performed with promptness and diligence in a professional manner and at a level of proficiency to be expected of a Dentist with the background and experience that the Dentist has represented themselves as having.</p>
                    <h3>1.3 Tools, Instruments and Equipment:</h3>
                        <p>The Dentist shall provide his tools, instruments and equipment and place of performing the Services unless otherwise agreed between the Parties.</p>
                    <h3>1.4 Representation and Warranty:</h3>
                        <p>The Dentist represents and warrants to Emerdency that it is under no contractual or other restrictions or obligations which are inconsistent with the execution of this Agreement or which will interfere with the performance of the Services.</p>
                <h2>2. Contract Period</h2>
                <h3>2.1 Commencement:</h3>
                <p>This Agreement shall commence on the Effective Date and shall remain in effect until the completion of the Services or the earlier termination of this Agreement as provided.</p>
                <h3>2.2 Termination:</h3>
                    <p>This Agreement may be terminated temporarily or indefinitely with immediate effect by either Party in the event of a material breach by the other Party.
                <div class="dashed-list">
                    <p><b class="orange-dash">-</b> “Material breach” shall include any violation of the terms of service.</p>
                    <p><b class="orange-dash">-</b> (ii) any other offence that a Party has failed to cure within the time agreed by the Parties </p>
                    <p><b class="orange-dash">-</b> (iii) the death or physical or mental incapacity of Dentist or any key person performing the Services on its behalf as a result of which the Dentist or crucial such person becomes unable to continue the proper performance of the Services,</p>
                    <p><b class="orange-dash">-</b> (iv) an act of gross negligence or willful misconduct of a Party, and (v) the insolvency, liquidation or bankruptcy of a Party.</p>
                </div><br/>
                <h3>2.3 Effect of Termination:</h3>
                    <p>Upon the effective date of termination of this Agreement, all legal obligations, rights, and duties arising out of this Agreement shall terminate except for such legal responsibilities, powers, and duties as shall have accrued before the effective date of termination and except as otherwise expressly provided in this Agreement.</p>
                <h2>3. Consultancy Fee and Expenses</h2>
                <h3>3.1 Consultancy Fee:</h3>
                    <p>In consideration of the Services to be rendered hereunder, the Patient shall pay a fixed fee for the booking of the appointment to Emerdency and the Patient shall pay a fixed fee to the Dentist for the emergency visit. However, the fixed fees are subject to changes made by Emerdency.</p>
                <p>3.2 The Dentist shall charge the Patient a fixed fee per tooth extracted (excluding surgical extractions).  The fixed fees are subject to changes made by Emerdency.</p>
                <p>3.3 Emerdency shall pay the Dentist a fixed fee for a telephone consultation with the Patient. The telephone consultation will comprise of a 10-minute direct conversation with a GDC-registered Dentist.</p>
                <h2>4. Appointment with a Dentist </h2>
                    <p>4.1 Emerdencys’ online platform will make the appointments for emergency care of the patient, once the patient is booked they must be seen by the Dentist.</p>
                    <p>4.2. The appointment made by Emerdency is to take the individual out of pain, however it is not to provide definitive treatment. In the event the Patient is in need of definitive treatment, “you” the “Dentist” may carry out the treatment.</p>
                    <p>4.3. It is at the Dentist’s discretion to see a patient if he/she arrives more than 10 minutes late to the arranged appointment.</p>
                    <p>4.4. The Dentist may register patients at his/her practice following emergency treatment and charge for definitive treatment as per the Dental practice’s own pricing structure.</p>
                    <p>4.5. The Dentist will provide an online submission to the system at least an hour in advance of the times that are available to see emergency patients. Once the patient has been seen at the Dentist’s practice, the Dentist must confirm the appointment has been completed on the Emerdency online portal.</p>
                    <p>4.6. If the Patients’ dental problem has not resolved at the initial appointment, the Dentist will treat the patient again within a week of the initial visit to address the dental issue at no extra cost to the patient.</p>
                    <p>4.7 The Dentist is solely responsible to diagnose and treat the Patient. In the event the Patient is not satisfied with the treatment/service provided by the Dentist, the dental practice or the staff at the dental practice then the responsibility to resolve the issues lies solely with the Dentist.</p>
                <h2>5. Treatments</h2>
                    <p>Treatments that are included in the Emerdency appointment are as follows:</p>
                    <div class="dashed-list">
                        <p><b class="orange-dash">-</b> Assessment and advice</p>
                        <p><b class="orange-dash">-</b> X-rays and report</p>
                        <p><b class="orange-dash">-</b> Prescription for pain management</p>
                        <p><b class="orange-dash">-</b> Temporary filling</p>
                        <p><b class="orange-dash">-</b> Initiate root canal treatment</p>
                        <p><b class="orange-dash">-</b> Re-cementing a Crown/Bridge/Veneer/Inlay</p>
                        <p><b class="orange-dash">-</b> Management of an infected socket (following an extraction)</p>
                        <p><b class="orange-dash">-</b> Management of an infected wisdom tooth</p>
                        <p><b class="orange-dash">-</b> Draining of an abscess</p>
                        <p><b class="orange-dash">-</b> Re-implantation of an avulsed permanent tooth</p>
                        <p><b class="orange-dash">-</b> Easing of dentures (simple adjustment-does not include sending to a lab for repairs)</p>
                    </div>
                <p>No additional charges should be incurred by the Patient during the emergency dental appointment, which is within the scope of the Services listed above.</p>
                <h2>6. Private Appointments for Definitive Treatment</h2>
                    <p>6.1 Following the emergency treatment of the Patient the Dentist will have the option to register the Patient on the NHS, privately or to discharge them.</p>
                    <p>6.2 The initial treatment performed by the Dentist on Emerdency referred Patients’ will be on a Private basis and not on the NHS.</p>
                <h2>7. Confidentiality of Records. </h2>
                    <p>Confidentiality of patient records and personal information shall be maintained by all UK laws in force as of the effective date of this Agreement and those that may be enacted in the future, including the GDPR guidelines. The Dentist will not use any information received in the course of providing Services to Patients except as necessary for the proper discharge of his/her obligations hereunder. The Dentist agrees to comply with all of the UK requirements..</p>
                <h2>8. Professional Judgment</h2>
                    <p>The Dentist shall have the responsibility for determining treatment and administering care. This Agreement shall not be construed to limit the Dentist from acting within the lawful scope of practice, from advising or advocating on behalf of a patient. This Agreement shall not restrict or prohibit the Dentist from necessary dental care for patients referred from Emerdency. The Dentist agrees not to refuse to provide essential Services to Emerdency clients for emergency treatment.</p>
                <h2>9. Relationship of Parties</h2>
                    <p>All Dentist’s providing care under this Agreement are independent contractors, and nothing herein shall be construed to create an agency, employment, partnership, joint venture or fiduciary relationship between The Dentist and Emerdency.</p>
                <h2>10. Interference with Business</h2>
                    <p>10.1 Non-Competition. During the term of this Agreement, the Dentist will engage in no business or other activities which are, directly or indirectly, competitive with the business activities of Emerdency without obtaining the prior written consent of Emerdency.</p>
                    <p>10.2 Non-Solicitation. The Dentist agrees that for one (1) year after termination of this Agreement, The Dentist shall not divert or attempt to divert from Emerdency any business of any kind in which it is engaged, including, without limitation, the solicitation of or interference with any of its customers, or Patients during the Agreement Period and for one (1) year after that.</p>
                <h2>11. Insurance</h2>
                    <p>The Dentist shall maintain at its sole expense, liability insurance covering the performance of the Services by the Dentist. Any such insurance coverage shall have limits and terms reasonably satisfactory to Emerdency. Emerdency may require the Dentist to provide, a certificate of insurance evidencing such coverage.</p>
                <h2>12. Governing Law and Dispute Resolution</h2>
            <p>These Terms and Conditions and the Agreement to which they relate shall be governed and construed by the laws in force in England and Wales, and the parties submit to the exclusive jurisdiction of the courts of England and Wales.</p>

            <p>The Parties consent to the jurisdiction of England and Wales and venue in the courts of England and Wales.</p>
            </div>
		</div>
<?php include( 'footer.php' ); ?>