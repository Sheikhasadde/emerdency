<?php
    session_start();

    $title = "Emergency Dentist Near Me Contact Page | Emerdency";
    $description = "Get in touch with your local emergency dentist today through Emerdency, we make it simple, why make it complicated?";

    include( "php/contact-form.php" );
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $reason = $_POST["reason"];
        $name = $_POST["name"];
        $email = $_POST["email_address"];
        $contact = $_POST["contact_no"];
        $message = $_POST["message"];

        $success = contactEmerdency($reason, $name, $email, $contact, $message);

        if ($success){
	        header("Location:pages/contact-thank-you");
	        exit;
        }
    }

    include("header.php");
?>
<div class="main-content">
<div class="col-md-12 page-header" >

</div>
<div class="col-md-10 col-md-offset-2">
    <h1 class="page-title">Contact</h1>
</div>
    <div class="col-md-12 ">
        <div class="col-md-2"></div>
        <div class="col-md-8 contact-form-container">
           
<div class="col-md-2"></div>
<span class="error"><?php if($error != ""){echo "<p>{$error}</p>";}?></span>
                <div class="col-md-8 contact-form">
                    <h2  style="color:#e8541c; text-align:center; margin-bottom:20px; ">Get In Touch With Us</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="col-md-6 first">
                            <select class="customSelect cf-input" name="reason">
                                <option selected disabled>Reason for contacting...</option>
                                <option value="General Enquiry">General Enquiries</option>
                                <option value="Complaint">Complaints</option>
                                <option value="Cancellation">Cancellations</option>
                            </select>
                            <input placeholder="Name " class="cf-input" type="text" name="name" required />
                        </div>
                        <div class="col-md-6">
                            <input placeholder="Email Address" type="email" name="email_address" required class="cf-input" />
                            <input placeholder="Contact Number" type="number" name="contact_no" min="0" required class="cf-input"/>
                        </div>
                       <div class="col-md-12">
                        <textarea class="postcode contactForm cf-input" rows="16" maxlength="2000" style="resize:none; white-space: pre-wrap;" name="message" placeholder="Type your message..."></textarea>
                       </div>
                        <div class="col-md-6">
                        <input class="btn cf-input" style="border:2px solid #e8541c" type="submit" value="Contact Us" />
                       </div>
                    </form>
                </div>
                <div class="col-md-2"></div>
        </div>
<div class="col-md-2">

</div>
    </div>
</div>

<?php include( 'footer.php' ); ?>