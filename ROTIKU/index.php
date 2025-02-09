<?php
include('db.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Rotiku</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Script untuk Timer Logout
        let timer;

        function startTimer() {
            timer = setTimeout(() => {
                const userResponse = confirm("Apakah Anda masih ingin melanjutkan ini?");
                if (userResponse) {
                    startTimer();
                } else {
                    window.location.href = 'logout.php';
                }
            }, 3000000); // 1 menit
        }
        window.onload = startTimer;
    </script>
    <style>
        /* Style untuk tombol dark mode */
        .dark-mode-toggle {
            background-color: #444;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        .dark-mode-toggle:hover {
            background-color: #333;
        }

        /* Dark mode styles */
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        .navbar.dark-mode {
            background-color: #1e1e1e;
        }

        .nav-item a.dark-mode {
            color: #e0e0e0;
        }

        .card.dark-mode {
            background-color: #2a2a2a;
            color: #e0e0e0;
            border-color: #444;
        }

        a.dark-mode {
            background-color: #555;
            color: #fff;
        }

        a.dark-mode:hover {
            background-color: #666;
        }

        /* Style for header icon positioning */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Align content to the left */
            background-color: #333;
            padding: 10px;
        }

        .navbar .logo {
            margin-right: auto; /* Push other elements to the right */
        }

        .navbar img.img-logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .navbar .nav-item a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
        }

        /* Warna coklat untuk teks dalam card */
    .card h3,
    .card p {
        color: #8B4513; /* Warna coklat */
    }

    /* Warna coklat untuk teks h1 */
    h1 {
        color: #8B4513; /* Warna coklat */
    }
    </style>
    <script>
        // Script untuk mengatur Dark Mode
        document.addEventListener("DOMContentLoaded", function () {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;

            // Cek apakah dark mode aktif sebelumnya
            const isDarkMode = localStorage.getItem('darkMode') === 'enabled';
            if (isDarkMode) {
                body.classList.add('dark-mode');
                darkModeToggle.textContent = '☀️ Mode Terang';
            }

            // Event listener untuk toggle dark mode
            darkModeToggle.addEventListener('click', () => {
                if (body.classList.contains('dark-mode')) {
                    body.classList.remove('dark-mode');
                    localStorage.setItem('darkMode', 'disabled');
                    darkModeToggle.textContent = '🌙 Mode Gelap';
                } else {
                    body.classList.add('dark-mode');
                    localStorage.setItem('darkMode', 'enabled');
                    darkModeToggle.textContent = '☀️ Mode Terang';
                }
            });
        });
    </script>
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <ul class="navbar-nav mr-auto">
                <a href="#" class="nav-item logo">
                    <img src="gambar/bg.png" class="img-logo" alt="Toko Rotiku">
                </a>
                <li class="nav-item">
                    <a href="#home" class="text-decoration-none">Home</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="text-dsecoration-none">Logout</a>
                </li>
            </ul>
            <!-- Tombol Dark Mode -->
            <button id="darkModeToggle" class="dark-mode-toggle">🌙 Mode Gelap</button>
        </nav>
    </header>

    <!-- HOME -->
    <section class="home" id="home">
        <div class="row">
            <div class="image">
                <img src="home-img-1.png" class="main-home-image" alt="">
            </div>
        </div>

        <div class="image-slider">
            <img src="image/home-img-1.png" alt="">
            <img src="image/home-img-2.png" alt="">
            <img src="image/home-img-3.png" alt="">
        </div>
    </section>

    <center>
        <h1>Data Produk</h1>
    </center>
    <div class="tambah">
        <center><a href="tambah.php">Tambah Produk</a></center>
    </div>

    <center>
        <form action="" method="GET">
            <input type="text" name="query" placeholder="Cari produk...">
            <button type="submit">Cari</button>
        </form>
    </center>

    <br />

    <div class="container">
        <?php
        // Cek apakah ada query pencarian
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $query = $_GET['query'];
            // Jalankan query untuk mencari produk berdasarkan nama
            $sql = "SELECT * FROM produk WHERE nama_produk LIKE '%$query%' ORDER BY id ASC";
        } else {
            // Jalankan query untuk menampilkan semua data
            $sql = "SELECT * FROM produk ORDER BY id ASC";
        }

        $result = mysqli_query($koneksi, $sql);
        // Mengecek apakah ada error ketika menjalankan query
        if (!$result) {
            die("Query Error: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
        }

        // Buat perulangan untuk element card dari data produk
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="card">
                <h3><?php echo $row['nama_produk']; ?></h3>
                <div class="card-image">
                    <img src="gambar/<?php echo $row['gambar_produk']; ?>" alt="<?php echo $row['nama_produk']; ?>">
                </div>
                <p><?php echo substr($row['deskripsi'], 0, 50); ?>...</p>
                <p>Harga Beli: Rp <?php echo number_format($row['harga_beli'], 0, ',', '.'); ?></p>
                <p>Harga Jual: Rp <?php echo number_format($row['harga_jual'], 0, ',', '.'); ?></p>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="hapus.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Anda yakin akan menghapus data ini?')">Hapus</a>
            </div>
        <?php
        }
        ?>
    </div>
    <center><a href="cetak.php">Cetak Laporan</a></center>
    <center>
        <?php
        $video_id = "O19GfkK9Gwk?si=l1tnmaEb1fr6UaxM"; // Ganti dengan ID video yang diinginkan
        ?>
        <h1>Video Cara Membuat Roti</h1>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allowfullscreen></iframe>
    </center>

</body>

</html>
