<?php
/**
 * Emerdency-Live - tel-appointment-slots.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 08/05/2018
 * Time: 15:59
 * Description :
 */

include( "../includes/db_connect.php" );

session_start();

if(!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] !== '2'){
	header("Location:dentist-login");
}

include( "../header-schedule.php" );
?>
<div class="main-content">
	<h1 class="page-title">Telephone Appointment Slots</h1>
	<a class="btn back" href="dentist-account">Back</a>
	<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
		<div class="dhx_cal_navline">
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
			<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
			<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
			<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
		</div>
		<div class="dhx_cal_header"></div>
		<div class="dhx_cal_data"></div>
	</div>

	<script>
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

        scheduler.config.lightbox.sections=[
            { name:"description", height:50, type:"textarea", map_to:"text", focus:true},
            { name:"time", height:72, type:"time", map_to:"auto"}
        ];

        scheduler.config.xml_date="%Y-%m-%d %H:%i";
        scheduler.config.separate_short_events = true;
        scheduler.config.first_hour = 8;
        scheduler.config.last_hour = 24;
        scheduler.config.start_on_monday = true;

        scheduler.init('scheduler_here', new Date(), "month");
        scheduler.load("../php/tel-events.php");

        var dp = new dataProcessor("../php/tel-events.php");
        dp.init(scheduler);
	</script>
	<?php include( "../footer.php" ); ?>