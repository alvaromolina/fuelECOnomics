
<!DOCTYPE html>
<html xmlns:fb="http://ogp.me/ns/fb#">
  <head>
    <meta charset="utf-8">
    <title>Fuel Economics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FuelECOnomics is page to learn and play with data about the economics of fuel consumption and CO2 emissions. Learn and act!">
    <meta name="author" content="alvaromolinac@gmail.com">
<meta name="google-site-verification" content="jpsx0cmWuVnBguUAVUeMKmgQN5-e0cUwKHi8aa3fEuI" />      
<link rel=”image_src” href=”<?= base_url() ?>img/car.png”/ >

    <!-- Le styles -->
    <link href="<?= base_url();?>css/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url();?>css/style.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <!-- <link href="<?= base_url();?>css/bootstrap-responsive.css" rel="stylesheet"> -->
    <style type="text/css">
	#map{
		width: 99.5%;
    height: 500px; 
    margin-left: auto;
    margin-right: auto;
	}

    </style>
    <script type="text/javascript">
        base_url = "<?=base_url() ?>";
    </script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places,geometry"></script>
<script src="<?=base_url();?>js/javascript.js" type="text/javascript"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script src="<?= base_url();?>js/bootstrap-transition.js"></script>
<script src="<?= base_url();?>js/bootstrap-alert.js"></script>
<script src="<?= base_url();?>js/bootstrap-modal.js"></script>
<script src="<?= base_url();?>js/bootstrap-dropdown.js"></script>
<script src="<?= base_url();?>js/bootstrap-scrollspy.js"></script>
<script src="<?= base_url();?>js/bootstrap-tooltip.js"></script>
<script src="<?= base_url();?>js/bootstrap-popover.js"></script>
<script src="<?= base_url();?>js/bootstrap-button.js"></script>
<script src="<?= base_url();?>js/bootstrap-collapse.js"></script>
<script src="<?= base_url();?>js/bootstrap-carousel.js"></script>
<script src="<?= base_url();?>js/bootstrap-typeahead.js"></script>
<script src="<?= base_url();?>js/bootstrap-tab.js"></script>



<script type="text/javascript">



  var aggregates = [
    "1A",
    "Z4",
    "4E",
    "XC",
    "Z7",
    "7E",
    "EU",
    "XE",
    "XD",
    "XR",
    "XS",
    "ZJ",
    "XJ",
    "XL",
    "XO",
    "XM",
    "XN",
    "ZQ",
    "XQ",
    "XP",
    "XU",
    "XY",
    "OE",
    "8S",
    "ZG",
    "ZF",
    "XT",
    "1W"];


    google.load('visualization', '1', {packages: ['motionchart','geochart']});    

    function drawVisualizationgraph() {
        $.getJSON('data.json', function(jsondata) {
          console.log(jsondata);
          var data = new google.visualization.DataTable(jsondata);
          var options = {};
          options['state'] ='{"nonSelectedAlpha":0.4,"iconType":"BUBBLE","showTrails":true,"xZoomedDataMin":0,"time":"2007","yZoomedDataMin":33.003,"yZoomedDataMax":6791804.714,"uniColorForNonSelected":false,"playDuration":15000,"iconKeySettings":[],"xZoomedDataMax":136012580,"yZoomedIn":false,"orderedByX":false,"xLambda":0,"colorOption":"11","xZoomedIn":false,"duration":{"multiplier":1,"timeUnit":"Y"},"yAxisOption":"3","yLambda":0,"sizeOption":"4","xAxisOption":"2","orderedByY":false,"dimensions":{"iconDimensions":["dim0"]}}';

          options['width'] = 800;
          options['height'] = 400;
          var motionchart = new google.visualization.MotionChart(
            document.getElementById('visualizationgraph'));
          motionchart.draw(data, options);
        });                     
    }
    
    
    

    google.setOnLoadCallback(drawVisualizationgraph);

    function drawVisualization(index,year) {


      $('#titlemap').html('<img align="center" src="'+base_url+'img/ajax-loader.gif">');
      $('#visualization').html('');
      
      $.getJSON("http://api.worldbank.org/countries/all/indicators/"+index+"?date="+year+"&format=jsonp&per_page=250&prefix=?&callback=?", 
        
        function(jsondata){
          //alert(data[1].page);
          //console.log(jsondata);

          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Country');
          data.addColumn('number', 'value');

          
          $.each(jsondata[1], function(i,item){
            
            if(jQuery.inArray(item.country.id,aggregates) == -1){
              data.addRow([item.country.value,Number(item.value)]);
              //console.log(item);  
            }            
          });

          data.addRows(1);          
          data.setValue(0, 0, jsondata[1][0].country.value);
          data.setValue(0, 1, Number(jsondata[1][0].value));          
          var geochart = new google.visualization.GeoChart(
            document.getElementById('visualization'));


          var options = {
              width: 600, 
              height: 400,
              title: jsondata[1][0].indicator.value
          };
          geochart.draw(data,options );
          $('#titlemap').html(jsondata[1][0].indicator.value+' '+'('+year+')');
          

      });
    }    
  google.setOnLoadCallback(drawVisualization('EN.ATM.CO2E.KT','2008')); 
