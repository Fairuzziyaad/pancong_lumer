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
    $nama = $_POST["nama"];
    $nomor_telepon = $_POST["nomor_telepon"];
    $tingkat_kematangan = $_POST["tingkat_kematangan"];
    $topping = isset($_POST["topping"]) ? implode(", ", $_POST["topping"]) : "";
    $jenis_adonan = $_POST["jenis_adonan"];
    $catatan = $_POST["catatan"];

    $sql = "INSERT INTO pembeli (nama, nomor_telepon, tingkat_kematangan, topping, jenis_adonan, catatan) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    // Tampilkan query SQL
    echo "SQL Query: " . $sql . "<br>";
    
    // Tampilkan nilai-nilai yang akan dimasukkan
    echo "Values: " . $nama . ", " . $nomor_telepon . ", " . $tingkat_kematangan . ", " . $topping . ", " . $jenis_adonan . ", " . $catatan . "<br>";

    // Coba prepare statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $nama, $nomor_telepon, $tingkat_kematangan, $topping, $jenis_adonan, $catatan);

    if ($stmt->execute()) {
        header("Location: tabeldata.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
