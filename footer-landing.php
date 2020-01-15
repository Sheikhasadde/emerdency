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