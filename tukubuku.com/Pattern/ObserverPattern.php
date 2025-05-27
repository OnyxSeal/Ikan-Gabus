<?php
// SessionAlertObserver.php

session_start();

interface Observer {
    public function update($event, $data);
}

class SessionAlertObserver implements Observer {
    public function update($event, $data) {
        switch ($event) {
            // Login events
            case 'login_success':
                $_SESSION['username'] = $data['username'];
                $_SESSION['alert_class'] = "alert-success";
                $_SESSION['alert_message'] = "Login berhasil";
                echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2000);</script>";
                break;

            case 'login_failed':
                $_SESSION['alert_class'] = "alert-danger";
                $_SESSION['alert_message'] = "Username atau email atau password salah. Silakan coba lagi.";
                header("Location: sign.php");
                exit();
                break;

            // Register events
            case 'register_success':
                $_SESSION['alert_class'] = "alert-success";
                $_SESSION['alert_message'] = "Pendaftaran berhasil. Silakan login dengan akun baru kamu.";
                echo "<script>setTimeout(function(){ window.location.href = 'sign.php'; }, 2000);</script>";
                break;

            case 'register_email_exists':
                $_SESSION['alert_class'] = "alert-danger";
                $_SESSION['alert_message'] = "Email tersebut sudah digunakan. Silakan coba dengan email lain.";
                break;

            case 'register_email_invalid':
                $_SESSION['alert_class'] = "alert-danger";
                $_SESSION['alert_message'] = "Pastikan Anda memasukan Email Universitas Singaperbangsa Karawang.";
                break;

            default:
                $_SESSION['alert_class'] = "alert-warning";
                $_SESSION['alert_message'] = "Terjadi peristiwa yang tidak dikenali.";
        }
    }
}
?>
