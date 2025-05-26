<?php
include '../connection/conn.php';
if (isset($_POST["submit"])) {
  $title = $_POST["title"];
  $author = $_POST["author"];
  $sinopsis = $_POST["sinopsis"];
  $isbn = $_POST["isbn"];
  $genre = $_POST["genre"];
  $price = $_POST["price"];
  $stock = $_POST["quantityavail"];
  $nop = $_POST["numberofpage"];
  $postby = $_POST["postby"];
  if ($_FILES["image"]["error"] == 4) {
    echo "<script>alert('Image Does Not Exist');</script>";
  } else {
    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
      echo "<script>alert('Invalid Image Extension');</script>";
    } else if ($fileSize > 1000000) {
      echo "<script>alert('Image Size Is Too Large');</script>";
    } else {
      $newImageName = str_replace(' ', '_', $fileName);
      $newImageName = preg_replace('/[^\w\-.:]/', '', $newImageName);

      $newImageName = "[NEW] [" . $title . "] " . date("Y.m.d") . " - " . date("h.i.sa") . '.' . $imageExtension;

      move_uploaded_file($tmpName, 'listgambar/' . $newImageName);
      $query = "INSERT INTO books (title, author, sinopsis, isbn, genre, price, quantityavail, numberofpage, cover, postby) VALUES('$title', '$author', '$sinopsis', '$isbn', '$genre', '$price', '$stock', '$nop', '$newImageName', '$postby')";
      mysqli_query($db, $query);
      echo "<script>alert('Buku berhasil ditambahkan'); document.location.href = 'barang.php';</script>";
    }
  }


}

// Query untuk mengambil buku terbaru
$query_produk = "SELECT * FROM books ORDER BY publicationdate DESC LIMIT 4";
$result_produk = $db->query($query_produk);

$recent_books = [];

if ($result_produk->num_rows > 0) {
  while ($row = $result_produk->fetch_assoc()) {
    $recent_books[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Tambah Buku</title>
  <link rel="icon" href="https://www.gigaval.com/favicon.ico">
</head>

<style>
  body {
    font-family: Poppins;
  }

  .nasiLemak {
    margin: 2% 1% 2% 6.5%;
    display: flex;
    align-items: start;
    gap: 30px;
  }

  .nasiPadang {
    flex: 3;
    background-color: white;
    padding: 16px;
    border-radius: 10px;
    height: 100%;
  }

  .nasiTangkar {
    flex: 1;
    background-color: white;
    padding: 16px;
    border-radius: 10px;
  }

  .titleDBar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1% 0%;
    border-bottom: 2px solid rgba(128, 0, 0, 0.4);
    margin-bottom: 10px;
  }

  #titleTB {
    font-size: 24px;
    font-weight: 600;
  }

  /* Style untuk input */
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

  /* Style untuk textarea */
  textarea {
    display: block;
    width: 100%;
    min-width: 839px;
    min-height: 80px;
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
    box-sizing: border-box;
    max-width: 100%;
    resize: none;
  }

  textarea:focus {
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

  .recentBookAdded {
    background-color: #EDEDED;
    border-radius: 10px;
    height: auto;
    padding: 10px;
    margin-bottom: 20px;
  }

  .boxRBA {
    background-color: #EDEDED;
    display: grid;
    grid-template-columns: 1fr 2fr;
    border-bottom: 1px solid black;
    /* Menambahkan margin bawah untuk memisahkan item */
  }

  .coverRBA img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
    margin-right: 10px;
  }

  .addBy {
    text-align: right;
  }

  .actBack a {
    color: black;
    text-decoration: none;
    transition: all 1s ease-in-out;
  }

  .actBack a .fa-angle-left {
    transition: margin 0.5s ease-in-out;
  }

  .actBack:hover .fa-angle-left {
    margin-left: 5px;
    margin-right: -5px;
    transition: margin 0.5s ease-in-out;
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
  <?php include "nav.php" ?>
  <?php include "sidebar.php" ?>
  <div class="nasiLemak">
    <div class="nasiPadang">
      <div class="actBack">
        <a href="javascript:history.back()">
          <i class="fa fa-angle-left"></i>&emsp;Kembali
        </a>
      </div>
      <div class="titleDBar">
        <span id="titleTB">Tambah Buku</span>
      </div>
      <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <label for="title">Judul : </label>
        <input class="input" type="text" name="title" id="title" placeholder="Masukkan judul" required> <br>

        <label for="author">Author : </label>
        <input class="input" type="text" name="author" id="author" placeholder="Masukkan author" required> <br>

        <label for="sinopsis">Sinopsis : </label>
        <textarea class="input" name="sinopsis" id="sinopsis" placeholder="Masukkan Sinopsis" required></textarea> <br>

        <label for="isbn">ISBN : </label>
        <input class="input" type="text" name="isbn" id="isbn" placeholder="Masukkan kode isbn" required> <br>

        <label for="genre">Genre : </label>
        <input class="input" type="text" name="genre" id="genre" placeholder="Masukkan genre buku" required> <br>

        <label for="price">Harga : </label>
        <input class="input" type="number" name="price" id="price" placeholder="Masukkan harga" required> <br>

        <label for="quantityavail">Stock : </label>
        <input class="input" type="number" name="quantityavail" id="quantityavail" placeholder="Masukkan jumlah stock"
          required> <br>

        <label for="numberofpage">Jumlah Halaman : </label>
        <input class="input" type="number" name="numberofpage" id="numberofpage" placeholder="Masukkan jumlah halaman"
          required> <br>

        <input class="input" type="hidden" name="postby" id="postby" value="<?php echo $fullname ?>">

        <label for="image">Image : </label>
        <input class="input" type="file" name="image" id="image" accept=".jpg, .jpeg, .png" required> <br>

        <div class="editBut">
          <div class="subJud">
            <button class="button" type="submit" name="submit">Posting</button>
          </div>
        </div>
      </form>
    </div>

    <!-- buku terakhir yang ditambahkan ini teh abangku -->
    <div class="nasiTangkar">
      <div class="titleDBar">
        <span id="titleTB">Buku yang terakhir ditambahkan</span>
      </div>
      <?php foreach ($recent_books as $book): ?>
        <div class="recentBookAdded">
          <div class="boxRBA">
            <div class="coverRBA">
              <img src="listgambar/<?php echo $book['cover']; ?>" alt="<?php echo $book['title']; ?>">
            </div>
            <div class="descRBA">
              <span id="titleRBA"><b><?php echo $book['title']; ?></b></span><br>
              <span id="authorRBA">Author: <?php echo $book['author']; ?></span>
            </div>
          </div>
          <div class="addBy">
            <span id="addBy"><i>Added by :</i> <?php echo $book['postby']; ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

<script>
  const inputs = document.querySelectorAll(".input");
  const button = document.querySelector(".button");

  inputs.forEach(input => input.addEventListener("input", validateInputs));

  function validateInputs() {
    const allFilled = Array.from(inputs).every(input => input.value !== "");
    button.disabled = !allFilled;
  }

  validateInputs();  // Initial validation in case some inputs are pre-filled
</script>

</html>