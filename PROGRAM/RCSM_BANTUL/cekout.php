<?php
session_start();
include "admin/function.php";

if (isset($_POST['cekout'])) {
  $id_pelangan = $_SESSION['id_pelangan'];
  if (cekout_cekStockKeranjang($id_pelangan) == "ada barang keranjang tidak tersedia") {
    echo "<script>
              alert('Barang Yang Anda beli ada yang tidak Tersedia')
              alert('Anda Dapat Menghapus barang dikeranjang anda')
              window.location.replace('keranjang_belanja.php');
              </script>";
  } else {
    $dataKeranjang = keranjang($_SESSION['id_pelangan']);
    // $dataOngkir = ongkir_pelangan();
  }
} else {
  header("Location: keranjang_belanja.php");
}

$total_berat = 0;

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <title>RCSM Bantul</title>
  <link rel="stylesheet" href="asset/style/navbar.css">
  <link rel="stylesheet" href="asset/style/keranjang.css">
</head>

<body class="bg-light">
  <?php include 'menu.php'; ?>

  <div class="spasi-menu" style="height: 100px;"></div>
  <!-- <?php //var_dump($dataKeranjang); 
        ?> -->


  <form action="cekout_tambah.php" method="POST">
    <div class="container">
      <div class="row mt-5 ml-2">
        <h3 style="color:rgb(235, 78, 104); font-weight: 500">Cek Out Belanja</h3>
      </div>



      <div class="row ml-2">
        <p class="text-danger font-weight-light">*mengisi data pemesanan</p>
      </div>

      <div class="row mt-3">
        <div class="col-md-8">
          <div class="card bg-white rounded-0">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-house-user mr-2"></i>Akan Dikirim Kemana?</h5>
              <p class="card-text" style="margin-top: 10px;">Andri Firmansyah - 089632311271</p>
              <p class="font-weight-light" style="margin-top: -10px;">ahsyandri@gmail.com</p>

              <div class="form-group">

              </div>

              <!-- <div class="form-group">
                <label>Distrik</label>
                <select class="form-control" name="nama_distrik">
                  <option value="">Pilih Distrik</option>
                  <option value="">provinsi belum dipilih</option>
                </select>
              </div> -->


              <div class="form-group">
                <label>Kota</label>
                <select class="form-control" name="nama_kota" required>
                  <option value="">Loading data kota...</option>
                </select>
              </div>

              <div class="form-group">
                <label>Pengiriman</label>
                <select class="form-control" name="nama_ekspedisi" required>
                  <option value="">Pilih Ekspedisi pengiriman</option>
                </select>
              </div>

              <div class="form-group">
                <label>Paket</label>
                <select name="nama_paket" class="form-control" required>

                </select>
              </div>

              <div class="form-group">
                <label>Berat paket</label>
                <input type="number" name="berat" class="form-control" disabled>
              </div>

              <div class="form-group">
                <label class="text-secondary">Alamat Lengkap</label>
                <textarea class="form-control" rows="3" required placeholder="Jalan-RT-RW-Kota-Kabupaten-Provinsi" name="alamat_pengiriman"></textarea>
                <small class="text-info">*pastikan bahwa anda mengirimkan alamat anda secara lengkap dan juga sesuaikan dengan pilihan biaya pengiriman sesuai alamat anda</small>
              </div>
            </div>
          </div>

          <div class="card bg-white rounded-0 mt-4">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-shopping-cart mr-2 mb-2"></i>Pesanan</h5>
              <!-- <p class="card-text" style="margin-top: 10px;">Tanggal : 29-09-2021</p> -->
              <div class="table-responsive">
                <table class="table align-middle">
                  <thead>
                    <?php $total_harga_semua_barang = 0; ?>
                    <?php foreach ($dataKeranjang as $barang) :  ?>
                      <tr class="pt-2">
                        <td scope="col" class="align-middle pt-3"><img src="admin/gambar/<?= $barang['gambar']; ?>" alt="" width="100px"></td>
                        <td scope="col" class="align-middle"><?= $barang['nama']; ?></td>
                        <?php
                        // mendapatkan total berat -----------------------------------------
                        $total_berat += ($barang['jumlah_barang'] * $barang['berat']);
                        ?>
                        <td scope="col" class="align-middle"><?= $barang['jumlah_barang']; ?> pcs</td>
                        <td scope="col" class="align-middle">
                          <?php $total_harga = $barang['harga'] * $barang['jumlah_barang']; ?>
                          <h5 class="">RP <?= $total_harga; ?></h5>
                          <?php $total_harga_semua_barang += $total_harga; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <tr>
                      <td scope="col" colspan="3" class="align-middle">
                        <p style="font-weight: 900;">Total Berat : </p>
                      </td>
                      <td scope="col">
                        <input type="hidden" value="<?= $total_berat; ?>" id="total-berat" name="berat_pesanan">
                        <p style="font-weight: 900;"><span id="total_berat" totalBerat="<?= $total_berat; ?>"><?= $total_berat; ?></span> gram</p>
                      </td>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card bg-danger rounded-0">
            <div class="card-body">
              <h5 class="card-title text-white"><i class="fas fa-money-bill-wave mr-2 text-white"></i>Rincian Harga</h5>
              <hr style="background-color: white;">

              <ul class="list-group">
                <li class="d-flex justify-content-between align-items-center">
                  <p class="text-white">Total Harga</p>
                  <span>
                    <p class="text-white" style="font-size: 15px;">Rp <span id="total_harga" totalHarga="<?= $total_harga_semua_barang; ?>"><?= $total_harga_semua_barang; ?></span></p>
                  </span>
                </li>
                <li class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
                  <p class="text-white">Ongkos Kirim</p>
                  <span>
                    <p class="text-white" style="font-size: 15px;">Rp <span id="vOngkosKirim">-</span></p>
                  </span>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                  <h5 class="text-white">Total Pembayaran</h5>
                  <span>
                    <h5 class="text-white">Rp <span id="vTotalPembayaran">-</span></h5>
                  </span>
                </li>
                <input type="hidden" name="biaya_pengiriman" value="" id="input-biaya-pengiriman">
                <input type="hidden" name="total_pembayaran" value="" id="input-total-pembayaran">
                <button class="btn btn-light width-100 mt-2 font-weight-bold text-danger">Cek Out</button>
                <a href="keranjang_belanja.php" class=" w-100 mt-2 btn btn-outline-danger text-white">Batal</a>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>


  <!-- <script src=" https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/50cc75fb6a.js" crossorigin="anonymous"></script>
  <!-- <script src="jquery/jquery.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script>
    // const v_ongkosKirim = document.querySelector('#vOngkosKirim')
    // const v_totalHarga = document.querySelector('#vTotalPembayaran')
    // const select_ongkir = document.querySelector('#select_ongkir')
    // const total_harga_string = document.querySelector('#total_harga').getAttribute('totalHarga')
    // const total_harga = parseInt(total_harga_string)
    // console.log("Total Harga : " + total_harga)
    // const total_berat_string = document.querySelector('#total_berat').getAttribute('totalBerat')
    // const total_berat = parseInt(total_berat_string)
    // console.log("Total Berat : " + total_berat)
    // const input_biaya_pengiriman = document.getElementById("input-biaya-pengiriman")
    // const input_total_pembayaran = document.getElementById("input-total-pembayaran")



    // // Event ------------------------------------------------------------------------
    // document.getElementById("select_ongkir").onchange = function() {
    //   const harga_ongkir = this.options[this.selectedIndex].getAttribute("dataHarga")
    //   const nilai_harga_ongkir = (harga_ongkir != null) ? parseInt(harga_ongkir) : parseInt(0)

    //   v_ongkosKirim.innerText = (harga_ongkir != null) ? harga_ongkir : "-"
    //   v_totalHarga.innerText = "-"

    //   if (nilai_harga_ongkir != 0 || null) {
    //     const total_ongkir = biaya_pengiriman(total_berat, nilai_harga_ongkir)
    //     const total_pembayaran = total_harga + total_ongkir

    //     v_ongkosKirim.innerText = total_ongkir
    //     input_biaya_pengiriman.value = total_ongkir
    //     v_totalHarga.innerText = total_pembayaran
    //     input_total_pembayaran.value = total_pembayaran
    //   }
    // };


    // // Function Global ---------------------------------------------------------------
    // function biaya_pengiriman(total_berat, ongkir) {
    //   let biaya = 0;
    //   if (total_berat < 1000) {
    //     biaya = ongkir
    //   } else {
    //     biaya = (Math.round(total_berat) / 1000) * ongkir;
    //   }
    //   return Math.round(biaya);
    // }


    $(document).ready(function() {

      var totalBerat = $('#total_berat').attr("totalBerat")
      $("input[name=berat]").val(totalBerat)
      // console.log(totalBerat)

      $.ajax({
        type: 'get',
        url: './API_pengiriman/api_kabupaten_kota.php',
        success: function(hasil_kota) {
          // console.log(hasil_ekspedisi)
          $("select[name=nama_kota]").html(hasil_kota)
        }
      });

      $("select[name=nama_kota]").on("change", function() {
        $('#vOngkosKirim').text('-')
        $('#vTotalPembayaran').text('-')
      })

      $.ajax({
        type: 'post',
        url: './API_pengiriman/api_pengiriman.php',
        success: function(hasil_ekspedisi) {
          // console.log(hasil_ekspedisi)
          $("select[name=nama_ekspedisi]").html(hasil_ekspedisi)
        }
      });


      $("select[name=nama_ekspedisi]").on("change", function() {
        $('#vOngkosKirim').text('-')
        $('#vTotalPembayaran').text('-')
        // MENENTUKAN PAKET :
        //1. MENDAPATKAN EKPEDISI TERPILIH -------------------------------
        var ekspedisi_terpilih = $("select[name=nama_ekspedisi]").val();
        console.log("ekspedisi: " + ekspedisi_terpilih)
        //2. MENDAPATKAN distrik TERPILIH -------------------------------
        var distrik_terpilih = $("option:selected", "select[name=nama_kota]").attr("id_distrik");
        console.log("distrik|kota: " + distrik_terpilih)
        //3. input berat -------------------------------------------------
        var berat_paket = $("input[name=berat]").val()
        $.ajax({
          type: 'post',
          url: 'API_pengiriman/api_paket.php',
          data: `ekspedisi=${ekspedisi_terpilih}&&distrik=${distrik_terpilih}&&berat=${berat_paket}`,
          success: function(hasil_paket) {
            // console.log(hasil_paket)
            $("select[name=nama_paket]").html(hasil_paket)
          }
        })
      })


      $("select[name=nama_paket]").on("change", function() {
        var harga_paket_terpilih = parseInt($("option:selected", "select[name=nama_paket]").attr("ongkir"));
        var total_harga = parseInt($('#total_harga').attr('totalHarga'));
        let total_pembayaran = "-";

        if (harga_paket_terpilih != '') {
          total_pembayaran = harga_paket_terpilih + total_harga;
          $('#vOngkosKirim').text(harga_paket_terpilih)
          $('#vTotalPembayaran').text(total_pembayaran)
          $('#input-biaya-pengiriman').val(harga_paket_terpilih)
          $("#input-total-pembayaran").val(total_pembayaran)
        } else {
          total_pembayaran = "-";
        }
        // console.log('-----------------------------------------');
        // console.log(`harga paket      : ${harga_paket_terpilih}`)
        // console.log(`total_harga      : ${total_harga}`)
        // console.log(`total pembayaran : ${total_pembayaran}`)
      })
    })
  </script>
</body>

</html>