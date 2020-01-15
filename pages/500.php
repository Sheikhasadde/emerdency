<?php
/**
 * Emerdency-Live - 500.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 30/04/2018
 * Time: 17:11
 * Description :
 */

include('../header.php');
?>
	<div class="inner-row">
		<div class="col-1">
            <div class="error-code">500</div>
			<h2 class="error-code-text">Sorry, we had some technical problems with your last operation.</h2>
			<h3 class="error-code-text">Please refresh the page or click the back button below and try again.</h3>
			<input class="btn" type="button" value="Back" onclick="history.back()">
		</div>
	</div>
<?php include('../footer.php'); ?>