</script>


<script type="text/javascript">

var rendererOptions = {
  draggable: true
};
var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
var directionsService = new google.maps.DirectionsService();
var map;

var bolivia = new google.maps.LatLng(-13.9908, -66.1936);
var autocompletefrom;
var autocompleteto;


function mapInit() {

  var myOptions = {
    zoom: 1,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: bolivia
  };
  map = new google.maps.Map(document.getElementById("map"), myOptions);
  
  directionsDisplay.setMap(map);
  
  var from = document.getElementById('from');
  var to = document.getElementById('to');
  
  autocompletefrom = new google.maps.places.Autocomplete(from);
  autocompletefrom.bindTo('bounds', map);
  autocompleteto = new google.maps.places.Autocomplete(to);

  var infowindow = new google.maps.InfoWindow();
  var marker = new google.maps.Marker({
    map: map
  });


  google.maps.event.addListener(autocompletefrom, 'place_changed', function() {
          infowindow.close();
          var place = autocompletefrom.getPlace();
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }


          /*var image = new google.maps.MarkerImage(
              place.icon,
              new google.maps.Size(71, 71),
              new google.maps.Point(0, 0),
              new google.maps.Point(17, 34),
              new google.maps.Size(35, 35));
          marker.setIcon(image); */
          marker.setPosition(place.geometry.location);

          /*var address = '';
          if (place.address_components) {
            address = [(place.address_components[0] &&
                        place.address_components[0].short_name || ''),
                       (place.address_components[1] &&
                        place.address_components[1].short_name || ''),
                       (place.address_components[2] &&
                        place.address_components[2].short_name || '')
                      ].join(' ');
          }

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);*/
        });

  
  
  //directionsDisplay.setPanel(document.getElementById("directionsPanel"));

  google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
    computeTotalDistance(directionsDisplay.directions);
  });
  /*
  calcRoute(); */
}

function calcRoute(from, to) {

  var request = {
    origin: from,
    destination: to,
    //waypoints:[{location: "Bourke, NSW"}, {location: "Broken Hill, NSW"}],
    travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {

      directionsDisplay.setDirections(response);
    }
    else if  (status == google.maps.DirectionsStatus.INVALID_REQUEST){
      al = '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>Error!</strong> Pleas try again with other directions.</div>';
      $('#total').html(al);

    }
    else if  (status == google.maps.DirectionsStatus.NOT_FOUND) {
      al = '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>Error!</strong> Origin or destination not found.</div>';
      $('#total').html(al);
    }
    else if  (status == google.maps.DirectionsStatus.ZERO_RESULTS) {
      al = '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>Error!</strong> Route not found.</div>';
      $('#total').html(al);

    }
    else {
      al = '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>Error!</strong> Pleas try again.</div>';
      $('#total').html(al);
    }
  });
}

function computeTotalDistance(result) {
  var total = 0;
  var myroute = result.routes[0];
  for (i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
  }
  total = total / 1000;

  if($('#combined1').length!=0)
    combined1 = $('#combined1').val();
  else
    combined1 = "";

  if($('#price').length!=0)
    price = $('#price').val();
  else
    price = "";
  
  
  $.post(base_url+"index/routeData",  {"route":total, "volumeunit":$("input[name='volumeunit']:checked").val(), "distanceunit":$("input[name='distanceunit']:checked").val(),'combined1':combined1,'price':price
          }, function(response){
            $('#total').html(response);
          });

  //document.getElementById("total").innerHTML = total + " km";
}


