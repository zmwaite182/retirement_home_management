<?php
    include_once 'db.php';
    session_start();
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
        echo "</table>";

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

    } elseif ($_SESSION['job'] == 'doctor') {

    } elseif ($_SESSION['job'] == 'caregiver') {

    } elseif ($_SESSION['job'] == 'supervisor') {

    }
?>
    <button name="<?php session_unset(); ?>">UNSET</button>
</body>
</html>
