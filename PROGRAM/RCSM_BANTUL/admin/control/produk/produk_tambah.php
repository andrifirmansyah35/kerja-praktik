<?php
// 1.Get Data Kategori
$datakategori = kategori("SELECT * FROM kategori");

// 2. Tambah Produk 
if (isset($_POST['submit'])) {
    if (produk_tambah($_POST) > 0) {
        echo "
                <script>
                    alert('Data Berhasil Ditambahkan');
                    document.location.href = 'index.php?page=produk';
                </script>
            ";
    } else {
        echo mysqli_error($conn);
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <h1>Tambah Produk</h1>
            </div>
            <div class="row>">
                <div class="col-md-12">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" placeholder="Masukkan Nama Produk" required name="nama">
                        </div>
                        <div class="form-group">
                            <label>Kategori Produk</label>
                            <select class="form-control" required name="kategori">
                                <option>-Masukan Kategori Produk-</option>
                                <?php foreach ($datakategori as $kategori) : ?>
                                    <option value="<?= $kategori['id']; ?>"><?= $kategori['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga Beli</label>
                            <input type="number" class="form-control" placeholder="Masukkan harga Beli Produk" required name="harga_beli">
                        </div>
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" class="form-control" placeholder="Masukkan harga Jual Produk" required name="harga">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan deksripsi produk" name="deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" class="form-control" placeholder="Masukkan Stock" min="0" required name="stok">
                        </div>
                        <div class="form-group">
                            <label>Berat(gram)</label>
                            <input type="number" class="form-control" placeholder="Masukkan Stock" min="15" required name="berat">
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <div class="letak-input" style="margin-bottom: 10px;">
                                <input type="file" class="form-control" name="gambar">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" name="submit">Tambah Produk</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>