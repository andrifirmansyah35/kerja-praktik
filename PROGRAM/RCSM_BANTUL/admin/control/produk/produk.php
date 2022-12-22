<?php
$produks = produk();
error_reporting(0);

// Aksi Tambah Produk --------------------------\
if (isset($_POST['produk_stok_tambah'])) {

    // var_dump($_POST);
    produk_stok_tambah($_POST);

    $produks = produk();
}
//  Tambah produk end ----------------------------

?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">

                <!-- Modal  Tambah Stok-->
                <?php foreach ($produks as $produk) : ?>
                    <div class="modal fade" id="produk_id<?= $produk['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Stok <strong><?= $produk['nama']; ?></strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label>Harga beli(sekarang)</label>
                                            <input name="harga_beli_lama" type="number" class="form-control" value="<?= $produk['harga_beli']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga jual(sekarang)</label>
                                            <input name="harga_jual_lama" type="number" class="form-control" value="<?= $produk['harga']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Jumlah Produk(sekarang)</label>
                                            <input name="stock_lama" type="number" class="form-control" value="<?= $produk['stok']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>harga beli stok tambahan</label>
                                            <input name="harga_beli_stock_tambah" type="number" class="form-control" min="9000" required>
                                        </div>
                                        <div class="form-group">
                                            <label>harga jual stok tambahan</label>
                                            <input name="harga_jual_stock_tambah" type="number" class="form-control" min="9000" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Jumlah stock tambahkan</label>
                                            <input name="stock_tambah" type="number" class="form-control" min="1" max="100" required>
                                            <input name="id_produk" type="hidden" value="<?= $produk['id']; ?>">
                                        </div>

                                </div>
                                <div class=" modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">kembali</button>
                                    <button name="produk_stok_tambah" type="submit" class="btn btn-primary">Tambahkan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h1>Daftar Produk</h1>
                </div>
            </div>
            <div class="row">
                <div class="card-body">
                    <a href="index.php?page=produktambah" class="btn btn-primary">
                        Tambah Produk
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>harga(beli)</th>
                                                <th>harga(jual)</th>
                                                <!-- <th>gambar</th> -->
                                                <th>stok</th>
                                                <!-- <th>berat(gram)</th> -->
                                                <th>aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $nmr = 1; ?>
                                            <?php foreach ($produks as $produk) : ?>
                                                <tr>
                                                    <td><?= $nmr; ?></td>
                                                    <td><?= $produk['nama']; ?></td>
                                                    <td><?= query_result("SELECT * FROM kategori WHERE id = $produk[id_kategori]")['nama']; ?></td>
                                                    <td><?= $produk['harga_beli']; ?></td>
                                                    <td><?= $produk['harga']; ?></td>
                                                    <!-- <td></?= $produk['gambar']; ?></td> -->
                                                    <td><?= $produk['stok']; ?></td>
                                                    <!-- <td></?= $produk['berat']; ?></td> -->
                                                    <td>
                                                        <button type="button" class="badge badge-primary" data-toggle="modal" data-target="#produk_id<?= $produk['id']; ?>">
                                                            Tambah Stok
                                                        </button>
                                                        <a href="index.php?page=produkdetail&id=<?= $produk['id']; ?>" class="badge badge-success">Detail</a>
                                                        <a href="index.php?page=produkubah&id=<?= $produk['id']; ?>" class="badge badge-warning">ubah</a>
                                                        <a href="index.php?page=produkhapus&id=<?= $produk['id']; ?>" class="badge badge-danger" onclick=" return confirm('yakin');">hapus</a>
                                                    </td>
                                                </tr>
                                                <?php $nmr++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.card-body -->
                            </div><!-- /.card -->
                        </div>
                    </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>