<?php
  session_start();
  include_once 'db.php';

  if (!isset($_SESSION['job'])) {
    header('Location: decline_access.php');
    exit();
  } elseif ($_SESSION['job'] == 'admin') {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Approval</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <table>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Yes</th>
            <th>No</th>
        </tr>
        <?php
            if (isset($_GET['check_id']) && isset($_GET['approval']) && isset($_GET['job'])) {
                $current_user = $_GET['check_id'];
                $new_approval = $_GET['approval'];
                $job = $_GET['job'];

                $update_approval_query = "UPDATE `users` SET reg_approval = $new_approval WHERE user_id = $current_user";
                $update_approval= mysqli_query($conn, $update_approval_query);

                if ($new_approval == 0) {
                    echo "User Removed!";
                    if ($job == 'patient') {
                        $delete_patients_query = "DELETE FROM patients WHERE user_id = $current_user";
                        $delete_patients= mysqli_query($conn, $delete_patients_query);
                    } elseif ($job != 'patient' && $job != 'family_member') {
                        $delete_employees_query = "DELETE FROM employees WHERE user_id = $current_user";
                        $delete_employees= mysqli_query($conn, $delete_employees_query);
                    }
                    $delete_users_query = "DELETE FROM users WHERE user_id = $current_user";
                    $delete_users= mysqli_query($conn, $delete_users_query);
                } elseif ($new_approval == 1) {
                    echo 'User Added!';
                }
            }

            $get_users = "SELECT * FROM `users` WHERE reg_approval = 2;";
            $users= mysqli_query($conn, $get_users);

            while($row = mysqli_fetch_assoc($users)) {
                $user_id = $row['user_id'];
                $job = $row['job'];
                echo "
                    <tr>
                        <td>".$row['f_name']." ".$row['l_name']."</td>
                        <td>".$row['job']."</td>
                        <td><a href='reg_approval.php?check_id=$user_id&approval=1&job=$job'>&#x2713</a></td>
                        <td><a href='reg_approval.php?check_id=$user_id&approval=0&job=$job'>X</a></td>
                    </tr>
                ";
            }
          } else {
            header('Location: decline_access.php');
            exit();
          }
        ?>
    </table>
    <a href="./index.php">Go Back</a>
</body>
</html>
