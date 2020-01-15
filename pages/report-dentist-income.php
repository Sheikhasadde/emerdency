<?php
/**
 * Emerdency-Live - dentist-reports.php
 * Created by Cool Hand Studios.
 * Developer: Aamir
 * Date: 03/05/2018
 * Time: 12:07
 * Description :
 */

session_start();
if($_SESSION['loggedIn'] !== 3){
	header("Location:../index.php");
}
include( '../header.php' );
?>
	<div class="main-content">
	<h1 class="page-title">Reports - Dentist Income</h1>
	<div class="inner-row">
		<input class="btn back" type="button" value="Back" onclick="history.back()">
		<canvas id="incomeChart"></canvas>
	</div>
	<script type="text/javascript">
        var dentistID = <?php echo json_encode($_SESSION["dentistId"]); ?>;
        $(document).ready(function(){
            $.ajax({
                url: "https://www.emerdency.co.uk/php/reports.php?dentistId="+dentistID,
                method: "GET",
                success: function(data) {
                    var months = [];
                    var money = [];

                    for(var i in data) {
                        months.push(data[i].date);
                        money.push(data[i].income);
                    }
                    var chartdata = {
                        labels: months,
                        datasets : [
                            {
                                label: 'Total Income (£)',
                                backgroundColor: 'rgb(232,84,28)',
                                borderColor: 'rgb(232,84,30)',
                                hoverBackgroundColor: 'rgb(41,41,48)',
                                hoverBorderColor: 'rgb(41,41,53)',
                                data: money
                            }
                        ]
                    };

                    var ctx = $("#incomeChart");

                    var barGraph = new Chart(ctx, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
	</script>
	<script src="../chartJS/Chart.min.js" async></script>
<?php include( '../footer.php' ); ?>