<?php
// Mulai sesi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah sesi username sudah ada
if (isset($_SESSION['username'])) {
    // Redirect pengguna ke halaman lain atau lakukan tindakan lain jika sesi sudah aktif
    header('Location: index.php');
    exit;
}

// Include file koneksi ke database
include "connection/conn.php";

if (isset($_POST['masuk'])) {
    $user = $_POST['usem']; // Ambil input username atau email
    $pw = $_POST['password'];

    // Query untuk memeriksa apakah username atau email dan password cocok
    $sql = "SELECT * FROM user WHERE (username='$user' OR email='$user') AND password='$pw'";
    $result = mysqli_query($db, $sql);

    // Memeriksa jumlah baris yang dikembalikan oleh query
    if (mysqli_num_rows($result) == 1) {
        // Jika username atau email dan password cocok, set session username
        $_SESSION['username'] = $user;

        // Set notifikasi login berhasil
        $_SESSION['alert_class'] = "alert-success";
        $_SESSION['alert_message'] = "Login berhasil";

        // Redirect ke halaman dashboard setelah beberapa detik
        echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2000);</script>";
    } else {
        // Jika username atau email atau password tidak cocok, set notifikasi kesalahan
        $_SESSION['alert_class'] = "alert-danger";
        $_SESSION['alert_message'] = "Username atau email atau password salah. Silakan coba lagi.";

        // Redirect kembali ke halaman login
        header("Location: sign.php");
        exit();
    }
}
?>

<?php
include "connection/conn.php";

if (isset($_POST['daftar'])) {
    // Ambil data dari form pendaftaran
    $avatar = 'default_profile.png';
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nohp = $_POST['nohp'];
    $socmed = ' ';
    $alamat = $_POST['alamat'];

    // Query untuk memeriksa apakah username atau email sudah ada dalam database
    $check_user_query = "SELECT * FROM user WHERE username='$username' OR email='$email'";
    $check_user_result = mysqli_query($db, $check_user_query);

    // Jika username atau email sudah ada dalam database
    if (mysqli_num_rows($check_user_result) > 0) {
        // Tampilkan pesan kesalahan
        $_SESSION['alert_class'] = "alert-danger";
        $_SESSION['alert_message'] = "Email tersebut sudah digunakan. Silakan coba dengan email lain.";
    } else {
        // Jika username dan email belum ada dalam database, tambahkan data pengguna baru
        $insert_user_query = "INSERT INTO user (avatar, fullname, email, username, password, phone, socmed, address) VALUES ('$avatar', '$fullname', '$email', '$username', '$password', '$nohp', '$socmed', '$alamat')";
        mysqli_query($db, $insert_user_query);
        // Set notifikasi pendaftaran berhasil
        $_SESSION['alert_class'] = "alert-success";
        $_SESSION['alert_message'] = "Pendaftaran berhasil. Silakan login dengan akun baru kamu.";

        echo "<script>setTimeout(function(){ window.location.href = 'sign.php'; }, 2000);</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="sign.css">
    <link rel="icon" href="www.gigaval.com/favicon.ico">
    <title>Sign in/Sign up</title>
</head>

<style>
    body {
        font-family: Poppins;
    }

    .notif {
        position: fixed;
        top: 68px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        width: 100%;
        max-width: 800px;
    }

    .alert>.start-icon {
        margin-right: 0;
        min-width: 18px;
        text-align: center;
    }

    .alert>.start-icon {
        margin-right: 5px;
    }

    .greencross {
        font-size: 14px;
        color: #25ff0b;
        text-shadow: none;
    }

    /* notif */
    .alert-simple.alert-danger {
        border: 1px solid rgba(241, 6, 6, 0.81);
        border-radius: 5px;
        background-color: white;
        box-shadow: 0px 0px 2px #ff0303;
        color: #ff0303;
        transition: 0.5s;
        cursor: pointer;
        animation: slideIn 0.5s ease-in-out;
    }

    .alert-danger:hover {
        background-color: rgba(220, 17, 1, 0.33);
        color: white;
        transition: 0.5s;
    }

    .danger {
        font-size: 14px;
        color: #ff0303;
        text-shadow: none;
    }

    /* kalo berhasil */
    .alert-simple.alert-success {
        border: 1px solid rgba(36, 241, 6, 0.46);
        border-radius: 5px;
        background-color: white;
        box-shadow: 0px 0px 2px #259c08;
        color: #0ad406;
        transition: 0.5s;
        cursor: pointer;
        animation: slideIn 0.5s ease-in-out;
    }

    .alert-success:hover {
        background-color: rgba(7, 149, 66, 0.35);
        color: white;
        transition: 0.5s;
    }

    .alertprimary {
        font-size: 18px;
        color: #03d0ff;
        text-shadow: none;
    }

    .alert:before {
        content: '';
        position: absolute;
        width: 0;
        height: calc(100% - 44px);
        border-left: 1px solid;
        border-right: 2px solid;
        border-bottom-right-radius: 3px;
        border-top-right-radius: 3px;
        left: 0;
        top: 50%;
        transform: translate(0, -50%);
        height: 20px;
    }

    .fa-times {
        -webkit-animation: blink-1 2s infinite both;
        animation: blink-1 2s infinite both;
    }

    @keyframes slideIn {
        from {
            transform: translate(0%, -100%);
            opacity: 0;
        }

        to {
            transform: translate(0);
            opacity: 1;
        }
    }

    .forgetPass {
        line-height: 1px;

        &:hover {
            color: #800000;
        }
    }

    /* Gaya untuk modal overlay */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    /* Gaya untuk modal content */
    .modal-content {
        background-color: #fff;
        padding: 16px;
        border-radius: 8px;
        text-align: center;
        max-width: 500px;
        width: 80%;
        z-index: 7;
        animation: slideLur 0.5s ease-in-out;
    }

    @keyframes slideLur {
        from {
            transform: translateY(20%);
            opacity: 0;
        }

        to {
            transform: translateX(0%);
            opacity: 1;
        }
    }

    /* Gaya untuk tombol close */
    .close-btn {
        background-color: red;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: 0.5s ease-in-out;

        &:hover {
            background-color: #900000;
        }

        &:active {
            box-shadow: 0 3px #666;
            transform: translateY(4px);
        }

        &:focus {
            outline: none;
        }
    }

    #emailModal,
    #whatsappModal,
    #whatsappModal a {
        font-size: 14px;
    }

    #whatsappModal a {
        text-transform: capitalize;
        color: #800000;
    }
