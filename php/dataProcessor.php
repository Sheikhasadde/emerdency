<?php
/**
 * Emerdency - dataProcessor.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 15/03/2018
 * Time: 14:36
 * Description :
 */

session_start();

$dentistId = $_SESSION["userId"];
$_SESSION["practiceId"] = "3";

require_once("../scheduler/connector/scheduler_connector.php");
require_once("../scheduler/connector/dataprocessor.php");

function myInsert($action){
	$action->addField("dentist_id", "21");
}

?>
