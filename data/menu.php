<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= SITE ?>" class="brand-link elevation-4">
    <img src="dist/img/AdminLTELogo.png" alt="<?= $site_baslik ?>" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">
      <?= $site_baslik ?>
    </span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">
          <?= $_SESSION["adsoyad"] ?>
        </a>
      </div>
    </div>

    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Ara">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Projeler
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $site_url ?>proje-ekle" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Yeni Proje</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $site_url ?>proje-listesi" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Proje Listesi</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Tanımlamalar
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= $site_url ?>stok-kartlari" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Stok Kartları</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Ayarlar
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="<?= $site_url ?>ayarlar" class="nav-link">
                <i class="fas fa-cog nav-icon"></i>
                <p>Portal Ayarları</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>