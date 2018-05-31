<?php
$message_pop_up = '';
if ($reg_no == '') {
    $message_pop_up = 'Please, choose a registration number (Reg Num)';
}
?>
<style>
    #data-table1 td {
        padding: 3px 7px;
        font-size: 13px;
        vertical-align: middle;
        color: #6B6B6B;
    }
    #data-table1 th {
        background-color: #ffffff; border-bottom: 1px solid #000000; 
        font-size: 12px;
    }   
    #data-table2 td {
        padding: 3px 7px;
        font-size: 13px;
        vertical-align: middle;
        color: #6B6B6B;
    }
    #data-table2 th {
        background-color: #ffffff; border-bottom: 1px solid #000000; 
        font-size: 12px;
    } 
    #data-table3 td {
        padding: 3px 7px;
        font-size: 13px;
        vertical-align: middle;
        color: #6B6B6B;
    }
    #data-table3 th {
        background-color: #ffffff; border-bottom: 1px solid #000000; 
        font-size: 12px;
    }
    table.dataTable.no-footer {
        border-bottom: 0px;
        margin-bottom: 20px;
    }
</style>
<div class="col-md-10">
    <?php if (isset($_GET['message'])) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $_GET['message']; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
    <?php if ($message_pop_up != '') { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php echo $message_pop_up; ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
    <div id="data-table-manger">
        <div class="clearfix">
            <h3 class="pull-left">Vehicle and Motorcycle Usage Log</h3>
            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">                    
                    <!--<button type="button" style='margin-right:10px;' class="btn btn-default pink-button" data-toggle="modal" data-target="#myImportModal_log">Import Details</button>-->
                    <a class="btn btn-default " href="<?php echo URL . 'importclass/fleet/fleet_log/fleetclass/fleetcombined/fleet_log_view/1'; ?>">Import Details</a>
                    <button type="button" class="btn btn-default pink-button" data-toggle="modal" 
                    <?php if ($priv > 1) {
                        ?>data-target="#myModal_log"<?php
                            } else {
                                ?>data-target="#my_Modal_alert"<?php }
                            ?>>Add Usage Log</button>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div class="table-responsive">
        <table id="data-table1" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th colspan="13" style=" border-radius: 5px 5px 0px 0px; ">Registration number: 
            <form action="<?php echo URL; ?>fleetclass/fleetcombined/fleet_log_view/1" method="post" role="form" >
                <select class="form-control input-sm" style="width:170px; float: left;"  name="RegNum" id="RegNum">
                    <option value="<?php echo $reg_no; ?>"<?php if ($reg_no) echo 'selected'; ?>>
                        <?php if ($reg_no == '') {
                            echo 'No Reg Num';
                        } else {
                            echo $reg_no;
                        } ?></option>
                        <?php
                    foreach ($RegNumLog as $key => $value) {
                        ?>
                        <option value="<?php echo $value['RegNum']; ?>"<?php if ($reg_no == $value['RegNum']) echo 'selected'; ?>>
    <?php echo $value['RegNum']; ?></option>
<?php } ?>
                </select>
                <input class="btn btn-default pink-button" style="height: 30px; margin-left: 5px;" type="submit" name="submit_reg_num"  value="CHOOSE REG NUM">   
            </form>
            </th>
            </tr> 
            <tr>
                <th colspan="13" >Office: <?php echo $office_location; ?> </th>
            </tr>
            <tr> 
                <th class="export-visible" >Date</th>
                <th class="export-visible" >Fuel quantity in Litres</th>
                <th class="export-visible" >Odometer Curr F. Reading</th>
                <th class="export-visible" >Odometer Prev F. Reading</th>
                <th class="export-visible" >Kilometers covered</th>
                <th class="export-visible" >Kilometers per litre</th>
                <th class="export-visible" >Fuel cost</th>
                <th class="export-visible" >Authorizing Person</th>
                <th class="export-visible" >Authorizing Signature</th>
                <th class="export-visible" >Rider</th>
                <th class="export-visible" >Comment</th>
                <th class="export-visible" ></th>
                <th class="export-visible" ></th>
            </tr>
            </thead>
            <tbody>
                <?php
                $sum_fuel_cost = 0;
                if (sizeof($datalog) != 0) {
                    $sum_k_cov = 0;
                    $sum_fuel_quant = 0;
                    $id_log = 0;
                    foreach ($datalog as $key => $value) {
                        ?>                    
                        <tr style="background-color: #FFF;">
                            <td><?php echo $edit_date = $value["Date"]; ?></td>
                            <td><?php echo $fuel_quant = $value["FuelQuant"]; ?></td>
                            <td><?php echo $current_fuel_red = $value["CurrentFuelRead"]; ?></td>
                            <td><?php echo $previous_fuel_read = $value["PreviousFuelRead"]; ?></td>
                            <td><?php echo $k_cov = $value["KilometerCov"]; ?></td>
                            <td><?php echo round($value["Kilometer_p_Liter"], 2); ?></td>
                            <td><?php echo $fuel_cost = $value["FuelCost"]; ?></td>
                            <td><?php echo $author_person = $value["AuthPerson"]; ?></td>
                            <td><?php echo $author_signe = $value["AuthSigne"]; ?></td>
                            <td><?php echo $rider_edit = $value["Rider"]; ?></td>
                            <td><?php echo $comment_edit = $value["Comment"]; ?></td>
                            <td>
                                <input type="hidden" name="edit_RegNum_log" value="<?php echo $value["ID"]; ?>"/>
                                <input type="hidden" name="edit_date_log" value="<?php echo $edit_date; ?>"/>
                                <input type="hidden" name="edit_fuel_quant_log" value="<?php echo $fuel_quant; ?>"/>
                                <input type="hidden" name="edit_cur_fuel_read_log" value="<?php echo $current_fuel_red; ?>"/>
                                <input type="hidden" name="edit_prev_fuel_read_log" value="<?php echo $previous_fuel_read; ?>"/>
                                <input type="hidden" name="edit_fuel_cost_log" value="<?php echo $fuel_cost; ?>"/>
                                <input type="hidden" name="edit_auth_person_log" value="<?php echo $author_person; ?>"/>
                                <input type="hidden" name="edit_auth_signe_log" value="<?php echo $author_signe; ?>"/>
                                <input type="hidden" name="edit_rider_log" value="<?php echo $rider_edit; ?>"/>
                                <input type="hidden" name="edit_comment_log" value="<?php echo $comment_edit; ?>"/>
                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" <?php if ($priv > 2) { ?>
                                            data-target="#myModal_log_edit" onclick="loaddata(<?php echo $id_log; ?>);"<?php } else { ?>
                                            data-target="#my_Modal_alert"<?php } ?>>
                                    Edit</button>
                            </td> 
                            <td>
                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" <?php if ($priv > 3) { ?>
                                            data-target="#myModal_log_delete" onclick="loaddata_delete(<?php echo $id_log; ?>);"<?php } else { ?>
                                            data-target="#my_Modal_alert"<?php } ?>>
                                    Delete</button>
                            </td>
                        </tr>
                        <?php
                        $id_log++;
                        $sum_fuel_quant += $fuel_quant;
                        $sum_k_cov += $k_cov;
                        $sum_fuel_cost += $fuel_cost;
                    }
                    ?>


                    <tr>
                        <th style=" border-radius: 0px 0px 0px 0px; "></th>
                        <th ></th>
                        <th >Av Km/week</th>
                        <th ></th>
                        <th ></th>
                        <th ></th>
                        <th ></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr> 
                        <th>Total Ltrs:</th>
                        <th><?php echo $sum_fuel_quant; ?></th>
                        <th><?php
                            if ($sum_fuel_quant == 0) {
                                echo"";
                            } else {
                                echo round(($sum_k_cov / $sum_fuel_quant), 2);
                            }
                            ?></th>
                        <th>Total Kms:</th>
                        <th><?php echo $sum_k_cov; ?></th>
                        <th>Total FuelC:</th>
                        <th><?php echo $sum_fuel_cost; ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tbody>               
    <?php
}
?>
        </table>
    </div>  

    <!--###################################### Maintenance Table################################-->
    <hr>
    <div id="data-table-manger">
        <div class="clearfix">
            <h3 class="pull-left">Maintenance Cost (Oil, Repairs, Cleaning etc)</h3>
            <div class="btn-group pull-right">
                <div class="btn-group pad-top-15">
                    <a class="btn btn-default " href="<?php echo URL . 'importclass/fleet/fleet_maintenance/fleetclass/fleetcombined/fleet_log_view/1'; ?>">Import Details</a>
                    <!--<button type="button" style='margin-right:10px;' class="btn btn-default pink-button" data-toggle="modal" data-target="#myImportModal_maint">Import Details</button>-->
                    <button type="button" class="btn btn-default pink-button" data-toggle="modal" 
                            <?php if ($priv > 1) {
                                ?>data-target="#myModal_maint"<?php
                            } else {
                                ?>data-target="#my_Modal_alert"<?php }
                            ?>>Add Maintenance Cost</button>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="table-responsive">
        <table id="data-table2" class="table table-striped table-hover">
            <thead>             
                <tr style=""> 
                    <th class="export-visible" style="border-radius: 5px 0px 0px 0px;">Date</th>
                    <th class="export-visible">Category</th>
                    <th class="export-visible">Description</th>
                    <th class="export-visible">Total cost</th>
                    <th class="export-visible">Outsource Material</th>
                    <th class="export-visible">Outsource Material (T. Cost)</th>
                    <th class="export-visible">Outsource Labour (T. Cost)</th>
                    <th class="export-visible">Description of outsource work performed</th>
                    <th class="export-visible">Odometer Reading</th>
                    <th class="export-visible"></th>
                    <th class="export-visible" style="border-radius: 0px 5px 0px 0px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (sizeof($dataMaint) != 0) {
                    $idmaint = 0;
                    $sum_total_cost = 0;
                    $sum_out_mater_t_cost = 0;
                    $sum_out_labour = 0;
                    foreach ($dataMaint as $key => $value) {
                        ?>
                        <tr style="background-color: #FFF;">
                            <td><?php echo $edit_date_maint = $value["Date"]; ?></td>
                            <td><?php echo $edit_category = $value["Category"]; ?></td>
                            <td><?php echo $edit_description = $value["Description"]; ?></td>
                            <td><?php echo $total_cost = $value["TotalCost"]; ?></td>
                            <td><?php echo $edit_out_mater_ind = $value["OutMater_indicate"]; ?></td>
                            <td><?php echo $out_mater_t_cost = $value["OutMater_TCost"]; ?></td>
                            <td><?php echo $out_labour = $value["OutLabour"]; ?></td>
                            <td><?php echo $edit_out_work_performed = $value["Out_work_performed"]; ?></td>
                            <td><?php echo $edit_odometer = $value["OdometerReading"]; ?></td>
                            <td>
                                <input type="hidden" name="edit_RegNum_maint" value="<?php echo $value["ID"]; ?>"/>
                                <input type="hidden" name="edit_date_maint" value="<?php echo $edit_date_maint; ?>"/>
                                <input type="hidden" name="edit_outsource_materials_maint" value="<?php echo $edit_out_mater_ind; ?>"/>
                                <input type="hidden" name="edit_category_maint" value="<?php echo $edit_category; ?>"/>
                                <input type="hidden" name="edit_description_maint" value="<?php echo $edit_description; ?>"/>
                                <input type="hidden" name="edit_total_cost_maint" value="<?php echo $total_cost; ?>"/>
                                <input type="hidden" name="edit_out_source_materials_cost_maint" value="<?php echo $out_mater_t_cost; ?>"/>
                                <input type="hidden" name="edit_out_source_labour_cost_maint" value="<?php echo $out_labour; ?>"/>
                                <input type="hidden" name="edit_odometer_reading_maint" value="<?php echo $edit_out_work_performed; ?>"/>
                                <input type="hidden" name="edit_description__work_perf_maint" value="<?php echo $edit_odometer; ?>"/>
                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" <?php if ($priv > 2) { ?>
                                            data-target="#myModal_maint_edit" onclick="loaddata_maint(<?php echo $idmaint; ?>);"<?php } else { ?>
                                            data-target="#my_Modal_alert"<?php } ?>>
                                    Edit</button>
                            </td> 
                            <td>
                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" <?php if ($priv > 3) { ?>
                                            data-target="#myModal_maint_delete" onclick="loaddata_delete_maint(<?php echo $idmaint; ?>);"<?php } else { ?>
                                            data-target="#my_Modal_alert"<?php } ?>>
                                    Delete</button>
                            </td> 
                        </tr>
                        <?php
                        $idmaint++;
                        $sum_total_cost += $total_cost;
                        $sum_out_mater_t_cost += $out_mater_t_cost;
                        $sum_out_labour += $out_labour;
                    }
                    ?>   
                    <tr> 
                        <th ></th>
                        <th >Total Cost:</th>
                        <th ><?php echo $sum_total_cost; ?></th>
                        <th >Total Material:</th>
                        <th ><?php echo $sum_out_mater_t_cost; ?></th>
                        <th ><?php echo $sum_out_labour; ?></th>
                        <th >T.Maintenance Cost</th>
                        <th><?php echo $sum_out_all = $sum_total_cost + $sum_out_mater_t_cost + $sum_out_labour; ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr> 
               </tbody> 
    <?php
} else {
    $sum_out_all = 0;    
}
?> 
        </table>
    </div>
    <!--################################### Cumulative Expenses  #####################################-->
    <hr>
    <div id="data-table-manger">

        <div class="clearfix">
            <h3 class="pull-left">Cumulative Expenses</h3>            
        </div>
        <hr>
    </div>
    <div class="table-responsive">
        <table id="data-table3" class="table table-striped table-hover">
            <thead>
                <tr style=""> 
                    <th class="export-visible" style="background-color: #ffffff; border-bottom: 1px solid #000000; border-radius: 5px 0px;"></th>
                    <th class="export-visible" style="background-color: #ffffff; border-bottom: 1px solid #000000;">This Week Total Cost</th>                
                    <th class="export-visible" style="background-color: #ffffff; border-bottom: 1px solid #000000;"></th>
                    <th class="export-visible" style="background-color: #ffffff; border-bottom: 1px solid #000000;">Previous week <br>Cumulative Total Cost</th>
                    <th class="export-visible" style="background-color: #ffffff; border-bottom: 1px solid #000000;"></th>
                    <th class="export-visible" style="background-color: #ffffff; border-bottom: 1px solid #000000;">Cumulative Total<br> as of Date</th>
                    <th class="export-visible" style="background-color: #ffffff; border-bottom: 1px solid #000000; border-radius: 0px 5px;"></th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ((sizeof($dataMaint) != 0)||(sizeof($datalog) != 0)) {
            $sum_cum_fuel_cost = 0;
            if (sizeof($datalogtotal) != 0) {
                foreach ($datalogtotal as $key => $value) {
                    $fuel_cost = $value["FuelCost"];
                    $sum_cum_fuel_cost += $fuel_cost;
                }
            }

            $sum_cum_total_cost = 0;
            $sum_cum_out_mater_t_cost = 0;
            $sum_cum_out_labour = 0;
            if (sizeof($dataMaintTotal) != 0) {
                foreach ($dataMaintTotal as $key => $value) {
                    $total_cost = $value["TotalCost"];
                    $out_mater_t_cost = $value["OutMater_TCost"];
                    $out_labour = $value["OutLabour"];
                    $sum_cum_total_cost += $total_cost;
                    $sum_cum_out_mater_t_cost += $out_mater_t_cost;
                    $sum_cum_out_labour += $out_labour;
                }
            }
            $sum_cum_out_all = $sum_cum_total_cost + $sum_cum_out_mater_t_cost + $sum_cum_out_labour;
            ?>
            
                <tr style="background-color: #ffffff;"> 
                    <td>Total Fuel cost</td>
                    <td><?php echo $sum_fuel_cost; ?></td>
                    <td></td>
                    <td><?php echo $sum_cum_fuel_cost - $sum_fuel_cost; ?></td>
                    <td></td>
                    <td><?php echo $sum_cum_fuel_cost; ?></td>
                    <td></td>
                </tr>
                <tr style="background-color: #ffffff;"> 
                    <td>Total Maintenance Cost</td>
                    <td><?php echo $sum_out_all; ?></td>
                    <td></td>
                    <td><?php echo $sum_cum_out_all - $sum_out_all; ?></td>
                    <td></td>
                    <td><?php echo $sum_cum_out_all; ?></td>
                    <td></td>
                </tr>
                <tr style="background-color: #ffffff;"> 
                    <td style="border-bottom: 1px solid #000000;">Total cost</td>
                    <td style="border-bottom: 1px solid #000000;"><?php echo $sum_fuel_cost + $sum_out_all; ?></td>
                    <td style="border-bottom: 1px solid #000000;"></td>
                    <td style="border-bottom: 1px solid #000000;"><?php echo ($sum_cum_fuel_cost - $sum_fuel_cost) + ($sum_cum_out_all - $sum_out_all); ?></td>
                    <td style="border-bottom: 1px solid #000000;"></td>
                    <td style="border-bottom: 1px solid #000000;"><?php echo $sum_cum_fuel_cost + $sum_cum_out_all; ?></td>
                    <td style="border-bottom: 1px solid #000000;"></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ########################################### Modal Usage Log Add #####################################################  -->
<div class="modal fade" id="myModal_log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Usage Log</h4>
            </div>
            <form action="<?php echo URL; ?>fleetclass/fleetcombined/fleet_log/1" method="post" role="form" >
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">                         

                            <div class="form-group">
                                <label>Reg Number</label><br>
                                <select id="reg_no2" name="RegNum" class="form-control input-sm" required >
                                    <option value=''>No Reg Num</option>
<?php foreach ($RegNumPopup as $key => $value) { ?>
                                        <option value="<?php echo $value['reg_no']; ?>"><?php echo $value['reg_no']; ?></option><?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date</label><br>
                                <input type="text" id="date" name="date" class="form-control input-sm datepicker" required/>
                            </div>
                            <div class="form-group">
                                <label>Fuel quantity in Litres</label><br>
                                <input type="text" id="fuel_quant" name="fuel_quant" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="fuel_quantSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Odometer Curr F. reading</label><br>
                                <input type="text" id="cur_fuel_read" name="cur_fuel_read" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="cur_fuel_readSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Odometer Prev F. reading</label><br>
                                <input type="text" id="prev_fuel_read" name="prev_fuel_read" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="prev_fuel_readSpan"></span>                                
                            </div>
                            <div class="form-group">
                                <label>Fuel cost</label><br>
                                <input type="text" id="fuel_cost" name="fuel_cost" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="fuel_costSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Authorizing Person</label><br>
                                <input type="text" id="auth_person" name="auth_person" class="form-control input-sm"/><span id=""></span>
                            </div>                            
                            <div class="form-group">
                                <label>Authorizing Signature</label><br>
                                <input type="text" id="auth_signe" name="auth_signe" class="form-control input-sm"/><span id=""></span>
                            </div> 
                            <div class="form-group">
                                <label>Rider</label><br>
                                <input type="text" id="rider" name="rider" class="form-control input-sm"/><span id=""></span>
                            </div>
                            <div class="form-group">
                                <label>Comment</label><br>
                                <textarea name="comment"></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add" id="add_usage_log">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ########################################### Modal Maintenance Cost Add #####################################################  -->
<div class="modal fade" id="myModal_maint" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Maintenance Cost</h4>
            </div>
            <form action="<?php echo URL; ?>fleetclass/fleetcombined/fleet_maintenance/2" method="post" role="form" >
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Reg Number</label><br>
                                <select id="reg_no2" name="RegNum" class="form-control input-sm" required >
                                    <option value=''>No Reg Num</option>
<?php foreach ($RegNumPopup as $key => $value) { ?>
                                        <option value="<?php echo $value['reg_no']; ?>"><?php echo $value['reg_no']; ?></option><?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Outsource Materials (Indicate the material)</label><br>
                                <textarea name="outsource_materials"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Date</label><br>
                                <input type="text" id="date1" name="date" class="form-control input-sm datepicker" required/>
                            </div>
                            <div class="form-group">
                                <label>Category</label><br>                                
                                <select id="category" name="category" class="form-control input-sm" required >
                                    <option value=''>No Category</option>                                    
                                    <option value='Cleaning'>Cleaning</option>
                                    <option value='General servicing'>General servicing</option>
                                    <option value='Oil/ Lubricant'>Oil/ Lubricant</option>
                                    <option value='Repairs'>Repairs</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Description</label><br>
                                <textarea name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Total Cost</label><br>
                                <input type="text" id="total_cost" name="total_cost" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="total_costSpan"></span>
                            </div>                            
                            <div class="form-group">
                                <label>Outsource Materials(Total Cost)</label><br>
                                <input type="text" id="out_source_materials_cost" name="out_source_materials_cost" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="out_source_materials_costSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Outsource Labour(Total Cost)</label><br>
                                <input type="text" id="out_source_labour_cost" name="out_source_labour_cost" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="out_source_labour_costSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Odometer Reading</label><br>
                                <input type="text" id="odometer_reading" name="odometer_reading" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="odometer_readingSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Description of Outsource Work Performed</label><br>
                                <textarea name="description__work_perf"></textarea>
                            </div>                             


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add" id="add_maintenance_cost">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> 

<!-- ########################################### Modal Usage Log Edit #####################################################  -->
<div class="modal fade" id="myModal_log_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Usage Log</h4>
            </div>
            <form action="<?php echo URL; ?>fleetclass/fleetcombined/fleet_log/1" method="post" role="form" >
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">                         
                            <input type="hidden" id="up_RegNum_log" name="edit_RegNum" value=""/>                
                            <div class="form-group">
                                <label>Reg Number</label><br>
                                <select id="up_RegNum_log" name="RegNum" class="form-control input-sm" required >
                                    <option value='<?php echo $reg_no; ?>'> <?php echo $reg_no; ?> </option>
<?php foreach ($RegNumPopup as $key => $value) { ?>
                                        <option value="<?php echo $value['reg_no']; ?>"><?php echo $value['reg_no']; ?></option><?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date</label><br>
                                <input type="text" id="up_date_log" name="date" value="" class="form-control input-sm datepicker" required/>
                            </div>
                            <div class="form-group">
                                <label>Fuel quantity in Litres</label><br>
                                <input type="text" id="up_fuel_quant_log" name="fuel_quant" value="" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="up_fuel_quant_logSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Odometer Curr F. reading</label><br>
                                <input type="text" id="up_cur_fuel_read_log" name="cur_fuel_read" value="" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="up_cur_fuel_read_logSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Odometer Prev F. reading</label><br>
                                <input type="text" id="up_prev_fuel_read_log" name="prev_fuel_read" value="" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="up_prev_fuel_read_logSpan"></span>
                            </div>                           
                            <div class="form-group">
                                <label>Fuel cost</label><br>
                                <input type="text" id="up_fuel_cost_log" name="fuel_cost" value="" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="up_fuel_cost_logSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Authorizing Person</label><br>
                                <input type="text" id="up_auth_person_log" name="auth_person" value="" class="form-control input-sm"/><span id="up_auth_person_logspan"></span>
                            </div>                            
                            <div class="form-group">
                                <label>Authorizing Signature</label><br>
                                <input type="text" id="up_auth_signe_log" name="auth_signe" value="" class="form-control input-sm"/><span id="up_auth_signe_logSpan"></span>
                            </div> 
                            <div class="form-group">
                                <label>Rider</label><br>
                                <input type="text" id="up_rider_log" name="rider" value="" class="form-control input-sm"/><span id="up_rider_logSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Comment</label><br>
                                <textarea id="up_comment_log" name="comment"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="edit" id="edit_usage_log">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ########################################### Modal Maintenance Cost Edit #####################################################  -->
<div class="modal fade" id="myModal_maint_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Maintenance Cost</h4>
            </div>
            <form action="<?php echo URL; ?>fleetclass/fleetcombined/fleet_maintenance/2" method="post" role="form" >
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="up_RegNum_maint" name="edit_RegNum" value=""/>             
                            <div class="form-group">
                                <label>Reg Number</label><br>
                                <select id="" name="RegNum" class="form-control input-sm" required >
                                    <option value='<?php echo $reg_no; ?>'> <?php echo $reg_no; ?> </option>
<?php foreach ($RegNumPopup as $key => $value) { ?>
                                        <option value="<?php echo $value['reg_no']; ?>"><?php echo $value['reg_no']; ?></option><?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Outsource Materials (Indicate the material)</label><br>
                                <textarea id="up_outsource_materials_maint" name="outsource_materials"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Date</label><br>
                                <input type="text" id="up_date_maint" name="date" value="" class="form-control input-sm datepicker" required/>
                            </div>
                            <div class="form-group">
                                <label>Category</label><br>                                
                                <select id="up_category_maint" name="category" class="form-control input-sm" required >
                                    <option value=''> </option>                                    
                                    <option value='Cleaning'>Cleaning</option>
                                    <option value='General servicing'>General servicing</option>
                                    <option value='Oil/ Lubricant'>Oil/ Lubricant</option>
                                    <option value='Repairs'>Repairs</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Description</label><br>
                                <textarea id="up_description_maint" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Total Cost</label><br>
                                <input type="text" id="up_total_cost_maint" name="total_cost" value ="" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="up_total_cost_maintSpan"></span>
                            </div>                            
                            <div class="form-group">
                                <label>Outsource Materials(Total Cost)</label><br>
                                <input type="text" id="up_out_source_materials_cost_maint" name="out_source_materials_cost" value="" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="up_out_source_materials_cost_maintSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Outsource Labour(Total Cost)</label><br>
                                <input type="text" id="up_out_source_labour_cost_maint" name="out_source_labour_cost" value="" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="up_out_source_labour_cost_maintSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Odometer Reading</label><br>
                                <input type="text" id="up_odometer_reading_maint" name="odometer_reading" value="" class="form-control input-sm" onKeyUp="isNumeric(this.id);" required/><span id="up_odometer_reading_maintSpan"></span>
                            </div>
                            <div class="form-group">
                                <label>Description of Outsource Work Performed</label><br>
                                <textarea id="up_description__work_perf_maint" name="description__work_perf"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="edit" id="edit_maintenance_cost">Save</button>
                </div>
            </form>
        </div>
    </div>
</div> 

<!-- ########################################### Modal Usage Log Delete #####################################################  -->
<div class="modal fade" id="myModal_log_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete Usage Log Record</h4>
            </div>
            <form action="<?php echo URL; ?>fleetclass/fleetcombined/fleet_log/<?php echo $reg_no; ?>" method="post" role="form" >
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">                         
                            <input type="hidden" id="delete_RegNum_log" name="Delete_RegNum" value="<?php echo $reg_no; ?>"/>          
                            <input type="hidden" id="delete_RegNum_log" name="RegNum" value="<?php echo $reg_no; ?>"/>          
                            <center>Are You Sure you want to delete <b><?php echo $reg_no; ?></b> Record Added on
                                <input style="background-color: #F3F5F2; border: none; font-weight: bold" type="text" id="delete_date_log" name="delete_date_log" value="" readonly/></center>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="delete" id="delete_usage_log">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ########################################### Modal Maintenance Delete #####################################################  -->
<div class="modal fade" id="myModal_maint_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete Maintenance Cost Record</h4>
            </div>
            <form action="<?php echo URL; ?>fleetclass/fleetcombined/fleet_maintenance/<?php echo $reg_no; ?>" method="post" role="form" >
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">                         
                            <input type="hidden" id="delete_RegNum_maint" name="Delete_RegNum" value="<?php echo $reg_no; ?>"/>          
                            <input type="hidden" id="delete_RegNum_maint" name="RegNum" value="<?php echo $reg_no; ?>"/>          
                            <center>Are You Sure you want to delete <b><?php echo $reg_no; ?></b> Record Added on
                                <input style="background-color: #F3F5F2; border: none; font-weight: bold" type="text" id="delete_date_maint" name="delete" value="" readonly/></center>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="delete_usage_maint" id="delete_usage_log">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--############################################# Modal Alert ################################################-->
<div class="modal fade" id="my_Modal_alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Sorry! You are not allowed to perform this action</h4>
            </div>            
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="myImportModal_log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Import  Details</h4>
            </div>
            <form  action="<?php echo URL; ?>fleetclass/import/<?php echo 'fleet_log/'; ?>" enctype="multipart/form-data" data-async data-target="myModal" method="post" role="form" id="modal-form">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                Select File to upload:
                                <input type="file" name="file" id="file" />
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Upload" name="update-verification"/>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button  type="submit" class="btn btn-primary" name="add-general-data" id="add-general-data">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

                                    function loaddata(idlog) {
                                        document.getElementById("up_RegNum_log").value = document.getElementsByName("edit_RegNum_log")[idlog].value;
                                        document.getElementById("up_date_log").value = document.getElementsByName("edit_date_log")[idlog].value;
                                        document.getElementById("up_fuel_quant_log").value = document.getElementsByName("edit_fuel_quant_log")[idlog].value;
                                        document.getElementById("up_cur_fuel_read_log").value = document.getElementsByName("edit_cur_fuel_read_log")[idlog].value;
                                        document.getElementById("up_prev_fuel_read_log").value = document.getElementsByName("edit_prev_fuel_read_log")[idlog].value;
                                        document.getElementById("up_fuel_cost_log").value = document.getElementsByName("edit_fuel_cost_log")[idlog].value;
                                        document.getElementById("up_auth_person_log").value = document.getElementsByName("edit_auth_person_log")[idlog].value;
                                        document.getElementById("up_auth_signe_log").value = document.getElementsByName("edit_auth_signe_log")[idlog].value;
                                        document.getElementById("up_rider_log").value = document.getElementsByName("edit_rider_log")[idlog].value;
                                        document.getElementById("up_comment_log").value = document.getElementsByName("edit_comment_log")[idlog].value;
                                    }
                                    function loaddata_maint(idmaint) {
                                        document.getElementById("up_RegNum_maint").value = document.getElementsByName("edit_RegNum_maint")[idmaint].value;
                                        document.getElementById("up_date_maint").value = document.getElementsByName("edit_date_maint")[idmaint].value;
                                        document.getElementById("up_outsource_materials_maint").value = document.getElementsByName("edit_outsource_materials_maint")[idmaint].value;
                                        document.getElementById("up_category_maint").value = document.getElementsByName("edit_category_maint")[idmaint].value;
                                        document.getElementById("up_description_maint").value = document.getElementsByName("edit_description_maint")[idmaint].value;
                                        document.getElementById("up_total_cost_maint").value = document.getElementsByName("edit_total_cost_maint")[idmaint].value;
                                        document.getElementById("up_out_source_materials_cost_maint").value = document.getElementsByName("edit_out_source_materials_cost_maint")[idmaint].value;
                                        document.getElementById("up_out_source_labour_cost_maint").value = document.getElementsByName("edit_out_source_labour_cost_maint")[idmaint].value;
                                        document.getElementById("up_odometer_reading_maint").value = document.getElementsByName("edit_odometer_reading_maint")[idmaint].value;
                                        document.getElementById("up_description__work_perf_maint").value = document.getElementsByName("edit_description__work_perf_maint")[idmaint].value;
                                    }
                                    function loaddata_delete(idlog) {
                                        document.getElementById("delete_RegNum_log").value = document.getElementsByName("edit_RegNum_log")[idlog].value;
                                        document.getElementById("delete_date_log").value = document.getElementsByName("edit_date_log")[idlog].value;
                                    }
                                    function loaddata_delete_maint(idmaint) {
                                        document.getElementById("delete_RegNum_maint").value = document.getElementsByName("edit_RegNum_maint")[idmaint].value;
                                        document.getElementById("delete_date_maint").value = document.getElementsByName("edit_date_maint")[idmaint].value;
                                    }
                                    $('#myModal_log').on('show.bs.modal', function(e) {

                                        autoColumn(4, '#myModal_log .modal-body .row', 'div', 'col-md-3');
                                        $('#message').html('');

                                    });
                                    $('#myModal_log_edit').on('show.bs.modal', function(e) {

                                        autoColumn(4, '#myModal_log_edit .modal-body .row', 'div', 'col-md-3');
                                        $('#message').html('');

                                    });
                                    $('#myModal_maint').on('show.bs.modal', function(e) {

                                        autoColumn(4, '#myModal_maint .modal-body .row', 'div', 'col-md-3');
                                        $('#message').html('');

                                    });
                                    $('#myModal_maint_edit').on('show.bs.modal', function(e) {

                                        autoColumn(4, '#myModal_maint_edit .modal-body .row', 'div', 'col-md-3');
                                        $('#message').html('');

                                    });

                                    $('form').validate();

</script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#data-table1').DataTable({
            bFilter: false,
            dom: 'T<"clear">lfrtip',
            tableTools: {
                sSwfPath: "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf",
                aButtons: [
                    {
                        sExtends: "xls",
                        sButtonText: "Export CSV",
                        mColumns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                ]
            },
             bInfo: false, bPaginate: false, bSort: false
        });

        var table = $('#data-table2').DataTable({
            bFilter: false,
            dom: 'T<"clear">lfrtip',
            tableTools: {
                sSwfPath: "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf",
                aButtons: [
                    {
                        sExtends: "xls",
                        sButtonText: "Export CSV",
                        mColumns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                ]
            },
             bInfo: false, bPaginate: false, bSort: false
        });

        var table = $('#data-table3').DataTable({
            bFilter: false,
            dom: 'T<"clear">lfrtip',
            tableTools: {
                sSwfPath: "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf",
                aButtons: [
                    {
                        sExtends: "xls",
                        sButtonText: "Export CSV"
                    }
                ]
            },
             bInfo: false, bPaginate: false, bSort: false
        });

    });
</script>