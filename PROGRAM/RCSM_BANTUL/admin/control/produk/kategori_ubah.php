<?php
if (isset($_GET['id'])) {
    $id_kategori = $_GET['id'];
    $kategori = query_result("SELECT * FROM kategori WHERE id = $id_kategori");
} else if ($_GET['id'] == null) {
    header("Location: index.php?page=kategori");
} else {
    header("Location: index.php?page=kategori");
}

if (isset($_POST['submit'])) {
    if (kategori_ubah($_POST) > 0) {
        echo " <script>
        document.location.href = 'index.php?page=kategori';
        </script>
    ";
    } else {
        echo "
        <script>
        document.location.href = 'index.php?page=kategori';
        </script>
    ";
    }
}

?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <?php if ($kategori != 0) : ?>
                <div class="row mb-4">
                    <h1>Ubah Kategori</h1>
                </div>
                <div class="row>">
                    <div class="col-md-6">

                        <form method="POST">
                            <input type="hidden" value="<?= $_GET['id']; ?>" name="id">
                            <div class="form-group">
                                <input type="text" class="form-control" value="<?= $kategori['nama']; ?>" name="nama">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>

                    </div>
                </div>
            <?php else : ?>
                <div class="row">
                    <div class="alert alert-warning text-center" role="alert">
                        <p class="my-3 ">Data Yang dicari Tidak Ditemukan</p>
                        <a class="btn btn-default" href="index.php?page=kategori">Kembali</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>