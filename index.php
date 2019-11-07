<?php
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

    } elseif ($_SESSION['job'] == 'doctor') {

    } elseif ($_SESSION['job'] == 'caregiver') {

    } elseif ($_SESSION['job'] == 'supervisor') {
        
    }
?>
    <button name="<?php session_unset(); ?>">UNSET</button>
</body>
</html>