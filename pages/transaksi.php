<?php
require_once __DIR__ . "/../koneksi.php";

$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
$barang    = mysqli_query($conn, "SELECT * FROM barang");
?>

<style>
.card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    max-width: 1000px;
}
.card h3 {
    margin-bottom: 20px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}
.form-group {
    margin-bottom: 15px;
}
label {
    font-weight: bold;
    display: block;
    margin-bottom: 6px;
}
select, input {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}
th {
    background: #f5f5f5;
}
.btn {
    padding: 10px 16px;
    border-radius: 5px;
    text-decoration: none;
    color: white;
    border: none;
    cursor: pointer;
}
.btn-simpan {
    background: #27ae60;
}
.btn-simpan:hover {
    background: #219150;
}
</style>

<div class="card">
<h3>Transaksi Penjualan</h3>

<form method="post" action="pages/proses_transaksi.php">

<div class="form-group">
<label>Pelanggan</label>
<select name="id_pelanggan" required>
    <option value="">-- Pilih Pelanggan --</option>
    <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
        <option value="<?= $p['id_pelanggan']; ?>">
            <?= $p['nama_pelanggan']; ?>
        </option>
    <?php } ?>
</select>
</div>

<table>
<tr>
    <th>Barang</th>
    <th>Harga</th>
    <th>Qty</th>
</tr>
<tr>
    <td>
        <select name="id_barang[]" required>
            <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                <option value="<?= $b['id_barang']; ?>">
                    <?= $b['nama_barang']; ?> (Stok: <?= $b['stok']; ?>)
                </option>
            <?php } ?>
        </select>
    </td>
    <td>
        <input type="number" name="harga[]" placeholder="Harga" required>
    </td>
    <td>
        <input type="number" name="qty[]" min="1" required>
    </td>
</tr>
</table>

<br>
<button type="submit" name="simpan" class="btn btn-simpan">
💾 Simpan Transaksi
</button>

</form>
</div>