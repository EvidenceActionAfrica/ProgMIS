<?php

require_once('../../includes/config.php');

$district_id = $_GET['district_id'];


 
// load county_name based on passed district_id
$result_display = mysql_query("SELECT * FROM districts WHERE district_id = '" . $district_id . "' LIMIT 1");
while ($row = mysql_fetch_array($result_display)) {
    echo $row['county'];
}  
