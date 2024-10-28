<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pancong_lumer";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $tingkat_kematangan = $_POST['tingkat_kematangan'];
    $topping = implode(", ", $_POST['topping']);
    $jenis_adonan = $_POST['jenis_adonan'];
    $catatan = $_POST['catatan'];

    $sql = "UPDATE pembeli SET nama=?, nomor_telepon=?, tingkat_kematangan=?, topping=?, jenis_adonan=?, catatan=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nama, $nomor_telepon, $tingkat_kematangan, $topping, $jenis_adonan, $catatan, $id);

    if ($stmt->execute()) {
        header("Location: tabeldata.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pembeli WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $toppings = explode(", ", $row['topping']);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Pesanan Pancong Lumer</title>
    
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="active.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="img/headerimage.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body id="order" style="background-color: #bfa58c;">
    <!-- heading -->
    <nav class="navbar navbar-expand-lg" style="background-color: #74512D;">
      <div class="container">
        <a class="header-image-link" href="index.html">
          <img src="img/headerimage.png" alt="header image" class="header-image" style="width: 4.5rem; height: auto; cursor: default;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" id="nav-home" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="nav-about" href="portal.html">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="nav-order" href="forminput.html">Order</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" id="nav-tabeldata" href="tabeldata.php">Order Data</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- form edit -->
    <section style="background-color: #bfa58c;">
        <div class="container">
            <div class="row mb-3">
                <div class="col text-center mt-5">
                    <h1>Edit Pesanan</h1>
                </div>
            </div>
        </div>
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <!-- text box -->
            <div class="container">
                <div class="row justify-content-center">
                  <div class="col-md-6">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingName" name="nama" placeholder="Rudi Gunawan" value="<?php echo $row['nama']; ?>" required>
                      <label for="floatingName">Nama</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="floatingNumber" name="nomor_telepon" placeholder="0811111" value="<?php echo $row['nomor_telepon']; ?>" required>
                      <label for="floatingNumber">Nomer Telepon</label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- radio button -->
              <div class="d-flex justify-content-center" >
                <p class="me-3">Tingkat Kematangan:</p>
                <div class="form-check me-3" >
                  <input class="form-check-input" type="radio" name="tingkat_kematangan" id="flexRadioDefault1" value="Matang" <?php echo ($row['tingkat_kematangan'] == 'Matang') ? 'checked' : ''; ?> required>
                  <label class="form-check-label" for="flexRadioDefault1">
                    Matang
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="tingkat_kematangan" id="flexRadioDefault2" value="Setengah Matang" <?php echo ($row['tingkat_kematangan'] == 'Setengah Matang') ? 'checked' : ''; ?> required>
                  <label class="form-check-label" for="flexRadioDefault2">
                    Setengah Matang
                  </label>
                </div>
              </div>
              <!-- check box -->
              <div class="container">
                <div class="row justify-content-center mb-3">
                  <div class="col-md-6">
                    <p>Topping:</p>
                    <div class="row">
                      <?php
                      $all_toppings = ['Nuttela', 'Matcha', 'Ovomaltine', 'Meses', 'Susu Kental Manis', 'Keju', 'Oreo', 'Stroberi', 'Red velvet'];
                      foreach ($all_toppings as $topping) {
                        echo '<div class="col-md-6 col-lg-4 mb-3">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="topping[]" value="' . $topping . '" id="topping' . $topping . '"' . (in_array($topping, $toppings) ? ' checked' : '') . '>
                                  <label class="form-check-label" for="topping' . $topping . '">
                                    ' . $topping . '
                                  </label>
                                </div>
                              </div>';
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- select -->
              <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3">
                        <select class="form-select" aria-label="Default select example" name="jenis_adonan" required>
                            <option value="">Jenis Adonan</option>
                            <option value="Original" <?php echo ($row['jenis_adonan'] == 'Original') ? 'selected' : ''; ?>>Original</option>
                            <option value="Pandan" <?php echo ($row['jenis_adonan'] == 'Pandan') ? 'selected' : ''; ?>>Pandan</option>
                            <option value="Coklat" <?php echo ($row['jenis_adonan'] == 'Coklat') ? 'selected' : ''; ?>>Coklat</option>
                          </select>
                    </div>
                </div>
              </div>
              <!-- catatan -->
               <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Tinggalkan catatan disini" id="floatingTextarea2" name="catatan" style="height: 100px"><?php echo $row['catatan']; ?></textarea>
                            <label for="floatingTextarea2">Catatan</label>
                          </div>
                    </div>
                </div>
               </div>
               <!-- button -->
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <button type="submit" class="btn" style="background-color: #d0904f;">Simpan Perubahan</button>
                            <a href="tabeldata.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </div>
        </form>
     </section>

     <!-- Footer -->
     <footer style="background-color: #bfa58c;" class="text-white text-center pb-2 pt-5">
      <p>Created by <a href="https://instagram.com/zyaadp?igshid=OGQ5ZDc2ODk2ZA==" class="text-white fw-bold">Fairuz Ziyaad Purnomo</a></p>
    </footer>
    <!-- End Footer -->

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan mengedit data ini!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, edit!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
    </script>
  </body>
</html>

<?php
$conn->close();
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<script>
    Swal.fire(
        'Berhasil!',
        'Data telah diperbarui.',
        'success'
    ).then(() => {
        window.location.href = 'tabeldata.php';
    });
    </script>";
    exit();
}
?>
