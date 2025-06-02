const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});


function validateUsername() {
    var usernameInput = document.getElementById("username");
    var usernameValue = usernameInput.value;
    var usernameError = document.getElementById("usernameError");

    // Buat objek XMLHTTPRequest
    var xhr = new XMLHttpRequest();

    // Siapkan permintaan AJAX
    xhr.open("GET", "checkinguser.php?username=" + usernameValue, true);

    // Tangani respons dari server
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Tangani pesan kesalahan dari server
                if (xhr.responseText === "Username telah digunakan") {
                    usernameError.textContent = "Username udah dipake orang lain";
                } else {
                    usernameError.textContent = "";
                }
            } else {
                // Tangani kesalahan koneksi
                console.error('Terjadi kesalahan: ' + xhr.status);
            }
        }
    };

    // Kirim permintaan
    xhr.send();
}