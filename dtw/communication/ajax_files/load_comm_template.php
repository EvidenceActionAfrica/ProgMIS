<?php

require_once('../../includes/config.php');

$commType = $_GET['commType'];
$req = $_GET['req'];
$id = $_GET['id'];




if ($commType == "sms") {
    if ($req == "subject") {
        // load requested record
        $result_display = mysql_query("SELECT * FROM comm_sms_template WHERE id = '" . $id . "' LIMIT 1");
        while ($row = mysql_fetch_array($result_display)) {
            echo $row['title'];
        } 
    } elseif ($req == "body") {
        // load requested record
        $result_display = mysql_query("SELECT * FROM comm_sms_template WHERE id = '" . $id . "' LIMIT 1");
        while ($row = mysql_fetch_array($result_display)) {
            echo $row['body'];
        }
        return;
    }
} else if ($commType == "email") {
    if ($req == "subject") {
        // load requested record
        $result_display = mysql_query("SELECT * FROM comm_email_template WHERE id = '" . $id . "' LIMIT 1");
        while ($row = mysql_fetch_array($result_display)) {
            echo $row['subject'];
        }
    } elseif ($req == "body") {
        // load requested record
        $result_display = mysql_query("SELECT * FROM comm_email_template WHERE id = '" . $id . "' LIMIT 1");
        while ($row = mysql_fetch_array($result_display)) {
            echo $row['body'];
        }
    }
}
