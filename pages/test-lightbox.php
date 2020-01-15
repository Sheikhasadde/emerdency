<?php
/**
 * Emerdency-Live - test-lightbox.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 18/06/2018
 * Time: 21:10
 * Description :
 */

// Start Session
session_start();

include('../header.php');
?>
	<h1 class="page-title">Booking Confirmation</h1>
	<div class="inner-row">
		<div class="col-1">
				With: 	<input type='submit' data-fancybox data-type='iframe' data-src='register-lightbox2.php' href='javascript:;' class='btn fancybox-refresh' onclick='register' data-small-btn='true' value='Login / Register' />
		        Without:    </div><input type='submit' data-fancybox data-type='iframe' data-src='register-lightbox3.php' href='javascript:;' class='btn fancybox-refresh' onclick='register' data-small-btn='true' value='Login / Register' />
	</div>
<?php include("../footer.php");