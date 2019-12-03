<?php
    session_start();
    include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php
  $sql = "SELECT job FROM `roles`;";
  $list_of_roles = mysqli_query($conn, $sql);
  echo "
  <form method='post'>";
?>
  <label for="role_selection">
    Select Role: <select name='role_selection' onchange='checkPatient(this);' required>
      <?php
            while($row = mysqli_fetch_assoc($list_of_roles)) {
              echo"<option value='".$row['job']."'>".$row['job']."</option>";
            }
      ?>
    </select>
  </label>
  <label for="f_name">
    First Name: <input type="text" name="f_name" required>
  </label>
  <label for="l_name">
    Last Name: <input type="text" name="l_name" required>
  </label>
  <label for="email">
    Email: <input type="email" name="email" required>
  </label>
  <label for="phone">
    Phone Number: <input type="rel" name="phone" required>
  </label>
  <label for="password">
    Password: <input type="password" name="password" required>
  </label>
  <label for='dob'>
    Enter Date of Birth: <input type="date" name="birth" placeholder="Date of Birth" required>
  </label>
  <script>
      const checkPatient = (select) => {
          if (select.value == "patient") {
              document.getElementById('patientInfo').style.display = "block";
          } else {
              document.getElementById('patientInfo').style.display = "none";
          }
      }
  </script>
  <div id="patientInfo" style="display: none;">
      <input type='text' name='fam_code' placeholder='Family Code'>
      <input type='text' name='emergency_contact' placeholder='Emergency Contact'>
      <input type='text' name='relation' placeholder='Relation to Contact'>
  </div>

  <input type="submit" name="create_acc" value="Submit"/>
  </form>

  <?php

    if (isset($_POST['create_acc'])) {
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $password = $_POST['password'];
      $hash_pass = password_hash($password, PASSWORD_DEFAULT);
      $birth = $_POST['birth'];
      $role = $_POST['role_selection'];

      $sql = "INSERT INTO `users` (job, f_name, l_name, email, phone, user_password, dob, reg_approval) VALUES ('$role', '$f_name', '$l_name', '$email', '$phone', '$hash_pass', '$birth', 2);";
      mysqli_query($conn, $sql);

      $get_id = "SELECT user_id FROM users WHERE email = '$email';";
      $user_id= mysqli_query($conn, $get_id);
      while($row = mysqli_fetch_assoc($user_id)) {
          $_SESSION['user_id'] = $row['user_id'];
      }
      $user_id = $_SESSION['user_id'];

      if ($role == "patient") {
        $fam_code = $_POST['fam_code'];
        $emergency_contact = $_POST['emergency_contact'];
        $relation = $_POST['relation'];
        $sql = "INSERT INTO `patients` (user_id, family_code, emergency_contact, relation_ec) VALUES ('$user_id', '$fam_code', '$emergency_contact', '$relation');";
        mysqli_query($conn, $sql);

      } elseif ($role != "patient" || $role != "family_member") {
        $sql = "INSERT INTO `employees` (user_id) VALUES ('$user_id');";
        mysqli_query($conn, $sql);
      }
      header('Location: index.php');
    }
  ?>
<a href="./index.php" class='go_back'>Go Back</a>

</body>
</html>
