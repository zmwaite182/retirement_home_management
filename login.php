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
        <input type="submit" name="login">
    </form>
    <form action="index.php" method="post">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>