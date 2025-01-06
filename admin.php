<?php
session_start();

// Mencegah caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}


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

// Handle delete request
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $delete_sql = "DELETE FROM tugas_siswa WHERE id='$id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $conn->error . "'); window.location='admin.php';</script>";
    }
}

// Handle edit request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $edit_nama_siswa = $_POST['edit_nama_siswa'];
    $edit_kelas = $_POST['edit_kelas'];
    $update_sql = "UPDATE tugas_siswa SET nama_siswa='$edit_nama_siswa', kelas='$edit_kelas' WHERE id='$edit_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Record updated successfully'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Error updating record: " . $conn->error . "'); window.location='admin.php';</script>";
    }
}

// Handle search request
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql = "SELECT id, nama_siswa, kelas, file_tugas FROM tugas_siswa WHERE kelas LIKE '%$search_query%'";
} else {
    $sql = "SELECT id, nama_siswa, kelas, file_tugas FROM tugas_siswa";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Uploader - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="admin.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Pengaturan</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#settingsModal" href="#">
                    <i class="fas fa-cogs"></i>
                </a>
            </li>
            <li class="nav-item">
                <span class="nav-link" id="currentTime">HH:MM:SS</span>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="admin.php" class="brand-link">
            <span class="brand-text font-weight-light"><b>Task Uploader</b></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Tugas Siswa
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="dokumentasi.php" class="nav-link">
                            <i class="nav-icon fas fa-folder"></i>
                            <p>
                                Dokumentasi
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="file.php" class="nav-link">
                            <i class="nav-icon fas fa-folder"></i>
                            <p>
                                File Manager
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Daftar Tugas Siswa</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Tugas Siswa</h3>
                        <div class="card-tools">
                            <form method="GET" action="admin.php">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Cari Kelas" value="<?= $search_query ?>">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tugasTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>File Tugas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['nama_siswa'] . "</td>";
                                        echo "<td>" . $row['kelas'] . "</td>";
                                        echo "<td><a href='" . $row['file_tugas'] . "' download>" . basename($row['file_tugas']) . "</a></td>";
                                        echo "<td>
                                                <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' data-id='" . $row['id'] . "' data-nama='" . $row['nama_siswa'] . "' data-kelas='" . $row['kelas'] . "'>Edit</button>
                                                <a href='admin.php?action=delete&id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Hapus</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No records found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsModalLabel">Pengaturan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Pengaturan konten -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="admin.php">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_nama_siswa">Nama Siswa</label>
                            <input type="text" class="form-control" id="edit_nama_siswa" name="edit_nama_siswa" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_kelas">Kelas</label>
                            <input type="text" class="form-control" id="edit_kelas" name="edit_kelas" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        Copyright &copy; 2024 <a href="https://github.com/rizko77">Rizko Imsar</a>.
        All rights reserved.
    </footer>

</div>
<!-- ./wrapper -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var nama = button.data('nama')
            var kelas = button.data('kelas')

            var modal = $(this)
            modal.find('#edit_id').val(id)
            modal.find('#edit_nama_siswa').val(nama)
            modal.find('#edit_kelas').val(kelas)
        });

        function updateTime() {
            var now = new Date();
            var time = now.getHours() + ':' + (now.getMinutes()<10?'0':'') + now.getMinutes();
            document.getElementById('currentTime').textContent = time;
        }
        setInterval(updateTime, 1000);
        updateTime();
    });
</script>
</body>
</html>

<?php
$conn->close();
?>
