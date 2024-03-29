<?php
  session_start();
  include_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add Role</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
  </head>
  <body>
<?php
  if (!isset($_SESSION['job'])) {
    header('Location: decline_access.php');
    exit();
  } elseif ($_SESSION['job'] != 'admin') {
    header('Location: decline_access.php');
    exit();
  } else {

    $get_roles = "SELECT * FROM `roles`;";
    $list_of_roles = mysqli_query($conn, $get_roles);
    echo "
      <h1>Add Role</h1>
      <a href='./index.php'>Go Back</a>
      <a href='add_role.php'>Refresh List</a>
      <table>
          <tr>
              <th>Role</th>
              <th>Access Level</th>
          </tr>
    ";
    while($row = mysqli_fetch_assoc($list_of_roles)) {
      echo "<tr><td>".$row['job']."</td> <td>".$row['access_level']."</td></tr>";
    }
    echo "</table>
    <form method='post'>
        <label for='new role'>Add Role:</label>
        <input type='text' name='add_role' required>
        <label for='access_level'>Access Level:</label>
        <input type='number' name='access_level' required>
        <input type='submit' name='new_role' value='Insert'>
    </form>
    ";

    if (isset($_POST['new_role'])) {
      $check_role = 0;
      $new_job = $_POST['add_role'];
      $get_roles = "SELECT * FROM `roles`;";
      $list_of_roles = mysqli_query($conn, $get_roles);
      while($row = mysqli_fetch_assoc($list_of_roles)) {
        if ($row['job'] == $new_job) {
          $check_role += 1;
        }
      }
      if ($check_role > 0){
        echo "<p>Role Already Exists</p>";
      } else {
        $new_access_lvl = $_POST['access_level'];
        $sql = "INSERT INTO `roles` (job, access_level) VALUES ('$new_job', '$new_access_lvl');";
        mysqli_query($conn, $sql);
        echo "<p>Role Sucessfully Added!</p>";
      }
    }
  }
 ?>

  </body>
</html>
