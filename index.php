<?php
@session_start();
@ob_start();
define("DATA", "data/");
define("SAYFA", "include/");
define("SINIF", "class/");
include_once(DATA . "baglanti.php");
define("SITE", $site_url);
if(!empty($_SESSION["ID"]) && !empty($_SESSION["adsoyad"]) && !empty($_SESSION["mail"]))
{

}
else
{
  ?>
    <meta http-equiv="refresh" content="0,url=<?=SITE?>giris-yap">
  <?php
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?= $site_baslik ?>
  </title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= $site_url ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= $site_url ?>dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed">
  <div class="wrapper">

    <?php
    include_once(DATA . "header.php");
    include_once(DATA . "menu.php");

    if ($_GET && !empty($_GET["sayfa"])) {
      $sayfa = $_GET["sayfa"] . ".php";
      if (file_exists(SAYFA . $sayfa)) {
        include_once(SAYFA . $sayfa);
      } else {
        include_once(SAYFA . "home.php");
      }
    } else {
      include_once(SAYFA . "home.php");
    }

    include_once(DATA . "footer.php");
    ?>
  </div>
  <script src="<?= $site_url ?>plugins/jquery/jquery.min.js"></script>
  <script src="<?= $site_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= $site_url ?>dist/js/adminlte.min.js"></script>
  <script src="<?= $site_url ?>dist/js/demo.js"></script>
</body>

</html>