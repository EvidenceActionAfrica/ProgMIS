
<div class="col-md-10">
<form action="<?php echo URL.'expansion/testOdkCalls/'; ?>" method="POST">
    <div class="form-group">
      <label for="spreadsheet_key">Google Spreadsheet Public key :</label><br>
      <input  id="spreadsheet_key" type="text" name="spreadsheet_key" class="form-control input-sm" value="12ndptfZW_oHxkLJEHlkzG8ByJXwxU9f4ASB6OePCZ3k"required/>
    </div>

  <span>
  Sample public key with key highlighted: <font style="color:  blue">https://docs.google.com/spreadsheets/d/<font style="background-color: yellow">12ndptfZW_oHxkLJEHlkzG8ByJXwxU9f4ASB6OePCZ3k</font>/edit#gid=0</font></td>
   </span>
     <div class="form-group">
      <label for="column_to_use">Column containing values to search for :(e.g a,b,c,d)</label><br>
      <input  id="column_to_use" type="text" name="column_to_use" class="form-control input-sm"/>leave blank to see full table
    </div>
     <div class="form-group">
      <label for="waterpoint_id">Search value in column (e.g waterpoint ID):</label><br>
      <input  id="waterpoint_id" type="text" name="waterpoint_id" class="form-control input-sm"/>
    </div>

   <div class="form-group">
  <input class="btn btn-default" type='submit' value='send' name='send' id='send'/>
    </div>

</form>

<?php
// if(isset($responseData)){
//   echo $responseData;
// }
?>


<?php
/*
if (isset($_POST['send'])) {

  $spreadsheet_key = $_POST['spreadsheet_key'];
  $column_to_use = $_POST['column_to_use'];
  $waterpoint_id = $_POST['waterpoint_id'];
  $return_value = 0;

  $column_to_use_UPPER = strtoupper($column_to_use);
  $column_to_use_lower = strtolower($column_to_use);


  //$spreadsheet_key = "phNtm3LmDZEObQ2itmSqHIA"; //pablo.nyaga sample spreadsheet
  //$spreadsheet_key = "12ndptfZW_oHxkLJEHlkzG8ByJXwxU9f4ASB6OePCZ3k"; //online available public spreadsheet
  //$spreadsheet_key = "0Akse3y5kCOR8dEh6cWRYWDVlWmN0TEdfRkZ3dkkzdGc"; //online available public spreadsheet
  //$json_google = file_get_contents('https://spreadsheets.google.com/tq?tqx=out:json&tq=select+A,B,C&key=12ndptfZW_oHxkLJEHlkzG8ByJXwxU9f4ASB6OePCZ3k');
  //echo $json_google;
  // $data1 = file_get_contents('https://spreadsheets.google.com/tq?tqx=out:html&tq=select+B,C,I&key=phNtm3LmDZEObQ2itmSqHIA');
  // echo $data1;
  // 
  // 
  //display table
  if (empty($column_to_use)) {
    $html_spreadsheet = file_get_contents('https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:html&tq');
  } else {
    $html_spreadsheet = file_get_contents('https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:html&tq=select+' . $column_to_use_UPPER . '');
  }
  echo $html_spreadsheet;

  $json_google = file_get_contents('https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:json&tq=select+' . $column_to_use_UPPER . '');

  echo "<br/><br/>";
  echo '---------------------------------------------------------------------------------------------------------------<br/>';


  $json_google = str_replace("google.visualization.Query.setResponse(", "", "$json_google");
  $json_google = str_replace(");", "", "$json_google");

  // Convert JSON string to Array
  $someArray = json_decode($json_google, true);

  $numberOfRows = sizeof($someArray['table']['rows']);

  for ($i = 0; $i < $numberOfRows; $i++) {
    if ($waterpoint_id == $someArray['table']['rows'][$i][$column_to_use_lower]['0']['v']) {
      $return_value+=1;
    }
  }
  echo "matches found: ";
  echo $return_value;

    echo '<pre>';
    print_r($someArray);
    echo '</pre>';
  //echo $json_google = '{"version":"0.6","reqId":"0","status":"ok","sig":"1541589170","table":{"cols":[{"id":"A","label":"id","type":"number","pattern":"General"},{"id":"B","label":"waterpt name","type":"string"},{"id":"C","label":"value","type":"number","pattern":"General"}],"rows":[{"c":[{"v":1.0,"f":"1"},{"v":"Name 1 "},{"v":298.0,"f":"298"}]},{"c":[{"v":2.0,"f":"2"},{"v":"Name 2"},{"v":551.0,"f":"551"}]},{"c":[{"v":3.0,"f":"3"},{"v":"Name 3"},{"v":804.0,"f":"804"}]},{"c":[{"v":4.0,"f":"4"},{"v":"Name 4"},{"v":null}]},{"c":[{"v":5.0,"f":"5"},{"v":"Name 5"},{"v":1310.0,"f":"1310"}]},{"c":[{"v":6.0,"f":"6"},{"v":"Name 6"},{"v":null}]},{"c":[{"v":7.0,"f":"7"},{"v":"Name 7"},{"v":1816.0,"f":"1816"}]},{"c":[{"v":8.0,"f":"8"},{"v":"Name 8"},{"v":2069.0,"f":"2069"}]},{"c":[{"v":9.0,"f":"9"},{"v":"Name 9"},{"v":null}]},{"c":[{"v":10.0,"f":"10"},{"v":"Name 10"},{"v":null}]},{"c":[{"v":11.0,"f":"11"},{"v":"Name 11"},{"v":2828.0,"f":"2828"}]},{"c":[{"v":12.0,"f":"12"},{"v":"Name 12"},{"v":3081.0,"f":"3081"}]},{"c":[{"v":13.0,"f":"13"},{"v":"Name 13"},{"v":null}]},{"c":[{"v":14.0,"f":"14"},{"v":"Name 14"},{"v":3587.0,"f":"3587"}]},{"c":[{"v":15.0,"f":"15"},{"v":"Name 15"},{"v":null}]},{"c":[{"v":16.0,"f":"16"},{"v":"Name 16"},{"v":4093.0,"f":"4093"}]},{"c":[{"v":17.0,"f":"17"},{"v":"Name 17"},{"v":null}]},{"c":[{"v":18.0,"f":"18"},{"v":"Name 18"},{"v":4599.0,"f":"4599"}]},{"c":[{"v":19.0,"f":"19"},{"v":"Name 19"},{"v":4852.0,"f":"4852"}]}]}}';
}
*/
?>

