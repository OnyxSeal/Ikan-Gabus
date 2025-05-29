<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: ../sign.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <?php include "../layout/naviga.php" ?>
    <div class="contolner">
        <div class="content">
            <di class="ngotak">
                <?php include "prf-ls.php" ?>
                <?php include "prf-rs.php" ?>
            </div>
        </div>
    </div>
</body>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include "../layout/footer.php" ?>
</html>