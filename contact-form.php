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
    <h1 class="page-title">Contact Form</h1>
    <div class="inner-row">
        <div class="col-1">
            <br/>

                <span class="error"><?php if($error != ""){echo "<p>{$error}</p>";}?></span>
                <div class="contact-form">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="col-2 first">
                            <select class="customSelect" name="reason">
                                <option selected disabled>Reason for contacting...</option>
                                <option value="General Enquiry">General Enquiries</option>
                                <option value="Complaint">Complaints</option>
                                <option value="Cancellation">Cancellations</option>
                            </select>
                            <input placeholder="Name" type="text" name="name" required />
                        </div>
                        <div class="col-2">
                            <input placeholder="Email Address" type="email" name="email_address" required />
                            <input placeholder="Contact Number" type="number" name="contact_no" min="0" required />
                        </div>
                        <textarea class="postcode contactForm" rows="16" maxlength="2000" style="resize:none; white-space: pre-wrap;" name="message" placeholder="Type your message..."></textarea>
                        <input class="btn" type="submit" value="Contact Us" />
                    </form>
                </div>
        </div>
    </div>
</div>
<?php include( 'footer-no-contact.php' ); ?>