function countryChange(){

    $.post(base_url+"index/fuelPrice",  {"country":$('#country').attr('value'), "volumeunit":$("input[name='volumeunit']:checked").val()

    }, function(response){
      $('#fuel_price').html(response);
    });


}

  $(document).ready(function(){ 

      mapInit();
    
      $("#country").change(function() 
      {  
        if($("#country").attr('value') !=""){

          var geocoder = new google.maps.Geocoder();
          geocoder.geocode( { 'address': $("#country").attr('value')}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            map.fitBounds(results[0].geometry.viewport);
            map.setZoom(map.getZoom()+1);
          }
          });

          countryChange();

        } else {
          mapInit();          
        }


      }); 

      $("#route").click(function() 
      {  
        from = $("#from").val();
        to = $("#to").val();
        
        calcRoute(from, to);
      
      }); 

      $("#yearmap").change(function() 
      {  
        drawVisualization($('#mapindicator').attr('value'),$('#yearmap').attr('value'));
              
      }); 



  });
</script>

    <style type="text/css">
      body {
        font-family: sans-serif;
        font-size: 14px;
      }
      #map_canvas {
        height: 400px;
        width: 600px;
        margin-top: 0.6em;
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26920700-3']);
  _gaq.push(['_setDomainName', 'fueleconomics.info']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
  </head>

  <body>
<!-- ClickTale Top part -->
<script type="text/javascript">
var WRInitTime=(new Date()).getTime();
</script>
<!-- ClickTale end of Top part -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=249339448492082";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

  <div class="whitebanner" style="height: 70px;"> 
    
    <img width="60px" style="margin-left: 30px; margin-bottom: 20px;  margin-top: 10px;" src="<?= base_url()?>img/car.png"> 
    <img width="450px"  height="60" style="margin-top: 10px;"  src="<?= base_url()?>img/logoletters.png">
    </div>
    <div class="banner3">  &nbsp; </div>
    <div class="banner2">  &nbsp; </div>
    <div class="banner1">  &nbsp; </div>

    <div class="container-fluid">
      <div class="row-fluid">
          <div class="span11"> &nbsp;
          </div>        
      </div>


      <div class="row-fluid">
        <div class="span4">
          <form class="form-horizontal">
          <fieldset>
            <legend>Select country for fuel price</legend>
            <div class="control-group">
              <label class="control-label" style="width: 100px;" for="country">Country:</label>
              <div class="controls" style="margin-left: 120px;">
                <select id="country">
                  <option value="">Select a country</option>
                  <? foreach($countries as $country){ ?>
                    <option value="<?=$country['name']?>"><?=$country['name']?></option>
                  <? } ?>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" style="width: 100px;"> Volume unit:</label>
              <div class="controls" style="margin-left: 120px;">
                <label class="radio inline">
                  <input type="radio" name="volumeunit" id="liter" value="liter" checked="">
                  Liter
                </label>
                <label class="radio inline">
                  <input type="radio" name="volumeunit" id="gallon" value="gallon">
                  US Gallon
                </label>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" style="width: 100px;"> Distance unit:</label>
              <div class="controls" style="margin-left: 120px;">
                <label class="radio inline">
                  <input type="radio" name="distanceunit" id="km" value="km" checked="">
                  Km
                </label>
                <label class="radio inline">
                  <input type="radio" name="distanceunit" id="mile" value="mile">
                  Mile
                </label>
              </div>
            </div>

          </fieldset>
          </form>
          <div id="fuel_price">
          </div>

        </div>

        <div class="span4">
          <form class="form-horizontal">
            <fieldset>
              <legend>Select car</legend>
              <div class="control-group">
                <label class="control-label" style="width: 60px;" for="year">Year:</label>
                <div class="controls" style="margin-left: 80px;">
                  <select id="year" class="span10">
                    <option value="">Select a year</option>
                    <? foreach($years as $year){ ?>
                      <option value="<?=$year?>"><?=$year?></option>
                    <? } ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="width: 60px;" for="make">Make:</label>
                <div style="margin-left: 80px;" >
                  <select id="make" class="span10" disabled>
                    <option value="">Select make</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="width: 60px;" for="model">Model:</label>
                <div class="controls" style="margin-left: 80px;">
                  <select id="model" class="span10" disabled>
                    <option value="">Select a model</option>
                  </select>
                </div>
              </div>
            </fieldset>
          </form>
          <div id="car1" style="text-align: center;"> 
          </div>
          <p style="text-align: center;">
            <button class="btn btn-success disabled" id="compare" href="">Compare</button>
          </p>
          
        </div><!--/span-->
        <div class="span4" id="comparecar"  align="center">
        </div><!--/span-->
      </div>
      <div class="row-fluid">
          <div class="span11"> &nbsp;
          </div>        
      </div>
      <div class="row-fluid">        
        <div class="span4">
          <form class="form-horizontal">
            <fieldset>
              <legend>Trace your route</legend>
               <div class="control-group">
                  <label class="control-label" style="width: 60px;" for="from">From:</label>
                  <div class="controls" style="margin-left: 80px;"> 
                    <input type="text" class="span10" id="from">
                  </div>
                </div>
               <div class="control-group">
                  <label class="control-label" style="width: 60px;" for="to">To:</label>
                  <div class="controls" style="margin-left: 80px;">
                    <input type="text" class="span10" id="to">
                  </div>
                </div>
                <input style="margin-left: 20px;" class="btn btn-success" type="button" id="route" value="Trace route >>">
            </fieldset>
          </form>
          <div id="total">  </div>
          <!-- <div id="directionsPanel"></div> -->
        </div><!--/span-->
        <div class="span8">
          <div id="map" class="map"></div>
        </div>

      </div><!--/row-->

      <div class="row-fluid" id="co2">
          <div class="span11"> &nbsp;
          </div>        
      </div>


    
    <div class="row-fluid">
          <div class="span12"> <h1 style=" color: #FACB47; margin-left: 20px;"> Why CO2 emmisions are important? </h1>    
          <hr>

<table>
                      <thead> 
                      </thead>
                      <tbody>
                        <tr>
                          <td width='10%'> 
                          </td>
                        <td> 
          <h3  style=" color: #E8E8F0; "> 
              There is a scientific consensus that climate change is caused by human activity and the emission of greenhouse gases <a href="http://www.nap.edu/catalog.php?record_id=12782" target="_blank">[1] </a> <a href="http://www.pnas.org/content/early/2009/01/28/0812721106.full.pdf+html"> [2] </a> . Great part of this gasses are CO2 and <a href="http://www.fueleconomy.gov/feg/findacarhelp.shtml#carbonFootprint" target="_blank"> most of the CO2 produced  by a typical household comes from vehicles. </a>

<!-- <a href= > [3][4][5].  -->
               That is why choosing a fuel efficient car is very important, not only for our pockets but also for the enviroment.   <h3>

                <h2 style="color: white;"> Be smart when you buy a new car, buy a low Co2 emission car!. Buy ECOnomical!. </h2> </br>
              <h3 style=" color: #E8E8F0; ">
              Also look for alternatives to petro-fuel cars like walking, cycling, take public transportation, car pooling or alternative energy vehicles. <br>
              <hr>

              Be sure to try our <a href="#co2data">tools below</a> to find interesting information about CO2 emmisions, enviroment and the relation with the use of cars and the urban development. <br>
              
              Please <a href="#co2data"> comment below  </a> to share yor insights abou the data presented. <br>

              We will be also posting via our facebook page <fb:like-box href="https://www.facebook.com/pages/FuelECOnomics/303415156392462" width="292" show_faces="false" stream="false" header="false"></fb:like-box> <!-- and our blog -->. Please like us to follow our news.
               
          </h3>
          </td>
          <td width='10%'> 
                          </td>

                        </tr>

                      </tbody>
              </table>
            <br> <br>

          </div>
      </div>  


      <div class="row-fluid">
          <div class="span11"> &nbsp;
          </div>        
      </div>



      <div class="row-fluid">
          <div class="span12" id="co2data">
               <h1 style="margin-left:auto; margin-right: auto; width: 50%; color: #FACB47;"> CO2 Emmisions and Urban Development Data </h1>
              <hr>
              <div id="charts" style="margin-left: auto; margin-right: auto; width: 90%;">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#graphchart" data-toggle="tab"> Motion Charts</a></li>
                    <li ><a href="#mapchart"  data-toggle="tab">Maps</a></li>
                </ul>

                <div class="tab-content">

                  <div class="tab-pane active" id="graphchart">

                    <table>
                      <thead> 
                        <tr>
                          <th> &nbsp; </th>
                          <th colspan="2"> <h2 id="titlegraph"> &nbsp;  </h2></th>
                        </tr> 
                      </thead>
                      <tbody>
                        <tr>
                          <td width='10%'> &nbsp; </td>
                          <td colspan="2"><div id="visualizationgraph" style="margin-left:auto; margin-right: auto; width: 90%; color: #FACB47;"></div>
                          </td>
                        </tr>
                        <tr>
                        <td width='10%'> &nbsp; </td>

                        <td colspan="2">  
                     <small style="font-size: 75%; color: #363737;"> Data from <a href="http://data.worldbank.org/topic" target="_blank">World Bank:World Development Indicators</a> <br>
                          * Total Motor vehicles :  Calculated from = Motor vehicles (per 1,000 people) * Total Population/1000 </small> 

                     </td>
                        </tr>

                        <tr>
                            <td colspan="3">
                                <fb:comments href="http://www.fueleconomics.info" num_posts="10" width="470"></fb:comments>
                            </td>
                        </tr>

                      </tbody>
                    </table>
                  </div>

                  <div class="tab-pane " id="mapchart">
                    <table>
                      <thead> 
                        <tr>
                          <th> &nbsp; </th>
                          <th colspan="2"> &nbsp;</th>
                        </tr> 
                      </thead>
                      <tbody>
                        <tr>
                          <td width='40%'>
                            <ul class="nav nav-pills nav-stacked">
                              <li class="nav-header">
                                <select id="yearmap" class="span10">
                                  <? foreach($years as $year){ 
                                        if ($year < 2010) {
                                             ?>
                                    <option value="<?=$year?>" <? if($year==2008) echo 'selected'; ?>><?=$year?></option>
                                  <? }} ?>
                                </select>
                                <input type="hidden" id="mapindicator" value ="EN.ATM.CO2E.KT">
                              </li>

                              <li class="nav-header">
                                Enviroment indicators
                              </li>
                              <li class="active"><a href="" name="EN.ATM.CO2E.KT" data-toggle="pill">CO2 emissions (kt)</a></li>
                              <li><a href="" name="EN.ATM.CO2E.PC" data-toggle="pill">CO2 emissions (metric tons per capita)</a></li>
                              <li><a href="" name="EN.ATM.CO2E.EG.ZS" data-toggle="pill">CO2 intensity (kg per kg of oil equivalent energy use)</a></li>
                              <li><a href="" name="EN.ATM.CO2E.LF.KT" data-toggle="pill">CO2 emissions from liquid fuel consumption (kt)</a></li>
                              <li><a href="" name="EN.ATM.CO2E.LF.ZS" data-toggle="pill">CO2 emissions from liquid fuel consumption (% of total)</a></li>

                              <li><a href="" name="EN.ATM.CO2E.GF.KT" data-toggle="pill">CO2 emissions from gaseous fuel consumption (kt)</a></li>
                              <li><a href="" name="EN.ATM.CO2E.GF.ZS" data-toggle="pill">CO2 emissions from gaseous fuel consumption (% of total)</a></li>
                              <li><a href="" name="EN.ATM.CO2E.KD.GD" data-toggle="pill">CO2 emissions (kg per 2000 US$ of GDP)</a></li>
                              <li class="nav-header">
                                Social and Urban development indicators
                              </li>
                              <li>
                                <a href="" name="SP.POP.TOTL" data-toggle="pill">Total Population</a>
                              </li>
                              <li>
                                <a href="" name="SP.URB.TOTL" data-toggle="pill">Urban population</a>
                              </li>
                              <li>
                                <a href="" name="SP.URB.TOTL.IN.ZS" data-toggle="pill">Urban population (% of total)</a>
                              </li>
                              <li>
                                <a href="" name="IS.VEH.NVEH.P3" data-toggle="pill">Motor vehicles (per 1,000 people)</a>
                              </li>
                              <li>
                                <a href="" name="IS.VEH.PCAR.P3" data-toggle="pill">Passenger cars (per 1,000 people)</a>
                              </li>
                              <li>
                                <a href="" name="IS.VEH.ROAD.K1" data-toggle="pill">Vehicles (per km of road)</a>
                              </li>
                            </ul>
                          </td>
                          <td><h2 id="titlemap" style="color: white; text-align: center;"> </h2>
                              <div id="visualization" style="margin-left:auto; margin-right: auto; width: 90%; color: #FACB47;"></div>
                     <small style="font-size: 75%; color: #363737;"> Data from <a href="http://data.worldbank.org/topic" target="_blank">World Bank:World Development Indicators</a> <br>

                          </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <fb:comments href="http://www.fueleconomics.info" num_posts="10" width="470"></fb:comments>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                  </div> <!--tabpane -->
                </div><!--tabcontent -->

              </div> <!--charts -->
          </div>   <!--span -->
      </div> <!--row -->

      <div class="row-fluid">
          <div class="span11"> 
            <hr>
            <footer>
                <p>&copy; Fuel Economics 2012</p>
            </footer>
          </div>        
      </div>


    </div><!--/.fluid-container-->
    
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- ClickTale Bottom part -->
<div id="ClickTaleDiv" style="display: none;"></div>
<script type="text/javascript">
if(document.location.protocol!='https:')
  document.write(unescape("%3Cscript%20src='http://s.clicktale.net/WRc9.js'%20type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
if(typeof ClickTale=='function') ClickTale(7007,0.5,"www09");
</script>
<!-- ClickTale end of Bottom part -->
  </body>
</html>

