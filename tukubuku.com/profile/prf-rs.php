<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>righside</title>
    <link rel="stylesheet" href="notavailablebyval.css">
</head>

<body>
<div class="rightSide">
        <div class="titBox">
            <p>Edit Profil</p>
        </div>
        <div class="detBox">
            <div style="text-align: justify;">
                <span><i class="fa-solid fa-circle-exclamation fa-lg" style="color: rgba(0, 0, 0, 0.6);"></i> Periksa kelengkapan profile kamu untuk memastikan bahwa kamu bukan alien.</span>
            </div>
            <ul>
                <li class="detBut">
                    <a class="setLinks" href="edit/indi.php">
                        <i class="fa-solid fa-circle-user fa-lg"></i>
                        <span>Data Pribadi</span>
                    </a>
                </li>
                <li class="detBut">
                    <a class="setLinks" href="edit/kondi.php">
                        <i class="fa-solid fa-address-book fa-lg"></i>
                        <span>Kontak Pribadi</span>
                    </a>
                </li>
                <li class="detBut">
                    <a class="setLinks" href="#" onclick="openIF(event)">
                        <i class="fa-solid fa-user-group"></i>
                        <span>Akun Media Sosial</span>
                    </a>
                </li>
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
            </ul>
        </div>
    </div>
</body>

<script>
    function openIF() {
        document.getElementById("infoFitur").style.display = "block";
    }

    function closeIF() {
        document.getElementById("infoFitur").style.display = "none";
    }
</script>

</html>