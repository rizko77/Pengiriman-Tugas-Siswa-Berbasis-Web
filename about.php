<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Aplikasi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #000; /* Warna hitam */
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff; /* Warna putih */
        }

        body {
            background-color: #343a40; /* Warna gelap */
            color: #fff; /* Warna teks putih */
        }

        .card {
            background-color: #495057; /* Warna background kartu */
            color: #fff; /* Warna teks kartu */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="https://rizkoimsar.my.id/"><b>Task Uploader</b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" id="currentTime">HH:MM:SS WIB</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header bg-secondary text-white">
                Tentang Aplikasi
            </div>
            <div class="card-body">
                <h5 class="card-title">Aplikasi Pengumpulan Tugas Siswa</h5>
                <p class="card-text">Aplikasi ini dikembangkan oleh Rizko Imsar untuk mempermudah perekapan tugas siswa. Aplikasi ini memungkinkan siswa untuk mengirimkan tugas mereka secara online, dan guru dapat mengakses dan merekap tugas tersebut melalui antarmuka admin.</p>
                <p class="card-text">Cara kerja aplikasi ini adalah sebagai berikut:</p>
                <ul>
                    <li><strong>Siswa:</strong> Mengirimkan tugas melalui formulir upload yang disediakan di halaman depan aplikasi.</li>
                    <li><strong>Guru:</strong> Mengakses halaman admin untuk merekap dan mengelola tugas siswa yang telah dikirimkan.</li>
                </ul>
                <p class="card-text"><strong>Catatan:</strong> Hanya guru yang memiliki akses ke bagian admin aplikasi. Pengguna lain tidak dapat mengakses tanpa izin dari pemilik web.</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function updateTime() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds} WIB`;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
