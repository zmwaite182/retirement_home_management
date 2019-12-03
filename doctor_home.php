<?php
  session_start();
  include_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
<?php
  if (!isset($_SESSION['job'])) {
    header('Location: decline_access.php');
    exit();
  } elseif ($_SESSION['job'] == 'doctor') {
    echo "<a href='./view_roster.php'>View Roster</a>";

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

    $doctor_id = $_SESSION['user_id'];

    $get_patients = "SELECT * FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id';";
    $patients_list= mysqli_query($conn, $get_patients);

    if (isset($_POST['search_patients_1'])) {
        $search = $_POST['search'];
        $get_patients = "SELECT * FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id' AND u.f_name = '$search';";
        $patients_list= mysqli_query($conn, $get_patients);
    } elseif (isset($_POST['search_patients_2'])) {
        $search = $_POST['search'];
        $get_patients = "SELECT * FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id' AND u.l_name = '$search';";
        $patients_list= mysqli_query($conn, $get_patients);
    } elseif (isset($_POST['search_patients_3'])) {
        $search = $_POST['search'];
        $get_patients = "SELECT * FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id' AND a.app_date = '$search';";
        $patients_list= mysqli_query($conn, $get_patients);
    } elseif (isset($_POST['search_patients_4'])) {
        $search = $_POST['search'];
        $get_patients = "SELECT * FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id' AND a.comment = '$search';";
        $patients_list= mysqli_query($conn, $get_patients);
    } elseif (isset($_POST['search_patients_5'])) {
        $search = $_POST['search'];
        $get_patients = "SELECT * FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id' AND a.morning_med = '$search';";
        $patients_list= mysqli_query($conn, $get_patients);
    } elseif (isset($_POST['search_patients_6'])) {
        $search = $_POST['search'];
        $get_patients = "SELECT * FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id' AND a.afternoon_med = '$search';";
        $patients_list= mysqli_query($conn, $get_patients);
    } elseif (isset($_POST['search_patients_7'])) {
        $search = $_POST['search'];
        $get_patients = "SELECT * FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id' AND a.night_med = '$search';";
        $patients_list= mysqli_query($conn, $get_patients);
    }

    echo "
        <h1>All Appointments</h1>
        <a href='./index.php'>View All</a>

        <table>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Date</th>
              <th>Comment</th>
              <th>Morning Med</th>
              <th>Afternoon Med</th>
              <th>Night Med</th>
            </tr>
            <tr>
              <td>
                <form method='post'>
                  <input type='text' name='search'>
                  <input type='submit' name='search_patients_1' value='Go'>
                </form>
              </td>
              <td>
                <form method='post'>
                  <input type='text' name='search'>
                  <input type='submit' name='search_patients_2' value='Go'>
                </form>
              </td>
              <td>
                <form method='post'>
                  <input type='text' name='search'>
                  <input type='submit' name='search_patients_3' value='Go'>
                </form>
              </td>
              <td>
                <form method='post'>
                  <input type='text' name='search'>
                  <input type='submit' name='search_patients_4' value='Go'>
                </form>
              </td>
              <td>
                <form method='post'>
                  <input type='text' name='search'>
                  <input type='submit' name='search_patients_5' value='Go'>
                </form>
              </td>
              <td>
                <form method='post'>
                  <input type='text' name='search'>
                  <input type='submit' name='search_patients_6' value='Go'>
                </form>
              </td>
              <td>
                <form method='post'>
                  <input type='text' name='search'>
                  <input type='submit' name='search_patients_7' value='Go'>
                </form>
              </td>
            </tr>
    ";
    while($row = mysqli_fetch_assoc($patients_list)) {
        echo "
            <tr>
              <td>".$row['f_name']."</td>
              <td>".$row['l_name']."</td>
              <td>".$row['app_date']."</td>
              <td>".$row['comment']."</td>
              <td>".$row['morning_med']."</td>
              <td>".$row['afternoon_med']."</td>
              <td>".$row['night_med']."</td>
            </tr>
            ";
    }
    echo "</table>";

    $current_date = date('Y-m-d');
    $get_appointments = "SELECT u.f_name, u.l_name, a.app_date, u.user_id FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id' AND app_date = '$current_date';";
    $appointments_list= mysqli_query($conn, $get_appointments);

    if (isset($_POST['till_date'])) {
      $till_date = $_POST['date'];
      $get_appointments = "SELECT u.f_name, u.l_name, a.app_date, u.user_id FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE doctor_id = '$doctor_id' AND app_date >= '$current_date' AND app_date <= '$till_date';";
      $appointments_list= mysqli_query($conn, $get_appointments);
    }

    echo "
      <h2>Upcoming Appointments</h2>
      <form method='post'>
        <input type='date' name='date'>
        <input type='submit' name='till_date' value='Until Date'>
      </form>
      <table>
        <tr>
          <th>Patient</th>
          <th>Date</th>
        </tr>
    ";

    while($each = mysqli_fetch_assoc($appointments_list)) {
      echo "
        <tr>
          <td><a href='appointments.php?patient_id=".$each['user_id']."'>".$each['f_name']." ".$each['l_name']."</a></td>
          <td>".$each['app_date']."</td>
        </tr>
      ";
    }
    echo "</table>";

  } else {
    header('Location: decline_access.php');
    exit();
  }
?>
  </body>
</html>
