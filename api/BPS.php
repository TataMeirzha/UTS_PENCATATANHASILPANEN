<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$url = "https://webapi.bps.go.id/v1/api/list/model/data/lang/ind/domain/0000/var/2310/th/126/key/963fdf21a693d5cd78ed231fcc7055df/";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$response = curl_exec($ch);
$error    = curl_error($ch);
curl_close($ch);

if ($response === false || $response === '') {
    echo json_encode([
        "status" => "fallback",
        "komoditas" => ["Padi", "Jagung", "Kedelai", "Cabai", "Bawang Merah", "Bawang Putih", "Kentang", "Tomat", "Ubi Kayu", "Ubi Jalar"]
    ]);
    exit;
}

$data = json_decode($response, true);

$komoditas_list = [];

if (isset($data['data'][1]) && is_array($data['data'][1])) {
    foreach ($data['data'][1] as $row) {
        $nama = '';
        if (isset($row['turvar']))  $nama = $row['turvar'];
        elseif (isset($row['label'])) $nama = $row['label'];

        if ($nama && !in_array($nama, $komoditas_list)) {
            $komoditas_list[] = $nama;
        }
    }
}

if (empty($komoditas_list)) {
    $komoditas_list = ["Padi", "Jagung", "Kedelai", "Cabai", "Bawang Merah", "Bawang Putih", "Kentang", "Tomat", "Ubi Kayu", "Ubi Jalar"];
    echo json_encode(["status" => "fallback", "komoditas" => $komoditas_list]);
} else {
    echo json_encode(["status" => "ok", "komoditas" => $komoditas_list]);
}
?>