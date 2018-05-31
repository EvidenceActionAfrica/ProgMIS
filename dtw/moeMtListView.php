<html>
  <head>
    <title>View MOE MT</title>
    <?php
       include "includes/meta-link-script.php";
       include "includes/config.php";
    ?>

    <?php
    if (isset($_GET['deleteid'])) {
      // get id
      $deleteid = $_GET['deleteid'];
      // delete
      $query = "DELETE FROM moe_mt_list WHERE id='$deleteid'";

      $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());

      header("Location:moeMtListView.php?status=deleted");
    }

    // get data

    $query = "SELECT * FROM moe_mt_list";

    $result = mysql_query($query) or die("<h1>Could not get MOE list</h1><br/>" . mysql_error());

    while ($row = mysql_fetch_assoc($result)) {
      $data[] = array(
          'id' => $row['id'],
          'first_name' => $row['first_name'],
          'second_name' => $row['second_name'],
          'ministry' => $row['ministry'],
          'posting_station' => $row['posting_station'],
          'county' => $row['county'],
          'job_group' => $row['job_group'],
          'phone_number' => $row['phone_number'],
          'email' => $row['email']
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
        <h1>View MOE Master Trainers</h1>
      </div>
      <form action="#">
        <td><font style="font-size: 15px;">Filter Division using any field:</font></td>
        <td><input type="text" name="search" value="" id="id_search" placeholder="Search" autofocus style="width: 300px"/></td>
        <a class="btn-custom-small" href="moeMtList.php">Create MOE MT</a>
      </form>
      <div style="width:100%; height:450px; overflow:scroll;">

       <table width="100%" border="0" align="center" cellspacing="1" class="table-hover">
            <thead>
            <tr style="border-bottom: 1px solid #B4B5B0;">
              <th scope="col">ID</th>
              <th scope="col">First Name</th>
              <th scope="col">Second Name</th>
              <th scope="col">Ministry</th>
              <th scope="col">Posting Station</th>
              <!-- <th scope="col">county</th>
              <th scope="col">job_group</th>
              <th scope="col">phone_number</th>
              <th scope="col">email</th> -->
              <th scope="col">Manage</th>

            </tr>
          </thead>
          <tbody>



            <?php
            $i = 1;
            foreach ($data as $key => $data) {
              ?>
              <tr style="border-bottom: 1px solid #B4B5B0;">
                <td align="center"><?php
                  echo $i;
                  $i++;
                  ?></td>


                <td>

                  <?php echo $data['first_name'] ?>

                </td>

                <td>

                  <?php echo $data['second_name'] ?>

                </td>

                <td align="center">
                  <?php echo $data['ministry'] ?>
                </td>

                <td>

                  <?php echo $data['posting_station'] ?>

                </td>

                    <!-- <td>

                <?php echo $data['county'] ?>

                    </td>

                    <td>

                <?php echo $data['job_group'] ?>

                    </td>

                    <td>

                <?php echo $data['phone_number'] ?>

                    </td>

                    <td>

                <?php echo $data['email'] ?>

                    </td> -->



                <td align="center">
                  <div class="manage-header-links">
                    <li><a href="moeMtListEdit.php?id=<?php echo $data['id']; ?>"> Edit  </a></li>
                    <li> <a href="?deleteid=<?php echo $data['id']; ?>"> Delete </a> </li>
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