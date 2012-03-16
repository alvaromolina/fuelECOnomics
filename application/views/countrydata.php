<?


if($volumeunit == 'gallon')  {
  $country['fuel_price'] = $country['fuel_price']/1.609344;
}
$country['fuel_price']= round($country['fuel_price'],2);

?>

<script>
$('#changeprice').click(function() 
{
  $('#fuelp').html('<input id="pricevalue" class="input-mini" type="text">');
  $('#action').html(' <span id="saveprice" style="cursor: pointer; cursor: hand;" class="label label-info">Save</span>');
  $('#changeprice').html('');
  
  //countryChange();
  $('#saveprice').click(function() 
  {
    if (!isNaN($('#pricevalue').attr('value'))){
    $('#price').attr('value',$('#pricevalue').attr('value'));
    $('#fuelp').html($('#pricevalue').attr('value'));
    $('#changeprice').html('Change');
    $('#action').html('');
    
    }
  //countryChange();
  });
});

</script>
<hr>
<div id="countrydata" style="margin-left: auto; margin-right: auto; width:80%;">

<table class="table">
  <tbody>
    <tr>
      <td style="color: #E8E8F0;"> <strong> *Cost fuel (per <?=$volumeunit?>) </strong> </td>
      <td style="color: #FACB47; font-size:150%;">
      <span id="fuelp">
      <?=$country['fuel_price'] ?> </span> $us <span id="action"></span>
      <span id="changeprice" style="cursor: pointer; cursor: hand;" class="label label-info">Change</span> 
      </td>
    </tr>
    <tr>
    <td colspan="2"  >  
 <small style="font-size: 65%; color: #363737;"> *From most current data of <a href="http://data.worldbank.org/indicator/EP.PMP.SGAS.CD" target="_blank">World Bank:World Development Indicators</a>  </small> 

 </td>
    </tr>

  </tbody>
</table>

<input type="hidden" id="price" name="price" value="<?=$country['fuel_price']?>">

<small style="font-size: 70%; color: #363737;"> * </small> 



</div>
