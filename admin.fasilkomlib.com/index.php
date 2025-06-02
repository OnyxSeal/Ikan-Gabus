<?php
session_start();
require_once "connection/conn.php";
require_once "Pattern/AuthFactory.php";
require_once "Pattern/ObserverPattern.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['masuk']) ? 'masuk' : (isset($_POST['daftar']) ? 'daftar' : null);

    if ($action !== null) {
        try {
            $handler = AuthFactory::create($action);
            $observer = new SessionAlertObserver();
            $handler->attach($observer);
            $handler->handle($_POST);
        } catch (Exception $e) {
            $_SESSION['alert_class'] = "alert-danger";
            $_SESSION['alert_message'] = "Terjadi kesalahan: " . $e->getMessage();
            header("Location: index.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <title>FasilkomLib</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: url('https://images.pexels.com/photos/256455/pexels-photo-256455.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
        animation: slideBackground 20s linear infinite;
    }

    @keyframes slideBackground {
        0% {
            background-position: 0% 0%;
        }

        50% {
            background-position: 0% 50%;
        }

        100% {
            background-position: 0% 0%;
        }
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        /* Adjust the overlay color and opacity here */
        z-index: -1;
    }

    .logo {
        position: relative;
        color: #800000;
        font-size: 30px;
        font-weight: 600;
        text-decoration: none;
        transform: translate(0%, -200%);
    }

    .notif {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 15;
        width: 100%;
        max-width: 800px;
    }

    .alert>.start-icon {
        margin-right: 0;
        min-width: 20px;
        text-align: center;
    }

    .alert>.start-icon {
        margin-right: 5px;
    }

    .greencross {
        font-size: 18px;
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
        /* text-shadow: 2px 1px #00040a; */
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
        font-size: 18px;
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
            transform: translateY(-100%);
            opacity: 0;
        }

        to {
            transform: translateY(0%);
            opacity: 1;
        }
    }

    .container {
        position: relative;
        width: 70vw;
        min-width: 7vw;
        height: 80vh;
        min-height: 8vh;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .container::before {
        content: "";
        position: absolute;
        top: 0;
        left: -50%;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, #800000, #330000);
        z-index: 6;
        transform: translateX(100%);
        transition: 1s ease-in-out;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .signin-signup {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-around;
        z-index: 5;
    }

    form {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 40%;
        min-width: 238px;
        padding: 0 10px;
    }

    form.sign-in-form {
        opacity: 1;
        transition: 0.5s ease-in-out;
        transition-delay: 1s;
    }

    form.sign-up-form {
        opacity: 0;
        transition: 0.5s ease-in-out;
        transition-delay: 1s;
    }

    .title {
        font-size: 35px;
        color: #000;
        margin-bottom: 10px;
    }

    .input-field {
        width: 100%;
        height: 50px;
        background: #f0f0f0;
        margin: 10px 0;
        border: 2px solid #800000;
        border-radius: 50px;
        display: flex;
        align-items: center;
    }

    .input-field i {
        flex: 1;
        text-align: center;
        color: #666;
        font-size: 18px;
    }

    .input-field input {
        flex: 5;
        background: none;
        border: none;
        outline: none;
        width: 100%;
        font-size: 18px;
        font-weight: 600;
        color: #444;
    }

    .btn {
        width: 150px;
        height: 50px;
        border: none;
        border-radius: 50px;
        background: #800000;
        border: 1px solid white;
        color: #fff;
        font-weight: 600;
        margin: 10px 0;
        text-transform: uppercase;
        cursor: pointer;
    }

    .btn:hover {
        background: #330000;
    }

    a {
        text-decoration: none;
    }

    .panels-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        width: 35%;
        min-width: 238px;
        padding: 0 10px;
        text-align: center;
        z-index: 6;
    }

    .left-panel {
        pointer-events: none;
    }

    .content {
        color: #fff;
        transition: 1.1s ease-in-out;
        transition-delay: 0.5s;
    }

    .panel h3 {
        font-size: 24px;
        font-weight: 600;
    }

    .panel p {
        font-size: 15px;
        padding: 10px 0;
    }

    .image {
        width: 100%;
        transition: 1.1s ease-in-out;
        transition-delay: 0.4s;
    }

    .left-panel .content {
        transform: translateX(-200%);
    }

    .right-panel .content {
        transform: translateX(0);
    }

    .account-text {
        display: none;
    }

    /*Animation*/
    .container.sign-up-mode::before {
        transform: translateX(0);
    }

    .container.sign-up-mode .right-panel .image,
    .container.sign-up-mode .right-panel .content {
        transform: translateX(200%);
    }

    .container.sign-up-mode .left-panel .image,
    .container.sign-up-mode .left-panel .content {
        transform: translateX(0);
    }

    .container.sign-up-mode form.sign-in-form {
        opacity: 0;
    }

    .container.sign-up-mode form.sign-up-form {
        opacity: 1;
    }

    .container.sign-up-mode .right-panel {
        pointer-events: none;
    }

    .container.sign-up-mode .left-panel {
        pointer-events: all;
    }

    /*Responsive*/
    @media (max-width:779px) {
        .container {
            width: 100vw;
            height: 100vh;
        }
    }

    @media (max-width:635px) {
        .container::before {
            display: none;
        }

        form {
            width: 80%;
        }

        form.sign-up-form {
            display: none;
        }

        .container.sign-up-mode2 form.sign-up-form {
            display: flex;
            opacity: 1;
        }

        .container.sign-up-mode2 form.sign-in-form {
            display: none;
        }

        .panels-container {
            display: none;
        }

        .account-text {
            display: initial;
            margin-top: 30px;
        }
    }

    @media (max-width:320px) {
        form {
            width: 90%;
        }
    }

    .rightObj {
        position: absolute;
        margin-right: -350px;
        transform: translate(-25%, 20%);
        margin-bottom: -220px;
        z-index: -1;
    }

    .leftObj {
        margin-right: -350px;
        transform: translate(-120%, -40%);
        margin-bottom: -320px;
        z-index: -1;
    }

    .leftLogo {
        position: relative;
        color: #fff;
        font-size: 30px;
        font-weight: 600;
        text-decoration: none;
        transform: translate(-30%, -250%);
    }

    .forgetPass {
        text-decoration: none;
        color: #900000;
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
        z-index: 9999;
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
    <div class="container">
        <div class="signin-signup">
            <form action="index.php" class="sign-in-form" method="post">
                <div class="logo">
                    <i class="fa-solid fa-book-open-reader"></i> FasilkomLib
                </div>
                <h2 class="title">Login</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="usem" placeholder="Username" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Kata sandi" required>
                </div>
                <a class="forgetPass" href="javascript:void(0);" onclick="openModal()">
                    <span id="forgetPass">Lupa Password?</span>
                </a>
                <input type="submit" name="masuk" class="btn" value="Masuk">
            </form>
            <form action="index.php" class="sign-up-form" method="post">
                <h2 class="title">Daftar</h2>
                <div class="input-field">
                    <input type="hidden" name="avatar" value="default_profile.png">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Nama Lengkap" name="fullname" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Kata sandi" name="password" required>
                </div>
                <div class="input-field">
                    <i class="fa-solid fa-phone"></i>
                    <input type="number" placeholder="No HP" name="nohp" required>
                </div>
                <input type="submit" name="daftar" value="Daftar" class="btn">
            </form>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Sudah punya akun?</h3>
                    <p>Masuknya cuma pake username atau email kamu sama password kamu</p>
                    <button class="btn" id="sign-in-btn">Masuk</button>
                </div>
                <div class="panel left-panel leftObj">
                    <div class="content">
                        <img src="aset\haveacc.png" alt="kuda" width="250">
                    </div>
                </div>
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <div class="leftLogo">
                        <i class="fa-solid fa-book-open-reader"></i> FasilkomLib
                    </div>
                    <h3>Belum punya akun?</h3>
                    <p>Yuk, langsung daftar. Bikinnya ga pake lama, satset langsung jadi</p>
                    <button class="btn" id="sign-up-btn">Daftar</button>
                </div>
                <div class="modal-overlay" id="modal">
                    <div class="modal-content">
                        <h2>Kontak Admin</h2>
                        <p>Jika Anda lupa password, silakan hubungi admin untuk bantuan:</p>
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
                <div class="panel right-panel rightObj">
                    <div class="content">
                        <img class="image" src="aset\zeroacc.png" alt="kuda">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");
        sign_up_btn.addEventListener("click", () => {
            container.classList.add("sign-up-mode");
        });
        sign_in_btn.addEventListener("click", () => {
            container.classList.remove("sign-up-mode");
        });

        setTimeout(function () {
            closeNotification();
        }, 7000);
        function closeNotification() {
            document.getElementById("notification").style.display = "none";
        }


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