<script type="text/javascript">

function resetMake2(){
  $('#make2').attr('disabled', ''); 
  $('#make2').html('<option value="">Select make</option>'); 
}

function resetModel2(){
  $('#model2').attr('disabled', ''); 
  $('#model2').html('<option value="">Select model</option>');
  $('#car2').html("");  
}

function yearChange2(){
    resetMake2();
    resetModel2();    
    if($('#year2').attr('value') != "") {    
      $.post(base_url+"car/getMakes/"+$('#year2').attr('value'), {
      }, function(response){
        $('#make2').removeAttr('disabled');
        $('#make2').html(response);
      });
    }
}

function makeChange2(){
    resetModel2();
    if($('#make2').attr('value') != "") {
      $.post(base_url+"car/getModels/"+$('#year2').attr('value'), {"make":$('#make2').attr('value')

      }, function(response){
        $('#model2').removeAttr('disabled');
        $('#model2').html(response);
      });
    }

}
function modelChange2(){
    
    $('#car2').html('<img align="center" src="'+base_url+'img/ajax-loader.gif">');
    if($('#model2').attr('value') != "") {
      $.post(base_url+"car/showCar/2/"+$('#model2').attr('value'), {
        "volumeunit":$("input[name='volumeunit']:checked").val(),"distanceunit":$("input[name='distanceunit']:checked").val(),"price":$("#price").val()
      }, function(response){
        $('#car2').html(response);
      });
    }

}


$('#year2').change(function() 
  {
    yearChange2();
  }); 

  $('#make2').change(function() 
  {
    makeChange2();
    
  }); 

  $('#model2').change(function() 
  {
    modelChange2();

  });
</script>
<form class="form-horizontal">
  <fieldset>
    <legend>Select car</legend>
    <div class="control-group">
      <label class="control-label" style="width: 60px;" for="year2">Year:</label>
      <div class="controls" style="margin-left: 80px;">
        <select id="year2" class="span10">
          <option value="">Select a year</option>
          <? foreach($years as $year){ ?>
            <option value="<?=$year?>"><?=$year?></option>
          <? } ?>
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" style="width: 60px;" for="make2">Make:</label>
      <div style="margin-left: 80px;" >
        <select id="make2" class="span10" disabled>
          <option value="">Select make</option>
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" style="width: 60px;" for="model2">Model:</label>
      <div class="controls" style="margin-left: 80px;">
        <select id="model2" class="span10" disabled>
          <option value="">Select a model</option>
        </select>
      </div>
    </div>
  </fieldset>
</form>
<div id="car2" style="text-align: center;"> 
       
</div>

