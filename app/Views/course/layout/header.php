<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?></title>
  <!-- Favicon -->
  <link href="<?= BASE_URL ?>assets/img/logo.png" rel="icon">
  <link href="<?= BASE_URL ?>assets/img/logo.png" rel="apple-touch-icon">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/css/admin/mandatory/bootstrap.min.css">
  <!-- Typography CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/css/admin/mandatory/typography.css">
  <!-- Style CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/css/admin/mandatory/style.css">
  <!-- Responsive CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/css/admin/mandatory/responsive.css">
  <!-- Summer Note -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <!-- Datatables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/css/admin/custom.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<style>
  .nav-link.active {
    font-weight: bold;
    background-color: #B48B3D;
    border-radius: 4px;
  }

  .table-bordered {
    border: 3px solid #B48B3D;
    /* Mengatur warna border menjadi biru dan menebalkan */
    border-collapse: collapse;
  }

  .table-bordered td,
  .table-bordered th {
    border: 3px solid #B48B3D;
    /* Menebalkan border pada sel dan mengubah warnanya */
    padding: 10px;
  }

  .table-bordered td {
    border-left: none;
    /* Menghilangkan garis kiri pada setiap sel */
    border-right: none;
    /* Menghilangkan garis kanan pada setiap sel */
  }

  .table-bordered td:nth-child(2) {
    border-right: none;
    /* Menghilangkan garis kanan pada kolom kedua */
  }

  .table-bordered td:first-child {
    border-left: 3px solid #B48B3D;
    /* Menambahkan border kiri pada kolom pertama */
  }

  .table-bordered td:last-child {
    border-right: 3px solid #B48B3D;
    /* Menambahkan border kanan pada kolom terakhir */
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark px-3 <?= $liveroom ?? '' ?>">
  <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>course/member">
    <img src="<?= BASE_URL ?>assets/img/logo.png" class="logo-sidebar-admin mr-3" alt="Logo">
    <span>Online Course</span>
  </a>

  <div class="collapse navbar-collapse justify-content-end">
    <ul class="navbar-nav mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link text-white <?= $active_live ?? '' ?>" href="<?= BASE_URL ?>course/member/live">LIVE</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= $active_explore ?? '' ?>" href="<?= BASE_URL ?>course/member/explore">Explore</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= $active_learning ?? '' ?>" href="<?= BASE_URL ?>course/member/mycourse">My Learning</a>
      </li>
    </ul>
  </div>

  <div class="d-flex align-items-center gap-3">
    <a href="<?= BASE_URL ?>course/message/inbox" class="nav-link"><i class="bi bi-envelope <?= $active_message ?? 'text-white' ?>" style="font-size: 1.5rem;"></i></a>
    <div class="dropdown">
      <a href="#" class="nav-link dropdown-toggle" id="profileMenu" data-bs-toggle="dropdown">
        <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="profileMenu">
        <!-- <li><a class="dropdown-item text-white" href="#profile">Profile</a></li>
        <li><a class="dropdown-item text-white" href="#settings">Settings</a></li> -->
        <li><a class="dropdown-item text-white" href="<?= BASE_URL ?>course/auth/logout">Logout</a></li>
      </ul>
    </div>

  </div>

</nav>
<hr class="m-0 <?= $liveroom ?? '' ?>" style="border: 1px solid #c79a3a;">

<body style="background-color: #070707;">
  <!-- Wrapper Start -->
  <div class="wrapper">