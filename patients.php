<?php
  session_start();
  include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Roster</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>

    <?php
      if (!isset($_SESSION['job'])) {
        header('Location: decline_access.php');
        exit();
      } elseif ($_SESSION['job'] == 'admin') {

      $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient'";
      $patient_details= mysqli_query($conn, $get_patient_details);

      if (isset($_POST['search_patients_1'])) {
        $search_p = $_POST['search_p'];
        $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND u.user_id = '$search_p';";
        $patient_details= mysqli_query($conn, $get_patient_details);
      } elseif (isset($_POST['search_patients_2'])) {
        $search_p = $_POST['search_p'];
        $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND u.f_name = '$search_p';";
        $patient_details= mysqli_query($conn, $get_patient_details);
      } elseif (isset($_POST['search_patients_3'])) {
        $search_p = $_POST['search_p'];
        $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND u.l_name = '$search_p';";
        $patient_details= mysqli_query($conn, $get_patient_details);
      } elseif (isset($_POST['search_patients_4'])) {
        $search_p = $_POST['search_p'];
        $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND u.dob = '$search_p';";
        $patient_details= mysqli_query($conn, $get_patient_details);
      } elseif (isset($_POST['search_patients_5'])) {
        $search_p = $_POST['search_p'];
        $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND p.emergency_contact = '$search_p';";
        $patient_details= mysqli_query($conn, $get_patient_details);
      } elseif (isset($_POST['search_patients_6'])) {
        $search_p = $_POST['search_p'];
        $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND p.relation_ec = '$search_p';";
        $patient_details= mysqli_query($conn, $get_patient_details);
      } elseif (isset($_POST['search_patients_7'])) {
        $search_p = $_POST['search_p'];
        $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND p.admission_date = '$search_p';";
        $patient_details= mysqli_query($conn, $get_patient_details);
      }
    ?>
      <h1>Patients</h1>
      <a href='./index.php'>Go Back</a>
      <a href='./patients.php'>View All</a>

      <table>
        <tr>
          <th>User ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Date of Birth</th>
          <th>Emergency Contact</th>
          <th>EC Relation</th>
          <th>Admission Date</th>
        </tr>
        <tr>
          <td>
            <form method='post'>
              <input type='text' name='search_p'>
              <input type='submit' name='search_patients_1' value='Go'>
            </form>
          </td>
          <td>
            <form method='post'>
              <input type='text' name='search_p'>
              <input type='submit' name='search_patients_2' value='Go'>
            </form>
          </td>
          <td>
            <form method='post'>
              <input type='text' name='search_p'>
              <input type='submit' name='search_patients_3' value='Go'>
            </form>
          </td>
          <td>
            <form method='post'>
              <input type='text' name='search_p'>
              <input type='submit' name='search_patients_4' value='Go'>
            </form>
          </td>
          <td>
            <form method='post'>
              <input type='text' name='search_p'>
              <input type='submit' name='search_patients_5' value='Go'>
            </form>
          </td>
          <td>
            <form method='post'>
                <input type='text' name='search_p'>
                <input type='submit' name='search_patients_6' value='Go'>
            </form>
          </td>
          <td>
            <form method='post'>
              <input type='text' name='search_p'>
              <input type='submit' name='search_patients_7' value='Go'>
            </form>
          </td>
        </tr>

    <?php
      while($row = mysqli_fetch_assoc($patient_details)) {
        echo "
          <tr>
            <td>".$row['user_id']."</td>
            <td>".$row['f_name']."</td>
            <td>".$row['l_name']."</td>
            <td>".$row['dob']."</td>
            <td>".$row['emergency_contact']."</td>
            <td>".$row['relation_ec']."</td>
            <td>".$row['admission_date']."</td>
          </tr>
        ";
      }
    } else {
      header('Location: decline_access.php');
      exit();
    }
    ?>
  </body>
</html>
