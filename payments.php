<?php
    session_start();
    include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Payments</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <h1>Payments</h1>
        <?php
            $update_due = "UPDATE patients SET payment_due= payment_due+((CURDATE()-last_payment)*10), last_payment= CURDATE() WHERE last_payment < CURDATE();";
            $update= mysqli_query($conn, $update_due);
        ?>
        
        <form method='post'>
            <label for="patient_id">Patient ID</label>
            <input type="text" name="patient_id" required>
            <input type="submit" value="Check Patient" name="check_patient">
        </form>

        <?php
            if (isset($_POST['check_patient'])) {
                $patient_id = $_POST['patient_id'];
                $get_patient_name = "SELECT user_id, payment_due, last_payment FROM patients WHERE user_id = $patient_id;";
                $patient_name= mysqli_query($conn, $get_patient_name);
                $row = mysqli_fetch_assoc($patient_name);
            } elseif (isset($_POST['make_payment'])) {
                $total_due = $_POST['total_due'];
                $new_payment = $_POST['new_payment'];
                $patient_id = $_POST['patient_id'];
                if ($total_due - $new_payment >= 0) {
                    $get_payment = "UPDATE patients SET payment_due=$total_due - $new_payment WHERE user_id = $patient_id";
                    $payment= mysqli_query($conn, $get_payment);
                } else {
                    echo "You do not owe this much!";
                }
            }
        ?>
        
        <form method="post">
            <label for="patient_id">Patient ID</label>
            <input type="text" name="patient_id" value="<? echo $row['user_id'] ?? '' ?>" readonly>
            <label for="total_due">Total Due</label>
            <input type="text" name="total_due" value=" <? echo $row['payment_due'] ?? '' ?>" readonly>
            <label for="new_payment">New Payment</label>
            <input type="text" name="new_payment" required>
            <input type="submit" name="make_payment">
        </form>
        <p>$10 per day<br>$50 per appointment</p>

        <a href="./index.php">Go Back</a>
    </body>
</html>