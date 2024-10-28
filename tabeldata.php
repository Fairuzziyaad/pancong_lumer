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

// Proses penghapusan data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM pembeli WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: tabeldata.php");
    exit();
}

$sql = "SELECT * FROM pembeli";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pancong Lumer</title>
    
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="active.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="img/headerimage.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body id="order">
    <!-- heading -->
   

    <!-- form pembelian -->
    <section style="background-color: #AF8F6F;">
      <div class="container">
        <div class="row mb-3">
          <div class="col text-center mt-5">
            <h1>Data Pembeli</h1>
          </div>
        </div>
      </div>
      <!-- tombol order -->
      <div class="container">
        <div class="row justify-content-center mb-3">
          <div class="col-md-11">
            <a class="btn btn-order" style="background-color: #d0904f;" href="forminput.html">
              Order Form
            </a>
          </div>
        </div>
      </div>
      <!-- tabel data -->
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <table class="table table-warning table-striped">
              <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nomer Telepon</th>
                    <th scope="col">Tingkat Kematangan</th>
                    <th scope="col">Topping</th>
                    <th scope="col">Jenis Adonan</th>
                    <th scope="col">Catatan</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result->num_rows > 0) {
                      $counter = 1;
                      while($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          echo "<th scope='row'>" . $counter . "</th>";
                          echo "<td>" . $row["nama"] . "</td>";
                          echo "<td>" . $row["nomor_telepon"] . "</td>";
                          echo "<td>" . $row["tingkat_kematangan"] . "</td>";
                          echo "<td>" . $row["topping"] . "</td>";
                          echo "<td>" . $row["jenis_adonan"] . "</td>";
                          echo "<td>" . $row["catatan"] . "</td>";
                          echo "<td>
                                  <a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Edit</a>
                                  <button onclick='confirmDelete(" . $row["id"] . ")' class='btn btn-danger btn-sm'>Hapus</button>
                                  </td>";
                          echo "</tr>";
                          $counter++;
                      }
                  } else {
                      echo "<tr><td colspan='8'>Tidak ada data pemesanan</td></tr>";
                  }
                  ?>
                </tbody>
          </table>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer style="background-color: #AF8F6F;" class="text-white text-center pb-2 pt-5">
      <p>Created by <a href="https://instagram.com/zyaadp?igshid=OGQ5ZDc2ODk2ZA==" class="text-white fw-bold">Fairuz Ziyaad Purnomo</a></p>
    </footer>
    <!-- End Footer -->

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'tabeldata.php?delete=' + id;
            }
        })
    }
    </script>
  </body>
</html>

<?php
$conn->close();
?>
