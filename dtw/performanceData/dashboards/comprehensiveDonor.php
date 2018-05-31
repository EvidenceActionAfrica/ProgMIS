<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root

    if (isset($_GET['submit-donor'])) {
        if ($_GET['donor']=="END") {
            $donor="END";
        }elseif($_GET['donor']=="CIFF"){
            $donor="CIFF";
        }else{
            $donor="ALL";
        }
    }else{
        $donor="ALL";
    }   

    // $donor="CIFF";
$placeholder = "N/A";
$tabActive = "tab1"; //wierdness
$placeholder = "No Data";
include "queryFunctionsDonor.php"; // all the functons are here
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {

    $priv_ciff_kpi = $row['priv_ciff_kpi'];
    $priv_ciff_report = $row['priv_ciff_report'];
    $priv_end_fund = $row['priv_end_fund'];
    $priv_ntd = $row['priv_ntd'];
    $priv_usaid = $row['priv_usaid'];
    $priv_who = $row['priv_who'];
}
if ($priv_ciff_kpi == 0 && $priv_ciff_report == 0 && $priv_end_fund == 0 && $priv_ntd == 0 && $priv_usaid == 0 && $priv_who == 0) {

    header("Location:../../home.php");
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
        <title>Evidence Action</title>
        <?php require_once ("includes/meta-link-script.php"); ?>

        <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery(".content00").hide();
                //toggle the componenet with class msg_body
                jQuery(".heading00").click(function()
                {
                    jQuery(this).next(".content00").slideToggle(300);
                });
            });
        </script>
    </head>
    <body>
        <!---------------- header start ------------------------>
        <div class="header vnav_100px">
            <div style="float: left">  <img src="../../images/logo.png" />  </div>
            <div class="menuLinks">
                <?php require_once ("includes/menuNav.php"); ?> 
                <?php //require_once ("includes/loginInfo.php");  ?> 
            </div>
        </div>
        <div class="clearFix"></div>
        <!---------------- content body ------------------------>
        <div class="contentMain">

            <div class="contentLeft">
                <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?>
            </div>
            <div class="contentBody">

                <div id="loading">
                    <img id="loading-image" src="../../images/loading.gif" alt="Loading..." />
                </div>
                <?php //require_once "includes/reporting-menu-tabs.php";  ?>

                <!--================================================-->
                <div id="dashboard">

                    <div id="indicator">

                        <div class="dashboard_menu">
                            <?php require_once "includes/reporting-menu-tabs.php"; ?>
                            <div class="dashboard_export col-md-4 col-md-offset-2">


                                <?php if ($priv_ciff_report >= 1) { ?>
                                    <a  href="exportExcelKPI.php" class="btn-custom-small">Export To Excel</a> 

                                    <a class="btn-custom-small" href="exportPdfKPI.php" target="_blank">Export To PDF</a> 
                                <?php } ?>
                            </div>
                            <div class="vclear"></div>
                          <?php include "includes/kpi-donor-dropdown.php" ?>
                            <div class="row col-md-offset-5">

                                <h2> <?php 
                                    if (isset($GET['donor'])) {
                                        echo $GET['donor'];
                                    }
                                 ?> KPI'S</h2>
                            </div>
                        </div>

                        <table id="hor-minimalist-b">

                            <th scope="col"><b>Indicator</b></th>

                            <th class="td-left" scope="col" style="width:200px"><b>Total</b></th>
                        </table>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        No. of  children dewormed for STH once
                                    </td>
                                    <td class="td-left" style="width:200px"><?php //echo number_format(sumSTH()); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. of districts covered for STH
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(numDistinctPlain('district_id', 'a_bysch',$donor,'district_id')) ?></td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        No. of divisions covered for STH
                                    </td>
                                    <td class="td-left"><?php   echo number_format(numDistinctPlain('division_id', 'a_bysch',$donor,'division_id  ')) ?></td>
                                </tr>   
                                <tr >
                                    <td>
                                        No. of Enrolled Primary School Aged children dewormed for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumArgs('a_bysch',$donor,'district_id', 'a_trt_m', 'a_trt_f')); ?></td>

                                </tr>   
                                
                                <tr>
                                    <td>
                                        No. of Enrolled Primary School Aged children dewormed for STH (male)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumPlain('a_trt_m', 'a_bysch',$donor,'district_id')); ?></td>

                                </tr>   

                                <tr>
                                    <td>
                                        No. of Enrolled Primary School Aged children dewormed for STH (female)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumPlain('a_trt_f', 'a_bysch',$donor,'district_id')); ?></td>

                                </tr>


                                <tr>
                                    <td>
                                        No. of Non-enrolled (age 6-18) children dewormed for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolled6andover('STH',$donor,'district_id')); ?></td>

                                </tr>   
                                
                                <tr>
                                    <td>
                                        No. of Non-enrolled (age 6-18) children dewormed for STH (male)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolled6andoverMale('STH',$donor,'district_id')); ?></td>

                                </tr>   

                                
                                <tr>
                                    <td>
                                        No. of Non-enrolled (age 6-18) children dewormed for STH (female)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolled6andoverFemale('STH',$donor,'district_id')); ?></td>

                                </tr>


                                <tr>
                                    <td>
                                        No. of U5 children dewormed for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumUnder5($donor,'district_id')); ?></td>

                                </tr>   


                                <tr>
                                    <td>
                                        No. of U5 children dewormed for STH (male)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumUnder5Male($donor,'district_id')); ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of U5 children dewormed for STH (female)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumUnder5Female($donor,'district_id')); ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of ALB estimated for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumPlain('p_alb', 'p_bysch',$donor,'district_id')); ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        No. of children dewormed for Schisto once
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(sumSHISTO($donor,'district_id')); ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. of Sub-Counties covered for Schisto
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(numDistinct('district_id', 'a_bysch', 'Yes',$donor,'district_id')); ?></td>

                                </tr>    

                                <tr>
                                    <td>
                                        No. of divisions covered for Schisto
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numDistinct('division_id', 'a_bysch', 'Yes',$donor,'district_id')); ?></td>

                                </tr>      
                                <tr>
                                    <td>
                                        No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumArgs('a_bysch',$donor,'district_id', 'ap_trt_m', 'ap_trt_f', 'ap_ecd_f', 'ap_ecd_m')); ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Male)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumArgs('a_bysch',$donor,'district_id', 'ap_trt_m', 'ap_ecd_m')); ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Female)
                                    </td>
                                    <td class="td-left"><?php echo number_format(sumArgs('a_bysch',$donor,'district_id', 'ap_trt_f', 'ap_ecd_f')); ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        No. of Non Enrolled (age 6-18) children dewormed for Schisto
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolled6andover('SHISTO',$donor,'district_id')); ?></td>

                                </tr> 
                                <tr>
                                    <td>
                                        No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolled6andoverMale('SHISTO',$donor,'district_id')); ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolled6andoverFemale('SHISTO',$donor,'district_id')); ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <tr class="highlighter_tr">
                                        <td>
                                            Percentage of enrolled children aged 6+ receiving STH 
                                        </td>
                                        <td class="td-left" style="width:200px"><?php  echo percentage(sumArgs('a_bysch',$donor,'district_id','a_6_18_total','a_ecd_a'),sumPlain('a_total_child','a_bysch',$donor,'district_id'));?></td>

                                    </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        No. of Enrolled Primary School Aged children dewormed for STH
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(sumArgs('a_bysch',$donor,'district_id', 'a_trt_m', 'a_trt_f')); ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        Estimated target population of STH
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(EstimatedTotalSTH($donor,'district_id')) ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        Estimated No. of 'Enrolled Primary School' children for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumPlain('p_pri_enroll', 'p_bysch',$donor,'district_id')); ?></td>
                                </tr>   
                                <tr>
                                    <td>
                                        Estimated No. of 'Enrolled ECD' children for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumPlain('p_ecd_enroll', 'p_bysch',$donor,'district_id')); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <!-- #CORRECT : all the schools are targeted for STH -->
                                        No. of schools targeted for STH
                                    </td>
                                    <td class="td-left">
                                        <?php  echo number_format(numEstimated('p_sch_id', 'Y',$donor,'district_id')) ?>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>
                                        No. of public schools for STH 
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Public',$donor,'s_district_id')); ?></td>
                                </tr>   
                                <tr>
                                    <td>
                                        No. of private schools for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Private',$donor,'s_district_id')); ?></td>
                                </tr>  
                                <tr>
                                    <td>
                                        No. of 'other' schools for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Other',$donor,'s_district_id')); ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of 'no school type' schools for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'None',$donor,'s_district_id')); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        Percentage enrolled children aged 6+ receiving Schisto Treatment once
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo percentage(sumArgs('a_bysch',$donor,'district_id','ap_6_18_total','ap_ecd_a'),sumPlain('ap_total_child','a_bysch',$donor,'district_id'))?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(sumArgs('a_bysch', $donor,'district_id','ap_trt_m', 'ap_trt_f', 'ap_ecd_f', 'ap_ecd_m')); ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        Estimated target population of Schisto
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(EstimatedTotalSHISTO($donor,'district_id')); ?></td>

                                </tr>    
                                <tr >
                                    <td>
                                        Estimated No. of 'Enrolled Primary School' children for SCHISTO
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumEstimated('p_pri_enroll', 'Y',$donor,'district_id')) ?></td>

                                </tr>  
                                <tr>
                                    <td>
                                        <font> Estimated No. of 'Enrolled ECD' children for SCHISTO</font>
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumEstimated('p_ecd_enroll', 'Y',$donor,'district_id')) ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of districts planned for SCHISTO
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numDistinctP('district_id', 'Y',$donor,'district_id')) ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        No. of schools covered for Schisto
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numDistinct('school_id', 'a_bysch', 'Yes',$donor,'district_id')); ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        No. of schools targeted for Schisto
                                    </td>
                                    <td class="td-left">
                                        <?php   echo number_format(numFlexible('p_sch_id', 'p_bysch', 'p_sch_bilharzia', 'Yes',$donor,'district_id')) ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of public schools for SCHISTO
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numSchoolTypeS('Public', 'Yes',$donor,'s_district_id')) ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        No. of private schools for SCHISTO
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numSchoolTypeS('Private', 'Yes',$donor,'s_district_id')) ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of 'other' schools for SCHISTO
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numSchoolTypeS('Other', 'Yes',$donor,'s_district_id')) ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of 'no school type' schools for SCHISTO
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numSchoolTypeS('Not specified', 'Yes',$donor,'s_district_id')) ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        <font> No. of Enrolled Primary School Aged children registered for Schisto</font>
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumPriRegisteredSbysch('pzq',$donor,'s_district_id')) ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        Estimated No. of PZQ tablets needed
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumPlain('p_pzq', 'p_bysch',$donor,'district_id')); ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">

                                    <td>
                                        No. of Non-enrolled (age 6-18) children dewormed for STH
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(sumNonEnrolled6andover('STH',$donor,'district_id')); ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. of Non-enrolled (age 6-18) children dewormed for STH (male)
                                    </td>
                                    <td class="td-left" style="width:200px"><?php   echo number_format(sumNonEnrolled6andoverMale('STH',$donor,'district_id')); ?></td>

                                </tr>  
                                <tr>
                                    <td>
                                        No. of Non-enrolled (age 6-18) children dewormed for STH (female)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolled6andoverFemale('STH',$donor,'district_id')); ?></td>

                                </tr> 

                                <tr>
                                    <td>
                                        No. of Non-enrolled (age 6-10) children dewormed for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolledGender('a_6', 'a_bysch',$donor,'district_id')) ?></td>

                                </tr>      
                                <tr>
                                    <td>
                                        No. of Non-enrolled (age 11-14) children dewormed for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolledGender('a_11', 'a_bysch',$donor,'district_id')) ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of Non-enrolled (age 15-18) children dewormed for STH
                                    </td>
                                    <td class="td-left"><?php //echo number_format(sumNonEnrolledGender('a_15', 'a_bysch',$donor,'district_id')) ?></td>

                                </tr>

                                <tr>
                                    <td>
                                        Average No of Non-enrolled Children Treated per school (6-18)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(divisionValues(sumNonEnrolled6andover('STH',$donor,'district_id'),num('school_id','a_bysch',$donor,'district_id')),2,'.','')?></td>

                                </tr>
                                <tr>
                                    <td>
                                        Minimum No of Non-enrolled Children Treated per school (6-18)
                                    </td>
                                    <td class="td-left"><?php  echo minimum('a_6_18_total','a_bysch',$donor,'district_id')?></td>

                                </tr>
                                <tr>
                                    <td>
                                        Maximum No of Non-enrolled Children Treated per school (6-18)
                                    </td>
                                    <td class="td-left"><?php  echo maximum('a_6_18_total','a_bysch',$donor,'district_id')?></td>

                                </tr>
                                <tr>
                                    <td>
                                        No of Schools that Treated NO Non-Enrolled Children (6-18)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numFlexible('school_id','a_bysch','a_6_18_total',0,$donor,'district_id'))?></td>

                                </tr>

                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        <font> No. of Non Enrolled (age 6-18) children dewormed for Schisto</font>
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(sumNonEnrolled6andover('SHISTO',$donor,'district_id')); ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        <font> No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)</font>
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(sumNonEnrolled6andoverMale('SHISTO',$donor,'district_id')); ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        <font>  No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)</font>
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolled6andoverFemale('SHISTO',$donor,'district_id')); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of Non Enrolled (age 6-10) children dewormed for Schisto
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolledGender('ap_6', 'a_bysch',$donor,'district_id')) ?></td>

                                </tr>   
                                <tr>
                                    <td>
                                        No. of Non Enrolled (age 11-14) children dewormed for Schisto
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolledGender('ap_11', 'a_bysch',$donor,'district_id')) ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        No. of Non Enrolled (age 15-18) children dewormed for Schisto
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumNonEnrolledGender('ap_15', 'a_bysch',$donor,'district_id')) ?></td>

                                </tr>  
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        No. of U5 children dewormed for STH
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(sumUnder5($donor,'district_id')); ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. of U5 children dewormed for STH (male)
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo number_format(sumUnder5Male($donor,'district_id')); ?></td>

                                </tr>  
                                <tr>
                                    <td>
                                        No. of U5 children dewormed for STH (female)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumUnder5Female($donor,'district_id')); ?></td>

                                </tr>   

                                <tr>
                                    <td>
                                        No. of Non-enrolled (age 2-5) children dewormed for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumPlain('a_2_total', 'a_bysch',$donor,'district_id')); ?></td>

                                </tr> 
                                <tr>
                                    <td>
                                        No. of ECD children dewormed for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(sumArgs('a_bysch',$donor,'district_id','a_ecd_m', 'a_ecd_f')); ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        No of Schools Treating NO Under 5s
                                    </td>
                                    <td class="td-left"><?php  echo numFlexible('a_u5_total','a_bysch','a_u5_total',0,$donor,'district_id') ?></td>

                                </tr> 
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        Percentage No of target schools attending teacher training sessions
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo percentage(num('school_no','attnt_bysch',$donor,'attnt_district_id'),num('p_sch_id','p_bysch',$donor,'district_id')) ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. target schools attending teacher training sessions
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo ttSchoolsOnP($donor,'attnt_district_id'); ?></td>

                                </tr>  
                                <tr>
                                    <td>
                                        <!-- #CORRECT : all the schools are targeted for STH -->
                                        No. of schools targeted for STH
                                    </td>
                                    <td class="td-left"><?php  echo number_format(num('p_sch_id', 'p_bysch',$donor,'district_id')) ?></td>
                                </tr>     

                                <tr>
                                    <td>
                                        No. of District attending teacher training
                                    </td>
                                    <td class="td-left">
                                        <?php  echo numDistinctPlain('attnt_district_name', 'attnt_bysch',$donor,'attnt_district_id'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of divisions attending teacher training
                                    </td>
                                    <td class="td-left">
                                        <?php  echo number_format(num('attnt_division_name', 'attnt_bysch',$donor,'attnt_district_id')) ?>
                                    </td>
                                </tr> 

                                <tr>
                                    <td>
                                        No of Divisions Planned
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numDistinctPlain('division_id', 'p_bysch',$donor,'district_id')) ?></td>


                                </tr>
                                <tr>
                                    <td>
                                        No. of teachers trained
                                    </td>
                                    <td class="td-left">
                                        <?php  echo number_format(getAttntTeachersAll($donor,'attnt_district_id'))?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        Percentage of TTS where Albendazole (& Praziquantel if necessary) are available on the day of Training
                                    </td>
                                    <td class="td-left" style="width:200px">
                                        <?php  echo attntDDOntime($donor,'attnt_district_id');?>
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. of TTs with requiered drugs
                                    </td>
                                    <td class="td-left" style="width:200px">
                                        <?php  echo number_format(numFlexible('attnt_id', 'attnt_bysch', 'attnt_total_drugs', '1',$donor,'attnt_district_id')) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        No of TTS Planned
                                    </td>
                                    <td class="td-left"><?php  echo numDistinctPlain('attnt_id','attnt_bysch',$donor,'attnt_district_id') ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        No of TTS conducted
                                    </td>
                                    <td class="td-left"><?php  echo numDistinctPlain('attnt_id', 'attnt_bysch',$donor,'attnt_district_id') ?></td>

                                </tr>
                                <tr>
                                    <td>
                                        No of TTS conducted for STH Only
                                    </td>
                                    <td class="td-left">
                                        <?php   echo numDistinctFlexible('attnt_id', 'attnt_bysch', 'attnt_sth', '1',$donor,'attnt_district_id') ?>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        No of TTS conducted for STH & Schisto
                                    </td>
                                    <td class="td-left">
                                        <?php  echo numDistinctFlexible('attnt_id', 'attnt_bysch', 'attnt_schisto', '1',$donor,'attnt_district_id') ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        No of TTS (STH Only) where only Alb present
                                    </td>
                                    <td class="td-left"><?php  echo numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '0', 'attnt_sth', '1',$donor,'attnt_district_id') ?></td>
                                </tr>

                                <tr>
                                    <td>
                                        No of TTS (STH Only) where no drugs present
                                    </td>
                                    <td class="td-left"><?php  echo numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '0', 'attnt_sth', '1',$donor,'attnt_district_id') ?></td>
                                </tr>

                                <tr>
                                    <td>
                                        No of TTS (STH & Schisto) where Alb & Prazi present
                                    </td>
                                    <td class="td-left"><?php  echo numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '1', 'attnt_schisto', '1',$donor,'attnt_district_id') ?></td>
                                </tr>



                                <tr>
                                    <td>
                                        No of TTS (STH & Schisto) where only Alb & Prazi present
                                    </td>
                                    <td class="td-left"><?php  echo numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '1', 'attnt_schisto', '1',$donor,'attnt_district_id') ?></td>
                                </tr>

                                <tr>
                                    <td>
                                        No of TTS (STH & Schisto) where only Alb present
                                    </td>
                                    <td class="td-left"><?php  echo numAttntFlex('attnt_id', 'attnt_alb_tt', '1', 'attnt_pzq_tt', '0', 'attnt_schisto', '1',$donor,'attnt_district_id') ?></td>
                                </tr>


                                <tr>
                                    <td>
                                        No of TTS (STH & Schisto) where no drugs present
                                    </td>
                                    <td class="td-left"><?php  echo numAttntFlex('attnt_id', 'attnt_alb_tt', '0', 'attnt_pzq_tt', '0', 'attnt_schisto', '1',$donor,'attnt_district_id') ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        Percentage of schools attending  teacher trainings receiving all critical materials  for deworming  day at teacher trainings;  (critical is defined as: drugs, poles, monitoring  forms
                                    </td>
                                    <td class="td-left" style="width:200px">
                                        <?php 
                                                $row37 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0',$donor,'attnt_district_id'));
                                            $row44 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', 'Treating for Bilharzia',$donor,'attnt_district_id'));
                                            $row46 = $row46 = remove_comma($row37) + remove_comma($row44);

                                             echo percentage($row46,sumPlain('school_id','attnt_bysch',$donor,'attnt_district_id')) ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No of TTS conducted
                                    </td>
                                    <td class="td-left" style="width:200px"><?php  echo numDistinctPlain('attnt_id', 'attnt_bysch',$donor,'attnt_district_id') ?></td>

                                </tr>


                                <tr>
                                    <td>
                                        No. of schools attending teacher training
                                    </td>
                                    <td class="td-left"><?php  echo numDistinctPlain('school_id', 'attnt_bysch',$donor,'attnt_district_id'); ?></td>
                                </tr>


                                <tr>
                                    <td>

                                    <?php 
                                            // $row37 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0'));
                                            // $row44 = number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', 'Treating for Bilharzia')) ;
                                    ?>
                                        No. of schools with critical materials present
                                    </td>
                                    <!-- <td class="td-left"><?php// echo $row46 = number_format($row46 = remove_comma($row37) + remove_comma($row44)) ?></td> -->
                                    <td class="td-left"><?php  echo $row46 ?></td>
                                </tr>


                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH Only)
                                    </td>
                                    <td class="td-left"><?php  echo numDistinctFlexible('school_id', 'attnt_bysch', 'attnt_sth', '1',$donor,'attnt_district_id') ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH & Schisto)
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numDistinctFlexible('school_id', 'attnt_bysch', 'attnt_schisto', '1',$donor,'attnt_district_id')); ?> </td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH Only) with Drugs only
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '0',$donor,'attnt_district_id')) ?></td>
                                </tr>

                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH Only) with Forms only
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0',$donor,'attnt_district_id')) ?> </td>
                                </tr>


                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH Only) with Drugs & Forms
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '0',$donor,'attnt_district_id')) ?></td>
                                </tr>


                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH Only) with no critical Materials
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '0',$donor,'attnt_district_id')) ?> </td>
                                </tr>


                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH & Schisto) with Drugs only
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1',$donor,'attnt_district_id')) ?></td>
                                </tr>


                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH & Schisto) with Forms only
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1',$donor,'attnt_district_id')) ?></td>
                                </tr>


                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH & Schisto) with Drugs & Forms
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '0', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1',$donor,'attnt_district_id')) ?></td>
                                </tr>

                              <!--   <tr>
                                    <td>
                                        No. of schools attending teacher training (STH & Schisto) with no critical Materials
                                    </td>
                                    <td class="td-left"><?php //echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '0', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1')) ?></td>
                                </tr> -->



                               <!--  <tr>
                                    <td>
                                        No. of schools attending teacher training (STH & Schisto) with Drugs & Poles
                                    </td>
                                    <td class="td-left"><?php //echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1')) ?></td>
                                </tr> -->


                                <!-- <tr>
                                    <td>
                                        No. of schools attending teacher training (STH & Schisto) with Poles only
                                    </td>
                                    <td class="td-left"><?php //echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '0', 'attnt_sch_treatment', '1')) ?> </td>
                                </tr> -->
                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH & Schisto) with Poles & Forms
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '0', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1',$donor,'attnt_district_id')) ?></td>
                                </tr>


                                <tr>
                                    <td>
                                        No. of schools attending teacher training (STH & Schisto) with Drugs, Poles & Forms
                                    </td>
                                    <td class="td-left"><?php  echo number_format(numAttntFlex4('school_id', 'attnt_total_drugs', '1', 'attnt_total_poles', '1', 'attnt_total_forms', '1', 'attnt_sch_treatment', '1',$donor,'attnt_district_id')) ?></td>
                                </tr>

                              <!--   <tr>
                                    <td>
                                        No. TTs where funds are available
                                    </td>
                                    <td class="td-left">
                                        <?php ?>
                                    </td>
                                </tr> -->

                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        Percentage of schools performing  deworming  on designated  County deworming  day
                                    </td>
                                    <td style="width:200px" class="td-left">
                                        <?php  echo dewormingDayFormS('percent',$donor,'s_district_id'); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                    <tr>
                                        <td>
                                            No of schools that did not provide deworming date on Form S
                                        </td>
                                        <td style="width:200px" class="td-left">
                                            <?php  echo numFlexible('s_prog_sch_id','s_bysch','s_deworming_day','',$donor,'s_district_id')?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            No of schools that provided deworming date on Form S
                                        </td>
                                        <td class="td-left">
                                            <?php  echo NotEmpty('s_deworming_day','s_bysch',$donor,'s_district_id')?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            No of schools that performed Deworming Day on designated County deworming day
                                        </td>
                                        <td class="td-left">
                                            <?php  echo number_format(dewormingDayFormS(false,$donor,'s_district_id'));?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Total no of schools on form S
                                        </td>
                                        <td class="td-left"><?php  echo numDistinctPlain('s_prog_sch_id', 's_bysch',$donor,'s_district_id'); ?></td>
                                    </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        % divisions correctly (+/- 10%) reporting on school level coverage of total children dewormed.
                                    </td>
                                    <td class="td-left" style="width:200px"> <?php echo $placeholder; ?></td>

                                </tr>   
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        % Sub-Counties correctly (+/- 10%) reporting on school-level coverage of total children dewormed.
                                    </td>
                                    <td class="td-left" style="width:200px"> <?php echo $placeholder; ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. of Sub-Counties returning form S, A & D in full
                                    </td>
                                    <td class="td-left" style="width:200px">
                                        <?php ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of Divisions returning form S, A & D in full
                                    </td>
                                    <td class="td-left">
                                        <?php ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of  children dewormed for STH form S
                                    </td>
                                    <td class="td-left">
                                        <?php echo number_format(sumPlain('s_total_child', 's_bysch',$donor,'s_district_id')); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of  children dewormed for STH form A
                                    </td>
                                    <td class="td-left">
                                        <?php echo number_format(sumPlain('a_total_child', 'a_bysch',$donor,'district_id')); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of  children dewormed for STH form D
                                    </td>
                                    <td class="td-left"></td>
                                </tr>

                                <tr>
                                    <td>
                                        No. of  Schools dewormed for STH form S
                                    </td>
                                    <td class="td-left"><?php  echo numDistinctPlain('s_prog_sch_id', 's_bysch',$donor,'s_district_id'); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of  Schools dewormed for STH form A
                                    </td>
                                   <td class="td-left"><?php  echo number_format(numDistinctPlain('school_id', 'a_bysch',$donor,'district_id')); ?></td>                                    
                                </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        % Sub-Counties submitting forms S,A,and D to National level within three months of deworming day
                                    </td>
                                    <td class="td-left" style="width:200px"> <?php echo $placeholder; ?></td>

                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. of Schools returning form S
                                    </td>
                                    <td class="td-left" style="width:200px">
                                        
                                        <?php echo number_format(NotEmpty('s_prog_sch_id','s_bysch',$donor,'s_district_id'))?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>No. of Sub-County returning form A</td>
                                    <td class="td-left"><?php ?></td>
                                </tr>


                                <tr>
                                    <td>
                                        No. of Sub-County returning form D
                                    </td>
                                    <td class="td-left">
                                        <?php ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        No of Adults treated
                                    </td>
                                    <td class="td-left" style="width:200px">
                                        <?php ?>
                                    </td>
                                </tr>

                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. of Adult Treated for STH
                                    </td>
                                    <td class="td-left" style="width:200px">
                                        <?php echo number_format(sumPlain('s_adult_total', 's_bysch',$donor,'s_district_id')); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of Adult Treated for Schisto
                                    </td>
                                    <td class="td-left">
                                        <?php echo number_format(sumPlain('sp_adult_total', 's_bysch',$donor,'s_district_id')); ?>
                                    </td>
                                </tr>
                                </table>
                        </div>
                        <div class="heading00">
                            <table id="hor-minimalist-b">
                                <tr class="highlighter_tr">
                                    <td>
                                        No. of Gok personnel at regional training
                                    </td>
                                    <td class="td-left" style="width:200px">
                                        <?php ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="content00">
                            <table id="hor-minimalist-b">
                                <tr>
                                    <td>
                                        No. of Gok Sub-County personnel at Sub-County training
                                    </td>
                                    <td class="td-left" style="width:200px">
                                        <?php ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        No. of Gok divisional personnel at Sub-County training
                                    </td>
                                    <td class="td-left">
                                        <?php ?>
                                    </td>
                                </tr>
                            </table>

                        </div>

                    </div>

                </div> <!-- end content body-->



                <!--================================================-->
            </div><!--end of content Main -->
        </div>
        <div class="clearFix"></div>
        <!---------------- Footer ------------------------>
        <!--<div class="footer">  </div>-->
    </body>
</html>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">

    <script type="text/javascript">
        $(document).ready(function() {
            $('#data-table').dataTable();

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('table.display').dataTable();
        })
    </script>

