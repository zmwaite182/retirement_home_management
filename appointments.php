<?php
    session_start();
    include_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointments for Patient</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
        $doctor_id = $_SESSION['user_id'];
        $patient_id = $_GET['patient_id'];
        $current_date = date('Y-m-d');

        if (isset($_POST['add_prescription'])) {
            $comment = $_POST['comment'];
            $morning_med = $_POST['morning_med'];
            $afternoon_med = $_POST['afternoon_med'];
            $night_med = $_POST['night_med'];

            $check_confirmation = "SELECT confirm_appt FROM appointments WHERE app_date='$current_date' AND patient_user_id=$patient_id AND doctor_id=$doctor_id";
            $confirm = mysqli_query($conn, $check_confirmation);
            $each = mysqli_fetch_assoc($confirm);

            if (!$each['confirm_appt']) {
                $update_due = "UPDATE patients SET payment_due= payment_due+50 WHERE user_id=$patient_id;";
                $update= mysqli_query($conn, $update_due);
        
                $add_prescription = "UPDATE appointments SET comment='$comment', morning_med='$morning_med', afternoon_med='$afternoon_med', night_med='$night_med', confirm_appt=1 WHERE app_date='$current_date' AND patient_user_id=$patient_id AND doctor_id=$doctor_id;";
                mysqli_query($conn, $add_prescription);
            }
        }

        $get_appointments = "SELECT u.f_name, u.l_name, a.app_date, a.comment, a.morning_med, a.afternoon_med, a.night_med, a.confirm_appt FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE a.doctor_id = '$doctor_id' AND a.patient_user_id = '$patient_id';";
        $appointments_list= mysqli_query($conn, $get_appointments);  
        $row = mysqli_fetch_assoc($appointments_list);

        echo "
            <h1>".$row['f_name']." ".$row['l_name']." Appointments</h1>
            <a href='./index.php'>Go Back</a>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Comment</th>
                    <th>Morning Med</th>
                    <th>Afternoon Med</th>
                    <th>Night Med</th>
                </tr>
        ";
        
        $today = false;
        while($row = mysqli_fetch_assoc($appointments_list)) {
            if ($row['app_date'] == $current_date) {
                $today = true;
                $had_appt = $row['confirm_appt'];
            }
            echo "
              <tr>
                <td>".$row['app_date']."</td>
                <td>".$row['comment']."</td>
                <td>".$row['morning_med']."</td>
                <td>".$row['afternoon_med']."</td>
                <td>".$row['night_med']."</td>
              </tr>
            ";
          }
        echo "</table>";

        

        if ($today && !$had_appt) {
            echo"
                <h2>Add Prescription</h2>
                <form method='post'>
                    <label for='comment'>Comment</label>
                    <input type='text' name='comment'>
                    <label for='morning_med'>Morning Medication</label>
                    <input type='text' name='morning_med'>
                    <label for='afternoon_med'>Afternoon Medication</label>
                    <input type='text' name='afternoon_med'>                
                    <label for='night_med'>Night Medication</label>
                    <input type='text' name='night_med'>
                    <input type='submit' name='add_prescription' value='Confirm Appointment'>
                </form>
            ";
        } else {
            echo"
                <p>No appointment today</p>
            ";
        }
    ?>
</body>
</html>