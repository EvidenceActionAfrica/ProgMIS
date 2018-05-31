<?php
include ('header.php');

// require_once ('includes/auth.php');
require_once ('includes/config.php');
?>

<div class="row">

    <div class="col-md-2">

        <div class="sidebar">

            <?php require_once ('includes/left_bar.php'); ?>
        </div>

    </div>

    <div class="col-md-10">


        <?php
        $field_ar = array('m', 'h');
        foreach ($field_ar as $field) {
            echo $field;
            echo '<br>';
        }
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
//        $sql = "SELECT DISTINCT month FROM dsw_per_adoption_rates ,dsw_per_dispensed_rates ";
        $sql = "SELECT distinct dsw_per_dispensed_rates.month, dsw_per_adoption_rates.year FROM dsw_per_dispensed_rates INNER JOIN dsw_per_adoption_rates";


        $result = mysql_query($sql);
        while ($rows = mysql_fetch_array($result)) {
            $val1 = $rows['month'];
            $val2 = $rows['year'];
            echo $val1;
            
            echo '<br>';
            echo $val2;
            
            echo '<br>';
        }


//        $sql = "SELECT distinct month FROM `dsw_per_adoption_rates`ORDER BY month";
//        $result = mysql_query($sql);
//                                while ($row = mysql_fetch_array($result)) {
//                                    $prog = $row["month"];
//                                    echo $prog;
//                                     echo '<br>';
//                                }
//                  
        ?>
    </div>
</div> 
</body>

</html>       