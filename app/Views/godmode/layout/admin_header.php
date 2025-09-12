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
  <!-- Datatables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/style/css/admin/custom.css?<?php echo time() ?>">
  <!-- Summer Note -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs4.min.css" rel="stylesheet">
  <style>
    .menu-link.active {
      background-color: #B48B3D;
      /* Bootstrap primary color */
      color: #000;
    }
  </style>
</head>
<nav class="custom-navbar navbar navbar-dark">
  <div class="container-fluid d-flex justify-content-between align-items-center px-3">
    <!-- Mobile hamburger menu (left corner) -->
    <button class="navbar-toggler d-md-none" type="button" id="sidebarToggleBtn">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="tab-navigation d-none d-md-flex gap-2 mw-100">
      <a translate="no" href="<?= BASE_URL ?>godmode/signal" class="tab-item <?= $navbar_console ?? '' ?>">CONSOLE</a>
      <a translate="no" href="<?= BASE_URL ?>godmode/dashboard/hedgefund" class="tab-item <?= $navbar_hedgefund ?? '' ?>">HEDGE FUND</a>
      <!-- <a translate="no" href="<?= BASE_URL ?>godmode/onetoone/dashboard" class="tab-item <?= $navbar_onetoone ?? '' ?>">ONE TO ONE OLD</a> -->
      <a translate="no" href="<?= BASE_URL ?>godmode/dashboard/luxbtc" class="tab-item  <?= $navbar_luxbtc ?? '' ?>">ONE TO ONE</a>
      <!-- <a translate="no" href="<?= BASE_URL ?>godmode/dashboard/satoshi" class="tab-item <?= $navbar_satoshi ?? '' ?>">SATOSHI</a> -->
      <!-- <a translate="no" href="<?= BASE_URL ?>godmode/dashboard/course" class="tab-item <?= $navbar_course ?? '' ?>">COURSE</a> -->
    </div>

    <!-- Mobile hamburger menu (right corner) -->
    <button class="navbar-toggler d-md-none" type="button" id="menuToggleBtn" style="margin-left: auto;">
      <span class="navbar-toggler-icon"></span>
    </button>

  </div>
  <!-- Slide-in mobile menu -->
  <div id="mobileMenu" class="mobile-slide-menu">
    <a href="<?= BASE_URL ?>godmode/signal" class="menu-link <?= $navbar_console ?? '' ?>">CONSOLE</a>
    <a href="<?= BASE_URL ?>godmode/dashboard/hedgefund" class="menu-link <?= $navbar_hedgefund ?? '' ?>">HEDGE FUND</a>
    <!-- <a href="#">ONE TO ONE</a> -->
    <a href="<?= BASE_URL ?>godmode/dashboard/luxbtc" class="menu-link <?= $navbar_luxbtc ?? '' ?>">ONE TO ONE</a>
    <!-- <a href="<?= BASE_URL ?>godmode/dashboard/satoshi" class="menu-link <?= $navbar_satoshi ?? '' ?>">SATOSHI</a> -->
    <!-- <a href="<?= BASE_URL ?>godmode/dashboard/course" class="menu-link <?= $navbar_course ?? '' ?>">COURSE</a> -->
  </div>
</nav>

<body style="background-color: #070707;">
  <!-- Wrapper Start -->
  <div class="wrapper">