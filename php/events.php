<?php
/**
 * Emerdency - events.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 14/03/2018
 * Time: 12:45
 * Description :
 */

session_start();

$practiceDentist_id = $_GET["pd"];

require_once("../scheduler/connector/scheduler_connector.php");
require_once("../scheduler/connector/db_mysqli.php");
require_once ("../includes/db_connect.php");

define("DBTYPE","MySQLi");
$db = dbConnect();

$conn = new SchedulerConnector($db,DBTYPE);
$list = new OptionsConnector($db, DBTYPE);

function my_insert($data){
	global $conn;
	global $practiceDentist_id;
	$id = $data->get_value("id");
	$start = $data->get_value("start_date");
	$end = $data->get_value("end_date");
	$text = $data->get_value("text");
	$pdId = $data->get_value("practiceDentist_id");
	$disAccess = $data->get_value("dis_access");
	$telAdvice = $data->get_value("type");

	if ($telAdvice == 2){
		$sql = "INSERT INTO Appointment (`practiceDentist_id`, `start_date`, `end_date`, `text`, `dis_access`, `type`) VALUES ({$pdId},'{$start}', '{$end}', '{$text}', {$disAccess}, 2);";
	} else {
		$sql = "INSERT INTO Appointment (`id2`,`practiceDentist_id`, `start_date`, `end_date`, `text`, dis_access) VALUES ({$id},{$pdId},'{$start}', '{$end}', '{$text}', {$disAccess});";
	}
	$conn->sql->query($sql);
	$data->success();
}

$list->render_sql("SELECT PracticeDentist.id AS `pdId`, Practice.name AS label FROM Practice INNER JOIN PracticeDentist ON Practice.id = PracticeDentist.practice_id WHERE PracticeDentist.dentist_id = {$_SESSION["userId"]}", "id", "value, label");
$conn->event->attach("beforeInsert","my_insert");
$conn->filter("practiceDentist_id", $practiceDentist_id);
$conn->set_options("practiceDentist_id", $list);
$conn->render_table("Appointment","id","start_date,end_date,text,practiceDentist_id, dis_access, type");
