<?php
if (isset($_GET['id'])) {
    if (!getByIDProduk($_GET['id'])) {
        echo "
        <script>
        alert('Data Produk Tidak Ada');
        document.location.href='index.php?page=produk';
        </script>
        ";
    } else {
        $data = getByIDProduk($_GET['id']);
        if (produk_hapus($data) > 0) {
            echo " <script>
            alert('Data Berhasil Dihapus');
            document.location.href = 'index.php?page=produk';
            </script>
        ";
        } else {
            echo "
            <script>
            alert('Data Gagal Dihapus');
            </script>
        ";
        }
    }
}
