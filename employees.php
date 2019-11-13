<?php
    session_start();
    include_once 'db.php';

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
    } elseif (isset($_POST['search_employees_6'])) {
        $search_e = $_POST['search_e'];
        $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' AND u.job <> 'family_member' AND u.group_id = '$search_e';";
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
                <th>Group</th>
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
                <td>
                    <form method='post'>
                        <input type='text' name='search_e'>
                        <input type='submit' name='search_employees_6' value='Go'>
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
                <td>".$row['group_id']."</td>
            </tr>
            ";
    }
    echo "</table>";
?>