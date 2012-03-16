<?
$label = 'Kms';
if($distanceunit == 'mile')  {
  $label = 'Miles';
  $route = $route*0.621371192;
}

if($combined1!="" and $combined1!=0)
  $volume = $route/$combined1;
else
  $volume = 0;
$co2 = 8887*$volume;

$volumelabel ='gallons';
if($volumeunit == 'liter'){
  $volumelabel ='liters';
  $co2=$co2*0.264172052;
}

$route = round($route,4);
$cost = round($price*$volume,4);

$co2 = $co2/1000;

?>

<div id="routedatadiv" style="margin-left: auto; margin-right: auto; width:80%;">

<table class="table">
  <thead>
    <tr>
    <th colspan="4"> 
    </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="text-align: left; color: #E8E8F0;">Distance: </td>
      <td style="text-align: right; color: #FACB47; "> <?= $route.' '.$label ?>
      <input type="hidden" value="<?= $route ?>" id="distance" name="distance">
     </td>
    </tr>
    <tr>
      <td style="text-align: left; color: #E8E8F0;"> Fuel consumed: </td>
      <td style="text-align: right; color: #FACB47; "> <?=round($volume,4).' '.$volumelabel?>  </td>
    </tr>
    <tr>
      <td style="text-align: left; color: #E8E8F0;"> Cost Fuel: </td>
      <td style="text-align: right; color: #FACB47; "> <?=round($cost,2).' USD'?>  </td>
    </tr>

    <tr>
      <td style="text-align: left; color: #E8E8F0; "><a href="#co2"> <span class="label label-success" style="font-size: 130%;">CO2 emission:</span> <a> </td>
      <td style="text-align: right; color: #FACB47; font-size: 130%;"> <?=round($co2,2)?> Kgrams</td>

    </tr>
  </tbody>
</table>
</div>

