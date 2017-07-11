<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Sample page</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <script src="assets/js/chart-master/Chart.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
    <style type="text/css">
      .value {
        font-family: 'Abel', sans-serif;
        font-weight: bolder;
        font-size: 6em;
        padding-top: 20px;
      }
      .graphdata canvas {
        padding-left: 25%;
      }
    </style>
  </head>
  <script>


    (function doStuff() {

        $.get( "retrieve.php", { choice: "humidity" }, function (data) {
          $("#humidity").text(data);
        });            
        $.get( "retrieve.php", { choice: "lightIntensity" }, function (data) {
          $("#lightIntensity").text(data);
        });    
        $.get( "retrieve.php", { choice: "humidity" }, function (data) {
          $("#humidity").text(data);
        });
        $.get( "retrieve.php", { choice: "temperature" }, function (data) {
          $("#temperature").text(data);
        });     
        $.get( "retrieve.php", { choice: "heartBeat" }, function (data) {
          $("#heartBeat").text(data);
        });
        $.get( "retrieve.php", { choice: "audio" }, function (data) {
          $("#audio").text(data);
        }); 
             

       setTimeout(doStuff, 5000);
    
    }());

  </script>
  <body>
  
  <section id="container" >
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>Agriculture</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="login.html">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
  
    
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></p>
              	  <h5 class="centered">Amal</h5>
              	  	
                  <li class="mt">
                      <a href="index.html">
                          <i class="fa fa-dashboard"></i>
                          <span>Control Panel</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-desktop"></i>
                          <span>Statics</span>
                      </a>
                      
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-cogs"></i>
                          <span>Settings</span>
                      </a>
                  </li>
                 

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
         
          <div class="row mt">
             <div class="col-md-3 col-sm-3 mb">
                <div class="green-panel pn">
                  <div class="green-header">
                    <h5>Humidity</h5>

                  </div>
                <h1 class="value" id="humidity"></h1>

                <div id="humidityloader" style="display:none"><img src="assets/img/loading.gif"/ ></div>
                </div>
              </div>
             <div class="col-md-3 col-sm-3 mb">
                <div class="green-panel pn">
                  <div class="green-header">
                    <h5>Light Intensity</h5>
                  </div>
                <h1 class="value" id="intensity"></h1>
                 <div id="intensityloader" style="display:none"><img src="assets/img/loading.gif"/ ></div>
                </div>
              </div>
             <div class="col-md-3 col-sm-3 mb">
                <div class="green-panel pn">
                  <div class="green-header">
                    <h5>Moisture</h5>
                  </div>
                <h1 class="value" id="moisture"></h1>
                 <div id="moistureloader" style="display:none"><img src="assets/img/loading.gif"/ ></div>
                </div>
              </div>
             <div class="col-md-3 col-sm-3 mb">
                <div class="green-panel pn">
                  <div class="green-header">
                    <h5>Temperature</h5>
                  </div>
                <h1 class="value" id="temperature"></h1>
                 <div id="temperatureloader" style="display:none"><img src="assets/img/loading.gif"/ ></div>
                </div>
              </div>                                          
          </div>
			    <div class="row mt graphdata">
              <h2>Humidity</h2>
              <canvas id="c1" height="500" width="800"></canvas>
              <h2>Light Intensity</h2>
              <canvas id="c2" height="500" width="800"></canvas>              
              <h2>Moisture</h2>
              <canvas id="c3" height="500" width="800"></canvas>
              <h2>Temperature</h2>
              <canvas id="c4" height="500" width="800"></canvas>
          </div>
                <script>
    $.ajax({
        url: "graphdata.php",
        dataType: "JSON",
        success: function(json){
          var d1 = $.map(json['humidity'], function(value, index) {
              return [value];
          });
          var d2 = $.map(json['intensity'], function(value, index) {
              return [value];
          });

          var d3 = $.map(json['moisture'], function(value, index) {
              return [value];
          });
          var d4 = $.map(json['temperature'], function(value, index) {
              return [value];
          });

          var lineChartData = {
              labels : ["TT","EE","FF","DD"],
              datasets : [
                  {
                      fillColor : "rgba(220,220,220,0.5)",
                      strokeColor : "rgba(220,220,220,1)",
                      pointColor : "rgba(220,220,220,1)",
                      pointStrokeColor : "#fff",
                      data : d1
                  },
              ],         
          };
          new Chart(document.getElementById("c1").getContext("2d")).Line(lineChartData);

          var lineChartData = {
              labels : ["TT","EE","FF","DD"],
              datasets : [
                  {
                      fillColor : "rgba(220,220,220,0.5)",
                      strokeColor : "rgba(220,220,220,1)",
                      pointColor : "rgba(220,220,220,1)",
                      pointStrokeColor : "#fff",
                      data : d2
                  },
              ],         
          };
          new Chart(document.getElementById("c2").getContext("2d")).Line(lineChartData);


          var lineChartData = {
              labels : ["TT","EE","FF","DD"],
              datasets : [
                  {
                      fillColor : "rgba(220,220,220,0.5)",
                      strokeColor : "rgba(220,220,220,1)",
                      pointColor : "rgba(220,220,220,1)",
                      pointStrokeColor : "#fff",
                      data : d3
                  },
              ],         
          };
          new Chart(document.getElementById("c3").getContext("2d")).Line(lineChartData);


          var lineChartData = {
              labels : ["TT","EE","FF","DD"],
              datasets : [
                  {
                      fillColor : "rgba(220,220,220,0.5)",
                      strokeColor : "rgba(220,220,220,1)",
                      pointColor : "rgba(220,220,220,1)",
                      pointStrokeColor : "#fff",
                      data : d4
                  },
              ],         
          };
          new Chart(document.getElementById("c4").getContext("2d")).Line(lineChartData);                              
        }
    })                

                    
                    
                </script>
		</section>
      </section><!-- /MAIN CONTENT -->







      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              Amal Shajan
              <a href="blank.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
]]

  </body>
</html>
