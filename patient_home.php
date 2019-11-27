<?php
  session_start();
  include_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
  </head>
  <body>
<?php
  if (!isset($_SESSION['job'])) {
    header('Location: decline_access.php');
    exit();
  } elseif ($_SESSION['job'] == 'patient' || $_SESSION['job'] == 'family_member') {

      if ($_SESSION['job'] == 'patient'){
        $current_id = $_SESSION['user_id'];
        $current_date = date('Y-m-d');
        $get_patient_details = "SELECT * FROM `users` WHERE user_id = '$current_id';";
        $patient_details = mysqli_query($conn, $get_patient_details);
        $row = mysqli_fetch_assoc($patient_details);
        echo "
          <h1>Patient's Home</h1>
          <a href='./view_roster.php'>View Roster</a>
          <h2>Welcome ".$row['f_name']." ".$row['l_name'].".</h2>
          <p>Patient ID: ".$current_id."</p>
          <p>Todays date: ".$current_date."</p>
          <form method='post'>
              <input type='date' name='search_date' required>
              <input type='submit' name='search_p_home' value='Search'>
          </form>";

        if (isset($_POST['search_p_home'])) {
          $current_date = $_POST['search_date'];
          echo "<a href='patient_home.php'>View Today</a>";
        }

      } elseif ($_SESSION['job'] == 'family_member'){
        $current_date = date('Y-m-d');
        $current_id = NULL;
        echo "
          <h1>Family Member's Home</h1>
          <p>Todays date: ".$current_date."</p>
          <form method='post'>
              <input type='number' name='search_fam_code' required>
              <input type='submit' name='search_f_home' value='Search Family Code'>
          </form>";

        if (isset($_POST['search_f_home'])) {
          $fam_code = $_POST['search_fam_code'];
          $get_pat_info = "SELECT * FROM patients p JOIN users u ON p.user_id=u.user_id WHERE family_code = '$fam_code';";
          $pat_info = mysqli_query($conn, $get_pat_info);
          while($row = mysqli_fetch_assoc($pat_info)) {
            $_SESSION['temp_id'] = $row['user_id'];
            $group_id = $row['group_id'];
            $patient_name = $row['f_name']." ".$row['l_name'];
            $current_id = $_SESSION['temp_id'];
          }

          echo "
            <p>Patient ID: ".$current_id."</p>
            <p>Patient Name: ".$patient_name."</p>
          ";
          $get_patient_details = "SELECT * FROM `users` WHERE user_id = '$current_id';";
          $patient_details = mysqli_query($conn, $get_patient_details);
          $row = mysqli_fetch_assoc($patient_details);
          echo "
            <form method='post'>
                <input type='date' name='search_f_date' required>
                <input type='submit' name='search_fam' value='Search'>
            </form>";
        }
        if (isset($_POST['search_fam'])) {
          $current_date = $_POST['search_f_date'];
          $current_id = $_SESSION['temp_id'];
          echo "<p>Patient ID: ".$current_id."</p>
          <a href='patient_home.php'>View Today</a>";
        }
      }

    $get_doc_app = "SELECT patient_user_id, app_date, doctor_id FROM `appointments` WHERE app_date = '$current_date' AND patient_user_id = '$current_id'";
    $doc_app_details = mysqli_query($conn, $get_doc_app);
    $doc_ad = mysqli_fetch_assoc($doc_app_details);
    $doc_id = $doc_ad['doctor_id'];
    $resultCheck = mysqli_num_rows($doc_app_details);

    //getting doctor name based on ID
    $get_doc_name = "SELECT f_name, l_name FROM `users` WHERE user_id = '$doc_id';";
    $full_doc_name = mysqli_query($conn, $get_doc_name);
    $doctor_name_fl = mysqli_fetch_assoc($full_doc_name);

      //gets care giver needed for current day
      $get_group = "SELECT group_id FROM `patients` WHERE user_id = '$current_id'";
      $get_group_id = mysqli_query($conn, $get_group);
      $group_id = mysqli_fetch_assoc($get_group_id);

      //get care giver id
      if($group_id['group_id'] == 1){
        $get_id = "SELECT care_giver_1 FROM `rosters` WHERE roster_date = '$current_date';";
        $get_cg_id = mysqli_query($conn, $get_id);
        $id = mysqli_fetch_assoc($get_cg_id);
        $cg_id = $id['care_giver_1'];

      } elseif ($group_id['group_id'] == 2){
        $get_id = "SELECT care_giver_2 FROM `rosters` WHERE roster_date = '$current_date';";
        $get_cg_id = mysqli_query($conn, $get_id);
        $id = mysqli_fetch_assoc($get_cg_id);
        $cg_id = $id['care_giver_2'];

      } elseif ($group_id['group_id'] == 3){
        $get_id = "SELECT care_giver_3 FROM `rosters` WHERE roster_date = '$current_date';";
        $get_cg_id = mysqli_query($conn, $get_id);
        $id = mysqli_fetch_assoc($get_cg_id);
        $cg_id = $id['care_giver_3'];

      } elseif ($group_id['group_id'] == 4) {
        $get_id = "SELECT care_giver_5 FROM `rosters` WHERE roster_date = '$current_date';";
        $get_cg_id = mysqli_query($conn, $get_id);
        $id = mysqli_fetch_assoc($get_cg_id);
        $cg_id = $id['care_giver_4'];

      } else {
        $cg_id = NULL;
      }
      //get caregiver name
      $get_caregiver_name = "SELECT f_name, l_name FROM `users` WHERE user_id = '$cg_id';";
      $caregiver_name = mysqli_query($conn, $get_caregiver_name);
      $cg_name_fl = mysqli_fetch_assoc($caregiver_name);
      //get activity details
      $get_ad = "SELECT morning_med, afternoon_med, night_med, breakfast, lunch, dinner FROM `activities` WHERE patient_id = '$current_id' AND activity_date = '$current_date';";
      $ad = mysqli_query($conn, $get_ad);
      $list_of_ad = mysqli_fetch_assoc($ad);

      echo "
        <table>
          <tr>
            <th>Doctor's Name</th>
            <th>Doctor's Appointment</th>
            <th>Caregiver's Name</th>
            <th>Morning Medicine</th>
            <th>Afternoon Medicine</th>
            <th>Night Medicine</th>
            <th>Breakfast</th>
            <th>Lunch</th>
            <th>Dinner</th>
          </tr>
      ";
      echo "
          <tr>";
            if ($doctor_name_fl['f_name']){
              echo "<td>".$doctor_name_fl['f_name']." ".$doctor_name_fl['l_name']."</td> <td>&#x2713</td>";
            } else {
              echo "<td>N/A</td>
                    <td>X</td>";
            }
            if ($cg_name_fl['f_name']){
              echo "<td>".$cg_name_fl['f_name']." ".$cg_name_fl['l_name']."</td>";
            } else {
              echo "<td>N/A</td>";
            }
            if ($list_of_ad['morning_med']){
              echo "<td>&#x2713</td>";
            } else {
              echo "<td>[ ]</td>";
            }
            if ($list_of_ad['afternoon_med']){
              echo "<td>&#x2713</td>";
            } else {
              echo "<td>[ ]</td>";
            }
            if ($list_of_ad['night_med']){
              echo "<td>&#x2713</td>";
            } else {
              echo "<td>[ ]</td>";
            }
            if ($list_of_ad['breakfast']){
              echo "<td>&#x2713</td>";
            } else {
              echo "<td>[ ]</td>";
            }
            if ($list_of_ad['lunch']){
              echo "<td>&#x2713</td>";
            } else {
              echo "<td>[ ]</td>";
            }
            if ($list_of_ad['dinner']){
              echo "<td>&#x2713</td>";
            } else {
              echo "<td>[ ]</td>";
            }
            echo "
          </tr>
        </table>

        <form method='post'>
          <input type='submit' name='logout' value='logout'>
        </form>
        ";
           if (isset($_POST['logout'])) {
             session_unset();
             header('Location: index.php');
             exit();
           }
  } else {
    header('Location: decline_access.php');
    exit();
  }
  ?>
  </body>
</html>
