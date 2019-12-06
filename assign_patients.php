<?php
    session_start();
    include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Patients</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
    <body>
        <h1>Assign Patients</h1>
        <?php
            if (!isset($_SESSION['job'])) {
                header('Location: decline_access.php');
                exit();
            } else {
        ?>
            <form method="post">
                <label for="patient_id">User ID</label>
                <input type="text" name="patient_id" value="<? echo $_POST['patient_id'] ?? ''; ?>"required>
                <input type="submit" name="check_patient">
            </form>

            <?php
                if (isset($_POST['check_patient'])) {
                    $patient_id = $_POST['patient_id'];
                      $get_patient_name = "SELECT u.f_name, u.l_name FROM users u JOIN patients p ON u.user_id = p.user_id WHERE p.user_id = $patient_id;";
                      $patient_name= mysqli_query($conn, $get_patient_name);
                      $row = mysqli_fetch_assoc($patient_name);
                      if ($row['f_name']) {

                      echo "
                          <p>Patient Name: ".$row['f_name']." ".$row['l_name']."</p>
                          <form method='post'>
                              <label for='patient_id'>User ID</label>
                              <input type='text' name='patient_id' value='$patient_id'required readonly>
                              <label for='group'>Group</label>
                              <input type='number' name='group' min='1' max='4' required>
                              <label for='admission_date'>Admission Date</label>
                              <input type='date' name='admission_date' required>
                              <input type='submit' value='Make Changes' name='add_patient_info'>
                          </form>
                      ";
                  } else {
                    echo"<p>Invalid User Id</p>";
                  }
              }
              elseif (isset($_POST['add_patient_info'])) {

                 $patient_id = $_POST['patient_id'];
                 $group = $_POST['group'];
                 $admission_date = $_POST['admission_date'];

                 $sql = "UPDATE patients SET group_id= $group, admission_date= '$admission_date' WHERE user_id = $patient_id;";
                 mysqli_query($conn, $sql);
             }
            }

        ?>

        <a href="./index.php">Go Back</a>
    </body>
</html>
