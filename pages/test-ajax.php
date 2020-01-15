<?php
/**
 * Emerdency-Live - test-ajax.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 04/05/2018
 * Time: 16:30
 * Description :
 */

include('../header.php');
?>
<form id="foo">
	<label for="bar">A bar</label>
	<input id="bar" name="bar" type="text" value="" />
	<input type="submit" value="Send" />
</form>

<!-- The result of the search will be rendered inside this div -->
<div id="result"></div>
<script>
    var request = $.ajax({
        type: "POST",
        url: "http://localhost:8888/checkout.php",
        data: {Product_Name: theProduct_Name, Price: thePrice, Product_ID: theProduct_ID},
        dataType: "html"
    });

    request.done(function(msg) {
        alert ( "Response: " + msg );
    });

    request.fail(function(jqXHR, textStatus) {
        alert( "Request failed: " + textStatus );
    });
</script>