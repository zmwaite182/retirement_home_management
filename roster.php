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
      <input type='date' name='date' placeholder='Todays Date'>
      <label for='select_supervisor'>Choose Supervisor</label>
      <select name='select_supervisor'>
    ";
        while($row = mysqli_fetch_assoc($supervisor_name)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <label for='select_doctor'>Choose Doctor</label>
      <select name='select_doctor'>
      ";
          while($row = mysqli_fetch_assoc($doctor_name)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <label for='caregiver_1'>Choose Care Giver 1</label>
      <select name='caregiver_1'>
      ";
          while($row = mysqli_fetch_assoc($caregiver)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <select name='group_1'>
      ";
          while($row = mysqli_fetch_assoc($group)) {
              echo "<option value=\"{$row['group_id']}\">Group {$row['group_id']}</option>";
        }
      echo
      "
      </select>
      <label for='caregiver_2'>Choose Care Giver 2</label>
      <select name='caregiver_2'>
      ";
          $caregiver = mysqli_query($conn, $get_caregiver);
          while($row = mysqli_fetch_assoc($caregiver)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <select name='group_2'>
      ";
          $group = mysqli_query($conn, $get_group);
          while($row = mysqli_fetch_assoc($group)) {
              echo "<option value=\"{$row['group_id']}\">Group {$row['group_id']}</option>";
        }
      echo
      "
      </select>
      <label for='caregiver_3'>Choose Care Giver 3</label>
      <select name='caregiver_3'>
      ";
          $caregiver = mysqli_query($conn, $get_caregiver);
          while($row = mysqli_fetch_assoc($caregiver)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <select name='group_3'>
      ";
          $group = mysqli_query($conn, $get_group);
          while($row = mysqli_fetch_assoc($group)) {
              echo "<option value=\"{$row['group_id']}\">Group {$row['group_id']}</option>";
        }
      echo
      "
      </select>
      <label for='caregiver_4'>Choose Care Giver 4</label>
      <select name='caregiver_4'>
      ";
          $caregiver = mysqli_query($conn, $get_caregiver);
          while($row = mysqli_fetch_assoc($caregiver)) {
              echo "<option value=\"{$row['user_id']}\">{$row['f_name']} {$row['l_name']}</option>";
        }
      echo
      "
      </select>
      <select name='group_4'>
      ";
          $group = mysqli_query($conn, $get_group);
          while($row = mysqli_fetch_assoc($group)) {
              echo "<option value=\"{$row['group_id']}\">Group {$row['group_id']}</option>";
        }
      echo
      "
      </select>
      <input type='submit' name='create_acc' value='Submit'/>
    </form>
      ";

  }

?>
    <a href="./index.php">Cancel</a>

   </body>
 </html>
