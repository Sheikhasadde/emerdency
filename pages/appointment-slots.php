<?php
/**
 * Emerdency - appointment-slots.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 05/03/2018
 * Time: 13:03
 * Description :
 */

include ("../includes/db_connect.php");

session_start();

function getPDId($dentistId){
	$pdId = array();
	$db = dbConnect();
	$sql = "SELECT PracticeDentist.id, Practice.name FROM PracticeDentist INNER JOIN Practice ON PracticeDentist.practice_id = Practice.id WHERE PracticeDentist.dentist_id = {$dentistId} AND PracticeDentist.enabled = 0;";
	$results = $db->query($sql);

	while ($row = mysqli_fetch_assoc($results)){
	    //array_push($pdId, $row["id"],$row["name"] );
		$pdId[] = array($row["id"] => $row["name"]);
		//$pdId[] = $row["name"];
	}
	return $pdId;
}

if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] !== '2'){
	header("Location:../dentist-login");
}

$pdId = getPDId($_SESSION["userId"]);
$telAdvice = $_SESSION["telAdvice"];

include("../header-schedule.php");
?>
<div class="main-content">
    <h1 class="page-title">Appointment Slots</h1>
    <a class="btn back" href="dentist-account">Back</a>
        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
            <div class="dhx_cal_navline">
                <div class="dhx_cal_prev_button">&nbsp;</div>
                <div class="dhx_cal_next_button">&nbsp;</div>
                <div class="dhx_cal_today_button"></div>
                <div class="dhx_cal_date"></div>
                <div class="dhx_cal_tab" name="day_tab" style="right: auto; left: 14px;"></div>
                <div class="dhx_cal_tab" name="week_tab" style=""></div>
                <div class="dhx_cal_tab" name="month_tab" style=""></div>
            </div>
            <div class="dhx_cal_header"></div>
            <div class="dhx_cal_data"></div>
        </div>
    <script>
        // Get php variable and convert to JSON for JS usage
        var pdIdArray = <?php echo json_encode($pdId); ?>;
        // Get if Tel Advice
        var telAdvice = <?php echo json_encode($telAdvice); ?>;
        // Initialise array for Select options
        var practiceOpts = [];
        var format = scheduler.date.date_to_str("%H:%i");
        var step = 10;
        scheduler.config.hour_size_px=(60/step)*22;
        scheduler.templates.hour_scale = function(date){
            html="";
            for (var i=0; i<60/step; i++){
                html+="<div style='height:21px;line-height:21px;'>"+format(date)+"</div>";
                date = scheduler.date.add(date,step,"minute");
            }
            return html;
        };

        scheduler.locale.labels.section_dis_access = "Wheelchair Access";
        scheduler.locale.labels.section_practiceDentist_id = "Practice";
        scheduler.locale.labels.section_type = "Telephone Advice";

        if (telAdvice == 1) {
            scheduler.config.lightbox.sections=[
                { name:"description", height:50, type:"textarea", map_to:"text", focus:true},
                { name:"practiceDentist_id",  height:50, type:"select", map_to:"practiceDentist_id", options:practiceOpts},
                { name:"dis_access", height: 60, type: "radio", map_to: "dis_access", vertical: true,
                    options: [
                        {key:"1", label:"Yes"},
                        {key:"0", label:"No"}
                    ], default_value: "0"},
                { name:"type", height: 60, type: "radio", map_to: "type", vertical: true, options: [
                        {key:"2", label:"Yes"},
                        {key:"0", label:"No"}
                    ], default_value: "0"},
                { name:"time", height:72, type:"time", map_to:"auto"}
            ];
        } else {
            scheduler.config.lightbox.sections=[
                { name:"description", height:50, type:"textarea", map_to:"text", focus:true},
                { name:"practiceDentist_id",    height:50, type:"select", map_to:"practiceDentist_id", options:practiceOpts},
                { name:"dis_access", height: 60, type: "radio", map_to: "dis_access", vertical: true,
                    options: [
                        {key:"1", label:"Yes"},
                        {key:"0", label:"No"}
                    ], default_value: "0"},
                { name:"time", height:72, type:"time", map_to:"auto"}
            ];
        }

        // Loop through Array of PracticeDentist IDs. Create Key/Label array for Select & load data for each Practice
        for (var i = 0; i < pdIdArray.length; i++){
            var obj = pdIdArray[i];
            for (var key in obj){
                practiceOpts.push({key: key, label: obj[key]});
                scheduler.load("../php/events.php?pd="+key);
            }
        }

        scheduler.config.show_loading = true;
        scheduler.config.xml_date="%Y-%m-%d %H:%i";
        scheduler.config.separate_short_events = true;
        scheduler.config.first_hour = 8;
        scheduler.config.last_hour = 24;
        scheduler.config.start_on_monday = true;
        //specify event duration in minutes for auto end time
        scheduler.config.event_duration = 10;
        scheduler.config.auto_end_date = true;

        scheduler.init('scheduler_here', new Date(), "month");
        var dp = new dataProcessor("../php/events.php");
        dp.init(scheduler);
    </script>
	<?php include("../footer.php"); ?>
