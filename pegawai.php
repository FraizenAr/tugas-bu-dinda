<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai - Latihan PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Daftar Pegawai</h1>
        <div style="margin-bottom: 15px;">
            
        </div>
         <table>
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Username</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'koneksi.php';
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM pegawai");
                while ($tampil = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td><?php echo $tampil['nip']; ?></td>
                    <td><?php echo $tampil['nama']; ?></td>
                    <td><?php echo $tampil['alamat']; ?></td>
                    <td><?php echo $tampil['username']; ?></td>
                    <td><?php echo $tampil['password']; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
         </table>
    </div>

</body>
</html>