<?php

$orderStatus = "";

switch ($orderStatus) {
    case "belum-bayar":
        $orderStatus = 1;
        break;
    case "dikemas":
        $orderStatus = 2;
        break;
    case "dikirim":
        $orderStatus = 3;
        break;
    case "selesai":
        $orderStatus = 4;
        break;
    default:
        $orderStatus = "";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
    <link rel="stylesheet" href="order-stat.css">
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
    <div class="rightSide">
        <div class="titBox">
            <p>Status Pesanan</p>
        </div>
        <div class="detBox">
            <div style="text-align: justify;">
                <span>Perubahan status pesanan kamu, diupdate secara berkala</span>
                <div class="order-status">
                    <div class="step <?= $orderStatus >= 1 ? 'active' : '' ?>">
                        <a href="orderstatus/blmdbyr.php">
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
    </div>
</body>

</html>