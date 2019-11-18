<?php
  session_start();
  include_once 'db.php';
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Create Roster</title>
   </head>
   <body>

<?php
  if (!isset($_SESSION['job'])) {
    header('Location: decline_access.php');
    exit();
  } elseif ($_SESSION['job'] != 'admin' && $_SESSION['job'] != 'supervisor') {
    header('Location: decline_access.php');
    exit();
  } else {

    $get_supervisor = "SELECT user_id, f_name, l_name FROM `users` WHERE job = 'supervisor';";
    $supervisor_name = mysqli_query($conn, $get_supervisor);
    $get_doctor = "SELECT user_id, f_name, l_name FROM `users` WHERE job = 'doctor';";
    $doctor_name = mysqli_query($conn, $get_doctor);
    $get_caregiver = "SELECT user_id, f_name, l_name FROM `users` WHERE job = 'caregiver';";
    $caregiver = mysqli_query($conn, $get_caregiver);
    $get_group = "SELECT * FROM `groups`;";
    $group = mysqli_query($conn, $get_group);

    echo
    "
    <form method='post'>
      <input type='date' name='roster_date' placeholder='Todays Date' required>
      <label for='select_supervisor'>Choose Supervisor</label>
      <select name='select_supervisor' required>
    ";
        while($row = mysqli_fetch_assoc($supervisor_name)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <label for='select_doctor'>Choose Doctor</label>
      <select name='select_doctor' required>
      ";
          while($row = mysqli_fetch_assoc($doctor_name)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <label for='caregiver_1'>Choose Care Giver 1</label>
      <select name='caregiver_1' required>
      ";
          while($row = mysqli_fetch_assoc($caregiver)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <select name='group_1' required>
      ";
          while($row = mysqli_fetch_assoc($group)) {
              echo "<option value=\"{$row['group_id']}\">Group {$row['group_id']}</option>";
        }
      echo
      "
      </select>
      <label for='caregiver_2'>Choose Care Giver 2</label>
      <select name='caregiver_2' required>
      ";
          $caregiver = mysqli_query($conn, $get_caregiver);
          while($row = mysqli_fetch_assoc($caregiver)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <select name='group_2' required>
      ";
          $group = mysqli_query($conn, $get_group);
          while($row = mysqli_fetch_assoc($group)) {
              echo "<option value=\"{$row['group_id']}\">Group {$row['group_id']}</option>";
        }
      echo
      "
      </select>
      <label for='caregiver_3'>Choose Care Giver 3</label>
      <select name='caregiver_3' required>
      ";
          $caregiver = mysqli_query($conn, $get_caregiver);
          while($row = mysqli_fetch_assoc($caregiver)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <select name='group_3' required>
      ";
          $group = mysqli_query($conn, $get_group);
          while($row = mysqli_fetch_assoc($group)) {
              echo "<option value=\"{$row['group_id']}\">Group {$row['group_id']}</option>";
        }
      echo
      "
      </select>
      <label for='caregiver_4'>Choose Care Giver 4</label>
      <select name='caregiver_4' required>
      ";
          $caregiver = mysqli_query($conn, $get_caregiver);
          while($row = mysqli_fetch_assoc($caregiver)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <select name='group_4' required>
      ";
          $group = mysqli_query($conn, $get_group);
          while($row = mysqli_fetch_assoc($group)) {
              echo "<option value=\"{$row['group_id']}\">Group {$row['group_id']}</option>";
        }
      echo
      "
      </select>
      <input type='submit' name='create_roster' value='Submit'/>
    </form>
      ";

      if(isset($_POST['create_roster'])) {
        $roster_date = $_POST['roster_date'];
        $supervisor_id = $_POST['select_supervisor'];
        $doctor_id = $_POST['select_doctor'];
        $caregiver_1_id = $_POST['caregiver_1'];
        $group_id_1 = $_POST['group_1'];
        $caregiver_2_id = $_POST['caregiver_2'];
        $group_id_2 = $_POST['group_2'];
        $caregiver_3_id = $_POST['caregiver_3'];
        $group_id_3 = $_POST['group_3'];
        $caregiver_4_id = $_POST['caregiver_4'];
        $group_id_4 = $_POST['group_4'];

        $sql = "INSERT INTO `rosters` (roster_date, supervisor_id, doctor_id, care_giver_1, patient_group_1, care_giver_2, patient_group_2, care_giver_3, patient_group_3, care_giver_4, patient_group_4) VALUES ('$roster_date','$supervisor_id','$doctor_id','$caregiver_1_id','$group_id_1','$caregiver_2_id','$group_id_2','$caregiver_3_id','$group_id_3','$caregiver_4_id','$group_id_4');";
        mysqli_query($conn, $sql);
        echo "<p>Sucessfully Created Roster!</p>";
      }
  }

?>
    <a href="./index.php">Cancel</a>

   </body>
 </html>
