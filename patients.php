<?php 
  session_start();
  include_once 'db.php';

  $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient'";
  $patient_details= mysqli_query($conn, $get_patient_details);

  if (isset($_POST['search_patients'])) {
      $search_p = $_POST['search_p'];
      $get_patient_details = "SELECT * FROM users u JOIN patients p ON u.user_id = p.user_id WHERE u.job = 'patient' AND u.f_name = '$search_p' OR u.l_name = '$search_p' OR u.dob = '$search_p' OR p.emergency_contact = '$search_p' OR p.relation_ec = '$search_p' OR p.admission_date = '$search_p';";
      $patient_details= mysqli_query($conn, $get_patient_details);

  }

      echo "
        <h1>Patients</h1>
        <a href='./index.php'>Go Back</a>
        <a href='./patients.php'>View All</a>
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
?>