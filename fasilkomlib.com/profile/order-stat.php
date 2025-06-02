<?php
$currentLocation = $_SERVER['REQUEST_URI'];

if (strpos($currentLocation, 'order-stat') !== false) {
    $orderAddr = '../order-stat.php';
} elseif (strpos($currentLocation, 'produk') !== false) {
    $orderAddr = '../order-stat.php';
} else {
    $orderAddr = 'order-stat.php';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="order-stat.css">
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
</head>

<body>
    <?php include "../layout/naviga.php" ?>
    <div class="contolner">
        <div class="content">
            <di class="ngotak">
                <?php include "prf-ls.php" ?>
                <?php include "order-rs.php" ?>
        </div>
    </div>
    </div>
</body>
<?php include "../layout/footer.php" ?>

</html>