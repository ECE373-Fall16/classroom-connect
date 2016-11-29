<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>ClassRoom Connect</title>
    <!-- Bootstrap core CSS -->
   <link href="linkedFiles/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <link href="main.css" rel="stylesheet" type="text/css" >
    <?php require '../back_end/getmarkers.php'; ?>
  </head>
  <body>
      <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

   <script type="text/javascript">

     var A = 404;
     var B = 404;
     var C = 404;
     var D = 404;
	window.onload = function () {
    init();
    
  }
/////////////////////////////////////////////////
var socket;

function init() {
                      
  var host = "ws://127.0.0.1:9000/echobot"; // SET THIS TO YOUR SERVER
  retrieveChartData(true);
  
  try {
    socket = new WebSocket(host);
    console.log('WebSocket - status '+socket.readyState);
    socket.onopen    = function(msg) { 
        console.log("Welcome - status "+this.readyState);               
    };
    socket.onmessage = function(msg) { 
      if(msg.data == 'updatePoll'){
      retrieveChartData(false);
      console.log("Received: "+msg.data); 
    };
    socket.onclose   = function(msg) { 
      console.log("Disconnected - status "+this.readyState); 
    };
  }

  }
  catch(ex){ 
      console.log(ex); 
  }
  $("msg").focus();
}

function retrieveChartData(initFlag){
  $.ajax({
    url: "http://localhost:8888/classroom-connect/back_end/getmarkers.php",
    method:'GET'
     }).done(function(json) {                     
        A = json.one;
        B = json.two;
        C = json.three;
        D = json.four;
        if(initFlag){
          $('#chartContainer1').remove();
          $('#canvasDiv').append(" <div id='chartContainer1' style='height:25%; width:49%;float:right' ></div>  ");
        }
        renderChart();
    });
}

function send(){
  var txt,msg;
  txt = $("msg");
  msg = txt.value;
  if(!msg) { 
    alert("Message can not be empty"); 
    return; 
  }
  txt.value="";
  txt.focus();
  try { 
    socket.send(msg); 
    console.log('Sent: '+msg); 
  } catch(ex) { 
    console.log(ex); 
  }
}
function quit(){
  if (socket != null) {
    console.log("Goodbye!");
    socket.close();
    socket=null;
  }
}

function reconnect() {
  quit();
  init();
}

function renderChart(){
    //alert("A: " + A);
    // var A = <?php echo $resultONE ?>;
    // var B = <?php echo $resultTWO ?>;
    // var C = <?php echo $resultTHREE ?>;
    // var D = <?php echo $resultFOUR ?>;
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
  // generates first set of dataPoints
  updateChart(dataLength);

  // update chart after specified time.
  setInterval(function(){updateChart()}, updateInterval);
}

	</script>
	<script type="text/javascript" src="linkedFiles/canvasjs/canvasjs.min.js"></script>

<div id="canvasDiv">
     <div id="chartContainer1" style="height:25%; width:49%;float:right" ></div>
     <div id="chartContainer2" style="height:25%; width:49%;"></div>
</div>
<button type="reset" value="Reset">Reset</button> <!--fix this later and below stuff-->
<div>
	<!--<h1>Some text</h1>-->
</div>
  <!--  <style> erase this later
      body {
  padding-top: 80px;
  padding-left: 20px;
  padding-right: 20px;
      }
      .starter-template {
  padding: 40px 15px;
      text-align: left;

     body.radio2{
     background-color: #4CAF50;
     }
     .h1{
       position:relative;
     }
  }

  </style>-->
     <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         <!-- <a class="navbar-brand" href="#"><img src =logo.png alt=ClassRoom Connect height=40 width=200></a>-->
	   <a class="navbar-brand" href="#">ClassRoom Connect</a>
	  <style>

	  </style>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="home.html">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<div id="chartContainer" style="height: 300px; width:50%;">
	</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
<footer>
  <p>ClassRoom Connect</p>
</footer>

</html>
