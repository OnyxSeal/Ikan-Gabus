<?php
// Start session if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: ../../sign.php');
    exit;
}

include "../../connection/conn.php";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM user WHERE (username = '$username' OR email = '$username')";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $fullname = $row['fullname'];
        $pp = $row['avatar'];
    } else {
        $fullname = "";
        $pp = "default_profile.png";
    }
} else {
    $fullname = "";
    $pp = "default_profile.png";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../order-stat.css">
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
</head>

<style>
    .order-status {
        display: flex;
        padding-top: 10px;
    }

    .step {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .step.active:before {
        content: '';
        width: 100%;
        height: 3px;
        background-color: #007bff;
        position: absolute;
        top: 100%;
        left: 0;
    }

    .statText {
        z-index: 1;
    }

    .fa-wallet {
        height: 10px;
        width: 10px;
    }

    .setText {
        transition: all 0.2s ease-in-out;

        &:hover {
            margin-left: 3px;
        }
    }

    .step a {
        line-height: 10px;
    }
</style>

<body>
    <?php include "../../layout/naviga.php" ?>
    <div class="contolner">
        <div class="content">
            <div class="ngotak">
                <?php include "../prf-ls.php" ?>
                <div class="rightSide">
                    <div class="titBox">
                        <p>Status Pesanan</p>
                    </div>
                    <div class="detBox">
                        <div style="text-align: justify;">
                            <span>Perubahan status pesanan kamu, diupdate secara berkala</span>
                            <div class="order-status">
                                <div class="step <?= $orderStatus >= 1 ? 'active' : '' ?>">
                                    <a href="<?php echo $blmAddr ?>">
                                        <i class="fa-solid fa-wallet fa-lg"></i><br>
                                        <span class="statText">Belum Bayar</span>
                                    </a>
                                </div>
                                <div class="step <?= $orderStatus >= 2 ? 'active' : '' ?>">
                                    <a href="">
                                        <i class="fa-solid fa-boxes-packing fa-lg"></i><br>
                                        <span>Dikemas</span>
                                    </a>
                                </div>
                                <div class="step <?= $orderStatus >= 3 ? 'active' : '' ?>">
                                    <a href="">
                                        <i class="fa-solid fa-truck fa-lg"></i><br>
                                        <span>Dikirim</span>
                                    </a>
                                </div>
                                <div class="step <?= $orderStatus >= 4 ? 'active' : '' ?>">
                                    <a href="">
                                        <i class="fa-solid fa-square-check fa-lg"></i><br>
                                        <span>Selesai</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="belumDibayar" class="titBox">
                        <p>Edit Profil</p>
                    </div>
                    <div id="belumDibayar" class="detBox">
                        <div style="text-align: justify;">
                            <span>Cupcake ipsum dolor sit amet sweet tiramisu sesame snaps. Wafer jujubes danish biscuit
                                cupcake
                                croissant caramels muffin. Jelly-o candy canes cake chupa chups candy canes pudding.
                                Tootsie roll
                                jujubes pie sweet wafer. Macaroon brownie danish. Sweet roll marshmallow danish pie
                                cookie ice
                                cream. Halvah jelly beans chocolate bar gingerbread apple pie chocolate cake macaroon
                                danish.</span>
                        </div>
                        <ul>
                            <li class="detBut">
                                <a class="setLinks" href="#">
                                    <i class="fa-solid fa-circle-user fa-lg"></i>
                                    <span>Data Pribadi</span>
                                </a>
                            </li>
                            <li class="detBut">
                                <a class="setLinks" href="#">
                                    <i class="fa-solid fa-address-book fa-lg"></i>
                                    <span>Kontak Pribadi</span>
                                </a>
                            </li>
                            <li class="detBut">
                                <a class="setLinks" href="#">
                                    <i class="fa-solid fa-user-group fa-lg"></i>
                                    <span>Akun Media Sosial</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include "../../layout/footer.php" ?>

</html>