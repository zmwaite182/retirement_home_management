<?php
    session_start();
    include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<?php

  if (!isset($_SESSION['job'])) {
      echo "
          <form method='post' action='login.php'>
              <input type='submit' name='login' value='Login'>
          </form>
          <form method='post' action='register.php'>
              <input type='submit' name='register' value='Register'>
          </form>
      ";
  } elseif ($_SESSION['job'] == 'family_member') {

  } elseif ($_SESSION['job'] == 'patient') {

  } elseif ($_SESSION['job'] == 'admin') {

    echo "
        <a href='./index.php'>Go Back</a>
    ";

    $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient'";
    $patient_details= mysqli_query($conn, $get_patient_details);
    $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' and u.job <> 'family_member'";
    $employee_details= mysqli_query($conn, $get_employee_details);

    if (isset($_POST['search_patients'])) {
      $search_p = $_POST['search_p'];
      $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND u.f_name = '$search_p' OR u.l_name = '$search_p' OR u.dob = '$search_p' OR p.emergency_contact = '$search_p' OR p.relation_ec = '$search_p' OR p.admission_date = '$search_p';";
      $patient_details= mysqli_query($conn, $get_patient_details);

    } elseif (isset($_POST['search_employees'])) {
        $search_e = $_POST['search_e'];
        $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' AND u.job <> 'family_member' AND u.user_id = '$search_e' OR u.job = '$search_e' OR u.f_name = '$search_e' OR u.l_name = '$search_e' OR e.salary = '$search_e' OR e.group_id = '$search_e';";
        $employee_details= mysqli_query($conn, $get_employee_details);

    }
      echo "
          <h1>Patients</h1>
          <form method='post'>
              <input type='text' name='search_p'>
              <input type='submit' name='search_patients' value='Search Patients'>
          </form>

          <table>
            <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Emergency Contact</th>
            <th>EC Relation</th>
            <th>Admission Date</th>
            </tr>
        ";
        while($row = mysqli_fetch_assoc($patient_details)) {
          echo "
            <tr>
                <td>".$row['f_name']."</td>
                <td>".$row['l_name']."</td>
                <td>".$row['dob']."</td>
                <td>".$row['emergency_contact']."</td>
                <td>".$row['relation_ec']."</td>
                <td>".$row['admission_date']."</td>
              </tr>
          ";
        }
        echo "
          </table>

          <h1>Employees</h1>
          <form method='post'>
              <input type='text' name='search_e'>
              <input type='submit' name='search_employees' value='Search Employees'>
          </form>
        ";

        echo "
          <table>
              <tr>
              <th>User Id</th>
              <th>Role</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Salary</th>
              <th>Group</th>
              </tr>
        ";
        while($row = mysqli_fetch_assoc($employee_details)) {
            echo "
                <tr>
                <td>".$row['user_id']."</td>
                <td>".$row['job']."</td>
                <td>".$row['f_name']."</td>
                <td>".$row['l_name']."</td>
                <td>".$row['salary']."</td>
                <td>".$row['group_id']."</td>
                </tr>
                ";
        }
        echo "</table>
              <a href='roster.php'>Create Roster</a>
        ";

  } elseif ($_SESSION['job'] == 'doctor') {

  } elseif ($_SESSION['job'] == 'caregiver') {

  } elseif ($_SESSION['job'] == 'supervisor') {
    echo "<a href='roster.php'>Create Roster</a>";
  }

  echo "
        <form method='post'>
          <input type='submit' name='logout' value='logout'>
        </form>
       ";
       if (isset($_POST['logout'])) {
         session_unset();
         header('Location: index.php');
         exit();
       }

?>
</body>
</html>
