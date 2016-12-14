<?php session_start(); ?> 
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

    <link href="/linkedFiles/starter-template.css" rel="stylesheet">
    <link href="main.css?v=1.1" rel="stylesheet" type="text/css" >
    <!-- JQuery & AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://www.chartjs.org/assets/Chart.min.js"></script>
  </head>
  <body>
      <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

   <script type="text/javascript">

     var A = 404;
     var B = 404;
     var C = 404;
     var D = 404;
     var ctx;
	$(document).ready(function(){
    
    init();
    makeChart();
    
    $('#btnRESET').click(function(){
        resetPoll();
    });
    $('#btnPRINT').click(function(){
      alert('printing...');
    });
    $('#btnToggleChartView').click(function(){


        if($('#chartContainer1').is(":visible")){
            $('#chartContainer1').hide();  
        }else{
            $('#chartContainer1').show();
        }
        
    });

  });

/////////////////////////////////////////////////
var socket;
var sumUnderstanding;
function init() {

  var host = "ws://35.184.28.148:9000/echobot"; // SET THIS TO YOUR SERVER
  //var host = "ws://104.154.132.135:9000/echobot"; // SET THIS TO YOUR SERVER
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

function resetPoll(){
  var BUTTONPRESSED = 'resetPoll';
  var classnumber = <?php echo $_SESSION['CURRENTCLASS']; ?>;
  $.ajax({
    url: "../back_end/sqlConnection.php",//http://localhost:8888/classroom-connect/back_end/getmarkers.php
    method:'POST',
    data: {
        BUTTONPRESSED:BUTTONPRESSED,
        CLASSNUMBER: classnumber
    }
     }).done(function(json) {
       
    
    });
     alert('Poll Reset');
     retrieveChartData(false);
}

function retrieveChartData(initFlag){
  var currentClass = <?php echo $_SESSION['CURRENTCLASS'];?>;
  $.ajax({
    url: "../back_end/getmarkers.php",//http://localhost:8888/classroom-connect/back_end/getmarkers.php
    method:'GET',
    data: {
        CLASSNUMBER:currentClass
    }
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

}
function makeChart(){
      var canvas = document.getElementById('updating-chart'),
     ctx = canvas.getContext('2d'),
    startingData = {
      labels: [1, 2, 3, 4, 5, 6, 7],
      datasets: [
          
                {
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    data: [0, 0, 0, 0, 0, 0, 0]
                }
            ]
          },
          latestLabel = startingData.labels[6];

      // Reduce the animation steps for demo clarity.
      var myLiveChart = new Chart(ctx).Line(startingData, {animationSteps: 15});


      setInterval(function(){
      var currentClass = <?php echo $_SESSION['CURRENTCLASS'];?>;
        $.ajax({
          url: "../back_end/sqlConnectionGET.php",//http://localhost:8888/classroom-connect/back_end/getmarkers.php
          method:'GET',
          data: {
              CHECK: 'getUnderstandingData',
              CLASSNUMBER:currentClass,
          }
           }).done(function(json) {
           //alert(json.one + " me!");
            //return json.one;
           // Add two random numbers for each dataset
        myLiveChart.addData([json.one], ++latestLabel);
        // Remove the first point so we dont just add values forever
        myLiveChart.removeData();
          });
        
      }, 2000);
}

function getUnderstandingData(){
  var currentClass = <?php echo $_SESSION['CURRENTCLASS'];?>;
  $.ajax({
    url: "../back_end/sqlConnectionGET.php",//http://localhost:8888/classroom-connect/back_end/getmarkers.php
    method:'GET',
    data: {
        CHECK: 'getUnderstandingData',
        CLASSNUMBER:currentClass,
    }
     }).done(function(json) {
     alert(json.one + " me!");
      return json.one;
     
    });
      

}

	</script>
  
	<script type="text/javascript" src="linkedFiles/canvasjs/canvasjs.min.js"></script>

<div class = "chart_class" id="canvasDiv" style="width:100%; height: 100%;">
    <div>
         <div id="chartContainer1" style="height:50%; width:49%;float:right" ></div>
        <div class = "below_chart">
		<div>
            <input id="btnRESET" type="button" value="Reset" class ="button host_reset">
          </div>
			<div>
            <input id="btnToggleChartView" type="button" value="Show / Hide Chart" class ="button host_reset">
          </div>
     </div>
     <!-- <div id="chartContainer2" style="height:25%; width:49%;"></div> -->
     <!-- <canvas id="updating-chart" width="500" height="300"></canvas> -->
     <div style="height:30%; width:50%; padding:20px; float: left;">
     <h2>Classroom <?php echo $_SESSION['CURRENTCLASS'];?>: User Understanding</h2>
     <canvas id="updating-chart" style="height:100%; width:100%;;"></canvas>
     </div>
</div>


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
            <li class="active"><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
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
  <!-- <p>ClassRoom Connect <?php echo $_SESSION['CURRENTCLASS'] ?></p> -->
</footer>

</html>
