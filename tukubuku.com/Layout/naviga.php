<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>


<?php
$currentLocation = $_SERVER['REQUEST_URI'];

if (strpos($currentLocation, 'profile') !== false) {
    $signAddr = '../sign.php'; // Jika berada di dalam folder profile
} elseif (strpos($currentLocation, 'produk') !== false) {
    $signAddr = '../sign.php'; // Jika berada di dalam folder produk
} else {
    $signAddr = 'sign.php'; // Jika berada di luar folder profile dan produk
}
?>

<?php
$currentLocation = $_SERVER['REQUEST_URI'];

if (strpos($currentLocation, 'profile') !== false) {
    $accAddr = '#';
} elseif (strpos($currentLocation, 'orderstatus') !== false) {
    $accAddr = '#';
} else {
    $accAddr = 'profile/profile.php';
}
?>

<?php
$currentLocation = $_SERVER['REQUEST_URI'];

if (strpos($currentLocation, 'edit') !== false) {
    $cartAddr = '../../carts.php';
} elseif (strpos($currentLocation, 'orderstatus') !== false) {
    $cartAddr = '../../carts.php';
} elseif (strpos($currentLocation, 'profile') !== false) {
    $cartAddr = '../carts.php';
} else {
    $cartAddr = 'carts.php';
}
?>

<?php
$currentLocation = $_SERVER['REQUEST_URI'];

if (strpos($currentLocation, 'edit') !== false) {
    $connect = '../../connection/conn.php';
} elseif (strpos($currentLocation, 'orderstatus') !== false) {
    $connect = '../../connection/conn.php';
} elseif (strpos($currentLocation, 'profile') !== false) {
    $connect = '../connection/conn.php';
} else {
    $connect = 'connection/conn.php';
}
?>

<?php
$currentLocation = $_SERVER['REQUEST_URI'];

