<?php
/**
 * The array below just helps you to show where to place the values of the array $adminData.Do not use the one below.
 * The other logs are more of the same. If different, an example will be shown above the function
 * Good luck...
 */
$adminData = array(
    "userId" => "",
    "user_email" => "",
    "user_name" => "",
    "module" => "",
    "action" => "",
    "description" => "",
);

/**
 * Admin Data is an array
 * 
 */
function funcLogAdminData($arrAdminData) {
    $userId = $arrAdminData[0];
    $user_email = $arrAdminData[1];
    $user_name = $arrAdminData[2];
    //$form_name = $arrAdminData[3];
    $action = $arrAdminData[3];
    $description = $arrAdminData[4];
    
    $sql="INSERT INTO `log_admindata`(`user_id`, `user_email`, `user_name`, `action`, `description`,'module')";
    
    $sql.=" VALUES ('$userId','$user_email','$user_name','$action','$description',1)";
    
    $resultLog=mysql_query($sql);
    return $resultLog;
}
/*
This Method is an improvement of funcLogAdminData.It's used in all modules except the admin module.
It allows quicker insertions into the logs
*/

function quickFuncLog($ArrayData){

    $userId = $_SESSION['staff_id'];;
    $user_email = $_SESSION['staff_email'];;
    $user_name = $_SESSION['staff_name'];;
    //$form_name = $arrAdminData[3];
    $Module=$ArrayData[0];
    $action = $ArrayData[1];
    $description = $ArrayData[2];
    
    $sql="INSERT INTO `log_admindata`(`user_id`, `user_email`, `user_name`, `action`, `description`,`module`)";
    
     $sql.=" VALUES ('$userId','$user_email','$user_name','$action','$description',".$Module.")";
 
    $resultLog=mysql_query($sql) or die(mysql_error());
    return $resultLog;




}


?>
