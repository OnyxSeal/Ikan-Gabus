<?php
session_start();

include "../Connection/conn.php";

// Mengambil ID dari URL
$id = $_GET['edit_id'];

// Mengambil data barang berdasarkan ID
$stmt = $db->prepare("SELECT * FROM books WHERE bookID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
} else {
  echo "Data tidak ditemukan";
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data yang diubah dari form
  $title = $_POST['title'];
  $author = $_POST['author'];
  $sinopsis = $_POST['sinopsis'];
  $isbn = $_POST['isbn'];
  $genre = $_POST['genre'];
  $price = $_POST['price'];
  $quantityavail = $_POST['quantityavail'];
  $numberofpage = $_POST['numberofpage'];

  // Periksa apakah ada file gambar yang diunggah
  if ($_FILES['cover']['name']) {
    $target_dir = "listgambar/";

    date_default_timezone_set('Asia/Jakarta');

    $imageExtension = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));

    // Memeriksa apakah format file gambar valid
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageExtension, $allowedExtensions)) {
      echo "Format file gambar tidak valid. Harap unggah file dengan format JPG, JPEG, PNG, atau GIF.";
      exit;
    }

    $newImageName = "[" . $title . " Edited] " . date("Y.m.d") . " - " . date("h.i.sa") . "." . $imageExtension;

    $target_file = $target_dir . $newImageName;

    move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file);

    $cover = $newImageName;
  } else {
    $cover = $row['cover'];
  }

  // Perbarui data barang di database
  $stmt = $db->prepare("UPDATE books SET title = ?, author = ?, sinopsis = ?, isbn = ?, genre = ?, price = ?, quantityavail = ?, numberofpage = ?, cover = ? WHERE bookID = ?");
  $stmt->bind_param("ssssssisss", $title, $author, $sinopsis, $isbn, $genre, $price, $quantityavail, $numberofpage, $cover, $id);

  if ($stmt->execute()) {
    echo "<script>alert('Berhasil diubah'); document.location.href = 'barang.php';</script>";
  } else {
    echo "Error updating record: " . $stmt->error;
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Barang</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="icon" href="https://www.gigaval.com/favicon.ico">
</head>

<style>
  body {
    font-family: Poppins;
    background-color: #EDEDED;
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
    box-sizing: border-box;
    max-width: 100%;
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
    max-width: 839px;
    min-width: 839px;
    min-height: 40px;
    max-height: 80px;
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

  button:disabled {
    opacity: 0.5;
    pointer-events: none;
  }

  .cover img {
    height: 229px;
    width: 150px;
    background-size: contain;
    object-fit: cover;
  }

  .mb-3 {
    margin-bottom: 9px;
  }
</style>

<body>
  <div class="nasiLemak">
    <!-- buku terakhir yang ditambahkan ini teh abangku -->
    <div class="nasiTangkar">
      <div class="titleDBar">
        <span id="titleTB">Buku yang akan diubah</span>
      </div>
      <div class="bukuMwDiEdit mb-3">
        <div class="cover">
          <img src="listgambar/<?php echo $row['cover']; ?>" alt="">
        </div>
        <div class="judul mb-3">
          <label for="title">Judul : </label>
          <?php echo $row['title']; ?>
        </div>
        <div class="author mb-3">
          <label for="title">Author : </label>
          <?php echo $row['author']; ?>
        </div>
        <div class="sinopsis mb-3">
          <label for="title">Sinopsis : </label>
          <?php echo $row['sinopsis']; ?>
        </div>
        <div class="isbn">
          <label for="title mb-3">ISBN : </label>
          <?php echo $row['isbn']; ?>
        </div>
        <div class="genre mb-3">
          <label for="title">Genre : </label>
          <?php echo $row['genre']; ?>
        </div>
        <div class="price mb-3">
          <label for="title">Price : </label>
          <?php echo $row['price']; ?>
        </div>
        <div class="qa mb-3">
          <label for="title">Jumlah Stock : </label>
          <?php echo $row['quantityavail']; ?>
        </div>
        <div class="nop mb-3">
          <label for="title">Jumlah Halaman : </label>
          <?php echo $row['numberofpage']; ?>
        </div>
      </div>

    </div>
    <div class="nasiPadang">
      <div class="actBack">
        <a href="javascript:history.back()">
          <i class="fa fa-angle-left"></i>&emsp;Kembali
        </a>
      </div>
      <div class="titleDBar">
        <span id="titleTB">Edit Buku</span>
      </div>
      <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <label for="title">Judul : </label>
        <input type="text" name="title" value="<?php echo $row['title']; ?>"> <br>

        <label for="author">Author : </label>
        <input type="text" name="author" value="<?php echo $row['author']; ?>"> <br>

        <label for="sinopsis">Sinopsis : </label>
        <textarea name="sinopsis"><?php echo $row['sinopsis']; ?></textarea> <br>

        <label for="isbn">ISBN : </label>
        <input type="text" name="isbn" value="<?php echo $row['isbn']; ?>"> <br>

        <label for="genre">Genre : </label>
        <input type="text" name="genre" value="<?php echo $row['genre']; ?>"> <br>

        <label for="price">Harga : </label>
        <input type="number" name="price" value="<?php echo $row['price']; ?>"> <br>

        <label for="quantityavail">Stock : </label>
        <input type="number" name="quantityavail" value="<?php echo $row['quantityavail']; ?>"> <br>

        <label for="numberofpage">Jumlah Halaman : </label>
        <input type="number" name="numberofpage" value="<?php echo $row['numberofpage']; ?>"> <br>

        <label for="image">Image : </label>
        <div class="cover">
          <input type="file" name="cover" accept=".jpg, .jpeg, .png">
        </div> <br>

        <div class="editBut">
          <div class="subJud">
            <button type="submit" class="btn-edit">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>

  </div>
</body>

</html>

<?php
// Menutup koneksi
$db->close();
?>

</body>

</html>