<!DOCTYPE html>
<html>
    <head>
	<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 2px solid #ddd;
  padding: 2px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
        <script src="Chart.min.js"></script>
        <script src="jquery.js"></script>
    </head>
    <body>
	

    <h2 align="center"><font face="Geneva, Arial, Helvetica, sans-serif" size="+1">SKY BANKING MONTH WISE LOGIN</h2>
<table border="1" bordercolor="#999999" width="100%" id="customers">
<TR><TD>
    <!-- Graph will be rendered here -->
    <canvas id="barChart"></canvas>
  </TD></TR>
   </table>
        
    <!-- When document is ready make an ajax request -->
   <script>
   var chartColors = {
    green: '#9B0000',
    yellow: '#00CCFF',
    blue: '#FFA74F',
    olive: '#00CCFF',
    yellowgreen: '#00BB2F',
    orange: '#006600',
    paleGreen: '#009999',
    gold: '#00CCFF',
    aqua: '#0099FF',
    darkMagenta: '#003366',
    orchid: '#660099',
    wheat: '#FF3366',
	
    peru: '#009900',
    rosyBrown: '#ffc30b',
    lightSlateGray: '#0059a9',
    gainsboro: '#009900',
    firebrick: '#ffc30b',
    purple: '#0059a9',
    steelBlue: '#009900',
    red: '#ffc30b',
    lightSteelBlue: '#0059a9'
	};
	var colors = Object.values(chartColors);

        $(document).ready(function(){
		
            $.ajax({
                beforeSend: function() {
                    console.log("Making AJAX request");
                },
                cache: false,
                url: 'bargraph_sky.php',
                dataType: 'json',
                success: function(res) {
                    var  graphLabels = [],
                        graphData = [], selectedColors=[];
                    for(var i=0;i<res.length;i++){
                        graphData.push(res[i].TXN);
                        graphLabels.push(res[i].MONTH);
						selectedColors.push(colors[i]);
                    }
                    //Make a call to the function to draw the bar graph
                    drawGraph(graphLabels, graphData, selectedColors);
					
                },
                complete: function() {
                    console.log("AJAX request done");
                },
                error: function() {
                    console.log("Error occurred during AJAX request")
                }    
				     
            });
			
			
        }); 
		
      
        function drawGraph(Labels, Data, selectedColors){
            var ctxB = document.getElementById("barChart").getContext('2d');
			 myBarChart = new Chart(ctxB, {
                type: 'bar',
			
                data: {
                    labels: Labels,
                    datasets: [{
                        label: 'no. of login',
                        data: Data,
                   		backgroundColor:selectedColors,
                        borderWidth: 0
                    }]
                },
                options: {
				legend: {
        display: false
    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
			
            });  
}	
$('#barChart').click(function(evt){
	var activePoints = myBarChart.getElementsAtEventForMode(evt, 'point', myBarChart.options);
        var firstPoint = activePoints[0];
        var label = myBarChart.data.labels[firstPoint._index];
        var value = myBarChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
        window.open('total_skb_txn_bar_summary_show.php?value='+label,'newwindow','width=800,height=600');
		
		
});



			
		
        
    </script>
    </body>
</html>