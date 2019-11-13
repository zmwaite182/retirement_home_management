<?php
    session_start();
    include_once 'db.php';

    $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' and u.job <> 'family_member'";
    $employee_details= mysqli_query($conn, $get_employee_details);

    if (isset($_POST['search_employees'])) {
        $search_e = $_POST['search_e'];
        $get_employee_details = "SELECT * FROM users u JOIN employees e ON u.user_id = e.user_id WHERE u.job <> 'patient' AND u.job <> 'family_member' AND u.user_id = '$search_e' OR u.job = '$search_e' OR u.f_name = '$search_e' OR u.l_name = '$search_e' OR e.salary = '$search_e' OR e.group_id = '$search_e';";
        $employee_details= mysqli_query($conn, $get_employee_details);
    }
    echo "
        </table>

        <h1>Employees</h1>
        <a href='./index.php'>Go Back</a>
        <a href='./employees.php'>View All</a>
        <form method='post'>
            <input type='text' name='search_e'>
            <input type='submit' name='search_employees' value='Search Employees'>
        </form>
    ";

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