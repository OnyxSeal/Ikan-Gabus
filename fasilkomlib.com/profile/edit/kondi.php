<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "../../connection/conn.php";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM users WHERE (username = '$username' OR email = '$username')";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $nohp = $row['phone'];
    } else {
        $email = "";
        $nohp = "";
    }
} else {
    $email = "";
    $nohp = "";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_email = $_POST['email'];
    $new_phone = $_POST['phone'];

    $sql_update = "UPDATE users SET email = '$new_email', phone = '$new_phone' WHERE username = '$username' OR email = '$username'";
    mysqli_query($db, $sql_update);
    header("Location: kondi.php"); // Redirect after updating
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="edit.css">
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
</head>

<style>
    /* Style untuk textarea */
    textarea {
        display: block;
        width: 100%;
        resize: none;
        height: auto;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    textarea:focus {
        color: #495057;
        background-color: #fff;
        border-color: #800000;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.25);
    }

    .subTF {
        margin: 0 0 10px 0;
    }

    #subTF {
        font-size: 16px;
        font-weight: 600;
    }

    .emailText {
        color: rgba(0, 0, 0, 0.6);
    }

    input {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    input:focus {
        color: #495057;
        background-color: #fff;
        border-color: #800000;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.25);
    }

    input[type=number] {
        -moz-appearance: textfield;
        appearance: textfield;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .subJud {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .editBut {
        border-top: 2px solid rgba(128, 0, 0, 0.4);
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        margin-top: 1px;
        padding: 24px;
        background-color: white;
        width: 100%;
    }

    .subJud button {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40%;
        height: 40px;
        border: none;
        background-color: #800000;
        color: white;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .subJud button:hover {
        background-color: #660000;
    }

    .subJud button:disabled {
        opacity: 0.5;
        pointer-events: none;
    }
</style>

<body>
    <?php include "../../layout/naviga.php" ?>
    <div class="contolner">
        <div class="content">
            <di class="ngotak">
                <?php include "../prf-ls.php" ?>

                <div class="rightSide">
                    <div class="titBox">
                        <div class="actBack">
                            <a href="javascript:history.back()">
                                <i class="fa fa-angle-left"></i>&emsp;Kembali
                            </a>
                        </div>
                        <div class="subJud">
                            <p>Kontak Pribadi</p>
                        </div>
                    </div>
                    <div class="detBox">
                        <form method="POST" action="kondi.php" id="editForm">
                            <div style="text-align: justify;">
                                <div class="indi">
                                    <div class="dataIndi">
                                        <div class="subTF">
                                            <span id="subTF">Informasi Kontak Pribadi</span>
                                        </div>
                                        <span>Email</span><br>
                                        <span>
                                            <?php if ($email !== ""): ?>
                                                <span class="emailText">
                                                    <p><?php echo $email; ?></p>
                                                </span>
                                            <?php else: ?>
                                                <span class="emailTex">
                                                    <p>Email User</p>
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="dataIndi">
                                        <span>Nomor Ponsel</span><br>
                                        <input type="number" name="phone" placeholder="Nomor Ponsel"
                                            value="<?php echo $nohp; ?>" maxlength="15" required>
                                    </div>
                                </div>
                            </div>
                            <div class="editBut">
                                <div class="subJud">
                                    <button class="button" type="submit" name="submit" id="submitBtn" disabled>Simpan
                                        Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
    </div>
</body>
<?php include "../../layout/footer.php" ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var originalValues = {
            email: document.querySelector('input[name="email"]').value,
            phone: document.querySelector('input[name="phone"]').value
        };

        var formElements = document.querySelectorAll('input[name="email"], input[name="phone"]');
        var submitBtn = document.getElementById('submitBtn');

        formElements.forEach(function (element) {
            element.addEventListener('input', function () {
                var hasChanged = Array.from(formElements).some(function (el) {
                    return originalValues[el.name] !== el.value;
                });
                submitBtn.disabled = !hasChanged;
            });
        });
    });
</script>

</html>