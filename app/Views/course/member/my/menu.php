<ul class="nav nav-pills nav-justified">
  <li class="nav-item">
    <a class="nav-link <?= $active_course ?? '' ?> text-white" aria-current="page" href="<?= BASE_URL ?>course/member/mycourse">Class Progress</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= $active_cert ?? '' ?> text-white" href="<?= BASE_URL ?>course/member/mycertificate">Certificate</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= $active_demo ?? '' ?> text-white" href="<?= BASE_URL ?>course/member/mydemo">Demo</a>
  </li>
</ul>
<hr class="m-0" style="border: 1px solid #B48B3D;">
