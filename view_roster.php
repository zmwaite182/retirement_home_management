<?php
session_start();
include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Roster</title>
  </head>
  <body>

<?php
  if (!isset($_SESSION['job'])) {
    header('Location: decline_access.php');
    exit();
  } else {
    echo "
    <h1>View Roster</h1>
    <a href='./index.php'>Go Back</a>
    <a href='./view_roster.php'>View Todays Roster</a>

    <form method='post'>
      <input type='date' name='search_roster'>
      <input type='submit' name='search_r' value='Search'>
    </form>

    <table>
      <tr>
        <th>Date</th>
        <th>Doctor Name</th>
        <th>Supervisor Name</th>
        <th>Care Giver For Group 1</th>
        <th>Care Giver For Group 2</th>
        <th>Care Giver For Group 3</th>
        <th>Care Giver For Group 4</th>
      </tr>
      <tr>";

      if(isset($_POST['search_r'])) {
        $display_date = $_POST['search_roster'];
      } else {
        $display_date = date("Y-m-d");
      }
      $get_roster = "SELECT * FROM `rosters` WHERE roster_date = '$display_date';";
      $roster = mysqli_query($conn, $get_roster);
      $roster_row = mysqli_fetch_assoc($roster);
      if ($roster_row['roster_date']) {
      echo "<td>".$roster_row['roster_date']."</td>";

      $doc_id = $roster_row['doctor_id'];
      $get_doctor = "SELECT users.f_name, users.l_name FROM `users` JOIN `rosters` ON users.user_id = rosters.doctor_id WHERE rosters.roster_date = '$display_date' AND rosters.doctor_id = $doc_id;";
      $doctor_name = mysqli_query($conn, $get_doctor);
      $doctor_row = mysqli_fetch_assoc($doctor_name);
      echo "<td>".$doctor_row['f_name']." ".$doctor_row['l_name']."</td>";

      $sup_id = $roster_row['supervisor_id'];
      $get_supervisor = "SELECT users.f_name, users.l_name FROM `users` JOIN `rosters` ON users.user_id = rosters.supervisor_id WHERE rosters.roster_date = '$display_date' AND rosters.supervisor_id = $sup_id;";
      $supervisor_name = mysqli_query($conn, $get_supervisor);
      $supervisor_row = mysqli_fetch_assoc($supervisor_name);
      echo "<td>".$supervisor_row['f_name']." ".$supervisor_row['l_name']."</td>";

      $care_1 = $roster_row['care_giver_1'];
      $get_care_1 = "SELECT users.f_name, users.l_name FROM `users` JOIN `rosters` ON users.user_id = rosters.care_giver_1 WHERE rosters.roster_date = '$display_date' AND rosters.care_giver_1 = $care_1;";
      $care_1_name = mysqli_query($conn, $get_care_1);
      $care_1_row = mysqli_fetch_assoc($care_1_name);
      echo "<td>".$care_1_row['f_name']." ".$care_1_row['l_name']."</td>";

      $care_2 = $roster_row['care_giver_2'];
      $get_care_2 = "SELECT users.f_name, users.l_name FROM `users` JOIN `rosters` ON users.user_id = rosters.care_giver_2 WHERE rosters.roster_date = '$display_date' AND rosters.care_giver_2 = $care_2;";
      $care_2_name = mysqli_query($conn, $get_care_2);
      $care_2_row = mysqli_fetch_assoc($care_2_name);
      echo "<td>".$care_2_row['f_name']." ".$care_2_row['l_name']."</td>";

      $care_3 = $roster_row['care_giver_3'];
      $get_care_3 = "SELECT users.f_name, users.l_name FROM `users` JOIN `rosters` ON users.user_id = rosters.care_giver_3 WHERE rosters.roster_date = '$display_date' AND rosters.care_giver_3 = $care_3;";
      $care_3_name = mysqli_query($conn, $get_care_3);
      $care_3_row = mysqli_fetch_assoc($care_3_name);
      echo "<td>".$care_3_row['f_name']." ".$care_3_row['l_name']."</td>";

      $care_4 = $roster_row['care_giver_4'];
      $get_care_4 = "SELECT users.f_name, users.l_name FROM `users` JOIN `rosters` ON users.user_id = rosters.care_giver_4 WHERE rosters.roster_date = '$display_date' AND rosters.care_giver_4 = $care_4;";
      $care_4_name = mysqli_query($conn, $get_care_4);
      $care_4_row = mysqli_fetch_assoc($care_4_name);
      echo "<td>".$care_4_row['f_name']." ".$care_4_row['l_name']."</td>";

      echo "
      </tr>
      </table>
        ";
      } else {
        echo "<p>There is no Roster created for today.</p>";
      }
  }

?>




  </body>
</html>
