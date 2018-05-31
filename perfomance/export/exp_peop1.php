<?php 
echo 'test';

foreach ($_POST['rec_country'] as $index => $country_val_ ) {
    $country_name = $_POST['rec_country_name'][$index];
    echo $country_name;
    echo $country_val_;
    echo '<br>';
}
?>