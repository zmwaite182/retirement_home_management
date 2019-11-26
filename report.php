<?php
    session_start();
    include_once 'db.php';
?>
   
<h1>Admin's Report</h1>
<a href='./index.php'>Go Back</a>
<a href='./report.php'>View All</a>

<form method='post'>
    <input type='date' name='search_roster'>
    <input type='submit' name='search_r' value='Search'>
</form>

<table>
    <tr>
        <th>Patient's Name</th>
        <th>Doctor's Name</th>
        <th>Doctor's Appointment</th>
        <th>Caregiver's Name</th>
        <th>Morning Medicine</th>
        <th>Afternoon Medicine</th>
        <th>Night Medicine</th>
        <th>Breakfast</th>
        <th>Lunch</th>
        <th>Dinner</th>
    </tr>

<?php

    if(isset($_POST['search_r'])) {
        $display_date = $_POST['search_roster'];
    } else {
        $display_date = date("Y-m-d");
    }

    if (!isset($_SESSION['job'])) {
        header('Location: decline_access.php');
        exit();
      } elseif ($_SESSION['job'] != 'admin') {
        header('Location: decline_access.php');
        exit();
      } else {
        $get_appt = "SELECT a.confirm_appt FROM appointments a JOIN users u ON a.patient_user_id=u.user_id WHERE app_date = '$display_date';";
        $appt_details = mysqli_query($conn, $get_appt);
        $appt = mysqli_fetch_assoc($appt_details);

        $get_dr = "SELECT f_name, l_name FROM users WHERE user_id IN (SELECT a.doctor_id FROM appointments a JOIN users u ON a.patient_user_id=u.user_id WHERE app_date=CURDATE());";
        $dr_details = mysqli_query($conn, $get_dr);
        $doctor = mysqli_fetch_assoc($dr_details);

        $get_activities = "SELECT * FROM activities a JOIN users u ON a.patient_id = u.user_id;";
        $activity_details = mysqli_query($conn, $get_activities);
        $activity = mysqli_fetch_assoc($activity_details);

        $get_patient = "SELECT u.f_name, u.l_name, p.group_id FROM patients p JOIN users u ON p.user_id=u.user_id;";
        $patient_details= mysqli_query($conn, $get_patient);
        while($patient = mysqli_fetch_assoc($patient_details)) {
            if ($patient['group_id'] == 1) {
                $get_caregiver = "SELECT u.f_name, u.l_name FROM users u JOIN rosters r ON u.user_id = r.care_giver_1 WHERE r.roster_date = '$display_date';";
            } elseif ($patient['group_id'] == 2) {
                $get_caregiver = "SELECT u.f_name, u.l_name FROM users u JOIN rosters r ON u.user_id = r.care_giver_2 WHERE r.roster_date = '$display_date';";
            } elseif ($patient['group_id'] == 3) {
                $get_caregiver = "SELECT u.f_name, u.l_name FROM users u JOIN rosters r ON u.user_id = r.care_giver_3 WHERE r.roster_date = '$display_date';";
            } elseif ($patient['group_id'] == 4) {
                $get_caregiver = "SELECT u.f_name, u.l_name FROM users u JOIN rosters r ON u.user_id = r.care_giver_4 WHERE r.roster_date = '$display_date';";
            }
            $caregiver_details= mysqli_query($conn, $get_caregiver);
            $caregiver = mysqli_fetch_assoc($caregiver_details);
            
            echo "
                <tr>
                    <td>".$patient['f_name']." ".$patient['l_name']."</td>
                    <td>".$doctor['f_name']." ".$doctor['l_name']."</td>
                    <td>".$appt['confirm_appt']."</td>
                    <td>".$caregiver['f_name']." ".$caregiver['l_name']."</td>
                    <td>".$activity['morning_med']."</td>
                    <td>".$activity['afternoon_med']."</td>
                    <td>".$activity['night_med']."</td>
                    <td>".$activity['breakfast']."</td>
                    <td>".$activity['lunch']."</td>
                    <td>".$activity['dinner']."</td>
                </tr>
            ";
        }

        
        echo "</table>";
    }

?>
