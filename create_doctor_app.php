<?php
  session_start();
  include_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Doctor Appointment</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
<?php
  if (!isset($_SESSION['job'])) {
    header('Location: decline_access.php');
    exit();
  } elseif ($_SESSION['job'] != 'admin') {
    header('Location: decline_access.php');
    exit();
  } else {
    $get_doctor = "SELECT user_id, f_name, l_name FROM `users` WHERE job = 'doctor';";
    $doctor_name = mysqli_query($conn, $get_doctor);
    echo "
      <h1>Create Doctor Appointment</h1>
      <a href='./index.php'>Go Back</a>
      <form method='post'>
        <label for='patient ID'>Enter Patient ID:</label>
        <input type='number' name='patient_id' required>
        <input type='submit' name='chose_patient' value='Submit'/>
      </form>
        ";
      if (isset($_POST['chose_patient'])) {
        $patient_id = $_POST['patient_id'];
        $_SESSION['selected_patient'] = $patient_id;
        $get_patient_name = "SELECT f_name, l_name FROM `users` WHERE job = 'patient' AND user_id = '$patient_id' ";
        $patient_name = mysqli_query($conn, $get_patient_name);
        $resultCheck = mysqli_num_rows($patient_name);

        if($resultCheck>0) {
        $row = mysqli_fetch_assoc($patient_name);
          echo "<p>Selected Patient: ".$row['f_name']." ".$row['l_name']."</p>";
          echo "
            <form method='post'>
                <label for='date'>Date:</label>
                <input type='date' name='app_date' required>
                <label for='select_doctor'>Choose Doctor</label>
                <select name='select_doctor' required>";
          while($row = mysqli_fetch_assoc($doctor_name)) {
                echo "<option value=".$row['user_id'].">".$row['f_name']." ".$row['l_name']."</option>";
          }
          echo "
                 </select>
                 <input type='submit' name='c_appointment' value='Submit'/>
            </form>
            <a href='create_doctor_app.php'>Cancel</a>
          ";
          } else {
            echo "<p>Invalid Patient ID</p>";
          }
        }
      if (isset($_POST['c_appointment'])) {
          $pat_id = $_SESSION['selected_patient'];
          unset($_SESSION['selected_patient']);
          $app_date = $_POST['app_date'];
          $doc_id = $_POST['select_doctor'];
          $sql = "INSERT INTO `appointments` (patient_user_id, app_date, doctor_id) VALUES ('$pat_id','$app_date','$doc_id');";
          mysqli_query($conn, $sql);
          echo "<p>Appointment Sucessfully Created!</p>";
      }
    }
    ?>
  </body>
</html>