if (strpos($currentLocation, 'orderstatus') !== false || strpos($currentLocation, 'edit') !== false) {
    $homeAddr = '../../index.php';
} elseif (strpos($currentLocation, 'profile') !== false) {
    $homeAddr = '../index.php';
} else {
    $homeAddr = 'index.php';
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
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;

        &::selection {
            background-color: #800000;
            color: white;
        }
    }

    .nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 99;
        width: 100%;

        background: white;
        border-bottom: 5px solid #800000;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    }

    .nav .wrapper {
        position: relative;
        max-width: 1300px;
        padding: 0px 30px;
        height: 60px;
        line-height: 70px;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .nav .wrapper .logo a {
        color: #800000;
        font-size: 30px;
        font-weight: 600;
        text-decoration: none;
    }

    .nav .wrapper .nav-links {
        display: inline-flex;
    }

    .nav-links li {
        list-style: none;
    }

    .nav-links li a {
        color: #000;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        padding: 9px 15px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    /* .nav-links li a:hover{
    background: #800000;
    } */
    .nav-links .mobile-item {
        display: none;
    }

    .nav-links .drop-menu {
        margin-top: -6px;
        border-radius: 10px;
        position: absolute;
        background: white;
        width: 180px;
        line-height: 45px;
        top: 85px;
        opacity: 0;
        visibility: hidden;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    .nav-links li:hover .drop-menu {
        transition: all 0.3s ease;
        top: 70px;
        opacity: 1;
        visibility: visible;
    }

    .drop-menu li a {
        width: 100%;
        display: block;
        padding: 0 0 0 15px;
        font-weight: 400;
        border-radius: 0px;
    }

    .nav .wrapper .btn {
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        display: none;
    }

    .nav .wrapper .btn.close-btn {
        position: absolute;
        right: 30px;
        top: 10px;
    }

    .drop-menu li a:hover {
        background-color: #800000;
        color: white;
    }

    .drop-menu li:first-child a:hover {
        background-color: #800000;
        color: white;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
    }

    .drop-menu li:last-child a:hover {
        background-color: #800000;
        color: white;
        border-bottom-right-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    @media screen and (max-width: 1100px) {
        .wrapper .btn {
            color: #000;
            display: block;
        }

        .nav .wrapper .nav-links {
            position: fixed;
            height: 100vh;
            width: 100%;
            max-width: 350px;
            top: 0;
            left: -100%;
            background: #242526;
            display: block;
            padding: 50px 10px;
            line-height: 50px;
            overflow-y: auto;
            box-shadow: 0px 15px 15px rgba(0, 0, 0, 0.18);
            transition: all 0.3s ease;
        }

        /* custom scroll bar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #242526;
        }

        ::-webkit-scrollbar-thumb {
            background: #3A3B3C;
        }

        #menu-btn:checked~.nav-links {
            left: 0%;
        }

        #menu-btn:checked~.btn.menu-btn {
            display: none;
        }

        #close-btn:checked~.btn.menu-btn {
            display: block;
        }

        .nav-links li {
            margin: 15px 10px;
        }

        .nav-links li a {
            padding: 0 20px;
            display: block;
            font-size: 20px;
        }

        .nav-links .drop-menu {
            position: static;
            opacity: 1;
            top: 65px;
            visibility: visible;
            padding-left: 20px;
            width: 100%;
            max-height: 0px;
            overflow: hidden;
            box-shadow: none;
            transition: all 0.3s ease;
        }

        #showDrop:checked~.drop-menu,
        {
        max-height: 100%;
    }

    .nav-links .desktop-item {
        display: none;
    }

    .nav-links .mobile-item {
        display: block;
        color: #f2f2f2;
        font-size: 20px;
        font-weight: 500;
        padding-left: 20px;
        cursor: pointer;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .nav-links .mobile-item:hover {
        background: #3A3B3C;
    }

    .drop-menu li {
        margin: 0;
    }

    .drop-menu li a {
        border-radius: 5px;
        font-size: 18px;
    }

    .content .row .mega-links {
        border-left: 0px;
        padding-left: 15px;
    }

    .content .row header {
        font-size: 19px;
    }
    }

    .nav .wrapper input {
        display: none;
    }

    .underLiner {
        position: relative;
        color: #ecf0f1;
        text-decoration: none;
        transition: 0.5s;

        &::after {
            position: absolute;
            content: "";
            top: 100%;
            left: 0;
            width: 100%;
            height: 2px;
            background: #800000;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.3s;
            margin-top: 0px;
        }

        &:hover {
            color: #800000;
        }

        &:hover::after {
            transform: scaleX(1);
            transform-origin: center;
        }

        .search-form {
            display: flex;
            align-items: center;
            margin-right: auto;
            flex-grow: 1;
            padding: 10px !important;
        }

        .search-form input[type="text"] {
            height: auto;
            display: block;
            margin: 2px 0;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #800000;
            border-radius: 5px 0 0 5px;
            outline: none;
            flex-grow: 1;
        }

        .search-form button {
            background-color: #800000;
            color: white;
            border: none;
            padding: 12px 17px;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            font-size: 16px;
        }

        .search-form button:hover {
            background-color: #600000;
        }
    }

    .accBut {
        color: white !important;
        background-color: #800000;
        height: 1px !important;
    }

    .siu {
        border-radius: 100px !important;
        padding: 2px;
        color: white !important;
        background-color: #800000;
    }

    .siu:hover {
        transform: translateY(24px);
    }

    .fa-chevron-down {
        transform: translateY(2px);
        transition: all 0.3s ease;
    }

    li:hover .fa-chevron-down {
        transform: rotateX(180deg);
    }

    .fa-circle-user {
        height: 10px;
        width: 10px;
        padding-right: 32px;
    }

    .cartIcon .fa-cart-shopping {
        color: #800000;
        margin-right: 12px;
    }

    .search-form {
        display: flex;
        align-items: center;
        place-content: center;
        margin-right: auto;
        margin-left: 20px;
        flex-grow: 1;
    }

    .search-form input[type="text"] {
        max-width: 80%;
        max-height: 50px;
        display: block;
        margin: 2px 0;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-bottom: 2px solid #800000;
        outline: none;
        flex-grow: 1;
    }

    .search-form button {
        background-color: #800000;
        color: white;
        border: none;
        max-height: 50px;
        padding: 11px 16px;
        border-radius: 0 5px 5px 0px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .search-form button:hover {
        background-color: #600000;
    }

    .search-form button i {
        margin-right: 5px;
    }
</style>

<body>
    <nav class="nav">
        <div class="wrapper">
            <div class="logo">
                <a href="<?php echo $homeAddr; ?>"><i class="fa-solid fa-book-open-reader"></i> Tuku Buku</a>
            </div>
            <form action="search.php" method="get" class="search-form">
                <input type="text" name="query" placeholder="Cari judul buku..." required>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>

            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li>
                    <a class="underLiner" href="<?php echo $homeAddr; ?>">Beranda</a>
                </li>
                <!-- <li>
                    <a class="underLiner" href="#" class="desktop-item">Kategori
                        <i class="fa fa-chevron-down fa-xs"></i>
                    </a>
                    <input type="checkbox" id="showDrop">
                    <label for="showDrop" class="mobile-item">Kategori</label>
                    <ul class="drop-menu">
                        <li>
                            <a href="#">
                                <i class="fa fa-hand-o-right"></i>Fiksi
                            </a>
                        </li>
                        <li><a href="#">Non Fiksi</a></li>
                        <li><a href="#">Agama</a></li>
                        <li><a href="#">Bisnis</a></li>
                    </ul>
                </li> -->
                <li>
                    <a class="underLiner" href="about.php">Tentang Kami</a>
                </li>
                <li>
                    <a class="underLiner" href="contact.php">Hubungi Kami</a>
                </li>
                <?php if (!isset($_SESSION['username'])): ?>
                    <li>
                        <a class="siu" href="<?php echo $signAddr; ?>">
                            <i class="fa-solid fa-circle-user fa-xl"></i>
                            <span class="siu">Masuk ke Akun</span></a>
                    </li>
                <?php else: ?>
                    <li>
                        <a class="cartIcon" href="<?php echo $cartAddr ?>">
                            <i class="fa-solid fa-cart-shopping fa-xl"></i>
                        </a>
                    </li>
                    <li>
                        <a class="accBut" href="<?php echo $accAddr; ?>">
                            <i class="fa-solid fa-circle-user fa-xl"></i>
                            <i class="fa-solid fa-bars"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
        </div>
    </nav>
</body>

</html>