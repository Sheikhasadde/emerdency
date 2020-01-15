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