<?php
/**
 * Emerdency - bootstrap.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 06/03/2018
 * Time: 13:20
 * Description : Autoload Paypal SDK
 */

// Autoload the SDK Package. This will include all the files and classes to your autoloader

require __DIR__  . '/PayPal-PHP-SDK/autoload.php';

$apiContext = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'AQ_ZTUVd2Wpsmb1FEMQ4cgvyvpssF2aGxVYdfgcwpyk_PV38MxJ4sNHYA8p5xhbXjZHmDTOciJSBYkQx',     // ClientID
		'EKvHsivlb_9Kk44hBPtOrPavgtElgTBZ-jk3W5oDY8GLgW1rhs5LVAwJdlGWhuffLCHGwXaWgd6eJbxj'      // ClientSecret
	)
);

