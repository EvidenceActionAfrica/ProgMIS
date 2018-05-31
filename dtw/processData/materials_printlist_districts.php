<?php

if(isset($_POST["processData"])){

    

         $updateResult="Sub-Counties have been selected.";
        $num_rows=$_SESSION['rowCount'];
        unset($_SESSION['rowCount']);//To Avoid future errors since its unneeded after this
        $count=1;
        $disSelection=array();
        while($count<=$num_rows){
           //    echo "District ".$_POST["district".$count]."Selected<br/>".$_POST["selection".$count];
              if($_POST["district".$count] !=null){        
                  //  echo $_POST["selection".$count];
                    $selection=isset($_POST["selection".$count])?$_POST["selection".$count]:"NO";
                  //  echo $selection."<br/>";
                    $county=isset($_POST["county".$count])?$_POST["county".$count]:"";
                    $district=isset($_POST["district".$count])?$_POST["district".$count]:"";
                    
                  
                    if($selection=="YES"){
                      array_push($disSelection,$district);
                    }

              }
         ++$count;

        }

      
       $_SESSION["district_selection"]=$disSelection;

 
  }
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_materials_edit= $row['priv_materials_edit'];
}


if(!isset($_GET['Waveid'])){
 ?>

<form  method="post" style="margin-left:10%;">

<table class="table table-bordered table-condensed table-striped table-hover" >
<caption style='text-align:left;'><h2>Select A Wave For The Printlist</h2></caption>
  <tr  style="font-weight:bold">
    <td>No</td>
    <td>Wave</td>
    <td>Counties</td>
  </tr>
  
    <?php
      $sql='SELECT * from deworming_waves';
      $resultWave=mysql_query($sql);
      $count=1;
      while($waveRow=mysql_fetch_array($resultWave)){
        echo '<tr>';
        echo '<td><a  style="text-decoration:none;color:#000;" href="materials_printlist.php?Waveid='.$waveRow['id'].'">'.$count.'</a></td>';
        echo '<td><a style="text-decoration:none;color:#000;" href="materials_printlist.php?Waveid='.$waveRow['id'].'">'.$waveRow['deworming_wave'].'</a></td>';
        echo '<td><a style="text-decoration:none;color:#000;" href="materials_printlist.php?Waveid='.$waveRow['id'].'">'.$waveRow['county'].'</a></td>';
        echo '</tr>';
        ++$count;
      }
    ?>
 
</table>
</form>

<?php
}else{

$waveId=$_GET['Waveid'];
$sql='SELECT * from deworming_waves WHERE id='.$waveId;
$resultWave=mysql_query($sql);
$countyArray=array();
while($waveRow=mysql_fetch_array($resultWave)){

$countyString=$waveRow['county'];

while(stristr($countyString, ',',true)){
  $stringPos=strpos($countyString, ',')+1;
  $county=stristr($countyString, ',',true);
  array_push($countyArray, $county);
   $countyString=substr($countyString, $stringPos);
}

//The last county won't have a comma therefore push into array if its length is more than or equal to one
if(strlen($countyString)>=1){
   array_push($countyArray, $countyString);
}




}
$countyString='';
$count=0;
foreach ($countyArray as $key => $value) {
if($count==0){
$countyString.=' d.county="'.$value.'" ';
}else{
$countyString.=' OR d.county="'.$value.'"';
}
++$count;
}
$sql="SELECT DiSTINCT d.county,d.district_name FROM districts as d where ";
 $sql.=$countyString;
 $sql.=' ORDER by d.county ASC';
$result = mysql_query($sql);
$num_rows=mysql_affected_rows();
$_SESSION['rowCount']=$num_rows;
?>
<form  method="post" style="margin-left:30%;">
  <h2><u>Set Sub-Counties for Printlist form.</u></h2>
   <div style='background:#bada66;width:60%;'>
    <span id="h2info" style="font-size:1.3em;text-align:center;"> <?php echo $updateResult; $updateResult=""; ?></span>
    </div>
  
  <a style=" appearance:hyperlink;" class="btn" onclick="checkAll();">CHECK ALL </a> &nbsp; <a  class="btn" onclick="uncheckAll();">UNCHECK ALL</a><br/>
  <table class="table-hover" style="border: none" width="60%" >
    <thead>
        <tr>
          <th></th>        
           <th style='text-align:left;'>Number</th>
          <th style='text-align:left;'>County</th>
          <th style='text-align:left;'>Sub-County</th>
        </tr>
    </thead>
      <?php
        $count=1;
        while($row=mysql_fetch_array($result)){

          echo "<tr>";
          echo "<td style='text-align:style='text-align:left;'><input type='checkbox' class='checkers' name='selection".$count."' value='YES' style='text-align:left;' /></td>"."<td>".$count."</td><td><input type='text' style='text-align:left;'value='".$row["county"]."' readonly name='county".$count."' /></td><td ><input type='text' style='text-align:left;'readonly  value='".$row["district_name"]."' name='district".$count."' /></td>";
          echo "</tr>";
          ++$count;
        }
        echo "<br/><span style='text-align:left;font-weight:bold;'>Total Sub-Counties: ".$num_rows.'</span>';   
    ?>
  </table>
 <?php if($priv_materials_edit>=2){ ?>
  <input type="submit" name="processData" class="btn-custom" style="margin-left:30%;margin-top:5%;margin-bottom:5%;" value="Process Data" />
 <?php } ?>
</form>
<?php
}
?>
<script>
  function checkAll(){
      
       $(".checkers").prop("checked", true);
  }
  function uncheckAll(){
       $(".checkers").prop("checked", false);
  }
</script>