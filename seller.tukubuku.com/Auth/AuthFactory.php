<?php
require_once "connection/conn.php";

interface AuthInterface {
    public function handle($data);
}

class LoginHandler implements AuthInterface {
    public function handle($data) {
        global $db;
        $user = $data['usem'];
        $pw = $data['password'];

        $sql = "SELECT * FROM admin WHERE (usradm='$user' OR email='$user') AND pwadm='$pw'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $user;
            $_SESSION['alert_class'] = "alert-success";
            $_SESSION['alert_message'] = "Login berhasil";
            echo "<script>setTimeout(function(){ window.location.href = 'dashboard/dashboards.php'; }, 2000);</script>";
        } else {
            $_SESSION['alert_class'] = "alert-danger";
            $_SESSION['alert_message'] = "Username atau email atau kata sandi salah. Silakan coba lagi.";
            header("Location: index.php");
            exit();
        }
    }
}

class RegisterHandler implements AuthInterface {
    public function handle($data) {
        global $db;
        $avatar = $data['avatar'];
        $fullname = $data['fullname'];
        $email = $data['email'];
        $username = $data['username'];
        $password = $data['password'];
        $nohp = $data['nohp'];

        $check_user_query = "SELECT * FROM admin WHERE usradm='$username' OR email='$email'";
        $check_user_result = mysqli_query($db, $check_user_query);

        if (mysqli_num_rows($check_user_result) > 0) {
            $_SESSION['alert_class'] = "alert-danger";
            $_SESSION['alert_message'] = "Email tersebut sudah digunakan. Silakan coba dengan email lain.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@.*unsika\.ac\.id$/', $email)) {
            $_SESSION['alert_class'] = "alert-danger";
            $_SESSION['alert_message'] = "Pastikan Anda memasukan Email Univeristas Singaperbangsa Karawang";
        } else {
            $insert_user_query = "INSERT INTO admin (profile_picture, fullname, email, usradm, pwadm, nohpadm) VALUES ('$avatar', '$fullname', '$email', '$username', '$password', '$nohp')";
            mysqli_query($db, $insert_user_query);
            $_SESSION['alert_class'] = "alert-success";
            $_SESSION['alert_message'] = "Pendaftaran berhasil. Silakan login dengan akun baru kamu.";
            echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2000);</script>";
        }
    }
}

class AuthFactory {
    public static function create($type) {
        switch ($type) {
            case 'masuk':
                return new LoginHandler();
            case 'daftar':
                return new RegisterHandler();
            default:
                throw new Exception("Handler tidak ditemukan.");
        }
    }
}
