<?php
if (isset($_GET)) {
    if (kategori_hapus($_GET) > 0) {
        echo " <script>
        document.location.href = 'index.php?page=kategori'
        swal('Berhasil', 'Data berhasil Dihapus', 'success');
        </script>
    ";
    } else {
        echo "
        <script>
        swal('Gagal!, 'Data Gagal Dihapus', 'error');
        </script>
    ";
    }
}
