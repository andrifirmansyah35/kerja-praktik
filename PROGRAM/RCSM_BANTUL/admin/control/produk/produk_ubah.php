<?php

if (!isset($_GET['page']) || !isset($_GET['id']) || $_GET['page'] != 'produkubah') {
    echo "<script>
        document.location.href='index.php';
        </script>";
} else {
    $id_produk = $_GET['id'];
    $produk = query_result("SELECT * FROM produk WHERE id = $id_produk");
    $datakategori = kategori("SELECT * FROM kategori");
}

if (isset($_POST['ubah_produk'])) {
    if (produk_ubah($_POST)) {
        echo "<script>
        alert('Produk berhasil diubah')
        document.location.href = 'index.php?page=produk';
        </script>";
    } else {
        echo "<script>
        alert('GAGAL UBAH DATA PRODUK')
        document.location.href = 'index.php?page=produk';
        </script>";
    }
    // $id_produk = $_POST['id_produk'];
    // $produk = query_result("SELECT * FROM produk WHERE id = $id_produk");
}

?>
<div class="content-wrapper">
    <div class="content-header">
        <?php if ($produk) { ?>
            <div class="container-fluid">
                <div class="row mb-4">
                    <h1>Ubah Produk</h1>

                </div>
                <div class="row>">
                    <div class="col-md-12">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Produk" required name="nama" value="<?= $produk['nama']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Kategori Produk</label>
                                <select class="form-control" required name="kategori">
                                    <option>-Masukan Kategori Produk-</option>
                                    <?php foreach ($datakategori as $kategori) : ?>
                                        <option value="<?= $kategori['id']; ?>" <?= ($kategori['id'] == $produk['id_kategori']) ? "selected" : "" ?>> <?= $kategori['nama']; ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan deksripsi produk" name="deskripsi"><?= $produk['deskripsi']; ?></textarea>
                            </div>
                            <!-- <div class="form-group">
                                <label>Stok</label>
                                <input type="number" class="form-control" placeholder="Masukkan Stock" min="0" required name="stok" value="</?= $produk['stok']; ?>">
                            </div> -->
                            <div class="form-group">
                                <label>Berat(gram)</label>
                                <input type="number" class="form-control" placeholder="Masukkan Stock" min="10" max="2000" required name="berat" value="<?= $produk['berat']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Foto</label>
                                <br>
                                <img src="gambar/<?= $produk['gambar']; ?>" class="product-image" style="width: 200px;">
                                <div class="letak-input" style="margin-bottom: 10px;">
                                    <input type="file" class="form-control" name="gambar">
                                </div>
                            </div>
                            <input name="id_produk" type="hidden" value="<?= $produk['id']; ?>">
                            <input name="gambar_lama" type="hidden" value="<?= $produk['gambar']; ?>">
                            <button type="submit" class="btn btn-primary" name="ubah_produk">Ubah Produk</button>
                        </form>
                    </div>
                </div>

            </div>
        <?php } else { ?>
            <div class="container-fluid">
                <div class="row mb-4">
                    <h1 class="text-center">Data Tidak Ditemukan</h1>
                </div>
            <?php } ?>
            </div>
    </div>