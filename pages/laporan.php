<?php
require_once __DIR__ . "/../koneksi.php";

$mulai   = $_GET['mulai'] ?? '';
$sampai = $_GET['sampai'] ?? '';

$where = "";
if ($mulai && $sampai) {
    $where = "WHERE DATE(tanggal) BETWEEN '$mulai' AND '$sampai'";
}

$query = mysqli_query($conn, "
    SELECT t.*, p.nama_pelanggan
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    $where
    ORDER BY t.tanggal DESC
");

$total_pendapatan = 0;
?>

<style>
.card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,.1);
}
.filter {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}
.filter input, .filter button {
    padding: 8px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}
th {
    background: #f5f5f5;
}
.total {
    font-weight: bold;
    background: #ecf0f1;
}
.btn {
    padding: 8px 12px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
}
.btn-filter {
    background: #3498db;
}
</style>

<div class="card">
<h3>Laporan Penjualan</h3>

<form method="get" class="filter">
    <input type="hidden" name="page" value="laporan">
    <input type="date" name="mulai" value="<?= $mulai ?>">
    <input type="date" name="sampai" value="<?= $sampai ?>">
    <button class="btn btn-filter">Filter</button>
</form>

<table>
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Kode</th>
    <th>Pelanggan</th>
    <th>Total</th>
</tr>

<?php $no=1; while($row = mysqli_fetch_assoc($query)) {
    $total_pendapatan += $row['total'];
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
    <td><?= $row['kode_transaksi'] ?></td>
    <td><?= $row['nama_pelanggan'] ?></td>
    <td>Rp <?= number_format($row['total'],0,',','.') ?></td>
</tr>
<?php } ?>

<tr class="total">
    <td colspan="4">TOTAL PENDAPATAN</td>
    <td>Rp <?= number_format($total_pendapatan,0,',','.') ?></td>
</tr>
</table>
</div>
