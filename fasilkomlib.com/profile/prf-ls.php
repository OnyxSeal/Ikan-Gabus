<?php
$currentLocation = $_SERVER['REQUEST_URI'];

// Determine profile address
if (strpos($currentLocation, 'orderstatus') !== false || strpos($currentLocation, 'edit') !== false) {
    $profAddr = '../profile.php';
} else {
    $profAddr = 'profile.php';
}

// Determine order status address
if (strpos($currentLocation, 'orderstatus') !== false || strpos($currentLocation, 'edit') !== false) {
    $orderAddr = '../order-stat.php';
} else {
    $orderAddr = 'order-stat.php';
}

if (strpos($currentLocation, 'orderstatus') !== false || strpos($currentLocation, 'edit') !== false) {
    $logoutAddr = "../../logout.php";
} else {
    $logoutAddr = "../logout.php";
}

// gambar
if (strpos($currentLocation, 'edit') !== false || strpos($currentLocation, 'orderstatus') !== false) {
    $ppurl = '../../image/profile/';
} else {
    $ppurl = '../image/profile/';
}
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include $connect;

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM users WHERE (username = '$username' OR email = '$username')";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $fullname = $row['fullname'];
        $pp = $row['avatar'];
        $stat = $row['status'];
        $bio = $row['bio'];
    } else {
        $fullname = "";
        $pp = "default_profile.png";
        $stat = "";
        $bio = "";
    }
} else {
    $fullname = "";
    $pp = "default_profile.png";
    $stat = "";
    $bio = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>leftside</title>
</head>

<style>
    /* Popup styles */
    .modalIF  {
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        display: none;
        flex-direction: column;
        align-items: center;
        padding: 1.6rem 0rem;
        border: 3px solid #800000;
        border-radius: 15px;
        background: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23900000" fill-opacity="1" d="M0,256L9.6,245.3C19.2,235,38,213,58,224C76.8,235,96,277,115,298.7C134.4,320,154,320,173,309.3C192,299,211,277,230,245.3C249.6,213,269,171,288,128C307.2,85,326,43,346,48C364.8,53,384,107,403,112C422.4,117,442,75,461,90.7C480,107,499,181,518,224C537.6,267,557,277,576,250.7C595.2,224,614,160,634,165.3C652.8,171,672,245,691,277.3C710.4,309,730,299,749,266.7C768,235,787,181,806,176C825.6,171,845,213,864,224C883.2,235,902,213,922,192C940.8,171,960,149,979,128C998.4,107,1018,85,1037,90.7C1056,96,1075,128,1094,122.7C1113.6,117,1133,75,1152,64C1171.2,53,1190,75,1210,74.7C1228.8,75,1248,53,1267,42.7C1286.4,32,1306,32,1325,37.3C1344,43,1363,53,1382,69.3C1401.6,85,1421,107,1430,117.3L1440,128L1440,320L1430.4,320C1420.8,320,1402,320,1382,320C1363.2,320,1344,320,1325,320C1305.6,320,1286,320,1267,320C1248,320,1229,320,1210,320C1190.4,320,1171,320,1152,320C1132.8,320,1114,320,1094,320C1075.2,320,1056,320,1037,320C1017.6,320,998,320,979,320C960,320,941,320,922,320C902.4,320,883,320,864,320C844.8,320,826,320,806,320C787.2,320,768,320,749,320C729.6,320,710,320,691,320C672,320,653,320,634,320C614.4,320,595,320,576,320C556.8,320,538,320,518,320C499.2,320,480,320,461,320C441.6,320,422,320,403,320C384,320,365,320,346,320C326.4,320,307,320,288,320C268.8,320,250,320,230,320C211.2,320,192,320,173,320C153.6,320,134,320,115,320C96,320,77,320,58,320C38.4,320,19,320,10,320L0,320Z"></path></svg>');
        background-color: white;
        box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.2);
        height: 150px;
        background-size: cover;
        background-repeat: no-repeat;
        z-index: 5;
        animation: nyorosod 20s linear infinite, slideLur 1s ease-in-out;
    }

    @keyframes slideLur {
        from {
            top: 60%;
            opacity: 0;
        }

        to {
            top: 50%;
            opacity: 1;
        }
    }

    @keyframes nyorosod {
        0% {
            background-position: 0 0;
        }

        50% {
            background-position: 100% 0;
        }

        100% {
            background-position: 0 0;
        }
    }

    .message {
        font-size: 1.1rem;
        /* margin-bottom: 1.6rem; */
        margin-top: 0;
        text-align: center;
        font-weight: 500;
        background-color: white;
        padding: 1px 16px;
        width: 100%;
    }

    .options .btn {
        cursor: pointer;
        /* color: black; */
        font-family: inherit;
        font-size: inherit;
        padding: 0.3rem 3.4rem;
        border: 3px solid #800000;
        margin-right: 2.6rem;
        box-shadow: 0 0 0 #800000;
        transition: all 0.2s;
        border-radius: 10px;
    }

    .btn:last-child {
        margin: 0;
    }

    .btn:hover {
        box-shadow: 0.4rem 0.4rem 0 #800000;
        transform: translate(-0.4rem, -0.4rem);
    }

    .btn:active {
        box-shadow: 0 0 0 #800000;
        transform: translate(0, 0);
    }

    .options {
        display: flex;
        justify-content: center;
    }

    .nbIF {
        color: #000;
        text-transform: uppercase;
        font-weight: 500;
        background-color: white;
    }

    .profile-pic {
        border: 2px solid rgba(0, 0, 0, 0.3);
        border-radius: 50%;
        color: transparent;
        transition: all 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .profile-pic input {
        display: none;
    }

    .profile-pic img {
        position: absolute;
        object-fit: cover;
        width: 72px;
        height: 72px;
        box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.35);
        border-radius: 100px;
        z-index: 0;
    }

    .profile-pic .-label {
        cursor: pointer;
        height: 72px;
        width: 72px;
    }

    .profile-pic:hover .-label {
        font-size: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 10000;
        color: #fafafa;
        transition: background-color 0.2s ease-in-out;
        border-radius: 50%;
        margin-bottom: 0;
    }

    .profile-pic span {
        display: inline-flex;
        padding: 0.2em;
        height: 2em;
    }

    /* Popup styles */
    .modal {
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: auto;
        display: none;
        flex-direction: column;
        align-items: center;
        padding: 1.6rem 3rem;
        border: 3px solid #800000;
        border-radius: 15px;
        background-color: white;
        box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.2);
        height: 150px;
        background-size: cover;
        background-repeat: no-repeat;
        animation: slideLur 1s forwards;
        z-index: 5;
    }

    @keyframes slideLur {
        from {
            top: 100%;
        }

        to {
            top: 50%;
        }
    }

    .message {
        font-size: 1.1rem;
        margin-bottom: 1.6rem;
        margin-top: 0;
        text-align: center;
    }

    .options .btn {
        cursor: pointer;
        font-family: inherit;
        font-size: inherit;
        padding: 0.3rem 3.4rem;
        border: 3px solid black;
        margin-right: 2.6rem;
        box-shadow: 0 0 0 black;
        transition: all 0.2s;
        border-radius: 10px;
    }

    .btn:last-child {
        margin: 0;
    }

    .btn:hover {
        box-shadow: 0.4rem 0.4rem 0 black;
        transform: translate(-0.4rem, -0.4rem);
    }

    .btn:active {
        box-shadow: 0 0 0 black;
        transform: translate(0, 0);
    }

    .options {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .yb {
        background-color: green;
        color: white;
    }

    .nb {
        background-color: red;
        color: white;
    }

    /* Style dari profile */

    .leftSide {
        padding: 10px;
        width: 30%;
        /* background-color: blue; */
        height: auto;
    }

    .profBox {
        background-color: white;
        height: auto;
        width: 100%;
        display: flex;
        border-radius: 10px;
        padding: 16px;
        align-items: center;
        align-content: center;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    }

    .setBox {
        margin-top: 20px;
        padding: 16px;
        background-color: white;
        height: auto;
        width: 100%;
        border-radius: 10px;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    }

    .setBut:not(:last-child) {
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
    }

    li {
        list-style-type: none;
    }

    ul .setBut,
    a {
        text-decoration: none;
        color: black;
        font-size: 16px;
        font-weight: 500;
        line-height: 42px;

        &:hover {
            color: #800000;
        }
    }

    .setText {
        transition: all 0.2s ease-in-out;

        &:hover {
            margin-left: 3px;
        }
    }

    .pp img {
        height: 72px;
        width: 72px;
    }

    .descPp {
        font-family: Montserrat;
        margin: 0 0 0 10px;
        line-height: 21px;
        font-weight: 300;
    }

    .descName {
        text-transform: uppercase;
        font-size: 16px;
        font-weight: 500;
    }

    .descStat,
    .descCamp {
        text-transform: capitalize;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        font-weight: 400;
    }
</style>

<body>
    <div class="leftSide">
        <div class="profBox">
            <div class="pp">
                <form class="form" id="form" action="" enctype="multipart/form-data" method="post">
                    <div class="profile-pic">
                        <label class="-label" for="avatar">
                            <span class="glyphicon glyphicon-camera"></span>
                            <span>Ganti Gambar</span>
                        </label>
                        <input type="hidden" name="fullname" value="<?php echo $fullname; ?>">
                        <input id="avatar" name="image" type="file" accept=".jpg, .png, .jpeg"
                            onchange="loadFile(event)" />
                        <img src="<?php echo $ppurl . $pp; ?>" id="output" width="128" height="128"
                            alt="<?php echo $pp; ?>" />
                    </div>
                </form>
            </div>
            <div class="descPp">
                <span class="descName">
                    <?php if (isset($fullname) && $fullname !== ""): ?>
                        <span><?php echo htmlspecialchars($fullname); ?></span>
                    <?php else: ?>
                        <span>[Nama Lengkap User]</span>
                    <?php endif; ?>
                </span><br>
                <span class="descStat">
                    <?php if (isset($stat) && $stat !== ""): ?>
                        <span><?php echo htmlspecialchars($stat); ?></span>
                    <?php else: ?>
                        <span>[Status User]</span>
                    <?php endif; ?>
                </span><br>
                <span class="descCamp">
                    <?php if (isset($bio) && $bio !== ""): ?>
                        <span><?php echo htmlspecialchars($bio); ?></span>
                    <?php else: ?>
                        <span>[Bio User]</span>
                    <?php endif; ?>
                </span>
            </div>
        </div>
        <div class="setBox">
            <ul>
                <li class="setBut">
                    <a href="<?php echo htmlspecialchars($profAddr); ?>">
                        <i class="fa-solid fa-user-cog fa-lg"></i>
                        <span class="setText">Profil</span>
                    </a>
                </li>
                <li class="setBut">
                    <a href="javascript:void(0);" onclick="openLogoutPopup()">
                        <i class='fa fa-sign-out fa-lg'></i>
                        <span class="setText">Keluar</span>
                    </a>
                </li>
            </ul>
            <div class="modalIF" id="infoFitur">
                <div class="goyang">
                    <div class="message">
                        <p class="message1">Oopsss, fitur tersebut belum tersedia</p>
                    </div>
                    <div class="options">
                        <button class="btn nbIF" onclick="closeIF()">baiklah</button>
                    </div>
                </div>
            </div>
            <div class="modal" id="logoutPopup">
                <div class="goyang">
                    <p class="message">Yakin mau keluar?</p>
                    <div class="options">
                        <button class="btn yb" onclick="logout()">Yes</button>
                        <button class="btn nb" onclick="closeLogoutPopup()">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function openIF() {
        document.getElementById("infoFitur").style.display = "flex";
    }

    function closeIF() {
        document.getElementById("infoFitur").style.display = "none";
    }

    function openLogoutPopup() {
        document.getElementById("logoutPopup").style.display = "flex";
    }

    function closeLogoutPopup() {
        document.getElementById("logoutPopup").style.display = "none";
    }

    function logout() {
        window.location.href = "<?php echo $logoutAddr ?>";
    }

    function loadFile(event) {
        document.getElementById('form').submit();
    }
</script>

<?php

if (isset($_FILES['image'])) {
    $fullname = $_POST['fullname'];

    $imgName = $_FILES['image']['name'];
    $imgSize = $_FILES['image']['size'];
    $tmpName = $_FILES['image']['tmp_name'];

    $validImg = ['jpg', 'jpeg', 'png'];
    $imgExtension = explode('.', $imgName);
    $imgExtension = strtolower(end($imgExtension));
    if (!in_array($imgExtension, $validImg)) {
        echo
            "
        <script>
            alert('Invalid Image Extension');
            document.location.href = '$ppurl';
        </script>
        ";
    } else if ($imgSize > 1200000) {
        echo
            "
        <script>
            alert('Image Size Too Large');
            document.location.href = '$ppurl';
        </script>
        ";
    } else {
        $newImgName = "[" . $fullname . "] " . " " . date("Y.m.d") . " - " . date("h.i.sa");
        $newImgName .= "." . $imgExtension;
        $query = "UPDATE users SET avatar = '$newImgName' WHERE fullname = '$fullname'";
        $result = mysqli_query($db, $query);
        move_uploaded_file($tmpName, $ppurl . $newImgName);
        echo
            "
        <script>
            document.location.href = '$profAddr';
        </script>
        ";
    }
}
?>

</html>