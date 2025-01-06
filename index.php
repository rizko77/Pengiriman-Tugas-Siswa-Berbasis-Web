<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Uploader Beta</title>
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

        .drop-zone {
            max-width: 100%;
            padding: 25px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            color: #ccc;
            font-size: 1.2em;
            background-color: #495057; /* Background warna gelap */
        }

        .drop-zone.dragover {
            background-color: #e9ecef;
            border-color: #333;
            color: #333;
        }

        .drop-zone__prompt {
            margin: 0;
        }

        .drop-zone input[type="file"] {
            display: none;
        }

        .drop-zone__thumb {
            margin-top: 10px;
            font-size: 1em;
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
                        <a class="nav-link" href="about.php">Tentang</a>
                    </li>
                    
                    <!--li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li-->
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/rizko77/" target="_blank">GitHub</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" id="currentTime">HH:MM:DD WIB</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header bg-secondary text-white">
                Form Upload Tugas Siswa
            </div>
            <div class="card-body">
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_siswa">Nama Siswa *</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas *</label>
                        <select class="form-control" id="kelas" name="kelas" required>
                            <option>-- Pilih Kelas --</option>
                            <option value="1">Edit Kelas Di Code Pada File index.html</option>
                            <option value="2">Edit Kelas Di Code Pada File index.html</option>
                            <option value="3">Edit Kelas Di Code Pada File index.html</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_tugas">File Tugas *</label>
                        <div class="drop-zone">
                            <span class="drop-zone__prompt">Pilih File Disini... (Max 9MB)</span>
                            <input type="file" name="file_tugas" id="file_tugas" required>
                            <div class="drop-zone__thumb"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info">Kirim Tugas</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.querySelectorAll(".drop-zone__prompt, .drop-zone").forEach((element) => {
            element.addEventListener("click", (event) => {
                element.closest(".drop-zone").querySelector("input[type='file']").click();
            });
        });

        document.querySelectorAll(".drop-zone input[type='file']").forEach((inputElement) => {
            inputElement.addEventListener("change", (event) => {
                if (inputElement.files.length) {
                    updateThumbnail(inputElement.closest(".drop-zone"), inputElement.files[0]);
                }
            });
        });

        document.querySelectorAll(".drop-zone").forEach((dropZoneElement) => {
            dropZoneElement.addEventListener("dragover", (event) => {
                event.preventDefault();
                dropZoneElement.classList.add("dragover");
            });

            ["dragleave", "dragend"].forEach((type) => {
                dropZoneElement.addEventListener(type, (event) => {
                    dropZoneElement.classList.remove("dragover");
                });
            });

            dropZoneElement.addEventListener("drop", (event) => {
                event.preventDefault();
                if (event.dataTransfer.files.length) {
                    dropZoneElement.querySelector("input[type='file']").files = event.dataTransfer.files;
                    updateThumbnail(dropZoneElement, event.dataTransfer.files[0]);
                }
                dropZoneElement.classList.remove("dragover");
            });
        });

        function updateThumbnail(dropZoneElement, file) {
            let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

            if (dropZoneElement.querySelector(".drop-zone__prompt")) {
                dropZoneElement.querySelector(".drop-zone__prompt").remove();
            }

            if (!thumbnailElement) {
                thumbnailElement = document.createElement("div");
                thumbnailElement.classList.add("drop-zone__thumb");
                dropZoneElement.appendChild(thumbnailElement);
            }

            thumbnailElement.dataset.label = file.name;
            thumbnailElement.textContent = file.name;
        }

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
