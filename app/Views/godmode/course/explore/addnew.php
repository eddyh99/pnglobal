<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .form-row {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    
    .form-label-fixed {
      width: 150px;
      margin-bottom: 0;
    }

  .form-custom {
    background-color: #2a2212;
    color: #d4af37;
    font-weight: 600;
    padding: 5px 10px;
    border: 2px solid #d4af37;
    border-radius: 5px;
    font-size: 0.9rem;
    display: inline-block;
    margin-bottom: 15px;
    width: 200px;
  }

  .form-control-custom {
    background-color: transparent;
    border: 2px solid #d4af37;
    color: white;
    border-radius: 5px;
    padding: 12px;
    width: 100%;
    font-size: 1rem;
  }

  .form-control-custom:focus {
    outline: none;
    box-shadow: none;
    border-color: #ffd700;
  }

  .thumbnail-wrapper {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    align-items: center;
  }

  .video-thumb,
  .plus-box {
    width: 180px;
    height: 100px;
    border: 2px solid #d4af37;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background-color: #1a1a1a;
  }

  .video-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .plus-box {
    font-size: 2rem;
    color: #d4af37;
    cursor: pointer;
  }

  .label-thumb-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 15px;
  }

  .label-thumb-row .form-custom {
    margin-right: 20px;
  }

  .save-btn {
    background-color: #d4af37;
    border: none;
    color: black;
    padding: 10px 40px;
    font-weight: 600;
    border-radius: 5px;
    margin-top: 30px;
  }
</style>

<div class="content-page mb-5">
  <div class="container-fluid">
    <div class="row content-body">
      <div class="col-12">

        <h2 class="text-center text-white mb-4">Explore</h2>

        <div class="form-row mb-4">
          <label class="form-custom form-label-fixed">Title</label>
          <input type="text" class="form-control-custom" placeholder="Title of course">
        </div>

        <div class="mb-4">
          <label class="form-custom">Mentor</label>
          <input type="text" class="form-control-custom" placeholder="Super Man">
        </div>

        <div class="mb-4">
          <label class="form-custom">Description</label>
          <textarea class="form-control-custom" rows="4" placeholder="Course Description..."></textarea>
        </div>

        <div class="mb-4">
          <label class="form-custom">Cover</label>
          <div class="video-thumb mt-2">
            <img src="https://via.placeholder.com/180x100" alt="cover">
          </div>
        </div>

        <div class="mb-4">
          <div class="label-thumb-row">
            <label class="form-custom">Video</label>
            <div class="thumbnail-wrapper">
              <div class="video-thumb">
                <img src="https://i.ytimg.com/vi/92-r05H6l_U/mqdefault.jpg" alt="Video Thumbnail">
              </div>
              <div class="plus-box">
                <i class="bi bi-plus-lg"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="text-center">
          <button type="button" class="save-btn">SAVE</button>
        </div>
      </div>
    </div>
  </div>
</div>        
