<?php

require('db.class.php');

Class Rollout {

  public function multi_in_array($value, $array) {
    foreach ($array AS $item) {
      if (!is_array($item)) {
        if ($item == $value) {
          return true;
        }
        continue;
      }

      if (in_array($value, $item)) {
        return true;
      } else if ($this->multi_in_array($value, $item)) {
        return true;
      }
    }
    return false;
  }

  public function insert_flag($activity_id, $constraint, $unique_id) {
    global $database;
    $database->query('INSERT INTO rollout_activity_constr_flags(id, rollout_activity_id, rollout_activity_constr_id) VALUES(:id, :rollout_activity_id, :rollout_activity_constr_id)', array(
        ':id' => NULL,
        ':rollout_activity_id' => $activity_id,
        ':rollout_activity_constr_id' => $constraint
            )
    );
    $database->query('UPDATE rollout_activity SET activity_status = :activity_status WHERE unique_id = :unique_id', array(
        ':activity_status' => 1,
        ':unique_id' => $unique_id
            )
    );
  }

  public function build_calendar($month, $year, $dateArray = NULL, $header, $waveData = NULL, $cView = 1 ) {

    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

    // How many days does this month contain?
    $numberDays = date('t', $firstDayOfMonth);

    // Retrieve some information about the first day of the
    // month in question.
    $dateComponents = getdate($firstDayOfMonth);

    // What is the name of the month in question?
    $monthName = $dateComponents['month'];

    // What is the index value (0-6) of the first day of the
    // month in question.
    $dayOfWeek = $dateComponents['wday'];

    if ($cView == 1) {

      // Create the table tag opener and day headers  
      $calendar = "<td><table class='table table-bordered'>";

      if ($header != 0) {
        $calendar .= "<tr>";
        $calendar .= "<th colspan='$numberDays'>$monthName $year</th>";
        $calendar .= "</tr>";
      }

      // Initiate the day counter, starting with the 1st.  
      $currentDay = 1;

      $calendar .= "<tr>";

      $month = str_pad($month, 2, "0", STR_PAD_LEFT);

      while ($currentDay <= $numberDays) {

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$currentDayRel-$month-$year";

        if ($header != 0) {

          $day = date('D', strtotime($date));
          $calendar .= "<td class='day-label' rel='$date'>$day<br>$currentDay</td>";

        } else {

          if ($this->multi_in_array($date, $dateArray)) {

            foreach ($dateArray as $arr) {
              if ($arr['date'] == $date) {
                $activity = 'activity-type-' . ( $arr['activity']);
                break;
              }
            }

            $calendar .= "<td class='day activity $activity' rel='$date'><a href='index.php?act=editactivity&wave=".$waveData['wave']."&loc=".urlencode($waveData['loc'])."'></a></td>";
          
          } else {

            $calendar .= "<td class='day' rel='$date'></td>";

          }

        }

        // Increment counters 
        $currentDay++;
      }

      $calendar .= "</tr>";

      $calendar .= "</table></td>";

    } else if ($cView == 2) {

      $weeks = ($numberDays/7);

      if ($numberDays%7 >= 1 ) {

        $weeks = $weeks + 1;

      }

      // Create the table tag opener and day headers  
      $calendar = "<td><table class='table table-bordered'>";

      if ($header != 0) {
        $calendar .= "<tr>";
        $calendar .= "<th colspan='$weeks'>$monthName $year</th>";
        $calendar .= "</tr>";
      }

      $calendar .= "<tr>";

      $month = str_pad($month, 2, "0", STR_PAD_LEFT);

      // Initiate the day counter, starting with the 1st.  
      $currentDay = 1; $wk = 1;

      while ($currentDay <= $numberDays) {
        
        if (  $wk > 4 ) {
          $lastDay = $currentDay + ($numberDays%7)-1;
        } else {
          $lastDay = $currentDay + 6;
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $lastDayRel = str_pad($lastDay, 2, "0", STR_PAD_LEFT);

        $date = "$currentDayRel-$month-$year";
        $lastdate = "$lastDayRel-$month-$year";

        if ($header != 0) {

          $day = date('D', strtotime($date));
          $lday = date('D', strtotime($lastdate));

          $calendar .= "<td class='day-label' rel='$date'><div class='pull-left'>$day<br>$currentDay</div> <div class='pull-right'>$lday<br>$lastDay</div></td>";

        } else {

          if ($this->multi_in_array($date, $dateArray)) {

            foreach ($dateArray as $arr) {
              if ($arr['date'] == $date) {
                $activity = 'activity-type-' . ( $arr['activity']);
               
              }
            }

            $calendar .= "<td class='day activity $activity' rel='$date'><a href='index.php?act=editactivity&wave=".$waveData['wave']."&loc=".urlencode($waveData['loc'])."'></a></td>";
          
          } else {

            $calendar .= "<td class='day' rel='$date'></td>";

          }

        }

        // Increment counters 
        $currentDay+=7;$wk++;
      }

      $calendar .= "</tr>";

      $calendar .= "</table></td>";

    } else if ($cView == 3) {

      // Create the table tag opener and day headers  
      $calendar = "<td><table class='table table-bordered'>";

      if ($header != 0) {
        $calendar .= "<tr>";
        $calendar .= "<th>$monthName $year</th>";
        $calendar .= "</tr>";
      }

      // Initiate the day counter, starting with the 1st.  
      $currentDay = 1;

      $calendar .= "<tr>";

      $month = str_pad($month, 2, "0", STR_PAD_LEFT);

      // while ($currentDay <= $numberDays) {

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$currentDayRel-$month-$year";

        if ($header != 0) {

          //$day = date('D', strtotime($date));
          //$calendar .= "<td class='day-label' rel='$date'>$day<br>$currentDay</td>";

        } else {

          if ($this->multi_in_array($date, $dateArray)) {

            foreach ($dateArray as $arr) {
              if ($arr['date'] == $date) {
                $activity = 'activity-type-' . ( $arr['activity']);
                break;
              }
            }

            $calendar .= "<td class='day' colspan='$numberDays'><a href='index.php?act=editactivity&wave=".$waveData['wave']."&loc=".urlencode($waveData['loc'])."'></a></td>";
          
          } else {

            $calendar .= "<td class='day' rel='$date'></td>";

          }

        }

        // Increment counters 
      //   $currentDay++;
      // }

      $calendar .= "</tr>";

      $calendar .= "</table></td>";

    }

    return $calendar;
  }

  public function activityTypesArray($data, $results) {

    foreach ($results as $key => $value) {
      $activityArray[] = array(
          '0' => $data['activity_' . $value['activity_type_id'] . '_start'],
          '1' => $data['activity_' . $value['activity_type_id'] . '_end']
      );
    }

    return $activityArray;
  }

  public function addMasterTrainers($data) {

    global $database;
    foreach ($data as $key => $value) {      
      $database->query('SELECT * FROM rollout_master_trainers WHERE mt_id = :mt_id AND wave = :wave', array(
          ':mt_id' => $value,
          ':wave' => $_REQUEST['waveid']
        )
      );
      $count = $database->count();
      if ($count == 0) {
        $database->query('INSERT INTO rollout_master_trainers(id, mt_id, district, wave) VALUES(:id, :mt_id, :district, :wave)', array(
            ':id' => NULL,
            ':mt_id' => $value,
            ':district' => $_REQUEST['loc'],
            ':wave' => $_REQUEST['waveid']
        ));
      }
    }
  }

  public function masterTrainersLeader($mt_id) {

    global $database;
    $database->query("SELECT leader FROM rollout_master_trainers WHERE wave = :wave AND district = :district AND leader = :leader", 
      array(
        ':wave'     => $_REQUEST['waveid'],
        ':district' => urldecode($_REQUEST['loc']),
        ':leader'   => 1
      )
    );
    $count = $database->count();

    if ( $count >= 1) {

      $database->query('UPDATE rollout_master_trainers SET leader = :leader_new WHERE wave = :wave AND district = :district AND leader = :leader_old',
        array(
          ':wave'         => $_REQUEST['waveid'],
          ':district'     => urldecode($_REQUEST['loc']),
          ':leader_old'   => 1,
          ':leader_new'   => 0
          )
      );

    }

    $database->query('UPDATE rollout_master_trainers SET leader = :leader WHERE wave = :wave AND district = :district AND mt_id = :mt_id',
        array(
          ':wave'     => $_REQUEST['waveid'],
          ':district' => urldecode($_REQUEST['loc']),
          ":mt_id"    => $mt_id,
          ':leader'   => 1
          )
    );
  }

  public function removeMasterTrainer($data) {

    global $database;
    $database->query('DELETE FROM rollout_master_trainers WHERE mt_id = :mt_id AND district = :district AND wave = :wave',
      array(
        ':mt_id'    => $data['mtid'],
        ':district' => $data['loc'],
        ':wave'     => $data['waveid']
      )
    );
    $removed = $database->statement->rowCount();

    if ($removed > 0) {

      header('Location:index.php?act=addtrainers&waveid='.$data['waveid'].'&loc='. $data['loc'].'');

    }
  }

  public function addWave($data) {

    global $database;

    $counties = implode(",", $data['cty']);
    $database->query('INSERT INTO deworming_waves(id, deworming_wave, county) VALUES(:id, :deworming_wave, :county)', 
      array(
        ':id' => NULL, 
        ':deworming_wave' => $data['deworming_wave_title'], 
        ':county' => $counties
      )
    );

    $wave_id = $database->insertID();

    foreach ($data['cty'] as $key => $county) {

      $database->query('SELECT district_name FROM districts WHERE county = :county',
        array(
          ':county' => $county
        )
      );
      $districts = $database->statement->fetchall(PDO::FETCH_ASSOC);

      foreach ($districts as $key => $district_name) {

        $database->query("SELECT activity_type_id FROM rollout_activitytype");
        $activities = $database->statement->fetchall(PDO::FETCH_ASSOC);

        foreach ($activities as $key => $activity_id) {

          $database->query('INSERT INTO rollout_activity(id, actyvity_county, activity_venu, activity_type, start_date, end_date, activity_status, wave_id) VALUES(:id, :actyvity_county, :activity_venu, :activity_type, :start_date, :end_date, :activity_status, :wave_id)', 
            array(
              ':id' => NULL,
              ':actyvity_county' => $county,
              ':activity_venu' => $district_name['district_name'],
              ':activity_type' => $activity_id['activity_type_id'],
              ':start_date' => NULL,
              ':end_date' => NULL,
              ':activity_status' => NULL,
              ':wave_id' => $wave_id
            )

          );

        }

      }

    }
  }

  public function editWave($data) {

    global $database;

    $database->query('SELECT county FROM deworming_waves WHERE id = :id', 
      array(
        ':id' => $_GET['waveid']
      )
    );
    $results = $database->statement->fetch(PDO::FETCH_ASSOC);
    $initialCounties = explode(',', $results['county']);

    $newCounties = array_diff_assoc($data['cty'],$initialCounties);

    $removedCounties = array_diff_assoc($initialCounties,$data['cty']);

    $counties = implode(",", $data['cty']);
    $database->query('UPDATE deworming_waves SET deworming_wave = :deworming_wave, county = :county WHERE id = :id', 
      array(
        ':deworming_wave' => $data['deworming_wave_title'],
        ':county' => $counties,
        ':id' => $_GET['waveid']
      )
    );

    if ( !empty($newCounties) ) {

      foreach ($newCounties as $key => $county) {

        $database->query('SELECT district_name FROM districts WHERE county = :county',
          array(
            ':county' => $county
          )
        );
        $districts = $database->statement->fetchall(PDO::FETCH_ASSOC);

        foreach ($districts as $key => $district_name) {

          $database->query("SELECT activity_type_id FROM rollout_activitytype");
          $activities = $database->statement->fetchall(PDO::FETCH_ASSOC);

          foreach ($activities as $key => $activity_id) {

            $database->query('INSERT INTO rollout_activity(id, actyvity_county, activity_venu, activity_type, start_date, end_date, activity_status, wave_id) VALUES(:id, :actyvity_county, :activity_venu, :activity_type, :start_date, :end_date, :activity_status, :wave_id)', 
              array(
                ':id' => NULL,
                ':actyvity_county' => $county,
                ':activity_venu' => $district_name['district_name'],
                ':activity_type' => $activity_id['activity_type_id'],
                ':start_date' => NULL,
                ':end_date' => NULL,
                ':activity_status' => NULL,
                ':wave_id' => $_GET['waveid']
              )

            );

          }

        }

      }

    }

    if ( !empty($removedCounties) ) {

        foreach ($removedCounties as $key => $county) {

          $database->query('DELETE FROM rollout_activity WHERE actyvity_county = :actyvity_county', 
            array(
              ':actyvity_county' => $county,
            )
          );

        }

    }

    header("Location:index.php?act=allwaves"); 
  }

  public function removeWave($id) {

    global $database;
    $database->query('DELETE FROM deworming_waves WHERE id =' . $id . '');
    $removed = $database->statement->rowCount();

    if ($removed >= 1) {

      $msg = array('type' => 1, 'text' => 'The New Wave was Successfully Added');
      header("Location:index.php?act=allwaves");

    } else {

      $msg = array('type' => 0, 'text' => 'An Error Ocurred, Please try Again Later');

    }
  }

  public function addWaveActivity($data,$id) {

    foreach ($data as $key => $value) {

      if (!empty($value['activity_start'])) {
        $start_date = strtotime($value['activity_start']);
      } else {
        $start_date = NULL;
      }

      if (empty($value['activity_end'])) {
        $end_date = $start_date;
      } else {
        $end_date = strtotime($value['activity_end']);
      }

      global $database;
      $database->query('UPDATE rollout_activity SET start_date = :start_date, end_date = :end_date WHERE wave_id = :wave_id AND activity_type = :activity_type', 
        array(
          ':activity_type' => $value['activity_type_id'],
          ':start_date' => $start_date,
          ':end_date' => $end_date,
          ':wave_id' => $id
        )
      );

    }
  }

  public function addcountyActivity($data,$counties,$id) {

    foreach ($data as $key => $value) {

      if (!empty($value['activity_start'])) {
        $start_date = strtotime($value['activity_start']);
      } else {
        $start_date = NULL;
      }

      if (empty($value['activity_end'])) {
        $end_date = $start_date;
      } else {
        $end_date = strtotime($value['activity_end']);
      }

      if (!empty($value['actual_activity_date'])) {
        $actual_activity_date = strtotime($value['actual_activity_date']);
      } else {
        $actual_activity_date = NULL;
      }

      if ( $start_date != NULL ) {

        global $database;
        foreach ($counties as $key => $county) {
          $database->query('UPDATE rollout_activity SET start_date = :start_date, end_date = :end_date, actual_activity_date = :actual_activity_date WHERE activity_type = :activity_type AND wave_id = :wave_id AND actyvity_county = :actyvity_county',
            array(
              ':start_date' => $start_date,
              ':end_date' => $end_date,
              ':actual_activity_date' => $actual_activity_date,
              ':activity_type' => $value['activity_type_id'],
              ':actyvity_county' => $county,
              ':wave_id' => $id
              )
          );
        }

      }

    }
  }

  public function bulkAddDistricts($data,$activity_venus,$id) {

    foreach ($data as $key => $value) {

      if (!empty($value['activity_start'])) {
        $start_date = strtotime($value['activity_start']);
      } else {
        $start_date = NULL;
      }

      if (empty($value['activity_end'])) {
        $end_date = $start_date;
      } else {
        $end_date = strtotime($value['activity_end']);
      }

      if (!empty($value['actual_activity_date'])) {
        $actual_activity_date = strtotime($value['actual_activity_date']);
      } else {
        $actual_activity_date = NULL;
      }

      global $database;
      foreach ($activity_venus as $key => $district) {
        $database->query('UPDATE rollout_activity SET start_date = :start_date, end_date = :end_date, actual_activity_date = :actual_activity_date WHERE activity_type = :activity_type AND wave_id = :wave_id AND activity_venu = :activity_venu',
          array(
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':actual_activity_date' => $actual_activity_date,
            ':activity_type' => $value['activity_type_id'],
            ':activity_venu' => $district,
            ':wave_id' => $id
            )
        );
      }

    }
  }
 
  public function editWaveActivity($data, $id) {
    array_pop($data);

    global $database;
    $database->query("SELECT activity_type_id FROM rollout_activitytype WHERE activity_type_id NOT IN('1','2','3') ORDER BY activity_type_id ASC");
    $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

    $activityArray = $this->activityTypesArray($data, $results);

    $i=3;
    foreach ($activityArray as $key => $value) {

      if ($value[0] == 0 || empty($value[0]) ) { $start_date = NULL; } else { $start_date = strtotime($value[0]); }
      if ($value[1] == 0 || empty($value[1]) ) { $end_date = $start_date; } else { $end_date = strtotime($value[1]); }

      $database->query('UPDATE rollout_activity SET start_date = :start_date, end_date = :end_date WHERE activity_venu = :activity_venu AND activity_type = :activity_type AND wave_id = :wave_id',
        array(
          ':start_date' => $start_date,
          ':end_date' => $end_date,
          ':activity_venu' => urldecode($_REQUEST['loc']),
          ':activity_type' => $i,
          ':wave_id' => $id
          )
      );
      $edited = $database->statement->rowCount();

      $i++;
    }
  }

  public function removeActivity($wave, $location) {

    global $database;
    $database->query('DELETE FROM rollout_activity WHERE wave_id = :wave_id AND activity_venu = :activity_venu ', array(
        ':wave_id' => $wave,
        ':activity_venu' => $location
            )
    );
    $removed = $database->statement->rowCount();

    if ($removed != 0) {

      header("Location:index.php?act=activity&waveid=" . $wave . "");

    } else {

      $msg = array('type' => 0, 'text' => 'An Error Ocurred, Please try Again Later');

    }
  }

}

$rollOut = new Rollout();

?>