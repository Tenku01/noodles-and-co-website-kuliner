<?php
// Database connection
$koneksi = mysqli_connect("localhost", "root", "", "reservation");

// Check connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize and validate input data
$name = mysqli_real_escape_string($koneksi, trim($_POST['name'] ?? ''));
$telephone = mysqli_real_escape_string($koneksi, trim($_POST['telephone'] ?? ''));
$orang = mysqli_real_escape_string($koneksi, trim($_POST['orang'] ?? ''));
$tanggal = mysqli_real_escape_string($koneksi, trim($_POST['tanggal'] ?? ''));
$jam = mysqli_real_escape_string($koneksi, trim($_POST['jam'] ?? ''));
$pesan = mysqli_real_escape_string($koneksi, trim($_POST['pesan'] ?? ''));

// Validate required fields
if (empty($name) || empty($telephone) || empty($orang) || empty($tanggal) || empty($jam)) {
    die("All fields are required.");
}

// Prepared statement to insert data
$query = "INSERT INTO pesan (name, telephone, orang, tanggal, jam, pesan) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $telephone, $orang, $tanggal, $jam, $pesan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "Reservation successful.";
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// Close the database connection
mysqli_close($koneksi);
?>
