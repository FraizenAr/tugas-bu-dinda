<?php
include 'koneksi.php';

// Inisialisasi variabel untuk form
$id_barang   = "";
$nama_barang = "";
$harga       = "";
$stok        = "";
$is_edit     = false;
$pesan       = "";

// ==========================================
// 1. PROSES TAMBAH DATA (INSERT)
// ==========================================
if (isset($_POST['simpan'])) {
    $id_barang   = trim($_POST['id_barang']);
    $nama_barang = trim($_POST['nama_barang']);
    $harga       = (int)$_POST['harga'];
    $stok        = (int)$_POST['stok'];

    // Cek apakah ID Barang sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM barang_jualan WHERE id_barang = '$id_barang'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "<div class='alert error'>Gagal: ID Barang <b>$id_barang</b> sudah terdaftar! Gunakan ID lain.</div>";
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO barang_jualan (id_barang, nama_barang, harga, stok) VALUES ('$id_barang', '$nama_barang', '$harga', '$stok')");
        if ($query) {
            header("Location: barang.php?msg=sukses_tambah");
            exit;
        } else {
            $pesan = "<div class='alert error'>Gagal menambah data: " . mysqli_error($koneksi) . "</div>";
        }
    }
}

// ==========================================
// 2. AMBIL DATA UNTUK DIEDIT (SELECT BY ID)
// ==========================================
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $ambil = mysqli_query($koneksi, "SELECT * FROM barang_jualan WHERE id_barang = '$id'");
    $data_edit = mysqli_fetch_array($ambil);

    if ($data_edit) {
        $id_barang   = $data_edit['id_barang'];
        $nama_barang = $data_edit['nama_barang'];
        $harga       = $data_edit['harga'];
        $stok        = $data_edit['stok'];
        $is_edit     = true; // Mengaktifkan mode edit
    }
}

// ==========================================
// 3. PROSES SIMPAN PERUBAHAN (UPDATE)
// ==========================================
if (isset($_POST['update'])) {
    $id_barang   = trim($_POST['id_barang']);
    $nama_barang = trim($_POST['nama_barang']);
    $harga       = (int)$_POST['harga'];
    $stok        = (int)$_POST['stok'];

    $query = mysqli_query($koneksi, "UPDATE barang_jualan SET nama_barang='$nama_barang', harga='$harga', stok='$stok' WHERE id_barang='$id_barang'");
    if ($query) {
        header("Location: barang.php?msg=sukses_update");
        exit;
    } else {
        $pesan = "<div class='alert error'>Gagal mengubah data: " . mysqli_error($koneksi) . "</div>";
    }
}

// ==========================================
// 4. PROSES HAPUS DATA (DELETE - BONUS)
// ==========================================
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM barang_jualan WHERE id_barang = '$id_hapus'");
    header("Location: barang.php?msg=sukses_hapus");
    exit;
}

// Cek notifikasi dari URL (?msg=...)
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'sukses_tambah') {
        $pesan = "<div class='alert success'>Data barang baru berhasil ditambahkan!</div>";
    } elseif ($_GET['msg'] == 'sukses_update') {
        $pesan = "<div class='alert success'>Data barang berhasil diperbarui!</div>";
    } elseif ($_GET['msg'] == 'sukses_hapus') {
        $pesan = "<div class='alert success'>Data barang berhasil dihapus!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang - Latihan PHP</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styling tambahan khusus form dan notifikasi */
        .form-card {
            background-color: #ffffff;
            border: 1px solid #dce4ec;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        .alert {
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-primary {
            background-color: #3182ce;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #2b6cb0;
        }
        .btn-success {
            background-color: #38a169;
            color: #ffffff;
        }
        .btn-success:hover {
            background-color: #2f855a;
        }
        .btn-cancel {
            background-color: #e2e8f0;
            color: #4a5568;
            margin-left: 8px;
        }
        .btn-cancel:hover {
            background-color: #cbd5e0;
        }
        .action-link {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 4px;
        }
        .action-edit {
            background-color: #ebf8ff;
            color: #3182ce;
            border: 1px solid #bee3f8;
        }
        .action-edit:hover {
            background-color: #3182ce;
            color: #ffffff;
        }
        .action-delete {
            background-color: #fff5f5;
            color: #e53e3e;
            border: 1px solid #fed7d7;
        }
        .action-delete:hover {
            background-color: #e53e3e;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Menampilkan pesan notifikasi jika ada -->
        <?php echo $pesan; ?>

        <!-- ============================================== -->
        <!-- FORM INPUT / UBAH DATA                        -->
        <!-- ============================================== -->
        <div class="form-card">
            <h2><?php echo $is_edit ? "✏️ Ubah Data Barang (" . htmlspecialchars($id_barang) . ")" : "➕ Tambah Barang Baru"; ?></h2>
            <form action="barang.php" method="POST">
                <div class="form-grid">
                    <div class="input-group">
                        <label>ID Barang:</label>
                        <!-- Jika sedang edit, ID barang dibuat readonly agar tidak bentrok -->
                        <input type="text" name="id_barang" value="<?php echo htmlspecialchars($id_barang); ?>" placeholder="Contoh: B006" <?php echo $is_edit ? "readonly style='background:#edf2f7; cursor:not-allowed;'" : "required"; ?>>
                    </div>
                    <div class="input-group">
                        <label>Nama Barang:</label>
                        <input type="text" name="nama_barang" value="<?php echo htmlspecialchars($nama_barang); ?>" placeholder="Nama barang" required>
                    </div>
                    <div class="input-group">
                        <label>Harga (Rp):</label>
                        <input type="number" name="harga" value="<?php echo htmlspecialchars($harga); ?>" placeholder="0" required>
                    </div>
                    <div class="input-group">
                        <label>Stok:</label>
                        <input type="number" name="stok" value="<?php echo htmlspecialchars($stok); ?>" placeholder="0" required>
                    </div>
                </div>

                <div>
                    <?php if ($is_edit): ?>
                        <button type="submit" name="update" class="btn btn-success">💾 Simpan Perubahan</button>
                        <a href="barang.php" class="btn btn-cancel">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="simpan" class="btn btn-primary">+ Simpan Barang</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- ============================================== -->
        <!-- TABEL DAFTAR BARANG                            -->
        <!-- ============================================== -->
        <h2>Daftar Barang</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th style="width: 140px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM barang_jualan ORDER BY id_barang ASC");
                
                if (mysqli_num_rows($data) == 0) {
                    echo "<tr><td colspan='6' style='text-align:center; color:#888;'>Belum ada data barang.</td></tr>";
                }

                while ($tampilkan = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><b><?php echo htmlspecialchars($tampilkan['id_barang']); ?></b></td>
                    <td><?php echo htmlspecialchars($tampilkan['nama_barang']); ?></td>
                    <td>Rp <?php echo number_format($tampilkan['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($tampilkan['stok']); ?></td>
                    <td style="text-align: center;">
                        <!-- Link untuk Edit data (mengirimkan ?edit=ID) -->
                        <a href="barang.php?edit=<?php echo urlencode($tampilkan['id_barang']); ?>" class="action-link action-edit">Edit</a>
                        <!-- Link untuk Hapus data (mengirimkan ?hapus=ID) -->
                        <a href="barang.php?hapus=<?php echo urlencode($tampilkan['id_barang']); ?>" class="action-link action-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus barang <?php echo htmlspecialchars($tampilkan['nama_barang']); ?>?')">Hapus</a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>