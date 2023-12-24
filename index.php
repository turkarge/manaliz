<?php
@session_start();
@ob_start();
define("DATA", "data/");
define("SAYFA", "include/");
define("SINIF", "class/");
include_once("class/FL.php");
include_once("class/DB.php");
include_once("class/User.php");
$settings = DB::table("settings")->where("ID", 1)->first();
define("SITE", $settings->url);
define("TITLE", $settings->title);
define("VER", $settings->ver);
//include_once(DATA . "baglanti.php");
//define("SITE", $site_url);
if (!empty($_SESSION["ID"]) && !empty($_SESSION["adsoyad"]) && !empty($_SESSION["mail"])) {

} else {
  ?>
  <meta http-equiv="refresh" content="0,url=<?= SITE ?>giris-yap">
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
    <?= TITLE ?>
  </title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= SITE ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= SITE ?>dist/css/adminlte.min.css">
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
        include_once(SAYFA . "404.php");
      }
    } else {
      include_once(SAYFA . "home.php");
    }

    include_once(DATA . "footer.php");
    ?>
  </div>
  <script src="<?= SITE ?>plugins/jquery/jquery.min.js"></script>
  <script src="<?= SITE ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= SITE ?>dist/js/adminlte.min.js"></script>
</body>

</html>