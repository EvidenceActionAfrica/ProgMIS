<html>
<head>
   <link rel="stylesheet" href="dataTables.css">
</head>

<?php
include("dbconnection.php");
?>

    <body>
        <br><br><br>
        <?php

        function division($field, $value, $value1) {
            $query = "SELECT $field FROM first WHERE month = '$value' AND program = '$value1' AND $field != '0'
                        AND $field != ''";
            $result = mysql_query($query) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
            $nume = mysql_num_rows($result);

            $query1 = "SELECT $field FROM first WHERE month = '$value' AND program = '$value1' AND $field != ''";
            $result1 = mysql_query($query1) or die("<h1>Cannot get num of " . $field . "</h1>" . mysql_error());
            $deno = mysql_num_rows($result1);
           

            if ($deno==null){
				return 0;
            }else{
              $div = $nume / $deno;
              return $div;
        	}

        }?>

        <table  >
            <tr>
                <td  colspan="13">TCR_adoption  (total chlorine adoption)</td>
            </tr>
            <tr>
                <td width="50px"></td>
                <td width="90px">Jan</td>
                <td width="90px">Feb</td>
                <td width="90px">Mar</td>
                <td width="90px">Apr</td>
                <td width="90px">May</td>
                <td width="90px">Jun</td>
                <td width="90px">Jul</td>
                <td width="90px">Aug</td>
                <td width="90px">Sep</td>
                <td width="90px">Oct</td>
                <td width="90px">Nov</td>
                <td width="90px">Dec</td>
            </tr>
            <tr>
                <td>BSA</td>
                <td><?php echo round ((division('c803_tcr_reading', '1', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '2', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '3', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '4', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '5', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '6', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '7', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '8', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '9', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '10', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '11', 'BSA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '12', 'BSA')),8);?></td>
            </tr> 
            <tr>
                <td>KKM</td>
                <td><?php echo round ((division('c803_tcr_reading', '1', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '2', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '3', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '4', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '5', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '6', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '7', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '8', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '9', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '10', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '11', 'KKM')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '12', 'KKM')),8);?></td>
            </tr> 
            <tr>
                <td>LGR</td>
                <td><?php echo round ((division('c803_tcr_reading', '1', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '2', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '3', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '4', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '5', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '6', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '7', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '8', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '9', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '10', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '11', 'LGR')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '12', 'LGR')),8);?></td>
            </tr> 
            <tr>
                <td>SYA</td>
                <td><?php echo round ((division('c803_tcr_reading', '1', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '2', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '3', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '4', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '5', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '6', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '7', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '8', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '9', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '10', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '11', 'SYA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '12', 'SYA')),8);?></td>
            </tr> 
            <tr>
                <td>UJA</td>
                <td><?php echo round ((division('c803_tcr_reading', '1', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '2', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '3', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '4', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '5', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '6', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '7', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '8', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '9', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '10', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '11', 'UJA')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '12', 'UJA')),8);?></td>
            </tr>
            <tr>
                <td>VHG</td>
                <td><?php echo round ((division('c803_tcr_reading', '1', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '2', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '3', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '4', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '5', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '6', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '7', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '8', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '9', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '10', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '11', 'VHG')),8);?></td>
                <td><?php echo round ((division('c803_tcr_reading', '12', 'VHG')),8);?></td>
            </tr>
            <tr>
                <td>- </td>               
            </tr>
            
            <tr>
                <td  colspan="13">FCR_adoption (free chlorine adoption)</td>
            </tr>
            <tr>
                <td width="50px"></td>
                <td width="90px">Jan</td>
                <td width="90px">Feb</td>
                <td width="90px">Mar</td>
                <td width="90px">Apr</td>
                <td width="90px">May</td>
                <td width="90px">Jun</td>
                <td width="90px">Jul</td>
                <td width="90px">Aug</td>
                <td width="90px">Sep</td>
                <td width="90px">Oct</td>
                <td width="90px">Nov</td>
                <td width="90px">Dec</td>
            </tr>
            <tr>
                <td>BSA</td>
                <td><?php echo round ((division('c806_fcr_reading', '1', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '2', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '3', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '4', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '5', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '6', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '7', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '8', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '9', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '10', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '11', 'BSA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '12', 'BSA')),8);?></td>
            </tr> 
            <tr>
                <td>KKM</td>
                <td><?php echo round ((division('c806_fcr_reading', '1', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '2', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '3', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '4', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '5', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '6', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '7', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '8', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '9', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '10', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '11', 'KKM')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '12', 'KKM')),8);?></td>
            </tr> 
            <tr>
                <td>LGR</td>
                <td><?php echo round ((division('c806_fcr_reading', '1', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '2', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '3', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '4', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '5', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '6', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '7', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '8', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '9', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '10', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '11', 'LGR')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '12', 'LGR')),8);?></td>
            </tr> 
            <tr>
                <td>SYA</td>
                <td><?php echo round ((division('c806_fcr_reading', '1', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '2', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '3', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '4', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '5', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '6', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '7', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '8', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '9', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '10', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '11', 'SYA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '12', 'SYA')),8);?></td>
            </tr> 
            <tr>
                <td>UJA</td>
                <td><?php echo round ((division('c806_fcr_reading', '1', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '2', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '3', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '4', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '5', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '6', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '7', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '8', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '9', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '10', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '11', 'UJA')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '12', 'UJA')),8);?></td>
            </tr>
            <tr>
                <td>VHG</td>
                <td><?php echo round ((division('c806_fcr_reading', '1', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '2', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '3', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '4', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '5', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '6', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '7', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '8', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '9', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '10', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '11', 'VHG')),8);?></td>
                <td><?php echo round ((division('c806_fcr_reading', '12', 'VHG')),8);?></td>
            </tr>
        </table>  

    </body>
</html>