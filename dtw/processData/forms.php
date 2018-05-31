<html>
  <head>
    <title>View Master Trainers</title>
    <?php
    include "includes/meta-link-script.php";
    include "../includes/config.php";
    ?>

    <?php
    if (isset($_GET['deleteid'])) {
      // get id
      $deleteid = $_GET['deleteid'];
      // delete

      $sql = "DELETE FROM divisions WHERE id=:id";
      $result = mysql_query($query) or die(mysql_error());

      header("Location:divisionView.php?status=deleted");
    } //end delete
    // get divisions

    $query = "SELECT * FROM divisions";
    $result = mysql_query($query) or die(mysql_error());

    while ($row = mysql_fetch_assoc($result)) {
      $data[] = array(
          'id' => $row['id'],
          'district_id' => $row['district_id'],
          'division_id' => $row['division_id'],
          'dvision_name' => $row['dvision_name'],
          'county_id' => $row['county_id'],
          'wave_assigned' => $row['wave_assigned']
      );
    }
    ?>
  </head>

  <body>

    <?php include 'sideMenu.php'; ?>
    <div class="contentBody">
      <?php
      if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == 'deleted') {
          ?>
          <div class="updated">
            record deleted 
          </div>
          <?php
        }
      }
      ?>
      <div class="form-title">
        <h1>View Divisions</h1>
      </div>

      <form action="#">
        <td><font style="font-size: 15px;">Filter Division using any field:</font></td>
        <td><input type="text" name="search" value="" id="id_search" placeholder="Search" autofocus style="width: 300px"/></td>
        <a class="btn-custom-small" href="division.php">Create Division</a>
      </form>
      <div style="width:100%; height:450px; overflow:scroll;">
        <table width="100%" border="1" align="center" cellspacing="1" class="table-hover" summary="Employee Pay Sheet">
          <thead>
            <tr>
              <th>ID</th>
              <th>District ID</th>
              <th>Division ID</th>
              <th>Division Name</th>
              <th>County ID</th>
              <th>Wave <br/>Assigned</th>
              <th>Manage</th>
            </tr>
          </thead>
          <tbody>



            <?php
            $i = 1;
            foreach ($data as $key => $data) {
              ?>
              <tr>
                <td  align="center"><?php
                  echo $i;
                  $i++;
                  ?></td>

                <td align="center"><?php echo $data['district_id'] ?></td>
                <td align="center"><?php echo $data['division_id'] ?></td>
                <td><?php echo $data['dvision_name'] ?></td>
                <td align="center"><?php echo $data['county_id'] ?></td>
                <td align="center"><?php echo $data['wave_assigned'] ?></td>

                <td>
                  <div class="manage-header-links">
                    <li><a href="divisionEdit.php?id=<?php echo $data['id']; ?>"> Edit </a></li>
                    <li> <a href="?deleteid=<?php echo $data['id']; ?>">  Delete </a> </li>
                    <li> <a href=""> &nbsp;View </a> </li>
                  </div>
                </td>


              </tr>
              <?php
            } //end foreach
            ?>
        </table>
      </div>

      <!--filter includes-->
      <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
      <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
      <script type="text/javascript">
        $(function() {
          $('input#id_search').quicksearch('table tbody tr');
        });
      </script>
  </body>
</html>