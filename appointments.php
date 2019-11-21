<?php
    session_start();
    include_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Appointments for Patient</title>
</head>
<body>
    <?php
        // Change these to dynamic
        // $doctor_id = 6;
        // $patient_id = 8;
        $current_date = date('Y-m-d');
        $get_appointments = "SELECT u.f_name, u.l_name, a.app_date, a.comment, a.morning_med, a.afternoon_med, a.night_med FROM users u JOIN appointments a ON u.user_id = a.patient_user_id WHERE a.doctor_id = '$doctor_id' AND a.patient_user_id = '$patient_id';";
        $appointments_list= mysqli_query($conn, $get_appointments);    

        echo "
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

        if ($today) {
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
                    <input type='submit' name='add_prescription'>
                </form>
            ";
        }

        if (isset($_POST['add_prescription'])) {
            $comment = $_POST['comment'];
            $morning_med = $_POST['morning_med'];
            $afternoon_med = $_POST['afternoon_med'];
            $night_med = $_POST['night_med'];
      
            $sql = "UPDATE appointments SET comment='$comment', morning_med='$morning_med', afternoon_med='$afternoon_med', night_med='$night_med' WHERE app_date='$current_date' AND patient_user_id=$patient_id AND doctor_id=$doctor_id;";
            mysqli_query($conn, $sql);
        }

    ?>
</body>
</html>