<?

$label = 'MP';
$total = 15000;
$highway = 6750;
$city = 8250;


if($distanceunit == 'km')  {

  $model['city'] = $model['city'] / 3.7854118;
  $model['highway'] = $model['highway'] / 3.7854118;
  $model['combined'] = $model['combined'] / 3.7854118;
  $label = 'KM';
  $highway = 6750 / 3.7854118;
  $city = 8250 /  3.7854118;
  $total = $highway + $city;
}

if($volumeunit == 'liter')  {

  $model['city'] = 1.609344*$model['city'];
  $model['highway'] = 1.609344*$model['highway'];
  $model['combined'] = 1.609344*$model['combined'];
  $label = $label.'L';
}else{
  $label = $label.'G';  
}

$model['city'] = round($model['city'],2);
$model['highway'] = round($model['highway'],2);
$model['combined'] = round($model['combined'],2);

$cost25 =  round((25 / $model['combined'] )* $price,2);
$fuel25 =  round(25 / $model['combined'],2);
$costyear = ($highway / $model['highway'] )*$price + ($city / $model['city'])*$price ;
$volume = ($highway / $model['highway'] ) + ($city / $model['city']);
$co2 = 8887*$volume;

if($volumeunit == 'liter'){
  $co2=$co2*0.264172052;
}

$co2 = $co2/1000;


?>

<script>
$('#co2car<?=$num?>').tooltip({});

</script>
  
<div class="car">
<table class="table" style="width: 90%; margin-left: auto; margin-right: auto;">
  <thead>
    <tr>
    <th colspan="4" style="color: #A0D36E;"> <?=$model['make']?> <?=$model['model']?> <?=$model['year']?> <?=$model['description']?>  
    </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td rowspan="3"  style="text-align: center;"><img src="http://fueleconomy.gov<?=$model['photoUrl']?>"> </td>
      <td colspan="3" style="text-align: center; color: #E8E8F0;"> <strong> Fuel economy (<?= $label ?> )</strong><td>
    </tr>
    <tr>
      <td style="text-align: center;  color: #E8E8F0;">  City  </td>
      <td style="text-align: center;  color: #E8E8F0;"> Combined </td>
      <td style="text-align: center;  color: #E8E8F0;">  Highway </td>
    </tr>
    <tr>
      <td style="text-align: center; color: #FACB47; font-size:150%;"><?=$model['city']?>  </td>
      <td style="text-align: center; color: #FACB47; font-size:200%;"><?=$model['combined']?>
        <input type="hidden" value="<?=$model['combined']?>" id="combined<?=$num?>" name="combined<?=$num?>" >
      </td>
      <td style="text-align: center; color: #FACB47; font-size:150%;">  <?=$model['highway']?>  </td>
    </tr>
    <tr>
      <td colspan="2" style=" color: #E8E8F0;"> Cost to drive 25 <?=$distanceunit?>s :</td> 
      <td colspan="2" style=" color: #FACB47;" nowrap>  <? if($price ==0) { ?> 
                      <span class="label label-warning">Chose a price</span>       <? } else {?>

      <?=$cost25?> $us <? } ?></td> 
    </tr>
    <tr>
      <td colspan="2" style=" color: #E8E8F0;"> Fuel to drive 25 <?=$distanceunit?>s :</td>
      <td colspan="2" style=" color: #FACB47;" nowrap> 

      <?=$fuel25?> <?=$volumeunit?>s</td> 
    </tr>
    <tr>
      <td colspan="2" style=" color: #E8E8F0;"> Anual fuel cost* :</td>
      <td colspan="2" style=" color: #FACB47;" nowrap> <? if($price ==0) { ?> 
                     <span class="label label-warning">Chose a price</span>      <? } else { ?>


                     <?= round($costyear,2)?> $us <? } ?></td> 
    </tr>
    <tr>
      <td colspan="2" style=" color: #E8E8F0;"> <a href="#co2" id="co2car<?=$num?>" rel="tooltip" title="Click to learn more"> <span class="label label-success" style="font-size: 120%;">Anual CO2 emission**:</span> </a> </td>
      <td colspan="2" style="color: #FACB47; font-size: 120%;" nowrap> <?=round($co2,2)?> Kgrams</td>

    </tr>

    <tr>
    <td colspan="4"  style="font-size: 70%; color: #363737;">  
 <small> *Based on 45% highway, 55% city driving, <?=round($total,2)?> annual <?=$distanceunit?>s and the fuel price selected. <br>
          Fuel econmy data provided by fueleconomy.gov <br>
          **CO2 emmision based on formula provided by <a href="http://nepis.epa.gov/Exe/ZyNET.exe/P100CZFN.TXT?ZyActionD=ZyDocument&Client=EPA&Index=2011+Thru+2015&Docs=&Query=&Time=&EndTime=&SearchMethod=1&TocRestrict=n&Toc=&TocEntry=&QField=&QFieldYear=&QFieldMonth=&QFieldDay=&IntQFieldOp=0&ExtQFieldOp=0&XmlQuery=&File=D%3A%5Czyfiles%5CIndex%20Data%5C11thru15%5CTxt%5C00000003%5CP100CZFN.txt&User=ANONYMOUS&Password=anonymous&SortMethod=h%7C-&MaximumDocuments=1&FuzzyDegree=0&ImageQuality=r75g8/r75g8/x150y150g16/i425&Display=p%7Cf&DefSeekPage=x&SearchBack=ZyActionL&Back=ZyActionS&BackDesc=Results%20page&MaximumPages=1&ZyEntry=1&SeekPage=x&ZyPURL" target="_blank" > EPA publication </a></small> 

 </td>
    </tr>


  </tbody>
</table>
</div>
