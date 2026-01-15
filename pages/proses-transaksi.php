<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {

    $id_pelanggan = $_POST['id_pelanggan'];
    $tanggal = date('Y-m-d H:i:s');
    $kode = "TRX" . time();

    // 1. simpan transaksi
    mysqli_query($conn, "
        INSERT INTO transaksi (kode_transaksi, id_pelanggan, tanggal, total)
        VALUES ('$kode', '$id_pelanggan', '$tanggal', 0)
    ");

    $id_transaksi = mysqli_insert_id($conn);
    $total = 0;

    // 2. simpan detail
    foreach ($_POST['id_barang'] as $i => $id_barang) {

        $qty = $_POST['qty'][$i];

        $data = mysqli_query($conn, "SELECT harga, stok FROM barang WHERE id_barang='$id_barang'");
        $b = mysqli_fetch_assoc($data);

        if ($qty > $b['stok']) {
            die("Stok tidak cukup");
        }

        $subtotal = $b['harga'] * $qty;
        $total += $subtotal;

        mysqli_query($conn, "
            INSERT INTO transaksi_detail
            (id_transaksi, id_barang, harga, qty, subtotal)
            VALUES
            ('$id_transaksi', '$id_barang', '{$b['harga']}', '$qty', '$subtotal')
        ");

        // 3. kurangi stok
        mysqli_query($conn, "
            UPDATE barang SET stok = stok - $qty
            WHERE id_barang = '$id_barang'
        ");
    }

    // 4. update total
    mysqli_query($conn, "
        UPDATE transaksi SET total = '$total'
        WHERE id_transaksi = '$id_transaksi'
    ");

    header("Location: ../dashboard.php?page=transaksi");
    exit;
}