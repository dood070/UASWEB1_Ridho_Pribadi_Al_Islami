<?php
$host = "localhost";
$username ="root";
$password ="";
$dbname ="db_penjualan";

$conn = new mysqli($host, $username,$password,$dbname);

if($conn->connect_error){
    die("koneksi gagal: ". $conn->connect_error);
}
