<?php
isset($tabActive) ? $tabActive = $tabActive : $tabActive = 'tab1';
?>
<style type="text/css">
    #data-table_wrapper .dataTables_scroll .dataTables_scrollBody {
        overflow-x: -moz-hidden-scrollable;
    }
</style>
<div class="col-md-10">
    <?php if (isset($message)) { ?>
        <div class="alert alert-info text-center" role="alert" data-dismiss="alert">
            <?php
            echo $message;
            ?>
            <span style="float:right" aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        </div>
    <?php } ?>
    <h3 class="text-center">Plan A Verification</h3>

    <ul class="nav nav-pills">
        <li role="presentation" <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">Create Verification</a></li>
        <li role="presentation" <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a id="secondTab" href="#tab2" data-toggle="tab">Setup Verification Details</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1" >

            <?php
            if (!isset($_POST['nextPhase'])) {
                if (isset($lsmTerritories) && !empty($lsmTerritories)) {
                    ?>

                    <form action="<?php echo URL . 'expansion/siteVerification/'; ?>" method="POST" style='margin-top:5%;'>
                        <table id="data-table2" class="table table-striped table-hover" style='width:60%;'>
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php
                                    foreach ($lsmTerritories[$firstKey] as $key => $value) {

                                        if (!in_array($key, $arrayName = array('id', 'territory_id'))) {

                                            if ($key == "country" || $key == "Country") {
                                                continue;
                                            } else {
                                                echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                            }
                                        }
                                    }
                                    ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($lsmTerritories as $key => $value) {
                                    ?>
                                    <tr>
                                        <?php
                                        foreach ($value as $key => $value) {

                                            if (!in_array($key, $arrayName = array('id'))) {

                                                if ($key == "country" || $key == "Country") {
                                                    continue;
                                                } else if ($key == "territory_id") {
                                                    $territoryId = $value;

                                                    echo '<td ><input type="checkbox" style="border:0;margin:0;padding:0;align:left;" name="territoryId' . $i . '" value="' . $territoryId . '"/></td>';
                                                } else {
                                                    echo '<td >' . ucwords(str_replace('_', ' ', $value)) . '</td>';
                                                }
                                            }
                                        }
                                        ?>


                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>                  
                            </tbody>
                        </table>
                        <input type="submit" style='margin-left:30%;' name="nextPhase" class="btn btn-info" value="Next >>"/>
                    </form>
                <?php } else { ?>
                    <br/><br/><br/><br/>
                    <h4><b>No Lsm Territories Without Programs Found</b></h4>
                    <?php
                }
                ?>




            <?php } else { ?> 
                <div  id="myModal" tabindex="-1" role="dialog" style="margin-top:5%;">
                    <div>

                        <form  action="<?php echo URL; ?>expansion/sVerificationAdd/<?php echo $table; ?>"  method="post" role="form" id="modal-form">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                        foreach ($fields as $key => $value) {
                                            if ($value['Key'] == 'PRI') {
                                                continue;
                                            } elseif ($value['Key'] == 'MUL' && $value['Field'] == "country") {
                                                echo '
                                                                    <div class="form-group">';

                                                echo'<input type="hidden" name="' . $value['Field'] . '" value="' . $_SESSION['country'] . '"  class="form-control input-sm" >';
                                                echo '
                                                                    </div>';
                                            } elseif ($value['Key'] == 'MUL' && $value['Field'] != "full_name") {
                                                echo '
                                                                    <div class="form-group">
                                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                            <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                                foreach ($value['parents'] as $key => $value_) {
                                                    echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }
                                                echo '</select>
                                                                    </div>';
                                            } else if ($value['Key'] == 'MUL' && $value['Field'] == "full_name") {
                                                echo '
                                                                    <div class="form-group">
                                                                    <label>Field Officer\'s Name</label><br>
                                                                            <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select Field Officer\'s Name</option>';
                                                foreach ($value['parents'] as $key => $value_) {
                                                    echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }
                                                echo '</select>
                                                                    </div>';
                                            } else if ($value['Field'] == 'email') {
                                                echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                                                                </div>
                                                                        ';
                                            } else if (strpos($value['Field'], 'phone') !== false) {
                                                echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                                                </div>
                                                                        ';
                                            } else if (strpos($value['Field'], 'program') !== false) {
                                                echo '
                                                                <div class="form-group">
                                                                    <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                    <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" value="" required/>
                                                                            </div>
                                                                    ';
                                            } else if (strpos($value['Field'], 'contact') !== false) {
                                                echo '
                                                                    <div class="form-group">
                                                                        <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                        <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                                                </div>
                                                                        ';
                                            } else if (strpos($value['Field'], 'date') !== false) {
                                                echo '
                                                                        <div class="form-group">
                                                                            <label> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                            <input type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
                                                                        </div>
                                                                    ';
                                            } else if (strpos($value['Field'], 'verified_status') !== false) {
                                                continue;
                                            } else {
                                                echo '
                                                                        <div class="form-group">
                                                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                            <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                                        </div>
                                                                    ';
                                            }
                                        }
                                        echo '
                                                                <div class="form-group">
                                                                            <textarea style="display:none;"id="territories" name="territories" class="form-control input-sm">' . $territoryArray . '</textarea>
                                                                </div>
                                                                    ';
                                        ?>  
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button  type="submit" class="btn btn-primary" name="add-verification-data" id="add-verification-data">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div> 
            <?php } ?> 
        </div>
        <img src="<?php echo URL; ?>public/img/loading.gif" id="imgLoading" height="40px" style="position:absolute;top:50%;left:50%;margin:0 auto; visibility: visible"/>

        <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2" >
            <button type="button" id='official' data-toggle="modal" data-target="#myofficialsModal" style='display:none;'>View Officials</button>
            <button type="button" id='villagesBtn' data-toggle="modal" data-target="#myvillagesModal" style='display:none;'>View Villages</button>
            <button type="button" id='addVillage' data-toggle="modal" data-target="#addVillagemodal" style='display:none;'>Add Villages</button>

            <div class="table-responsive" style="margin-top:5%;">
                <?php if (!empty($data)) { ?>
                    <table style='table-layout:auto' id="data-table" class=" table table-bordered table-striped table-hover">
                        <thead>
                            <tr>

                                <th class="index">#</th>
                                <?php
                                foreach ($data[0] as $key => $value) {

                                    if (!in_array($key, $arrayName = array('id'))) {

                                        if ($key == "country" || $key == "Country") {
                                            continue;
                                        } else if ($key == "programId") {
                                            continue;
                                        } else {
                                            if (strlen($key) >= 15) {
                                                $key2 = substr($key, 0, 15);
                                                $key3 = substr($key, 15, strlen($key));
                                                $key4 = $key2 . '<br/>' . $key3;
                                                /// $key2+='...';
                                            } else {
                                                $key4 = $key;
                                            }
                                            echo '<th class="export-visible" title="' . ucwords(str_replace('_', ' ', $key)) . '" data-toggle="tooltip" data-placement="top" >';

                                            echo ucwords(str_replace('_', ' ', $key4));

                                            echo '</th>';
                                        }
                                    }
                                }
                                ?>
                                <th class="buttons">Villages</th>
                                <th class="buttons">Field Officers</th>
                                <th class="buttons "></th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>

                                <th class="index">#</th>
                                <?php
                                foreach ($data[0] as $key => $value) {

                                    if (!in_array($key, $arrayName = array('id'))) {

                                        if ($key == "country" || $key == "Country") {
                                            continue;
                                        } else if ($key == "programId") {

                                            continue;
                                        } else {

                                            echo '<th class="export-visible">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
                                        }
                                    }
                                }
                                ?>
                                <th class="buttons"></th>
                                <th class="buttons"></th>
                                <th class="buttons "></th>

                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($data as $key => $value) {
                                ?>
                                <tr>
                                    <td class="index" ></td>
                                    <?php
                                    foreach ($value as $key2 => $value2) {
                                        // echo "<pre>";var_dump($key);echo "</pre>";         

                                        if (!in_array($key2, $arrayName = array('id'))) {

                                            if ($key2 == "country" || $key2 == "Country") {
                                                continue;
                                            } else if ($key2 == "programId") {
                                                $programId = $value2;
                                                continue;
                                            } else {
                                                echo '<td class="export-visible text-center">' . $value2 . '</td>';
                                            }
                                        }
                                    }
                                    ?>
                                    <td class="buttons" ><a href="<?php echo URL . 'expansion/siteVerification/?addVillageFor=' . urlencode($programId) ?>"  class="btn btn-default btn-xs">Add</a>
                                        <a href="<?php echo URL . 'expansion/siteVerification/?viewVillageFor=' . urlencode($programId) ?>" class="btn btn-default btn-xs">View</a></td>

                                    <td class="buttons" ><a href="<?php echo URL . 'expansion/siteVerification/?addOfficersFor=' . urlencode($programId) ?>"  class="btn btn-default btn-xs">Add</a>
                                        <a href="<?php echo URL . 'expansion/siteVerification/?viewOfficersFor=' . urlencode($programId) ?>" class="btn btn-default btn-xs">View</a></td>

                                    <td class="buttons "><a href="<?php echo URL . 'expansion/sVerificationUpdate/site_verification/' . $value['id'] ?>" class="btn btn-default btn-xs">Edit</a>
                                        <a onclick="show_confirm('site_verification', '<?php echo $value['id']; ?>', '<?php echo $programId; ?>')" class="btn btn-default btn-xs">Delete</a></td>

                                </tr>
                                <?php
                            }
                            ?>                  
                        </tbody>
                    </table>

                <?php } else { ?>

                    <p><b>No Record Found</b></p>

                <?php } ?>

            </div>

        </div>
        <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3" >
            <?php
            if (isset($_GET['addOfficersFor'])) {
                ?>
                <div class='col-md-12'>
                    <span class="text-center" style="font-weight:bolder;">Click To Select Field Officers</span>
                    <div class="table-responsive" style="margin-top:5%;">


                        <table id="officialDataTable" class="table table-striped table-hover">
                            <thead>
                                <tr><td>Official</td></tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($fieldOfficers)) {
                                    foreach ($fieldOfficers as $key => $value) {

                                        $fieldOfficers = $value['full_name'];


                                        echo '<tr class="officials">';
                                        echo '<td class="officalName">' . $fieldOfficers . '</td>';
                                        echo "</tr>";
                                    }
                                } else {
                                    echo '<tr>';
                                    echo '<td>No Officials Selected</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                        <a id="button" class="btn btn-success">Save Officials</a>

                    </div>

                </div>
                <?php
            }
            ?>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo "Add F.O Details"; ?></h4>
                    </div>
                    <form  action="<?php echo URL; ?>expansion/sVerificationAdd/waterpoint_verification" data-async data-target="myModal2" method="post" role="form" id="modal-form">
                        <div class="modal-body">
                            <div id="message"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    foreach ($FOfields as $key => $value) {
                                        if ($value['Key'] == 'PRI') {
                                            continue;
                                        } elseif ($value['Key'] == 'MUL' && $value['Field'] == "country") {
                                            echo '
                                                                            <div class="form-group">
                                                                            <label>' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                                    <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                            foreach ($value['parents'] as $key => $value_) {

                                                if ($value_['id'] == $_SESSION['country']) {
                                                    echo'<option value="' . $value_['id'] . '" selected >' . $value_[$value['Field']] . '</option>';
                                                } else {
                                                    echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }
                                            }
                                            echo '</select>
                                                                </div>';
                                        } else if ($value['Key'] == 'MUL' && $value['Field'] == 'full_name') {
                                            echo '
                                                <div class="form-group">
                                                <label for="' . $value['Field'] . '" >Field Officer</label><br>
                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select Field Officer</option>';
                                            foreach ($value['parents'] as $key => $value_) {
                                                echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                            }
                                            echo '</select>
                                                </div>';
                                        } else if ($value['Key'] == 'MUL' && $value['Field'] == 'program') {
                                            echo '
                                                <div class="form-group">
                                                <label for="' . $value['Field'] . '" >' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                            foreach ($value['parents'] as $key => $value_) {
                                                if ($value_[$value['Field']] == $verificationId) {
                                                    echo'<option value="' . $value_['id'] . '" selected>' . $value_[$value['Field']] . '</option>';
                                                } else {
                                                    echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                                }
                                            }
                                            echo '</select>
                                                </div>';
                                        } else if ($value['Key'] == 'MUL') {
                                            echo '
                                                <div class="form-group">
                                                <label for="' . $value['Field'] . '" >' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                        <select id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required><option value="">Select ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</option>';
                                            foreach ($value['parents'] as $key => $value_) {
                                                echo'<option value="' . $value_['id'] . '" >' . $value_[$value['Field']] . '</option>';
                                            }
                                            echo '</select>
                                                </div>';
                                        } else if ($value['Field'] == 'email') {
                                            echo '
                                                <div class="form-group">
                                                    <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                    <input type="email" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" required/>
                                                            </div>
                                                    ';
                                        } else if (strpos($value['Field'], 'phone') !== false) {
                                            echo '
                                                <div class="form-group">
                                                    <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                    <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                            </div>
                                                    ';
                                        } else if (strpos($value['Field'], 'contact') !== false) {
                                            echo '
                                                <div class="form-group">
                                                    <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                                    <input type="text" id="' . $value['Field'] . '" name="' . $value['Field'] . '" class="form-control input-sm" onKeyUp="isNumeric(this.id);"/><span id="' . $value['Field'] . 'Span"></span>
                                                            </div>
                                                    ';
                                        } else if (strpos($value['Field'], 'date') !== false) {
                                            echo '
                                                    <div class="form-group">
                                                        <label for="' . $value['Field'] . '"> ' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                        <input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm datepicker"  />
                                                    </div>
                                                ';
                                        } else {
                                            echo '
                                                    <div class="form-group">
                                                        <label for="' . $value['Field'] . '">' . ucwords(str_replace('_', ' ', $value['Field'])) . '</label><br>
                                                        <input id="' . $value['Field'] . '" type="text" name="' . $value['Field'] . '" class="form-control input-sm"/>
                                                    </div>
                                                ';
                                        }
                                    }
                                    ?>  
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button  type="submit" class="btn btn-primary" name="add-FO-data" id="add-FO-data">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
        <!-- Modal -->
        <div class="modal fade" id="myofficialsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h3>List Of Officials </h3>
                    </div>

                    <div class="modal-body">
                        <table  id='viewDataTable' class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <td><b>Official</b></td>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($fieldOfficersArray)) {
                                    foreach ($fieldOfficersArray as $key => $value) {

                                        $fieldOfficers = $value['field_officer'];


                                        echo "<tr>";
                                        echo '<td class="officalName">' . $fieldOfficers . '</td>';
                                        echo "</tr>";
                                    }
                                } else {
                                    echo '<tr>';
                                    echo '<td>No Officials Selected</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <a id="removeButton" class="btn btn-success">Remove Selected</a>
                    </div>
                </div>
            </div>
        </div>  
        <!-- Modal -->
        <div class="modal fade" id="myvillagesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h3>List Of Villages </h3>
                    </div>

                    <div class="modal-body">
                        <?php if (isset($villageDetails) != null) { ?>
                            <table  id='viewvillageTable' class="table table-stripped table-hover">

                                <thead>

                                    <?php
                                    foreach ($villageDetails[0] as $key => $value) {



                                        if ($key == "country" || $key == "Country") {
                                            continue;
                                        } else if ($key == "id") {
                                            echo '<th >';
                                            echo '</th>';
                                        } else {

                                            echo '<th class="export-visible" title="' . ucwords(str_replace('_', ' ', $key)) . '" data-toggle="tooltip" data-placement="top" >';
                                            echo ucwords(str_replace('_', ' ', $key));
                                            echo '</th>';
                                        }
                                    }
                                    ?>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($villageDetails as $key => $value) {
                                        ?>
                                        <tr class="villageClass">

                                            <?php
                                            foreach ($value as $key2 => $value2) {
                                                // echo "<pre>";var_dump($key);echo "</pre>";         



                                                if ($key2 == "country" || $key2 == "Country") {
                                                    continue;
                                                } else if ($key2 == "id") {
                                                    echo '<td class="village  text-center" style="display:none;" >' . $value2 . '</td>';
                                                } else {
                                                    echo '<td class="export-visible text-center">' . $value2 . '</td>';
                                                }
                                            }
                                        }
                                        ?>
                                </tbody>

                            </table>
                            <a id="removeVillageButton" class="btn btn-success">Remove Selected</a>
                            <?php
                        } else {
                            echo 'No Villages Available For This Program';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div> 
        <div class="modal fade" id="addVillagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo "Add A Village"; ?></h4>
                    </div>
                    <form  action="<?php echo URL; ?>expansion/cauProgramsAdd/cau_programs/<?php echo $programId; ?>" data-async data-target="myModal2" method="post" role="form" id="modal-form">
                        <div class="modal-body">
                            <div id="message"></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label for="village" >Village</label><br>
                                        <select id="village" name="territory_id" class="form-control input-sm" required><option value="">Select Village</option>';
                                            <?php
                                            foreach ($villageArr as $key => $value) {

                                                echo'<option value="' . $value['id'] . '" >' . $value['admin_territory_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button  type="submit" class="btn btn-primary" name="add-FO-data" id="add-FO-data">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('#data-table2').DataTable();


<?php if (!empty($data)) { ?>
                                                    // Setup - add a text input to each footer cell
                                                    $('#data-table tfoot th').each(function() {
                                                        var title = $('#data-table thead th').eq($(this).index()).text();
                                                        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                                                    });


                                                    var visiblecols = [];
                                                    $('#data-table thead th').each(function(e) {
                                                        if ($(this).hasClass('export-visible')) {
                                                            visiblecols.push($(this).index());
                                                        }
                                                    });

                                                    var table = $('#data-table').DataTable({
                                                        scrollX: "100%",
                                                        scrollCollapse: false,
                                                        dom: 'T<"clear">lfrtip',
                                                        tableTools: {
                                                            sSwfPath: "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf",
                                                            aButtons: [
                                                                {
                                                                    sExtends: "xls",
                                                                    sButtonText: "Export All",
                                                                    mColumns: visiblecols
                                                                },
                                                                {
                                                                    sExtends: "xls",
                                                                    sButtonText: "Export Filtered",
                                                                    oSelectorOpts: {filter: 'applied', order: 'current'},
                                                                    mColumns: visiblecols
                                                                }
                                                            ]
                                                        },
                                                        columnDefs: [{
                                                                "searchable": false,
                                                                "orderable": true,
                                                                "targets": 0
                                                            }],
                                                        order: [[1, 'asc']]
                                                    });

                                                    // Apply the search
                                                    table.columns().eq(0).each(function(colIdx) {
                                                        $('input', table.column(colIdx).footer()).on('keyup change', function() {
                                                            table
                                                                    .column(colIdx)
                                                                    .search(this.value)
                                                                    .draw();
                                                        });
                                                    });

                                                    table.on('order.dt search.dt', function() {
                                                        table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function(cell, i) {
                                                            cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
<?php } ?>

                                                $('#officialDataTable').DataTable({
                                                    dom: 'T<"clear">lfrtip',
                                                    tableTools: {
                                                        "sRowSelect": "multi",
                                                        "aButtons": ["select_all", "select_none"]
                                                    }
                                                });

                                                $('#viewDataTable').DataTable({
                                                    dom: 'T<"clear">lfrtip',
                                                    tableTools: {
                                                        "sRowSelect": "multi",
                                                        "aButtons": ["select_all", "select_none"]
                                                    }
                                                });

                                                $('#viewvillageTable').DataTable({
                                                    dom: 'T<"clear">lfrtip',
                                                    tableTools: {
                                                        "sRowSelect": "multi",
                                                        "aButtons": ["select_all", "select_none"]
                                                    }
                                                });
                                            });

                                            $(function() {
                                                $('#myTab a:last').tab('show')
                                            })
                                            $('#myModal2').on('show.bs.modal', function(e) {

                                                autoColumn(3, '#myModal2 .modal-body .row', 'div', 'col-md-4');


                                            });
                                            window.onload = function() {
                                                // $("#mymodal").show();
                                                autoColumn(3, '#myModal .modal-body .row', 'div', 'col-md-4');
<?php
if (isset($_GET['viewOfficersFor'])) {
    echo "var btn=document.getElementById('official');"
    . "btn.click();"
    . "console.log('Button Called');";
}

if (isset($_GET['viewVillageFor'])) {

    echo "var btn=document.getElementById('villagesBtn');"
    . "btn.click();"
    . "console.log('Button Called');";
}

if (isset($_GET['addVillageFor'])) {

    echo "var btn=document.getElementById('addVillage');"
    . "btn.click();"
    . "console.log('Button Called');";
}
?>
                                            };


                                            function show_confirm(tables, deleteId, programId) {
                                                if (confirm("Are you sure you want to delete?")) {
                                                    location.replace('<?php echo URL ?>expansion/sVerificationDelete/' + tables + '/' + deleteId + '/' + programId);

                                                } else {
                                                    return false;
                                                }
                                            }

                                            //JavaScript post request like a form submit
                                            function post_to_url(path, params, method) {
                                                method = method || "post";

                                                var form = document.createElement("form");
                                                form.setAttribute("method", method);
                                                form.setAttribute("action", path);

                                                for (var key in params) {
                                                    if (params.hasOwnProperty(key)) {
                                                        var hiddenField = document.createElement("input");
                                                        hiddenField.setAttribute("type", "hidden");
                                                        hiddenField.setAttribute("name", key);
                                                        hiddenField.setAttribute("value", params[key]);

                                                        form.appendChild(hiddenField);
                                                    }
                                                }

                                                document.body.appendChild(form);
                                                form.submit();
                                            }

                                            function fnGetSelected(oTableLocal) {

                                                var selected = $(oTableLocal + ' tr.DTTT_selected'),
                                                        Officials = [];

                                                $(selected).each(function() {
                                                    Officials.push($(this).find('.officalName').text());
                                                });

                                                console.log(Officials);
<?php
if (isset($_GET['addOfficersFor'])) {
    $program = $_GET['addOfficersFor'];
} else {
    $program = 'none';
}
?>
                                                if (Officials.length > 0) {
                                                    post_to_url("<?php echo URL . 'expansion/verificationOfficialsAdd/' . $program; ?>", {officialsArray: Officials});
                                                }
                                                ;

                                            }
                                            function fnRemoveSelected(oTableLocal) {

                                                var selected = $(oTableLocal + ' tr.DTTT_selected'),
                                                        Officials = [];

                                                $(selected).each(function() {
                                                    Officials.push($(this).find('.officalName').text());
                                                });

                                                console.log(Officials);
<?php
if (isset($_GET['viewOfficersFor'])) {
    $program = $_GET['viewOfficersFor'];
} else {
    $program = 'none';
}
?>
                                                if (Officials.length > 0) {
                                                    post_to_url("<?php echo URL . 'expansion/verificationOfficialsDelete/' . $program; ?>", {officialsArray: Officials});
                                                }
                                                ;

                                            }
                                            function fnRemoveSelected2(oTableLocal) {

                                                var selected = $(oTableLocal + ' tr.DTTT_selected'),
                                                        villageClass = [];

                                                $(selected).each(function() {
                                                    villageClass.push($(this).find('.village').text());
                                                });

                                                console.log(villageClass);
<?php
if (isset($_GET['viewVillageFor'])) {
    $program = $_GET['viewVillageFor'];
} else {
    $program = 'none';
}
?>
                                                if (villageClass.length > 0) {
                                                    post_to_url("<?php echo URL . 'expansion/villageCauDelete/' . $program; ?>", {villagesArray: villageClass});
                                                }
                                                ;

                                            }


                                            $('body').on('click', '#button', function() {

                                                fnGetSelected('#officialDataTable');

                                            });

                                            $('body').on('click', '#removeButton', function() {
                                                if (confirm("Are you sure you want to delete?")) {
                                                    fnRemoveSelected('#viewDataTable');
                                                } else {
                                                    return false;
                                                }
                                            });

                                            $('body').on('click', '#removeVillageButton', function() {
                                                if (confirm("Are you sure you want to delete?")) {
                                                    fnRemoveSelected2('#viewvillageTable');
                                                } else {
                                                    return false;
                                                }
                                            });

        </script>
