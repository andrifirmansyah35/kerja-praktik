<?php
// $id_provinsi_terpilih = $_POST['id_provinsi'];
$curl = curl_init();

// curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=5",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "key: c0d77cc9a939254ca895bbf942582041"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  // echo $response; //masih dalam bentuk json 

  $array_response = json_decode($response, TRUE);
  $datadistrik = $array_response['rajaongkir']['results'];

  // echo "<pre>";
  // print_r($array_response['rajaongkir']['results']);
  // echo "</pre>";

  echo "<option value=''>---Pilih Kota Anda---</option>";

  foreach ($datadistrik as $distrik) {
    echo "<option value='$distrik[city_name]'
    id_distrik='" . $distrik['city_id'] . "'
    nama_provinsi='" . $distrik['province'] . "'
    nama_distrik='" . $distrik['city_name'] . "'
    kode_pos='" . $distrik['postal_code'] . "'>";
    echo $distrik['type'] . "-";
    echo $distrik['city_name'];
    echo "</option>";
  }
}
