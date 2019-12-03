<?php
  session_start();
  include_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Care Giver's Home</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
<?php
  if (!isset($_SESSION['job'])) {
    header('Location: decline_access.php');
    exit();
  } elseif ($_SESSION['job'] == 'caregiver') {
    $current_id = $_SESSION['user_id'];
    $current_date = date('Y-m-d');
    $get_cg_details = "SELECT * FROM `users` WHERE user_id = '$current_id';";
    $cg_details = mysqli_query($conn, $get_cg_details);
    $row = mysqli_fetch_assoc($cg_details);
    echo "
      <h1>Care Giver's Home</h1>
      <a href='./view_roster.php'>View Roster</a>
      <h2>Welcome ".$row['f_name']." ".$row['l_name'].".</h2>
    ";

    $gr1 = 0;
    $gr2 = 0;
    $gr3 = 0;
    $gr4 = 0;

    $get_cg_groups = "SELECT * FROM `rosters` WHERE roster_date = '$current_date';";
    $cg_groups = mysqli_query($conn, $get_cg_groups);
    while ($row = mysqli_fetch_assoc($cg_groups)) {
      if($row['care_giver_1'] == $current_id){
        $gr1 = 1;
      }
      if ($row['care_giver_2'] == $current_id) {
        $gr2 = 2;
      }
      if ($row['care_giver_3'] == $current_id) {
        $gr3 = 3;
      }
      if ($row['care_giver_4'] == $current_id) {
        $gr4 = 4;
      }
    }

    echo "
    <table>
      <tr>
        <th>Name</th>
        <th>Morning Medicine</th>
        <th>Afternoon Medicine</th>
        <th>Night Medicine</th>
        <th>Breakfast</th>
        <th>Lunch</th>
        <th>Dinner</th>
        <th></th>
      </tr>
    ";

    if($gr1>0){
      $get_p_id = "SELECT user_id FROM `patients` WHERE group_id = '$gr1';";
      $p_id = mysqli_query($conn, $get_p_id);

      echo "<form method='post'>";
      while ($row = mysqli_fetch_assoc($p_id)) {
        echo "<tr>";
        $id = $row['user_id'];
        $sql1 = "SELECT * FROM `users` WHERE user_id = '$id';";
        $names = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($names);
        echo "<td>".$row1['f_name']." ".$row1['l_name']."</td>";

        $sql2 = "SELECT * FROM `activities` WHERE patient_id = '$id';";
        $activity_details = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($activity_details);

        if ($row2['morning_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='morning_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['afternoon_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='afternoon_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['night_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='night_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['breakfast']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='breakfast' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['lunch']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='lunch' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['dinner']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='dinner' value=".htmlspecialchars($id)."></td>";
        }
      echo "
        <td><input type='submit' name='update_cg_home' value='Submit'></td>
      </tr>";
      }
      echo "</form>";

    }

    if($gr2>0){
      $get_p_id = "SELECT user_id FROM `patients` WHERE group_id = '$gr2';";
      $p_id = mysqli_query($conn, $get_p_id);

      echo "<form method='post'>";
      while ($row = mysqli_fetch_assoc($p_id)) {
        echo "<tr>";
        $id = $row['user_id'];
        $sql1 = "SELECT * FROM `users` WHERE user_id = '$id';";
        $names = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($names);
        echo "<td>".$row1['f_name']." ".$row1['l_name']."</td>";

        $sql2 = "SELECT * FROM `activities` WHERE patient_id = '$id';";
        $activity_details = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($activity_details);

        if ($row2['morning_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='morning_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['afternoon_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='afternoon_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['night_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='night_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['breakfast']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='breakfast' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['lunch']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='lunch' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['dinner']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='dinner' value=".htmlspecialchars($id)."></td>";
        }
      echo "
        <td><input type='submit' name='update_cg_home' value='Submit'></td>
      </tr>";
      }
      echo "</form>";
    }

    if($gr3>0){
      $get_p_id = "SELECT user_id FROM `patients` WHERE group_id = '$gr3';";
      $p_id = mysqli_query($conn, $get_p_id);

      echo "<form method='post'>";
      while ($row = mysqli_fetch_assoc($p_id)) {
        echo "<tr>";
        $id = $row['user_id'];
        $sql1 = "SELECT * FROM `users` WHERE user_id = '$id';";
        $names = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($names);
        echo "<td>".$row1['f_name']." ".$row1['l_name']."</td>";

        $sql2 = "SELECT * FROM `activities` WHERE patient_id = '$id';";
        $activity_details = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($activity_details);

        if ($row2['morning_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='morning_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['afternoon_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='afternoon_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['night_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='night_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['breakfast']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='breakfast' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['lunch']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='lunch' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['dinner']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='dinner' value=".htmlspecialchars($id)."></td>";
        }
      echo "
        <td><input type='submit' name='update_cg_home' value='Submit'></td>
      </tr>";
      }
      echo "</form>";
    }

    if($gr4>0){
      $get_p_id = "SELECT user_id FROM `patients` WHERE group_id = '$gr4';";
      $p_id = mysqli_query($conn, $get_p_id);

      echo "<form method='post'>";
      while ($row = mysqli_fetch_assoc($p_id)) {
        echo "<tr>";
        $id = $row['user_id'];
        $sql1 = "SELECT * FROM `users` WHERE user_id = '$id';";
        $names = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($names);
        echo "<td>".$row1['f_name']." ".$row1['l_name']."</td>";

        $sql2 = "SELECT * FROM `activities` WHERE patient_id = '$id';";
        $activity_details = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($activity_details);

        if ($row2['morning_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='morning_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['afternoon_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='afternoon_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['night_med']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='night_med' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['breakfast']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='breakfast' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['lunch']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='lunch' value=".htmlspecialchars($id)."></td>";
        }
        if ($row2['dinner']) {
          echo "<td><input type='checkbox' checked disabled></td>";
        } else {
          echo "<td><input type='checkbox' name='dinner' value=".htmlspecialchars($id)."></td>";
        }
      echo "
        <td><input type='submit' name='update_cg_home' value='Submit'></td>
      </tr>";
      }
      echo "</form>";
    }

    if (isset($_POST['update_cg_home'])) {
      $current_date = date('Y-m-d');
      echo "<a href= 'care_giver_home.php'>Refresh List</a>";
      foreach ($_POST as $key => $value) {
        $check_user = "SELECT * FROM `activities` WHERE patient_id = '$value' AND activity_date = '$current_date';";
        $user_valid = mysqli_query($conn, $check_user);
        $row = mysqli_fetch_assoc($user_valid);

        if (mysqli_num_rows($user_valid) == 0 && $value > 0) {
          $sql = "INSERT INTO `activities` (patient_id, activity_date) VALUES ('$value', '$current_date');";
          mysqli_query($conn, $sql);
        }

         if ($key == 'morning_med'){
           $sql = "UPDATE `activities` SET morning_med = 1 WHERE patient_id = '$value' AND activity_date = '$current_date';";
           mysqli_query($conn, $sql);

        } elseif ($key == 'afternoon_med') {
          $sql = "UPDATE `activities` SET afternoon_med = 1 WHERE patient_id = '$value' AND activity_date = '$current_date';";
          mysqli_query($conn, $sql);

        } elseif ($key == 'night_med') {
          $sql = "UPDATE `activities` SET night_med = 1 WHERE patient_id = '$value' AND activity_date = '$current_date';";
          mysqli_query($conn, $sql);

        } elseif ($key == 'breakfast') {
          $sql = "UPDATE `activities` SET breakfast = 1 WHERE patient_id = '$value' AND activity_date = '$current_date';";
          mysqli_query($conn, $sql);

        } elseif ($key == 'lunch') {
          $sql = "UPDATE `activities` SET lunch = 1 WHERE patient_id = '$value' AND activity_date = '$current_date';";
          mysqli_query($conn, $sql);

        } elseif ($key == 'dinner') {
          $sql = "UPDATE `activities` SET dinner = 1 WHERE patient_id = '$value' AND activity_date = '$current_date';";
          mysqli_query($conn, $sql);
        }

      }
    }
    echo "
          <form method='post' class='index_form'>
            <input type='submit' name='logout' value='Logout'>
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
