<?php

interface UserAction {
    public function execute();
}

interface Subject {
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify($event, $data);
}

class LoginUser implements UserAction, Subject {
    private $db;
    private $data;
    private $observers = [];

    public function __construct($db, $data) {
        $this->db = $db;
        $this->data = $data;
    }

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, fn($o) => $o !== $observer);
    }

    public function notify($event, $data) {
        foreach ($this->observers as $observer) {
            $observer->update($event, $data);
        }
    }

    public function execute() {
        $user = $this->data['usernameOrEmail'];
        $pw = $this->data['password'];

        $sql = "SELECT * FROM users WHERE (username='$user' OR email='$user') AND password='$pw'";
        $result = mysqli_query($this->db, $sql);

        if (mysqli_num_rows($result) == 1) {
            $this->notify('login_success', ['username' => $user]);
        } else {
            $this->notify('login_failed', ['username' => $user]);
        }
    }
}

class RegisterUser implements UserAction, Subject {
    private $db;
    private $data;
    private $observers = [];

    public function __construct($db, $data) {
        $this->db = $db;
        $this->data = $data;
    }

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, fn($o) => $o !== $observer);
    }

    public function notify($event, $data) {
        foreach ($this->observers as $observer) {
            $observer->update($event, $data);
        }
    }

    public function execute() {
        $avatar = 'default_profile.png';
        $fullname = $this->data['fullname'];
        $email = $this->data['email'];
        $username = $this->data['username'];
        $password = $this->data['password'];
        $nohp = $this->data['nohp'];
        $alamat = $this->data['alamat'];

        $check_user_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $check_user_result = mysqli_query($this->db, $check_user_query);

        if (mysqli_num_rows($check_user_result) > 0) {
            $this->notify('register_email_exists', ['email' => $email]);
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@.*unsika\.ac\.id$/', $email)) {
            $this->notify('register_email_invalid', ['email' => $email]);
        } else {
            $insert_user_query = "INSERT INTO users (avatar, fullname, email, username, password, phone, address)
                                  VALUES ('$avatar', '$fullname', '$email', '$username', '$password', '$nohp', '$alamat')";
            mysqli_query($this->db, $insert_user_query);
            $this->notify('register_success', ['username' => $username]);
        }
    }
}

class UserFactory {
    public static function create($type, $db, $data): UserAction|Subject {
        return match ($type) {
            'login' => new LoginUser($db, $data),
            'register' => new RegisterUser($db, $data),
            default => throw new Exception("Tipe tidak dikenali: $type")
        };
    }
}
?>
