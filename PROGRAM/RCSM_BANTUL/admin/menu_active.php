<?php

$menu_provinsi_active = "";
$menu_kategori_active = "";
$menu_produk_active = "";
if (isset($_GET['page'])) {
    if ($_GET['page'] == "provinsi") {
        $menu_provinsi_active = "active";
    } else if ($_GET['page'] == "kategori") {
        $menu_kategori_active = "active";
    } else if ($_GET['page'] == "produk") {
        $menu_produk_active = "active";
    }
}
