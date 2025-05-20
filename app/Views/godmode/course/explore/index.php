<?php if (!empty(session('success'))) { ?>
  <div class="alert alert-success fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
    <div class="iq-alert-icon">
      <i class="ri-information-line"></i>
    </div>
    <div class="iq-alert-text text-black">
      <?= session('success') ?>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <i class="ri-close-line text-black"></i>
    </button>
  </div>
<?php } ?>
<div class="content-page mb-5">
  <div class="container-fluid">
    <div class="row content-body">
      <div class="col-12">
        
          <div class="section-title">Explore</div>

          <!-- Add New -->
          <a class="add-card" href="<?=BASE_URL . $url ?>explore/addnew">
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="60"><path fill="#FFFFFF" d="M416 208H272V64c0-17.7-14.3-32-32-32h-32c-17.7 0-32 14.3-32 32v144H32c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32h144v144c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V304h144c17.7 0 32-14.3 32-32v-32c0-17.7-14.3-32-32-32z"/></svg><br>
              Add new
            </div>
          </a>
          
          <hr class="hr-primary mb-4">
          <div id="course-content">
          </div>
            <h4 id="noCourseText" class="text-center">Loading courses..</h4>

          <!-- Course Card 1 -->
          <!-- <div class="course-wrapper">
            <div class="course-number">2</div>
            <div class="course-card">
              <img src="https://via.placeholder.com/180x100?text=Course+Thumbnail" alt="Course Thumbnail" class="course-img" />
              <div class="course-content">
                <h5>This is the title of the online course at pn global</h5>
                <p class="text-secondary fw-bold">MENTOR NAME</p>
                <p class="text-secondary" style="font-size: 0.9rem;">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry...
                </p>
              </div>
              <div class="edit-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="32"><path fill="#FFFFFF" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1 .8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"/></svg>
              </div>
            </div>
          </div> -->

      </div>
    </div>
  </div>
</div>