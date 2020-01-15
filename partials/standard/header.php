<section class="header-wrapper">
	<header class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="logo text-sm-center text-md-left">
					<a href="../"><img src="/images/logo-horizontal-header.jpg" width="395" height="78" alt="Emerdency - Emergency Dentist <?php echo $cityloc ?>" /></a>
				</div>
			</div>
	       
			<div class="col-lg-6 col-md-12 text-right buttons text-sm-center">
				<?php
					if($_SESSION["loggedIn"] == 0){
						?>
							<a href="/login" class="button-1">PATIENT LOGIN</a>
							<a href="/dentist-login" class="button-2">DENTIST LOGIN</a>
							<a href="/register" class="button-3">REGISTER</a>
						<?php
					}
					elseif($_SESSION["loggedIn"] == 1){
						?>
							<a href="/php/logout.php" class="button">LOG OUT</a>
							<a href="/pages/my-account" class="button">MY ACCOUNT</a>
							<?php
								if ($_SESSION["incompleteBooking"]) {
									if ($_SESSION["timestamp"]){
										$timeNow = time();
										$timestamp = strtotime($_SESSION["timestamp"]);
										if ($timeNow > $timestamp){
											unset($_SESSION["incompleteBooking"]);
											unset($_SESSION["timestamp"]);
											unset($_SESSION["availAppts"]);
										} else {
											echo "<div class='confirm'><a class='confirm button' href='pages/booking-confirmation'>COMPLETE BOOKING</a></div>";
										}
									}
								}
							?>
						<?php
					}
					elseif($_SESSION["loggedIn"] == 2){
						?>
							<a href="/php/logout.php" class="button">LOG OUT</a>
							<a href="/pages/dentist-account" class="button">DENTIST ACCOUNT</a>
						<?php
					}
					elseif($_SESSION["loggedIn"] == 3){
						?>
							<a href="/php/logout.php" class="button">LOG OUT</a>
							<a href="/pages/admin-account" class="button">ADMIN ACCOUNT</a>
						<?php
					}
					else{
						?>
							<a href="/login" class="button">PATIENT LOGIN</a>
							<a href="/dentist-login" class="button">DENTIST LOGIN</a>
							<a href="/register" class="button">REGISTER</a>
						<?php
					}
				?>
			</div>
		</div>
	</header>
</section>