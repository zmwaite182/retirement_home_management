<?php 
    session_start();
    if (ini_get('register_globals'))
{
    foreach ($_SESSION as $key=>$value)
    {
        if (isset($GLOBALS[$key]))
            unset($GLOBALS[$key]);
    }
}
    include_once 'db.php';
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
    <form method="post">
        <label for="email">Email</label>
        <input type="text" name="email" required>
        <label for="password">Password</label>
        <input type="text" name="password" required>
        <input type="submit" name="grant_access">
    </form>

    <?php
        if (isset($_POST['grant_access'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $correct_password = null;
            $get_pass = "SELECT user_id, user_password, job from users WHERE email = '$email';";
            $user_pass= mysqli_query($conn, $get_pass);
            while($row = mysqli_fetch_assoc($user_pass)) {
                if ($row) {
                    $user_id = $row['user_id'];
                    $correct_password = $row['user_password'];
                    $job = $row['job'];
                }
            }
            if ($correct_password == null) {
                echo '<p>Incorrect Email</p>';
            } elseif ($password == $correct_password) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['job'] = $job;
                header('Location: index.php');
                exit();
            } else {
                echo '<p>Incorrect Password</p>';
            }
        } 
    ?>

    <a href="./index.php">Cancel</a>
</body>
</html>