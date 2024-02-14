<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirect Page</title>
</head>
<body>
    <form method="post">
        <button type="submit" name="redirect">Go to Main Page</button>
    </form>

    <?php
    if (isset($_POST['redirect'])) {
        header('Location: main.php');
        exit();
    }
    ?>
</body>
</html>
