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
        $fullname = $row['fullname'];
        $gender = $row['gender'];
        $stat = $row['status'];
        $bio = $row['bio'];
    } else {
        $fullname = "";
        $gender = "";
        $stat = "";
        $bio = "";
    }
} else {
    $fullname = "";
    $gender = "";
    $stat = "";
    $bio = "";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_gender = $_POST['gender'];
    $new_status = $_POST['status'];
    $new_bio = $_POST['bio'];

    $sql_update = "UPDATE users SET gender = '$new_gender', status = '$new_status', bio = '$new_bio' WHERE username = '$username' OR email = '$username'";
    mysqli_query($db, $sql_update);
    header("Location: indi.php"); // Redirect after updating
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
                            <p>Informasi Pribadi</p>
                        </div>
                    </div>
                    <div class="detBox">
                        <form method="POST" action="indi.php" id="editForm">
                            <div style="text-align: justify;">
                                <div class="indi">
                                    <div class="dataIndi">
                                        <span>Nama Panjang</span><br>
                                        <span>
                                            <?php if ($fullname !== ""): ?>
                                                <span class="dataText">
                                                    <p><?php echo $fullname; ?></p>
                                                </span>
                                            <?php else: ?>
                                                <span class="dataText">
                                                    <p>Nama Lengkap User</p>
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="dataIndi">
                                        <span>Jenis Kelamin</span><br>
                                        <div class="custom-select">
                                            <select name="gender" id="gender">
                                                <option value="" disabled <?php echo ($gender === '') ? 'selected' : ''; ?>>
                                                    Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki" <?php echo ($gender === 'Laki-laki') ? 'selected' : ''; ?>>
                                                    Laki-laki</option>
                                                <option value="Perempuan" <?php echo ($gender === 'Perempuan') ? 'selected' : ''; ?>>
                                                    Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="dataIndi">
                                        <span>Status</span><br>
                                        <div class="custom-select">
                                            <select name="status">
                                                <option value="" disabled <?php echo ($stat === '') ? 'selected' : ''; ?>>
                                                    Isi
                                                    dengan benar</option>
                                                <option value="Siswa" <?php echo ($stat === 'Siswa') ? 'selected' : ''; ?>>
                                                    Siswa</option>
                                                <option value="Mahasiswa" <?php echo ($stat === 'Mahasiswa') ? 'selected' : ''; ?>>Mahasiswa</option>
                                                <option value="Pekerja" <?php echo ($stat === 'Pekerja') ? 'selected' : ''; ?>>Pekerja</option>
                                                <option value="Ibu_Rumah_Tangga" <?php echo ($stat === 'Ibu_Rumah_Tangga') ? 'selected' : ''; ?>>Ibu Rumah Tangga</option>
                                                <option value="Lainnya" <?php echo ($stat === 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="dataIndi">
                                        <span>Bio</span>
                                        <textarea name="bio" id="bio" maxlength="50"><?php echo $bio; ?></textarea>
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
            gender: document.getElementById('gender').value,
            status: document.querySelector('select[name="status"]').value,
            bio: document.getElementById('bio').value
        };

        var formElements = document.querySelectorAll('#gender, select[name="status"], #bio');
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