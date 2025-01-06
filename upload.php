<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root"; //Silahkan diubah jika dishoting
$password = ""; //Silahkan diubah jika dishoting
$dbname = "upload"; //Silahkan diubah jika dishoting

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_siswa = $_POST['nama_siswa'];
    $kelas = $_POST['kelas'];
    $file_tugas = $_FILES['file_tugas']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file_tugas);

    // Memindahkan file yang diunggah ke folder tujuan
    if (move_uploaded_file($_FILES["file_tugas"]["tmp_name"], $target_file)) {
        // Menyimpan data ke database
        $sql = "INSERT INTO tugas_siswa (nama_siswa, kelas, file_tugas) VALUES ('$nama_siswa', '$kelas', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            // Menampilkan modal sukses
            echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">';
            echo '<div class="modal fade show" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pemberitahuan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href=\'index.php\'">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tugas berhasil dikirim!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.href=\'index.php\'">OK</button>
                            </div>
                        </div>
                    </div>
                  </div>';
            echo '<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
            echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';
            echo '<script>$(document).ready(function() { $("#successModal").modal("show"); });</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
