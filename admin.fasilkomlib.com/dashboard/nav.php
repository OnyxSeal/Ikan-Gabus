<?php
// Mulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Koneksi ke database
include "../connection/conn.php";

$username = "";
$fullname = "[Nama Pengguna]";
$pp = "default_profile.png";
$pos = "user position";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM admin WHERE (usradm = '$username' OR email = '$username')";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $fullname = $row['fullname'];
        $pp = $row['profile_picture'];
        $pos = $row['position'];
    }
}
?>

<?php
$currentLocation = $_SERVER['REQUEST_URI'];
// gambar
if (strpos($currentLocation, 'edit') !== false || strpos($currentLocation, 'orderstatus') !== false) {
    $ppurl = '../../image/profile/';
} else if (strpos($currentLocation, 'dashboard') !== false) {
    $ppurl = '../image/profile/';
} else {
    $ppurl = 'image/profile/';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
        font-family: Poppins;
        background-color: #EDEDED;
    }

    nav {
        top: 0;
        left: 0;
        right: 0;
        background-color: white;
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
    }

    .title {
        text-align: center;
        color: #800000;
        font-size: 24px;
        font-weight: 600;
    }

    .profileSeller {
        position: absolute;
        right: 20px;
    }
</style>

<body>
    <nav>
        <div class="title">
            <i class="fa fa-book-open-reader"></i>
            <span>FasilkomLib</span>
        </div>
        <div class="profileSeller">
            <i class="fa fa-user-circle fa-lg"></i>
            <span><?php echo $fullname ?></span>
        </div>
    </nav>
</body>

</html>