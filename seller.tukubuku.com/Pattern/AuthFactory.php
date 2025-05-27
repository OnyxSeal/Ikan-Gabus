<?php
require_once __DIR__ . '/../connection/conn.php';
require_once __DIR__ . '/../Pattern/ObserverPattern.php';

interface AuthInterface {
    public function attach(Observer $observer);
    public function handle($data);
}

class AdminLoginHandler implements AuthInterface {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    private function notify($event, $data) {
        foreach ($this->observers as $observer) {
            $observer->update($event, $data);
        }
    }

    public function handle($data) {
        global $db;
        $user = $data['usem'];
        $pw = $data['password'];

        $sql = "SELECT * FROM admin WHERE (usradm='$user' OR email='$user') AND pwadm='$pw'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) === 1) {
            $this->notify('login_success', ['username' => $user, 'redirect' => 'dashboard/dashboards.php']);
        } else {
            $this->notify('login_failed', ['redirect' => 'index.php']);
        }
    }
}

class AdminRegisterHandler implements AuthInterface {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    private function notify($event, $data = []) {
        foreach ($this->observers as $observer) {
            $observer->update($event, $data);
        }
    }

    public function handle($data) {
        global $db;

        $avatar = $data['avatar'] ?? 'default_profile.png';
        $fullname = $data['fullname'];
        $email = $data['email'];
        $username = $data['username'];
        $password = $data['password'];
        $nohp = $data['nohp'];

        $check_user_query = "SELECT * FROM admin WHERE usradm='$username' OR email='$email'";
        $check_user_result = mysqli_query($db, $check_user_query);

        if (mysqli_num_rows($check_user_result) > 0) {
            $this->notify('register_email_exists');
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@.*unsika\.ac\.id$/', $email)) {
            $this->notify('register_email_invalid');
        } else {
            $insert_query = "INSERT INTO admin (profile_picture, fullname, email, usradm, pwadm, nohpadm) 
                             VALUES ('$avatar', '$fullname', '$email', '$username', '$password', '$nohp')";
            mysqli_query($db, $insert_query);
            $this->notify('register_success', ['redirect' => 'index.php']);
        }
    }
}

class AuthFactory {
    public static function create($type) {
        switch ($type) {
            case 'masuk':
                return new AdminLoginHandler();
            case 'daftar':
                return new AdminRegisterHandler();
            default:
                throw new Exception("Handler tidak ditemukan.");
        }
    }
}
