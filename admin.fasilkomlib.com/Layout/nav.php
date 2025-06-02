<?php
// Mulai sesi
session_start();
?>
<head>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    nav{
      position: fixed;
      top: 0;
      z-index: 99;
      width: 100%;
      background: #fff;
      box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    }
    nav .wrapperR{
      position: relative;
      max-width: 1300px;
      padding: 0px 30px;
      height: 55px;
      line-height: 70px;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .wrapperR .logosR a{
      color: #000;
      font-size: 30px;
      font-weight: 600;
      text-decoration: none;
    }
    .wrapperR .nav-linksR{
      display: inline-flex;
    }
    .nav-linksR li{
      list-style: none;
    }
    .nav-linksR li a{
      color: #000;
      text-decoration: none;
      font-size: 18px;
      font-weight: 500;
      padding: 12px 15px;
      border-radius: 5px;
      transition: all 0.3s ease;
    }
    .nav-linksR .drop-menuR{
      position: absolute;
      background: #242526;
      width: 180px;
      line-height: 45px;
      top: 85px;
      opacity: 0;
      visibility: hidden;
      box-shadow: 0 6px 10px rgba(0,0,0,0.15);
    }
    .nav-linksR li:hover .drop-menuR{
      transition: all 0.3s ease;
      top: 70px;
      opacity: 1;
      visibility: visible;
    }
    .drop-menuR li a{
      width: 100%;
      display: block;
      padding: 0 0 0 15px;
      font-weight: 400;
      border-radius: 0px;
    }
    .wrapperR .btnR{
      color: #fff;
      font-size: 20px;
      cursor: pointer;
      display: none;
    }
    .wrapperR .btnR.close-btnR{
      position: absolute;
      right: 30px;
      top: 10px;
    }

    @media screen and (max-width: 970px) {
      .wrapperR .btnR{
        display: block;
      }
      .wrapperR .nav-linksR{
        position: fixed;
        height: 100vh;
        width: 100%;
        max-width: 350px;
        top: 0;
        left: -100%;
        background: #242526;
        display: block;
        padding: 50px 10px;
        line-height: 50px;
        overflow-y: auto;
        box-shadow: 0px 15px 15px rgba(0,0,0,0.18);
        transition: all 0.3s ease;
      }
      #menu-btn:checked ~ .nav-linksR{
        left: 0%;
      }
      #menu-btn:checked ~ .btnR.menu-btnR{
        display: none;
      }
      #close-btn:checked ~ .btnR.menu-btnR{
        display: block;
      }
      .nav-linksR li{
        /* margin: 15px 10px; */
      }
      .nav-linksR li a{
        padding: 0 20px;
        display: block;
        font-size: 20px;
      }
      .nav-linksR .drop-menuR{
        position: static;
        opacity: 1;
        top: 65px;
        visibility: visible;
        padding-left: 20px;
        width: 100%;
        max-height: 0px;
        overflow: hidden;
        box-shadow: none;
        transition: all 0.3s ease;
      }
      .nav-linksR .mobile-itemR{
        display: block;
        color: #f2f2f2;
        font-size: 20px;
        font-weight: 500;
        padding-left: 20px;
        cursor: pointer;
        border-radius: 5px;
        transition: all 0.3s ease;
      }
      .nav-linksR .mobile-itemR:hover{
        background: #3A3B3C;
      }
      .drop-menuR li{
        margin: 0;
      }
      .drop-menuR li a{
        border-radius: 5px;
        font-size: 18px;
      }
    }
    nav input{
      display: none;
    }

    .logoBR{
        width: 40px;
        height: 40px;
        transform: translateY(7px);
        color: #000;
    }

    .underlineR {
      position: relative;
      color: #ecf0f1;
      text-decoration: none;
      transition: 0.5s;

      &::after {
        position: absolute;
        content: "";
        top: 100%;
        left: 0;
        width: 100%;
        height: 2px;
        background: #800000;
        transform: scaleX(0);
        transform-origin: center;
        transition: transform 0.3s;
        margin-top: 0px;
        }

        &:hover {
          color: #800000;
        }

        &:hover::after {
          transform: scaleX(1);
          transform-origin: center;
        }
      }
      #loading-bar {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 3px; /* Sesuaikan tinggi loading bar */
          background-color: #007bff; /* Warna loading bar */
          z-index: 9999;
      }

      #loading-bar-progress {
          height: 100%;
          background-color: #ffc107; /* Warna progres loading bar */
          width: 0%;
      }
      .logout{
        color: white !important;
        background-color: #800000;
        height: 1px !important;
      }

</style>

<body>
    <div id="loading-bar" style="display: none;">
            <div id="loading-bar-progress"></div>
    </div>
    <nav>
        <div class="wrapperR">
            <div class="logosR"><a href="index.php">
                    <i class="fa-solid fa-book"></i>
                    Tuku Buku </a></div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-linksR">
                <label for="close-btn" class="btnR close-btnR"><i class="fas fa-times"></i></label>
                <li>
                    <a class="underlineR" href="index.php">Beranda</a>
                </li>
                <li>
                    <a class="underlineR" href="mahasiswa.php">Kategori</a>
                </li>
                <li>
                    <a class="underlineR" href="matakuliah.php" class="desktop-itemR">About us</a>
                </li>
                <li>
                    <a class="underlineR" href="krs.php" class="desktop-itemR">Contact us</a>
                </li>

                <!-- Tampilkan tombol logout hanya jika pengguna sudah login -->
                <?php if (isset($_SESSION['username'])): ?>
                <li>
                    <a class="underlineR logout" href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                </li>
                <?php endif; ?>
                
            </ul>
            <label for="menu-btn" class="btnR menu-btnR"><i class="fas fa-bars"></i></label>
        </div>
    </nav>

      <script>
        function showLoadingBar() {
            document.getElementById("loading-bar").style.display = "block";
            document.getElementById("loading-bar-progress").style.width = "0%";
        }

        function updateLoadingBar(progress) {
            document.getElementById("loading-bar-progress").style.width = progress + "%";
        }

        function hideLoadingBar() {
            document.getElementById("loading-bar").style.display = "none";
        }
      </script>
</body>