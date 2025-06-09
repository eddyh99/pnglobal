<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title><?= $title?></title>
      <!-- Favicon -->
      <link href="<?= BASE_URL ?>assets/img/logo.png" rel="icon">
      <link href="<?= BASE_URL ?>assets/img/logo.png" rel="apple-touch-icon">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/mandatory/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/mandatory/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/mandatory/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/mandatory/responsive.css">
      <!-- Summer Note -->
      <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
      <!-- Datatables CSS -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
      <!-- Custom CSS -->
      <link rel="stylesheet" href="<?= BASE_URL?>assets/style/css/admin/custom.css">
   </head>
   <nav style="position: sticky; top: 0;z-index: 900;background-color: #070707;">
      <div class="d-flex justify-content-between mx-4">
      <div class="tab-navigation" style="width: 300px;">
      <a translate="no" href="<?= BASE_URL ?>godmode/signal" class="tab-item <?= $navbar_console ?? '' ?>">CONSOLE</a>
      </div>
      <div class="tab-navigation mw-100 mx-4">
            <a translate="no" href="<?= BASE_URL ?>godmode/dashboard/hedgefund" class="tab-item <?= $navbar_hedgefund ?? '' ?>">HEDGE FUND</a>
            <a translate="no" href="#" class="tab-item">ELITE BTC</a>
            <a translate="no" href="<?= BASE_URL ?>godmode/dashboard/luxbtc" class="tab-item  <?= $navbar_luxbtc ?? '' ?>">LUX BTC</a>
            <a translate="no" href="<?= BASE_URL ?>godmode/dashboard/satoshi" class="tab-item <?= $navbar_satoshi ?? '' ?>">SATOSHI</a>
            <a translate="no" href="<?= BASE_URL ?>godmode/dashboard/course" class="tab-item <?= $navbar_course ?? '' ?>">COURSE</a>
        </div>
      </div>
   </nav>

   <body style="background-color: #070707;">
        <!-- Wrapper Start -->
        <div class="wrapper">