<?php
include_once(SINIF . "VT.php");
$VT = new VT();
$ayarlar = $VT->VeriGetir("ayarlar", "WHERE ID=?", array(1), "ORDER BY ID ASC", 1);
if ($ayarlar != false) {
    $site_baslik = $ayarlar[0]["site_baslik"];
    $site_versiyon = $ayarlar[0]["site_versiyon"];
    $site_url = $ayarlar[0]["site_url"];
    $site_durum = $ayarlar[0]["site_durum"];
}
?>