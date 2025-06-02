<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            width: 100%;
            min-height: 100vh;
            text-align: center;
            /* background: linear-gradient(to bottom right, white 50%, #999999 50%); */
            background: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23900000" fill-opacity="1" d="M0,256L9.6,245.3C19.2,235,38,213,58,224C76.8,235,96,277,115,298.7C134.4,320,154,320,173,309.3C192,299,211,277,230,245.3C249.6,213,269,171,288,128C307.2,85,326,43,346,48C364.8,53,384,107,403,112C422.4,117,442,75,461,90.7C480,107,499,181,518,224C537.6,267,557,277,576,250.7C595.2,224,614,160,634,165.3C652.8,171,672,245,691,277.3C710.4,309,730,299,749,266.7C768,235,787,181,806,176C825.6,171,845,213,864,224C883.2,235,902,213,922,192C940.8,171,960,149,979,128C998.4,107,1018,85,1037,90.7C1056,96,1075,128,1094,122.7C1113.6,117,1133,75,1152,64C1171.2,53,1190,75,1210,74.7C1228.8,75,1248,53,1267,42.7C1286.4,32,1306,32,1325,37.3C1344,43,1363,53,1382,69.3C1401.6,85,1421,107,1430,117.3L1440,128L1440,320L1430.4,320C1420.8,320,1402,320,1382,320C1363.2,320,1344,320,1325,320C1305.6,320,1286,320,1267,320C1248,320,1229,320,1210,320C1190.4,320,1171,320,1152,320C1132.8,320,1114,320,1094,320C1075.2,320,1056,320,1037,320C1017.6,320,998,320,979,320C960,320,941,320,922,320C902.4,320,883,320,864,320C844.8,320,826,320,806,320C787.2,320,768,320,749,320C729.6,320,710,320,691,320C672,320,653,320,634,320C614.4,320,595,320,576,320C556.8,320,538,320,518,320C499.2,320,480,320,461,320C441.6,320,422,320,403,320C384,320,365,320,346,320C326.4,320,307,320,288,320C268.8,320,250,320,230,320C211.2,320,192,320,173,320C153.6,320,134,320,115,320C96,320,77,320,58,320C38.4,320,19,320,10,320L0,320Z"></path></svg>');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            padding: 5% 5%;
            animation: nyorosod 40s linear infinite;
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

        section {
            display: flex;
            justify-content: center;
        }

        main {
            place-items: center;
            width: 90%;
            max-width: 1300px;
            margin: 5% 5% 0% 5%;
        }

        main h2 {
            font-size: 48px;
            text-transform: capitalize;
        }

        .title {
            font-size: 36px;
            color: #800000;
            text-shadow: 3px 4px 1px #fff;
        }

        .desc {
            display: flex;
            justify-content: center;
        }

        .desc p {
            max-width: 600px;
            line-height: 16px;
            font-weight: 500;
            text-shadow: 1px 2px 0px #fff;
        }

        section ul,
        li,
        a {
            list-style-type: none;
            text-decoration: none;
        }

        section ul {
            margin-top: 10px;
            display: flex;
            flex-direction: row;
        }

        .sosmed {
            color: white;
            padding: 12px 22px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            margin: 16px;
            background-color: #800000;
            width: auto;
            border: 1px solid #fff;
            transition: 0.5s ease-in-out;

            &:hover {
                background-color: white;
                color: #800000;
                border: 1px solid #800000;
            }
        }

        .sosmed p {
            padding-left: 4px;
        }
    </style>

<body>
    <?php include "layout/naviga.php" ?>
    <main>
        <header>
            <div class="title">
                <h2>hubungi kami</h2>
            </div>
            <div class="desc">
                <p>Pilih salah satu kontak dibawah ini untuk menghubungi kami jika ada sesuatu yang ingin disampaikan
                    seputar website ini.</p>
            </div>
        </header>
        <section>
            <ul>
                <li>
                    <a href="https://www.instagram.com/vall.rar" target="_b">
                        <div class="sosmed">
                            <i class="fa-brands fa-instagram fa-xl"></i>
                            <p>Instagram</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="https://wa.me/6281321412314" target="_b">
                        <div class="sosmed">
                            <i class="fa-brands fa-whatsapp fa-xl"></i>
                            <p>Whatsapp</p>
                        </div>
                    </a>
                </li>
            </ul>
        </section>
    </main>
</body>

</html>