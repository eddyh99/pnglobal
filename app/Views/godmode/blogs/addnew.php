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

        <h2 class="text-center text-white mb-4">New Posts</h2>
        <form action="<?= BASE_URL ?>godmode/blogs/save_post" method="POST" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="form-custom form-label-fixed">Link</label>
            <div class="col-10">
              <input type="text" name="link" class="form-control-custom" placeholder="https://example.com" value="<?= old('link') ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="form-custom form-label-fixed">Title</label>
            <div class="col-10">
              <input type="text" name="title" class="form-control-custom" placeholder="Title of post" value="<?= old('title') ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="form-custom form-label-fixed">Content</label>
            <div class="col-10">
              <textarea id="content" name="content" class="form-control-custom" rows="10" placeholder="Content..."><?= old('content') ?></textarea>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="save-btn">Save Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="summerModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Insert Your Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="file" id="customImageInput" accept="image/*" />
      </div>
      <div class="modal-footer">
        <button type="button" id="insertCustomImage" class="btn btn-primary">Insert</button>
      </div>
    </div>
  </div>
</div>