</style>

<body>
    <?php include "layout/naviga.php" ?>
    <div class="notif">
        <?php if (!empty($_SESSION['alert_class']) && !empty($_SESSION['alert_message'])) { ?>
            <div id="notification" class="col-sm-12">
                <div class="alert fade alert-simple <?php echo $_SESSION['alert_class']; ?> alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"
                    role="alert" data-brk-library="component__alert">
                    <button type="button" class="close font__size-18" onclick="closeNotification()">
                        <span aria-hidden="true">
                            <i
                                class="fa fa-times <?php echo $_SESSION['alert_class'] == 'alert-success' ? 'alertprimary' : 'danger'; ?>"></i>
                        </span>
                        <span class="sr-only">Close</span>
                    </button>
                    <?php if ($_SESSION['alert_class'] == 'alert-success') { ?>
                        <i class="start-icon fa fa-thumbs-up faa-bounce animated"></i>
                        <strong class="font__weight-semibold">Mantap!</strong> <?php echo $_SESSION['alert_message']; ?>
                    <?php } else { ?>
                        <i class="start-icon far fa-times-circle faa-pulse animated"></i>
                        <strong class="font__weight-semibold">Oh Tidak!</strong> <?php echo $_SESSION['alert_message']; ?>
                    <?php } ?>
                </div>
            </div>
            <?php unset($_SESSION['alert_class']);
            unset($_SESSION['alert_message']); ?>
        <?php } ?>
    </div>
</body>
<div class="container" id="container">
    <div class="form-container sign-up">
        <form id="loginForm" action="sign.php" method="POST">
            <h1>Buat Akun</h1>
            <input type="text" placeholder="Nama Lengkap" name="fullname" required>
            <input type="email" placeholder="Email" name="email" required>
            <input type="text" id="username" placeholder="Username" required onblur="validateUsername()"
                name="username">
            <span id="usernameError" style="color: red;"></span>
            <input type="password" placeholder="Password" name="password" required>
            <input type="number" placeholder="No HP" name="nohp" required>
            <input type="text" placeholder="Alamat" name="alamat" required>
            <button type="submit" name="daftar">Daftar</button>
        </form>
    </div>
    <div class="form-container sign-in">
        <form action="sign.php" method="POST">
            <h1>Login</h1>
            <span>Masuk menggunakan username atau emailmu</span>
            <input type="text" placeholder="Username/Email" name="usem" required>
            <input type="password" placeholder="Password" name="password" id="pw" required>
            <a class="forgetPass" href="javascript:void(0);" onclick="openModal()">
                <span id="forgetPass">Lupa Password?</span>
            </a>
            <button type="submit" name="masuk">Masuk</button>
        </form>
    </div>
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h3>Sudah punya akun?</h3>
                <p>Masuknya pake username atau email punya kamu</p>
                <button class="hidden" id="login">Masuk</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h3>Belum punya akun?</h3>
                <p>Yuk, bikin akunmu. Tidak lama, satset jadi</p>
                <button class="hidden" id="register">Buat akun</button>
            </div>
        </div>
        <div class="modal-overlay" id="modal">
            <div class="modal-content">
                <h2>Kontak Admin</h2>
                <p>Jika Kamu lupa password, silakan hubungi Admin untuk bantuan:</p>
                <span id="emailModal">
                    <i class="fa-solid fa-envelope"></i> raivalm@gmail.com
                </span>
                <span id="whatsappModal">
                    <i class="fa-brands fa-whatsapp fa-lg"></i> 0813 2141 2314 atau
                    <a href="https://wa.me/6281321412314" target="_b"> klik disini</a>
                </span>
                <button class="close-btn" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="sign.js"></script>
<script>
    setTimeout(function () {
        closeNotification();
    }, 10000);
    function closeNotification() {
        // Menghilangkan notifikasi
        document.getElementById("notification").style.display = "none";
    }

    // Fungsi untuk membuka modal
    function openModal() {
        document.getElementById('modal').style.display = 'flex';
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('modal').style.display = 'none';
    }

    // Menutup modal ketika pengguna mengklik di luar modal content
    window.onclick = function (event) {
        const modal = document.getElementById('modal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
</body>

</html>