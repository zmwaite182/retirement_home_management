<?php
    session_start();
    include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Employees</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>

        <?php

        if (!isset($_SESSION['job'])) {
          header('Location: decline_access.php');
          exit();
        } elseif ($_SESSION['job'] == 'admin') {

            $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' and u.job <> 'family_member'";
            $employee_details= mysqli_query($conn, $get_employee_details);

            if (isset($_POST['search_employees_1'])) {
                $search_e = $_POST['search_e'];
                $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' AND u.job <> 'family_member' AND u.user_id = '$search_e';";
                $employee_details= mysqli_query($conn, $get_employee_details);
            } elseif (isset($_POST['search_employees_2'])) {
                $search_e = $_POST['search_e'];
                $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' AND u.job <> 'family_member' AND u.job = '$search_e';";
                $employee_details= mysqli_query($conn, $get_employee_details);
            } elseif (isset($_POST['search_employees_3'])) {
                $search_e = $_POST['search_e'];
                $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' AND u.job <> 'family_member' AND u.f_name = '$search_e';";
                $employee_details= mysqli_query($conn, $get_employee_details);
            } elseif (isset($_POST['search_employees_4'])) {
                $search_e = $_POST['search_e'];
                $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' AND u.job <> 'family_member' AND u.l_name = '$search_e';";
                $employee_details= mysqli_query($conn, $get_employee_details);
            } elseif (isset($_POST['search_employees_5'])) {
                $search_e = $_POST['search_e'];
                $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' AND u.job <> 'family_member' AND e.salary = '$search_e';";
                $employee_details= mysqli_query($conn, $get_employee_details);
            }

            echo "
                <h1>Employees</h1>
                <a href='./index.php'>Go Back</a>
                <a href='./employees.php'>View All</a>

                <table>
                    <tr>
                        <th>User Id</th>
                        <th>Role</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Salary</th>
                    </tr>
                    <tr>
                        <td>
                            <form method='post'>
                                <input type='text' name='search_e'>
                                <input type='submit' name='search_employees_1' value='Go'>
                            </form>
                        </td>
                        <td>
                            <form method='post'>
                                <input type='text' name='search_e'>
                                <input type='submit' name='search_employees_2' value='Go'>
                            </form>
                        </td>
                        <td>
                            <form method='post'>
                                <input type='text' name='search_e'>
                                <input type='submit' name='search_employees_3' value='Go'>
                            </form>
                        </td>
                        <td>
                            <form method='post'>
                                <input type='text' name='search_e'>
                                <input type='submit' name='search_employees_4' value='Go'>
                            </form>
                        </td>
                        <td>
                            <form method='post'>
                                <input type='text' name='search_e'>
                                <input type='submit' name='search_employees_5' value='Go'>
                            </form>
                        </td>
                    </tr>
            ";

            while($row = mysqli_fetch_assoc($employee_details)) {
                echo "
                    <tr>
                        <td>".$row['user_id']."</td>
                        <td>".$row['job']."</td>
                        <td>".$row['f_name']."</td>
                        <td>".$row['l_name']."</td>
                        <td>".$row['salary']."</td>
                    </tr>
                    ";
            }
            echo "</table>
                <form method='post'>
                    <label for='get_employee_id'>Employee ID:</label>
                    <input type='number' name='emp_id' required>
                    <label for='new_salary'>New Salary</label>
                    <input type='number' name='new_salary' required>
                    <input type='submit' name='update_salary' value='Update Salary'>
                </form>
                ";
            if (isset($_POST['update_salary'])) {
            $user_id = $_POST['emp_id'];
            $new_salary = $_POST['new_salary'];
            $check_id = "SELECT * FROM `employees` WHERE user_id = '$user_id';";
            $list_of_ids = mysqli_query($conn, $check_id);
            $resultCheck = mysqli_num_rows($list_of_ids);
            if($resultCheck>0) {
                $sql = "UPDATE `employees` SET salary = '$new_salary' WHERE user_id = '$user_id';";
                mysqli_query($conn, $sql);
                echo "<p>Salary Sucessfully Updated!</p>
                <a href='employees.php'>Refresh List</a>";
            } else {
                echo "<p>No employee with that ID exists</p>";
            }
            }
          } else {
            header('Location: decline_access.php');
            exit();
          }
        ?>
    </body>
</html>
