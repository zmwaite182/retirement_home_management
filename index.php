<?php
    session_start();
    if (ini_get('register_globals'))
{
    foreach ($_SESSION as $key=>$value)
    {
        if (isset($GLOBALS[$key]))
            unset($GLOBALS[$key]);
    }
}
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

  print_r($_SESSION);
  echo $_SESSION['job'];
  echo $_SESSION['user_id'];

  if (!isset($_SESSION['job'])) {

// WE ARE LOSING SESSION[JOB] WHEN WE POST TO SEARCH PATIENTS TABLE

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
        <a href='./index.php'>Cancel</a>
        <h1>Patients</h1>
        <form method='post'>
            <input type='text' name='search_p'>
            <input type='submit' name='search_patients' value='Search Patients'>
        </form>
    ";

    if (isset($_POST['search_patients'])) {
      $search_p = $_POST['search_p'];
      $sql = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND u.f_name = '$search_p' OR u.l_name = '$search_p' OR u.dob = '$search_p' OR p.emergency_contact = '$search_p' OR p.relation_ec = '$search_p' OR p.admission_date = '$search_p';";
      $searched_patients= mysqli_query($conn, $sql);
      echo "
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

      while($row = mysqli_fetch_assoc($searched_patients)) {
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
      echo "</table>";

    } else {
        $get_user_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient'";
        $user_details= mysqli_query($conn, $get_user_details);
        echo "
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
        while($row = mysqli_fetch_assoc($user_details)) {
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
              <input type='text'>
              <input type='submit' name='search_employees' value='Search Employees'>
          </form>
        ";

        $get_user_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' and u.job <> 'family_member'";
        $user_details= mysqli_query($conn, $get_user_details);
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
        while($row = mysqli_fetch_assoc($user_details)) {
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
        echo "</table>";
      }

  } elseif ($_SESSION['job'] == 'doctor') {

  } elseif ($_SESSION['job'] == 'caregiver') {

  } elseif ($_SESSION['job'] == 'supervisor') {

  }
?>
</body>
</html>
