<!DOCTYPE html>
<html lang="en">

<head>
  <title>Footer Design</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.gigaval.com/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

  body {
    line-height: 1.5;
    font-family: 'Poppins', sans-serif;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .container {
    bottom: 0;
    max-width: 1170px;
    margin: auto;
  }

  .row {
    display: flex;
    flex-wrap: wrap;
  }

  ul {
    list-style: none;
  }

  .footer {
    background-color: white;
    background-size: contain;
    background-repeat: repeat no-repeat;
    background-position: 35vw bottom;
    background-image: url("data:image/svg+xml;utf8,<svg viewBox='0 0 1200  134' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M0 98L50 92C100 86 200 74 300 50C400 26 500 -10 600 2C700 14 800 74 900 98C1000 122 1100 110 1150 104L1200 98V134H1150C1100 134 1000 134 900 134C800 134 700 134 600 134C500 134 400 134 300 134C200 134 100 134 50 134H0V98Z' fill='%23800000'/></svg>");
    padding: 70px 0;
    color: #000;
  }

  .footer-col {
    width: 25%;
    padding: 0 15px;
  }

  .footer-col h4 {
    font-size: 18px;
    color: #000;
    text-transform: capitalize;
    margin-bottom: 35px;
    font-weight: 500;
    position: relative;
  }

  .footer-col h4::before {
    content: '';
    position: absolute;
    left: 0;
    bottom: -10px;
    background-color: #800000;
    height: 2px;
    box-sizing: border-box;
    width: 50px;
  }

  .footer-col ul li:not(:last-child) {
    margin-bottom: 10px;
  }

  .footer-col ul li a {
    font-size: 16px;
    text-transform: capitalize;
    color: #000;
    text-decoration: none;
    font-weight: 300;
    display: block;
    transition: all 0.3s ease;
  }

  .footer-col ul li a:hover {
    color: #800000;
    padding-left: 8px;
  }

  .footer-col .social-links a {
    display: inline-block;
    height: 40px;
    width: 40px;
    background-color: #800000;
    margin: 0px 10px 10px 0;
    place-items: center ;
    text-align: center;
    line-height: 40px;
    border-radius: 50%;
    color: #ffffff;
    transition: all 0.5s ease;
  }

  .footer-col .social-links a:hover {
    color: #24262b;
    background-color: #ffffff;
  }

  /*responsive*/
  @media(max-width: 767px) {
    .footer-col {
      width: 50%;
      margin-bottom: 30px;
    }
  }

  @media(max-width: 574px) {
    .footer-col {
      width: 100%;
    }
  }
</style>

<body>

  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="footer-col">
          <h4>ikuti kami</h4>
          <div class="social-links">
            <a href="https://www.github.com/onyxseal">
              <i class="fab fa-github"></i>
            </a>
            <a href="https://www.instagram.com/vall.rar">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>

</body>

</html>