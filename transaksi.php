<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi - Latihan PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Transaksi</h2>
        <div style="margin-bottom: 15px;">
            
        </div>
         <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>ID Barang</th>
                    <th>qty</th>
                    <th>Harga total</th>
                    <th>nip</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'koneksi.php';
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM transaksi");
                while ($tampilkan = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $tampilkan['id_transaksi']; ?></td>
                    <td><?php echo $tampilkan['id_barang']; ?></td>
                    <td><?php echo $tampilkan['qty']; ?></td>
                    <td> <?php echo number_format($tampilkan['harga_total']); ?></td>
                    <td><?php echo $tampilkan['nip']; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
         </table>
    </div>

</body>
</html>