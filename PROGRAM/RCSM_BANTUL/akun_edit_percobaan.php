<?php
include "admin/function.php";
$word = "andri firmansyahputra";
echo "<h1>" . $word . "</h1>";

echo "<br>";

// cek string
if (preg_match("/[^A-Za-z]/", $word)) {
  echo "<h1>Invalid Characters!";
}

// $query_cari_email = query_result_array("SELECT * FROM pelangan WHERE email = 'ahsyandri@gmail.com'");
// $jumlah_email = count($query_cari_email);
// echo "<h1>jumlah email : " . $jumlah_email . "</h1>";
// // $cek_data_email = "kosong";
// // if () {
// //     // $cek_data_email = "ada";
// //     // return "Email Sudah Terdaftar";
// // }