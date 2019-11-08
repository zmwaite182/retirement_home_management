<?php
  include_once 'db.php';
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

  <form action="" method="post">
    <select name="role_selection">
      <option value="none">Select Role</option>
      <option value="patient">Patient</option>
      <option value="family_member">Family Member</option>
      <option value="supervisor">Supervisor</option>
      <option value="caregiver">Care Giver</option>
      <option value="doctor">Doctor</option>
    </select>

    <input type="text" name="f_name" placeholder="First Name">
    <input type="text" name="l_name" placeholder="Last Name">
    <input type="email" name="email" placeholder="Email">
    <input type="tel" name="phone" placeholder="Phone Number">
    <input type="text" name="password" placeholder="Password">
    <input type="date" name="birth" placeholder="Date of Birth">
    <input type="submit" name="create_acc" value="Submit"/>
  </form>

  <?php

    if (isset($_POST['create_acc'])) {
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $password = $_POST['password'];
      $birth = $_POST['birth'];
      $role = $_POST['role_selection'];

      $sql = "INSERT INTO `users` (job, f_name, l_name, email, phone, user_password, dob) VALUES ('$role', '$f_name', '$l_name', '$email', '$phone', '$password', '$birth');";
      mysqli_query($conn, $sql);

      $get_id = "SELECT user_id FROM users WHERE email = '$email';";
      $user_id= mysqli_query($conn, $get_id);
      while($row = mysqli_fetch_assoc($user_id)) {
          $_SESSION['user_id'] = $row['user_id'];
      }

      if ($role == "patient") {
        echo
        "<form action='' method='post'>
          <input type='text' name='fam_code' placeholder='Family Code'>
          <input type='text' name='emergency_contact' placeholder='Emergency Contact'>
          <input type='text' name='relation' placeholder='Relation to Contact'>
          <input type='submit' name='add_info' value='Submit'/>
        </form>";
      } elseif ($role != "patient" || $role != "family_member") {
        $user_id = $_SESSION['user_id'];
        echo $user_id;
        $sql = "INSERT INTO `employees` (user_id, f_name, l_name, job) VALUES ('$user_id', '$f_name', '$l_name', '$role');";
        mysqli_query($conn, $sql);
      }
    }
    if (isset($_POST['add_info'])) {
      $fam_code = $_POST['fam_code'];
      $emergency_contact = $_POST['emergency_contact'];
      $relation = $_POST['relation'];
      $user_id = $_SESSION['user_id'];

      $sql = "INSERT INTO `patients` (user_id, family_code, emergency_contact, relation_ec) VALUES ('$user_id', '$fam_code', '$emergency_contact', '$relation');";
      mysqli_query($conn, $sql);
    }
  ?>
<a href="./index.php">Cancel</a>

</body>
</html>
