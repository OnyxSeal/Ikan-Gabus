<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "../connection/conn.php";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM admin WHERE (usradm = '$username' OR email = '$username')";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $fullname = $row['fullname'];
        $pp = $row['profile_picture'];
        $pos = $row['position'];
    } else {
        $fullname = "";
        $pp = "default_profile.png";
        $pos = "user position";
    }
} else {
    $fullname = "[User Name]";
    $pp = "default_profile.png";
    $pos = "[User Position]";
}
?>

<?php
$currentLocation = $_SERVER['REQUEST_URI'];
// gambarr
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
    <title>Sidebar</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

    :root {
        --color-default: #800000;
        --color-second: #C40000;
        --color-white: #fff;
        --color-body: #e4e9f7;
        --color-light: #e0e0e0;
    }


    * {
        padding: 0%;
        margin: 0%;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        min-height: 100vh;
    }

    .sidebar {
        min-height: 100vh;
        width: 78px;
        padding: 6px 14px;
        z-index: 99;
        background-color: var(--color-default);
        transition: all .5s ease;
        position: fixed;
        top: 0;
        left: 0;
    }

    .sidebar.open {
        width: 240px;
    }

    .sidebar .logo_details {
        height: 60px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .sidebar .logo_details .icon {
        opacity: 0;
        transition: all 0.5s ease;
    }



    .sidebar .logo_details .logo_name {
        color: var(--color-white);
        font-size: 22px;
        font-weight: 600;
        opacity: 0;
        transition: all .5s ease;
    }

    .sidebar.open .logo_details .icon,
    .sidebar.open .logo_details .logo_name {
        opacity: 1;
    }

    .sidebar .logo_details #btn {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        font-size: 23px;
        text-align: center;
        cursor: pointer;
        transition: all .5s ease;
    }

    .sidebar.open .logo_details #btn {
        text-align: right;
    }

    .sidebar i {
        color: var(--color-white);
        height: 60px;
        line-height: 60px;
        min-width: 50px;
        font-size: 25px;
        text-align: center;
    }

    .sidebar .nav-list {
        margin-top: 20px;
        height: 100%;
    }

    .sidebar li {
        position: relative;
        margin: 8px 0;
        list-style: none;
    }

    .sidebar li .tooltip {
        position: absolute;
        top: -20px;
        left: calc(100% + 15px);
        z-index: 3;
        background-color: var(--color-white);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        padding: 6px 14px;
        font-size: 15px;
        font-weight: 400;
        border-radius: 5px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
    }

    .sidebar li:hover .tooltip {
        opacity: 1;
        pointer-events: auto;
        transition: all 0.4s ease;
        top: 50%;
        transform: translateY(-50%);
    }

    .sidebar.open li .tooltip {
        display: none;
    }

    .sidebar input {
        font-size: 15px;
        color: var(--color-white);
        font-weight: 400;
        outline: none;
        height: 35px;
        width: 35px;
        border: none;
        border-radius: 5px;
        background-color: var(--color-second);
        transition: all .5s ease;
    }

    .sidebar input::placeholder {
        color: var(--color-light)
    }

    .sidebar.open input {
        width: 100%;
        padding: 0 20px 0 50px;
    }

    .sidebar li a {
        display: flex;
        height: 100%;
        width: 100%;
        align-items: center;
        text-decoration: none;
        background-color: var(--color-default);
        position: relative;
        transition: all .5s ease;
        z-index: 12;
    }

    .sidebar li a::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        transform: scaleX(0);
        background-color: var(--color-white);
        border-radius: 5px;
        transition: transform 0.3s ease-in-out;
        transform-origin: left;
        z-index: -2;
    }

    .sidebar li a:hover::after {
        transform: scaleX(1);
        color: var(--color-default)
    }

    .sidebar li a .link_name {
        color: var(--color-white);
        font-size: 15px;
        font-weight: 400;
        white-space: nowrap;
        pointer-events: auto;
        transition: all 0.4s ease;
        pointer-events: none;
        opacity: 0;
    }

    .sidebar li a:hover .link_name,
    .sidebar li a:hover i {
        transition: all 0.5s ease;
        color: var(--color-default)
    }

    .sidebar.open li a .link_name {
        opacity: 1;
        pointer-events: auto;
    }

    .sidebar li i {
        height: 35px;
        line-height: 35px;
        font-size: 18px;
        border-radius: 5px;
    }

    .sidebar li.profile {
        position: fixed;
        height: 60px;
        width: 78px;
        left: 0;
        bottom: -8px;
        padding: 10px 14px;
        overflow: hidden;
        transition: all .5s ease;
    }

    .sidebar.open li.profile {
        width: 250px;
    }

    .sidebar .profile .profile_details {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
    }

    .sidebar li img {
        height: 45px;
        width: 45px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 10px;
    }

    .sidebar li.profile .name,
    .sidebar li.profile .designation {
        font-size: 15px;
        font-weight: 400;
        color: var(--color-white);
        white-space: nowrap;
    }

    .sidebar li.profile .designation {
        font-size: 12px;
    }

    .sidebar .profile #log_out {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        background-color: var(--color-second);
        width: 100%;
        height: 60px;
        line-height: 60px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.5s ease;
    }

    .sidebar.open .profile #log_out {
        margin-right: 12px;
        width: 50px;
        background: none;
    }

    .sidebar.open .profile #log_out:hover {
        background: white;
        color: black;
    }

    .home-section {
        position: relative;
        background-color: var(--color-body);
        min-height: 100vh;
        top: 0;
        left: 78px;
        width: calc(100% - 78px);
        transition: all .5s ease;
        z-index: 0;
    }

    .home-section .text {
        display: inline-block;
        color: var(--color-default);
        font-size: 25px;
        font-weight: 500;
        margin: 18px;
    }

    .sidebar.open~.home-section {
        left: 250px;
        width: calc(100% - 250px);
    }

    /* logout */
    .modal {
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: auto;
        display: none;
        flex-direction: column;
        align-items: center;
        padding: 1.6rem 3rem;
        border: 3px solid black;
        border-radius: 15px;
        background-color: white;
        box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.2);
        height: 150px;
        background-size: cover;
        background-repeat: no-repeat;
        animation: slideLur 1s forwards;
        z-index: 5;
    }

    @keyframes slideLur {
        from {
            top: 100%;
        }

        to {
            top: 50%;
        }
    }

    .message {
        font-size: 1.1rem;
        margin-bottom: 1.6rem;
        margin-top: 0;
        text-align: center;
    }

    .options .btn {
        cursor: pointer;
        color: white;
        font-family: inherit;
        font-size: inherit;
        padding: 0.3rem 3.4rem;
        border: 3px solid black;
        margin-right: 2.6rem;
        box-shadow: 0 0 0 black;
        transition: all 0.2s;
        border-radius: 10px;
    }

    .btn:last-child {
        margin: 0;
    }

    .btn:hover {
        box-shadow: 0.4rem 0.4rem 0 black;
        transform: translate(-0.4rem, -0.4rem);
    }

    .btn:active {
        box-shadow: 0 0 0 black;
        transform: translate(0, 0);
    }

    .options {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .yb {
        background-color: green;
    }

    .nb {
        background-color: red;
    }

    .name {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    #fullname{
        display: none;
    }
</style>

<body>
    <div class="sidebar">
        <div class="logo_details">
            <i class="fa-solid fa-book-open-reader icon"></i>
            <div class="logo_name">FasilkomLib</div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="dashboards.php">
                    <i class="bx bx-grid-alt"></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="barang.php">
                    <i class='bx bx-package'></i>
                    <span class="link_name">Buku    </span>
                </a>
                <span class="tooltip">Buku</span>
            </li>
            <!-- <li>
                <a href="pesanan.php">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="link_name">Pesanan</span>
                </a>
                <span class="tooltip">Pesanan</span>
            </li>
            <li>
                <a href="pengiriman.php">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span class="link_name">Pengiriman</span>
                </a>
                <span class="tooltip">Pengiriman</span>
            </li> -->
            <li class="profile">
                <div class="profile_details">
                    <img src="<?php echo $ppurl . $pp ?>" alt="profile image">
                    <div class="profile_content">
                        <div class="name" id="fullname"><?php echo $fullname ?></div>
                        <div class="name" id="shortname"></div>
                        <div class="designation"><?php echo $pos ?></div>
                    </div>
                </div>
                <div onclick="openLogoutPopup()">
                    <i class="bx bx-log-out" id="log_out" onclick="location.href=" javascript:void(0);""></i>
                </div>
            </li>
        </ul>
        <div class="modal" id="logoutPopup">
            <div class="goyang">
                <p class="message">Yakin mau keluar?</p>
                <div class="options">
                    <button class="btn yb" onclick="logout()">Yes</button>
                    <button class="btn nb" onclick="closeLogoutPopup()">No</button>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- script -->
<script>
    function singkatNama(nama) {
        let namaArray = nama.split(' ');
        if (namaArray.length > 1) {
            return `${namaArray[0]} ${namaArray[1].charAt(0)}`;
        }
        return nama;
    }

    // Mengambil nama dari elemen HTML yang sudah diisi oleh PHP
    let namaLengkap = document.getElementById('fullname').innerText;
    let namaSingkat = singkatNama(namaLengkap);
    document.getElementById('shortname').innerText = namaSingkat;

    window.onload = function () {
        const sidebar = document.querySelector(".sidebar");
        const closeBtn = document.querySelector("#btn");

        closeBtn.addEventListener("click", function () {
            sidebar.classList.toggle("open")
            menuBtnChange()
        })

        function menuBtnChange() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right")
            } else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu")
            }
        }
    }

    function openLogoutPopup() {
        document.getElementById("logoutPopup").style.display = "block";
    }

    function closeLogoutPopup() {
        document.getElementById("logoutPopup").style.display = "none";
    }

    function logout() {
        window.location.href = "../logout.php";
    }
</script>

</html>