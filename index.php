<?php
    session_start();
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
    echo "<h1>Admin's Home</h1>";
    echo "<a href='./patients.php'>View patients</a>";
    echo "<a href='./employees.php'>View employees</a>";
    echo "<a href='roster.php'>Create Roster</a>";
    echo "<a href='reg_approval.php'>Registration Approval</a>";

  } elseif ($_SESSION['job'] == 'doctor') {

  } elseif ($_SESSION['job'] == 'caregiver') {

  } elseif ($_SESSION['job'] == 'supervisor') {
    echo "<a href='roster.php'>Create Roster</a>";
  }

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

?>
</body>
</html>
