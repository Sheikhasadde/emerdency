<section class="main-wrapper">
	<main class="container">
		<div class="row">
			<div class="col-xl-8 col-lg-7 col-md-7 col-sm-12">
	            <iframe class="youtube" width="100%" height="450" src="https://www.youtube.com/embed/zx4-mOiXqSE?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
	        </div>
			<div class="col-xl-4 col-lg-5 col-md-5 col-sm-12">
				<div class="form-container">
					<h2>Appointment with a Dentist</h2>
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
                        <label>Wheelchair access needed: Yes<input type="radio" name="disAccess" value="1" required>No<input type="radio" name="disAccess" value="0" checked="checked"></label>
						</br>
						<input type="submit" name="search" value="Book Now">
					</form>
				</div>
                <div class="form-container">
                    <h2>Telephone Consultation</h2>
                    <a class="button-submit" href="tel-search-results" name="tel-search" >Phone Now</a>
                </div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<h1>Emergency Dental Care Within Your Reach</h1>
				<ul>
					<li>Are you suffering from severe dental pain?</li>
					<li>Have you got a swelling on your gum?</li>
					<li>Or maybe a swelling on your face, neck or around your mouth?</li>
					<li>Do you have painful loose teeth?</li>
					<li>Have you had an injury which has resulted in broken teeth or injured soft tissues?</li>
				</ul>

				<p>If you answer YES to any of the questions above, then you need the help of an emergency dentist at a clinic near you. Not sure where to go?  Dentists at Emerdency have you covered, book an emergency dental appointment with us now!</p>
			</div>
		</div>


		<!-- <div class="row">
			<div class="col-6">
				<img src="images/price.png" width="100%" height="auto" alt="Emergency Dentist <?php echo $cityloc ?>"/>
			</div>
		</div> -->
			    
		<div class="row">
			<div class="col-12">
				<h2>Emerdency is there when you need it</h2>

				<P>Emerdency dental service is designed to flawlessly provide you the care to relieve you of your dental pain. We all know to well the mental, physical and emotional impact of having to suffer from severe dental pain. Emerdency recognises the need and urgency of delivering dental relief.  Emerdency is the solution you have been waiting for!</P>
				<P>Regardless of how cautious you are, dental emergencies can occur at any time. Whether you are having a toothache, unusual sensitivity in your mouth or a facial swelling, you will undoubtedly get the best emergency dental service that will help you alleviate your symptoms.</P>

				<P>Emerdency has three main objectives when it comes to your urgent dental care. </p>
				<ol>
					<li>Provide relief of the immediate dental pain.</li>
					<li>Ensure the affected teeth and surrounding tissues are stabilised In order to prevent further damage</li>
					<li>To provide temporary pain relief; giving you the time to seek further care for definitive treatment options. </li>
				</ol>
			</div>
		</div>
	            
		<div class="row" style="background-color: #f2f2f2;">
			<div class="col-2">
			</div>
			<div class="col-8">
                <h2 style="text-align:center;">The Process</h2>
                <img src="images/the-process.png" width="100%" height="auto" alt="Emergency Dentist <?php echo $cityloc ?> Process"/>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<h2>Why Choose Emerdency Dentists?</h2>

				<p style="color: #e8541c;font-size: 1.2em;">Our dentists have been handpicked to deliver the best care possible. We aim to meet the following standards. </p>

			</div>
		</div>

		<div class="row">
			<div class="col-6">
				<h2>Excellent Patient Care </h2>
				<p>Emerdency puts you first! We care about your dental health and offer a comfortable experience in a relaxed atmosphere. Our team of professional dentists are super-friendly, and always strive to meet your urgent dental needs. </p>

				<h2>Transparency and Integrity </h2>
				<p>Emerdency is an open and transparent urgent dental care service. We will always make sure you are satisfied with the service we provide you. If you need urgent help, we will offer you a quick and direct appointment. Emerdency will make you feel comfortable in the safe hands of our experienced dentists.</p>
			</div>
			<div class="col-6">
				<h2>GDC Certified Professionals</h2>
				<p>All our dentists are duly registered and certified by the General Dental Council, giving you the confidence that they are very capable of providing emergency dental care in accordance with the latest guidelines.</p>

				<h2>Wheelchair  Access </h2>
				<p>Emerdency offers complete wheelchair access in a number of our clinics. </p>

				<h2>Fixed Competitive Price </h2>
				<p>Here at Emerdency, our price is fixed. There is no price uncertainty, no fluctuations, no hidden charges, or additional fees. We stand by our promise and maintain our excellent reputation. Our payment procedure is simple and straightforward. </p>

			</div>
		</div>
	</main>
</section>