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

<?php if (!empty(session('failed'))) { ?>
  <div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
    <div class="iq-alert-icon">
      <i class="ri-information-line"></i>
    </div>
    <div class="iq-alert-text text-black">
      <?= session('failed') ?>
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

        <h2 class="text-center text-white mb-4">Explore</h2>
        <form action="<?= BASE_URL ?>godmode/course/explore/store" method="POST" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="form-custom form-label-fixed">Title</label>
            <div class="col-10">
              <input type="text" name="title" class="form-control-custom" placeholder="Title of course" value="<?= old('title') ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="form-custom form-label-fixed">Mentor</label>
            <div class="col-10">
              <select class="form-control-custom" name="mentor_id">
                <option value="" class="text-center" <?= old('mentor_id') === '' ? 'selected' : '' ?>>--- Select mentor ---</option>
                <?php foreach ($mentor as $m): ?>
                  <option value="<?= $m->id ?>" <?= old('mentor_id') == $m->id ? 'selected' : '' ?>>
                    <?= $m->name ?? '-' ?>
                  </option>
                <?php endforeach ?>
              </select>

              <!-- <input type="text" name="" class="form-control-custom" placeholder="Super Man"> -->
            </div>
          </div>
          <div class="form-group row">
            <label class="form-custom form-label-fixed">Description</label>
            <div class="col-10">
              <textarea name="description" class="form-control-custom" rows="4" placeholder="Course Description..."><?= old('description') ?></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-custom form-label-fixed">Cover</label>
            <div class="col-10">
              <div class="mb-3">
                <input class="form-control-custom" name="cover" type="file" accept=".png,.jpg">
              </div>
              <!-- <div class="video-thumb">
                <img src="https://via.placeholder.com/180x100" alt="cover">
              </div> -->
            </div>
          </div>
          <div class="form-group row">
            <label class="form-custom form-label-fixed">Video</label>
            <div class="col-10">
              <div class="thumbnail-wrapper" id="thumbnailWrapper">
                <!-- <div class="video-thumb">
                <img src="https://via.placeholder.com/180x100" alt="cover">
              </div> -->
                <div class="plus-box" onclick="addVideoInput()">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="30">
                    <path fill="#FFFFFF" d="M416 208H272V64c0-17.7-14.3-32-32-32h-32c-17.7 
          0-32 14.3-32 32v144H32c-17.7 0-32 14.3-32 32v32c0 17.7 
          14.3 32 32 32h144v144c0 17.7 14.3 32 32 32h32c17.7 
          0 32-14.3 32-32V304h144c17.7 0 32-14.3 
          32-32v-32c0-17.7-14.3-32-32-32z" />
                  </svg><br>
                </div>
              </div>
              <div id="videoInputs"></div>
            </div>
          </div>
          <!-- <div class="form-group row">
            <label class="form-custom form-label-fixed">Video</label>
            <div class="col-10">
              <div class="thumbnail-wrapper">
                <div class="video-thumb">
                  <img src="https://i.ytimg.com/vi/92-r05H6l_U/mqdefault.jpg" alt="Video Thumbnail">
                </div>
                <div class="plus-box">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="30">
                    <path fill="#FFFFFF" d="M416 208H272V64c0-17.7-14.3-32-32-32h-32c-17.7 0-32 14.3-32 32v144H32c-17.7 0-32 14.3-32 32v32c0 17.7 14.3 32 32 32h144v144c0 17.7 14.3 32 32 32h32c17.7 0 32-14.3 32-32V304h144c17.7 0 32-14.3 32-32v-32c0-17.7-14.3-32-32-32z" />
                  </svg><br>
                </div>
              </div>
            </div>
          </div> -->

          <div class="text-center">
            <button type="submit" class="save-btn">SAVE</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  let videoCounter = 0;

  function addVideoInput() {
    const hiddenInputs = document.getElementById("videoInputs");
    const thumbnailWrapper = document.getElementById("thumbnailWrapper");

    const input = document.createElement("input");
    input.type = "file";
    input.accept = "video/*";
    input.style.display = "none";

    input.addEventListener("change", function() {
      const file = input.files[0];
      if (file) {
        const url = URL.createObjectURL(file);

        const wrapper = document.createElement("div");
        wrapper.style.display = "inline-block";
        wrapper.style.margin = "10px";
        wrapper.style.textAlign = "center";

        const video = document.createElement("video");
        video.src = url;
        video.controls = true;
        video.style.maxWidth = "200px";
        video.style.display = "block";

        const uploadBtn = document.createElement("button");
        uploadBtn.textContent = "Upload";
        uploadBtn.className = "btn btn-danger";
        uploadBtn.style.marginTop = "5px";
        uploadBtn.onclick = function() {
          uploadVideo(file, uploadBtn, deleteBtn, wrapper);
        };

        const deleteBtn = document.createElement("button");
        deleteBtn.textContent = "Hapus";
        deleteBtn.className = "btn btn-secondary";
        deleteBtn.style.marginTop = "5px";
        deleteBtn.style.marginLeft = "5px";
        deleteBtn.onclick = function() {
          wrapper.remove(); // Hapus semua elemen
        };

        wrapper.appendChild(video);
        wrapper.appendChild(uploadBtn);
        wrapper.appendChild(deleteBtn);

        const plusBox = thumbnailWrapper.querySelector(".plus-box");
        thumbnailWrapper.insertBefore(wrapper, plusBox);
      }
    });

    hiddenInputs.appendChild(input);
    input.click();
  }


  function uploadVideo(file, button, deleteButton, wrapper) {
    const formData = new FormData();
    formData.append("video", file);

    button.disabled = true;
    button.textContent = "Uploading...";
    deleteButton.disabled = true;

    fetch('<?= BASE_URL ?>godmode/course/explore/save_video', {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          button.textContent = "Uploaded ✅";
          button.classList.remove("btn-danger");
          button.classList.add("btn-success");
          deleteButton.disabled = false;
        } else {
          button.textContent = data.message || "Upload Gagal";
          button.disabled = false;
          deleteButton.disabled = false;
        }
      })
      .catch(err => {
        console.error(err);
        button.textContent = "Error Upload";
        button.disabled = false;
        deleteButton.disabled = false;
      });
  }
</script>