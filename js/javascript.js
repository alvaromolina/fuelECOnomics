/* Wall+ script by 99Points.info 
 * Copyright (c) 2011 Zeeshan Rasool
 * Licensed under the GNU General Public License version 3.0 (GPLv3)
 * http://www.webintersect.com/license.php
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 * See the GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Date: January 1, 2012
 *------------------------------------------------------------------------------------------------*/


function resetMake(){
  $('#make').attr('disabled', ''); 
  $('#make').html('<option value="">Select make</option>'); 
}

function resetModel(){
  $('#model').attr('disabled', ''); 
  $('#model').html('<option value="">Select model</option>');
  $('#car1').html(""); 
  $('#compare').addClass('disabled');    
}



function yearChange(){
    resetMake();
    resetModel();    
    if($('#year').attr('value') != "") {    
      $.post(base_url+"car/getMakes/"+$('#year').attr('value'), {
      }, function(response){
        $('#make').removeAttr('disabled');
        $('#make').html(response);
      });
    }
}

function makeChange(){
    resetModel();
    if($('#make').attr('value') != "") {
      $.post(base_url+"car/getModels/"+$('#year').attr('value'), {"make":$('#make').attr('value')

      }, function(response){
        $('#model').removeAttr('disabled');
        $('#model').html(response);
      });
    }

}
function modelChange(){
    
    
    $('#car1').html('<img align="center" src="'+base_url+'img/ajax-loader.gif">');
    $('#compare').addClass('disabled');    
    if($('#model').attr('value') != "") {
      $.post(base_url+"car/showCar/1/"+$('#model').attr('value'), {
        "volumeunit":$("input[name='volumeunit']:checked").val(),"distanceunit":$("input[name='distanceunit']:checked").val(),"price":$("#price").val()
      }, function(response){
        $('#compare').removeClass('disabled');            
        $('#car1').html(response);
      });
    }

}

function setRoute(){
  
if ($('#distance').length != 0) {
  from = $("#from").val();
  to = $("#to").val();        
  calcRoute(from, to);
}

}

$(document).ready(function(){	
	
  var section = $("#section").val();


  $('a[data-toggle="pill"]').on('shown', function (e) {
      console.log(e.target.name); // activated tab
      $('#mapindicator').attr('value',e.target.name);
      drawVisualization(e.target.name,$('#yearmap').attr('value'));
      //e.relatedTarget; // previous tab
  });
  
 	
	$('#uploadMedia').click(function(){
		$('#show_img_upload_div').show();
		//$('.main_bar').hide();
  });	

  $('#year').change(function() 
  {
    yearChange();
  });  

    
  $('#make').change(function() 
  {
    makeChange();
  }); 

  $('#model').change(function() 
  {
    modelChange();
  });

  $('#liter').change(function() 
  {
    modelChange();
    countryChange();        
    setRoute(); 
    modelChange2();  
  });
  
  $('#gallon').change(function() 
  {
    modelChange();
    countryChange();        
    setRoute();
    modelChange2();   
  });

  $('#km').change(function() 
  {
    modelChange();
    countryChange();            
    setRoute();   
    modelChange2();   
  });
  
  $('#mile').change(function() 
  {
    modelChange();
    countryChange();            
    setRoute(); 
    modelChange2();    
  });

  $('#compare').click(function() 
  {
      if(!$('#compare').hasClass('disabled')){
        $.post(base_url+"car/compareCar/", {}, function(response){
         $('#comparecar').html(response);
         location.href="#comparecar";
        });
      }
  });

    
  

});


