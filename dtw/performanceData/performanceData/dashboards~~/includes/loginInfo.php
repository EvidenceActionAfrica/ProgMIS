<div style="float: right; width: 25%">
  <div align="center" style="margin: 0px auto; margin-top: -10px">
    <table style="font-family: TStar-Reg; color: #EF637D">
        <thead>
          <th align="left" style="padding-left:10px; font-size: 14px">

            <form method="get" action="" class="select-years-form" style="float: left">
              <select name ="change_years" class="year-select" onchange="this.form.submit()">
                <option value="choose" class="btn">Choose</option>
                <?php 
                  foreach ($ea_databases as $key => $value) {
                  ?> 
                      <option <?php if ($_SESSION['database']==$value) {echo "selected"; } ?> value="<?php echo $value?>" class="year-select-option"><?php echo $key; ?> </option>
                  <?php
                  }
                 ?>
              </select>
            </form>

            <b style="color: grey; float: left"> - DTW Kenya </b> <br/>
            <div class="vclear"></div>
            <?php echo $_SESSION['staff_name']; ?><br/>
            <?php echo $_SESSION['staff_role']; ?><br/>
            <a href="../../logout.php" align="left" style="font-size: 14px">Log Out</a>
          </th>
        </thead>
        </table>
  </div>
</div> 

