<?php
echo "selam";
@session_start();
@ob_start();
define("DATA", "data/");
define("SAYFA", "include/");
define("SINIF", "class/");
include_once(DATA . "baglanti.php");
define("SITE", $site_url);
if(!empty($_SESSION["ID"]) && !empty($_SESSION["adsoyad"]) && !empty($_SESSION["mail"]))
{
  ?>
    <meta http-equiv="refresh" content="0,url=<?=SITE?>">
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
  <link rel="stylesheet" href="<?= $site_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= $site_url ?>dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?= SITE ?>"><b>
          <?= $site_baslik ?>
        </b></a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Lütfen oturum açın</p>
        <?php
        if($_POST)
        {
          if(!empty($_POST["kullanici"]) && !empty($_POST["sifre"]))
          {
            $kullanici=$VT->filter($_POST["kullanici"]);
            $sifre=md5($VT->filter($_POST["sifre"]));
            $kontrol=$VT->VeriGetir("kullanicilar","WHERE kullanici=? AND sifre=?",array($kullanici,$sifre),"ORDER BY ID ASC",1);
            if($kontrol!=false)
            {
              $_SESSION["kullanici"]=$kontrol[0]["kullanici"];
              $_SESSION["adsoyad"]=$kontrol[0]["adsoyad"];
              $_SESSION["mail"]=$kontrol[0]["mail"];
              $_SESSION["ID"]=$kontrol[0]["ID"];
              ?>
              <meta http-equiv="refresh" content="0;url=<?=SITE?>" />
              <?php
              exit();

            }
            else
            {
              echo '<div class="alert alert-danger">Kullanıcı adı eya şifre hatalıdır</div>';
            }

          }
          else
          {
            echo '<div class="alert alert-danger">Boş bıraktığınız alanları doldurunuz.</div>';

          }
        }
        ?>
        <form action="#" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="kullanici" placeholder="Kullanıcı Adı">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="sifre" placeholder="Şifre">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Giriş</button>
            </div>
          </div>
        </form>
        <p class="mb-1">
          <a href="sifremi-unuttum.php">Şifremi Unuttum</a>
        </p>
      </div>
    </div>
  </div>
  <script src="<?= $site_url ?>plugins/jquery/jquery.min.js"></script>
  <script src="<?= $site_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= $site_url ?>dist/js/adminlte.min.js"></script>
</body>

</html>