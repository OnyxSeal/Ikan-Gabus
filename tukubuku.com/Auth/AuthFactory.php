<?php
// AuthFactory.php

interface UserAction {
    public function execute();
}

class LoginUser implements UserAction {
    private $db;
    private $usernameOrEmail;
    private $password;

    public function __construct($db, $usernameOrEmail, $password) {
        $this->db = $db;
        $this->usernameOrEmail = $usernameOrEmail;
        $this->password = $password;
    }

    public function execute() {
        $user = mysqli_real_escape_string($this->db, $this->usernameOrEmail);
        $pw = mysqli_real_escape_string($this->db, $this->password);

        $sql = "SELECT * FROM user WHERE (username='$user' OR email='$user') AND password='$pw'";
        $result = mysqli_query($this->db, $sql);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $user;
            $_SESSION['alert_class'] = "alert-success";
            $_SESSION['alert_message'] = "Login berhasil";
            echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2000);</script>";
        } else {
            $_SESSION['alert_class'] = "alert-danger";
            $_SESSION['alert_message'] = "Username atau email atau password salah. Silakan coba lagi.";
            header("Location: sign.php");
            exit();
        }
    }
}

class RegisterUser implements UserAction {
    private $db;
    private $data;

    public function __construct($db, $data) {
        $this->db = $db;
        $this->data = $data;
    }

    public function execute() {
        $avatar = 'default_profile.png';
        $fullname = mysqli_real_escape_string($this->db, $this->data['fullname']);
        $email = mysqli_real_escape_string($this->db, $this->data['email']);
        $username = mysqli_real_escape_string($this->db, $this->data['username']);
        $password = mysqli_real_escape_string($this->db, $this->data['password']);
        $nohp = mysqli_real_escape_string($this->db, $this->data['nohp']);
        $socmed = ' ';
        $alamat = mysqli_real_escape_string($this->db, $this->data['alamat']);

        $check_sql = "SELECT * FROM user WHERE username='$username' OR email='$email'";
        $check_result = mysqli_query($this->db, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['alert_class'] = "alert-danger";
            $_SESSION['alert_message'] = "Email tersebut sudah digunakan. Silakan coba dengan email lain.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@.*unsika\.ac\.id$/', $email)) {
            $_SESSION['alert_class'] = "alert-danger";
            $_SESSION['alert_message'] = "Pastikan Anda memasukan Email Univeristas Singaperbangsa Karawang";
        } else {
            $insert_sql = "INSERT INTO user (avatar, fullname, email, username, password, phone, socmed, address)
                           VALUES ('$avatar', '$fullname', '$email', '$username', '$password', '$nohp', '$socmed', '$alamat')";
            mysqli_query($this->db, $insert_sql);

            $_SESSION['alert_class'] = "alert-success";
            $_SESSION['alert_message'] = "Pendaftaran berhasil. Silakan login dengan akun baru kamu.";
            echo "<script>setTimeout(function(){ window.location.href = 'sign.php'; }, 2000);</script>";
        }
    }
}

class UserFactory {
    public static function create($type, $db, $params) {
        if ($type === 'login') {
            return new LoginUser($db, $params['usernameOrEmail'], $params['password']);
        } elseif ($type === 'register') {
            return new RegisterUser($db, $params);
        } else {
            throw new Exception("Invalid user action type");
        }
    }
}
?>
