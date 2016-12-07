function renderChart(){
    var A = <?php echo $resultONE ?>;
    var B = <?php echo $resultTWO ?>;
    var C = <?php echo $resultTHREE ?>;
    var D = <?php echo $resultFOUR ?>;
    var sum = A+B+C+D;
  var data = [
  {label: "A", y: A},
  {label: "B", y: B},
  {label: "C", y: C},
  {label: "D", y: D},
  ];
var totalResponses = "total responses:"+sum;
var chart = new CanvasJS.Chart("chartContainer1",
  {
    //bar chart
      theme: "theme3",
    title:{
      text: "Responses"
    },
    axisY: {
      title: "Number of Responses"
    },
    legend:{
      verticalAlign: "top",
      horizontalAlign: "centre",
      fontSize: 18
    },
    data : [{
      type: "column",
      showInLegend: true,
      legendMarkerType: "none",
      legendText: totalResponses,
      indexLabel: "{y}",
      dataPoints: data
    }]
  });
  chart.render();
  var updateChart = function () {

    chart.render();

  };
  var updateInterval = 1000;
    // update chart after specified interval
    setInterval(function(){updateChart()}, updateInterval);

var dps = []; // dataPoints

  var chart = new CanvasJS.Chart("chartContainer2",{
   //live update chart
    theme: "theme3",
    title :{
      text: "Student Understanding"
                        },
               axisY:{
                    //title: "Primary Y Axis",
                    },
        //////////////
    data: [{
      type: "line",
      dataPoints: dps
    }]
  });

  var xVal = 0;
  var yVal = 0;
  var updateInterval = 100;
  var dataLength = 500; // number of dataPoints visible at any point

  var updateChart = function (count) {
    count = count || 1;
    // count is number of times loop runs to generate random dataPoints.
  //  backgroundColor:"#F5DEB3";
    for (var j = 0; j < count; j++) {
            yVal = yVal +  (1/5)*(Math.round(5 + Math.random() *(-5-5)));
            //yVal = yVal +Math.round(Math.random() *(-1-1));
            //yVal = yVal/2;
            if(yVal<0){}
            //if(yVal>0){document.body.style.backgroundColor = "green";}
      dps.push({
        x: xVal,
        y: yVal
      });
      xVal++;
    };
    if (dps.length > dataLength)
    {
      dps.shift();
    }
    chart.render();
  };
}
