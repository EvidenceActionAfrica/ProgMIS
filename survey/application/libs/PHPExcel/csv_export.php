<?php

$file_name = $_GET['file_name'];
$table_name = $_GET['table_name'];

require_once ('../includes/config.php');
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename='.$file_name.'.csv');

//select table to export the data
$select_table = mysql_query('select * from '.$table_name.' ');
$rows = mysql_fetch_assoc($select_table);

if ($rows) {
  getcsv(array_keys($rows));
}
while ($rows) {
  getcsv($rows);
  $rows = mysql_fetch_assoc($select_table);
}

// get total number of fields present in the database
function getcsv($no_of_field_names) {
  $separate = '';


  // do the action for all field names as field name
  foreach ($no_of_field_names as $field_name) {
    if (preg_match('/\\r|\\n|,|"/', $field_name)) {
      $field_name = '' . str_replace('', $field_name) . '';
    }
    echo $separate . $field_name;

    //sepearte with the comma
    $separate = ',';
  }

  //make new row and line
  echo "\r\n";
}

?>