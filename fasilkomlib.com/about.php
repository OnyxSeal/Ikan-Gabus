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
    <title>Tentang Kami</title>
    <link rel="icon" href="https://www.gigaval.com/favicon.ico">
</head>

<style>
    body {
        width: 100%;
        min-height: 100vh;
        text-align: center;
        background: linear-gradient(to bottom right, white 50%, #999999 50%);
        background-attachment: fixed;
        padding: 5% 5%;
    }

    main {
        align-content: center;
        width: 90%;
        max-width: 1300px;
        margin: 1% 5% 0% 5%;
    }

    main h2 {
        font-size: 48px;
        text-transform: capitalize;
    }

    .title {
        font-size: 36px;
        color: #800000;
    }

    .desc {
        line-height: 14px;
    }


    section img {
        z-index: 2;
    }

    .bgBlob {
        z-index: 1;
    }

    .sosmed ul li,
    .sosmed ul li a {
        list-style-type: none;
        text-decoration: none;
        color: white;

        &:hover{
            color: #800000;
        }
    }

    .sosmed {
        z-index: 3;
        margin-top: -40px;
        margin-bottom: 15px;
    }

    .sosmed ul li a{
        place-content: center;
        height: auto;
        width: auto;
        /* margin-top: -100px; */
        /* margin-bottom: 5px; */
        background-color: #800000;
        border-radius: 10px;
        z-index: 4;
        padding: 9px;
        border: 1px solid #800000;
        transition: 0.5s ease-in-out;

        &:hover {
            background-color: white;
            border: 1px solid #800000;
        }
    }

    .sosmed ul{
        display: flex;
        justify-content: row;
        gap: 10px;
    }

    .name {
        background-color: white;
        padding: 0 16px;
        line-height: 36px;
        border-radius: 10px 0 0;
        max-width: 480px;
        z-index: 3;
    }

    .name1 {
        background-color: white;
        padding: 0 16px;
        line-height: 36px;
        border-radius: 0 10px 0 0;
        max-width: 480px;
    }

    .raival {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: right;
    }

    .resti {
        margin-top: -200px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-repeat: no-repeat;
        background-position: left;
        background-size: contain;
    }
    .raival h2,
    .resti h2 {
        max-width: 800px;
        color: #333;
        font-size: 2em;
        text-align: right;
    }

    .jab {
        font-size: 20px;
        font-weight: 600;
        background-color: #900000;
        width: 200px;
        border-radius: 0 0 10px 10px;
        padding: 0 16px;
        text-align: right;
        color: white;
    }

    .jab1 {
        font-size: 20px;
        font-weight: 600;
        background-color: #900000;
        width: 200px;
        border-radius: 0 0 10px 10px;
        padding: 0 16px;
        text-align: left;
        color: white;
    }

    .content {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
    }

    .content-image img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .content-text {
        max-width: 400px;
        text-align: left;
    }

    .content-text h3 {
        color: #00A1E0;
        font-size: 1.5em;
    }

    .content-text p {
        color: #666;
        line-height: 1.6;
    }

    .content-text a {
        display: block;
        margin-top: 10px;
        color: #00A1E0;
        text-decoration: none;
        font-weight: bold;
    }

    .chat-msg-text {
        background-color: white;
        padding: 15px;
        border-radius: 20px 20px 0 20px;
        line-height: 1.5;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: -10px;
        position: relative;
        display: flex;
        transform: translate(-70%, 210%);
    }

    .chat-msg-text2 {
        background-color: white;
        padding: 15px;
        border-radius: 20px 20px 20px 0;
        line-height: 1.5;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: -10px;
        position: relative;
        display: flex;
        transform: translate(140%, 140%);
    }

    .chat-msg-text3 {
        background-color: white;
        padding: 15px;
        border-radius: 20px 20px 0 20px;
        line-height: 1.5;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: -10px;
        position: relative;
        display: flex;
        transform: translate(-230%, 110%);
    }

    .chat-msg-text+.chat-msg-text {
        margin-top: 10px;
    }

    .chat-msg-text {
        color: black;
    }
</style>

<body>
    <?php include "layout/naviga.php" ?>
    <main>
        <header>
            <div class="title">
                <h2>tentang kami</h2>
            </div>
            <div class="desc">
                <p>Pacu kudamu kawan, idolamu sedang dihina</p>
            </div>
        </header>
        <section class="raival" style="background-image: url('image/about/graph.png');">
            <div class="chat-msg-text">Makan ga makan asal minum</div>
            <img src="image/about/val.png" alt="Man" width="200px">
            <div class="sosmed">
                <ul>
                    <li>
                        <a href="https://www.instagram.com/vall.rar" target="_b">
                            <i class="fa-brands fa-instagram fa-xl"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.github.com/onyxseal" target="_b">
                            <i class="fa-brands fa-github fa-xl"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="name">
                <h2>Raival Maulidan M A</h2>
            </div>
            <div class="jab">
                <span>CEO/Owner</span>
            </div>
        </section>
        <section class="resti" style="background-image: url('image/about/graph(1).png');">
            <div class="chat-msg-text2">Aku sih yes</div>
            <img src="image/about/woman.png" alt="Woman" width="200px">
            <div class="name1">
                <h2>Resti Dwi Artika</h2>
            </div>
            <div class="jab1">
                <span>Assistant</span>
            </div>
        </section>
    </main>
</body>

</html>