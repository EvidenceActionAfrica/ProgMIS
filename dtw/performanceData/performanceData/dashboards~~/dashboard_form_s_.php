<html>
  <head>
    <title>View Master Trainers</title>
    <?php
    include "includes/meta-link-script.php";

    include "includes/config.php";
    ?>

    <style type="text/css">
    #content{
      margin: 30px auto;
      width: 800px;
    }

    #indicator ul li{
      list-style: none;
      border-bottom: solid thin;

    }

    #total ul li{
      list-style: none;
      border-bottom: solid thin;

    }

    #indicator{
      float: left;
    }

    #total{
      float: left;
    }

    #indicator, #total{
      /*width: 400px;*/
    }
  </style>

  <?php 
    

    include "functions_forms.php";

   ?>
  </head>

  <body>

    <?php include 'sideMenu.php'; ?>
    <div class="contentBody">
          <div id="content">

    <div id="dashboard">
      <div id="indicator">
        <table>
          <th>Indicator</th>
          <th>Total</th>
          <h2>Coverage Indicators</h2>
          <tr>

            <td>No. of districts covered</td>
            <td><?php echo numOfDistrictsCovered(); ?></td>
          </tr>
          <tr>

            <td>No. of schools covered</td>
            <td><?php echo numOfSchoolsCovered(); ?></td>
          </tr>
          <tr>

            <td>No. dewormed (children + adults)</td>
            <td><?php echo numOfDewormed(); ?></td>
          </tr>
          <tr>

            <td>No. of children dewormed</td>
            <td><?php echo numOfDewormedChildren(); ?></td>
          </tr>
          <tr>

            <td>Average children dewormed per district</td>
            <td><?php echo averageChildrenDewormedPerDistrict(); ?></td>
          </tr>
          <tr>

            <td>Range of district coverage (max district average)</td>
            <td>$Data</td>
          </tr>
          <tr>

            <td>Range of district coverage (min district average)</td>
            <td>$Data</td>
          </tr>
          <tr>

            <td>No. of 'Enrolled Primary + Enrolled ECD' children dewormed</td>
            <td><?php echo numPrimaryAndEcdChildrenDewormed(); ?></td>
          </tr>
          <tr>

            <td>No. of 'ECD' children dewormed</td>
            <td><?php echo ecdChildrenDewormed('ecd_treated_children_total'); ?></td>
          </tr>
          <tr>

            <td>No. of ECD Male children dewormed</td>
            <td><?php echo ecdChildrenDewormed('ecd_treated_male'); ?></td>
          </tr>
          <tr>

            <td>No. of ECD Female children dewormed</td>
            <td><?php echo ecdChildrenDewormed('ecd_treated_female'); ?></td>
          </tr>
          <tr>

            <td>No. of 'Primary' children dewormed</td>
            <td><?php echo primaryChildrenDewormed('number_treated_total'); ?></td>
          </tr>
          <tr>

            <td>No. of Primary Male children dewormed</td>
            <td><?php echo primaryChildrenDewormed('number_treated_male'); ?></td>
          </tr>
          <tr>

            <td>No. of Primary Female children dewormed</td>
            <td><?php echo primaryChildrenDewormed('number_treated_female'); ?></td>
          </tr>
          <tr>

            <td>No. of Primary children registered</td>
            <td><?php echo primaryChildrenDewormed('number_in_register_class_total'); ?></td>
          </tr>
          <tr>

            <td>No. of Male Primary children registered</td>
            <td><?php echo primaryChildrenDewormed('number_in_register_male'); ?></td>
          </tr>
          <tr>

            <td>No. of Female Primary children registered</td>
            <td><?php echo primaryChildrenDewormed('number_in_register_female'); ?></td>
          </tr>
          <tr>

            <td>No. of 'Non Enrolled' children dewormed</td>
            <td><?php echo nonEnrolledChildrenDewormed('non_enrolled_total'); ?></td>
          </tr>
          <tr>

            <td>No. of children aged 2-5 years dewormed</td>
            <td><?php echo allNonEnrolled2_5ChildrenDewormed(); ?></td>
          </tr>
          <tr>

            <td>No. of male children aged 2-5 years dewormed</td>
            <td><?php echo nonEnrolledChildrenDewormed('years_6_10_male'); ?></td>
          </tr>
          <tr>

            <td>No. of female children aged 2-5 years dewormed</td>
            <td><?php echo nonEnrolledChildrenDewormed('years_6_10_male'); ?></td>
          </tr>
          <tr>

            <td>No. of children aged 6+ years dewormed</td>
            <td><?php echo nonEnrolledOver6(); ?></td>
          </tr>
          <tr>

            <td>No. of male children aged 6+ years dewormed</td>
            <td><?php echo nonEnrolledOver6Male(); ?></td>
          </tr>
          <tr>

            <td>No. of female children aged 6+ years dewormed</td>
            <td><?php echo nonEnrolledOver6Female(); ?></td>
          </tr>
          <tr>

            <td>No. of adults dewormed</td>
            <td><?php echo adultsDewormed(); ?></td>
          </tr>
          <tr></tr>
          <tr></tr>



          <tr>
            <td><h2>Supply Estimation Indicators</h2></td>
            <td></td>
          </tr>
          <tr>
            <td>No. of tablets spoilt</td>
            <td><?php echo numSpoiltTablets(); ?></td>
          </tr>
          <tr>
            <td>No. of tablets supplied</td>
            <td><?php echo ecdChildrenDewormed('albendazole_recieved'); ?></td>
          </tr>
          <tr>
            <td>No. of tablets used (includes tablets given to children and adults and tablets spoilt)</td>
            <td><?php echo tabletsUsed(); ?></td>
          </tr>
          <tr>
            <td>No. of tablets returned</td>
            <td><?php echo ecdChildrenDewormed('albendazole_returned'); ?></td>
          </tr>
          <tr>
            <td>Ratio of tablets used to supplied</td>
            <td><?php echo ratioSuippliedToSpoiltTablets(); ?></td>
          </tr>
          <tr>
            <td>Ratio of tablets spolit to tablets supplied</td>
            <td><?php echo ratioSpoiltToSuppliedTablets(); ?></td>
          </tr>


          <tr></tr>
          <tr></tr>
          <tr>
            <td><h2>SCHISTO Indicators</h2></td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of districts covered</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of schools covered</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. dewormed (children + adults)</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of children dewormed</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of 'Enrolled Primary + Enrolled ECD' children dewormed</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of 'ECD' children dewormed</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of 'Primary' children dewormed</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of Primary Male children dewormed</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of Primary Female children dewormed</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of Primary children registered</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of 'Non Enrolled' children dewormed</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of adults dewormed</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of tablets spoilt</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of tablets supplied</td>
            <td>$data</td>
          </tr>
          <tr>
            <td>No. of tablets used (includes tablets given to children and adults and tablets spoilt)</td>
            <td>$data</td>
          </tr>
          <td>No. of tablets returned</td>
        </table>


        </ul>
      </div>

    

    </div>

  </div>
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