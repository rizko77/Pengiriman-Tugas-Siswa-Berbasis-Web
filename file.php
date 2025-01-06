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

// Folder uploads
$uploadDir = 'uploads/';

// Handle delete request
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $file = $_GET['file'];
    $filePath = $uploadDir . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
        echo "<script>alert('File deleted successfully'); window.location='file.php';</script>";
    } else {
        echo "<script>alert('File not found'); window.location='file.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
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
                <a href="file.php" class="nav-link">File Manager</a>
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
                        <a href="index.php" class="nav-link">
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
                        <h1 class="m-0">File Manager</h1>
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
                        <h3 class="card-title">Uploaded Files</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="fileTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($handle = opendir($uploadDir)) {
                                    while (false !== ($file = readdir($handle))) {
                                        if ($file != "." && $file != "..") {
                                            echo "<tr>";
                                            echo "<td>" . $file . "</td>";
                                            echo "<td>
                                                    <a href='" . $uploadDir . $file . "' download class='btn btn-primary btn-sm'>Download</a>
                                                    <a href='file.php?action=delete&file=" . urlencode($file) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    }
                                    closedir($handle);
                                } else {
                                    echo "<tr><td colspan='2'>No files found</td></tr>";
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
                    <h5 class="modal-title" id="settingsModalLabel">Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Settings content -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    function updateTime() {
        var now = new Date();
        var time = now.getHours() + ':' + (now.getMinutes()<10?'0':'') + now.getMinutes() + ':' + (now.getSeconds()<10?'0':'') + now.getSeconds();
        document.getElementById('currentTime').textContent = time;
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
</body>
</html>
