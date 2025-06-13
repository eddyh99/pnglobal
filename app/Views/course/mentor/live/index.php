<style>
  #duration::-webkit-datetime-edit-ampm-field {
    display: none;
  }
</style>
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

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">

        <div class="row content-body">
            <div class="col-lg-12">
                <h2 class="text-center">Live</h2>
                <div style="margin-bottom: 4rem;">
                    <h4 class="mb-3">Create Live Schedule</h4>
                    <div class="mx-4">
                        <form action="/">
                        <div class="row">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Title</b></span>
                            </div>
                            <div class="col">
                                <input type="text" name="title" class="form-control-custom border-primary text-white" value="Title of course">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Mentor</b></span>
                            </div>
                            <div class="col">
                                <select class="form-control-custom" name="mentor_id">
                                    <option value="" class="text-center" <?= old('mentor_id') === '' ? 'selected' : '' ?>>--- Select mentor ---</option>
                                    <?php foreach ($mentor as $m): ?>
                                        <option value="<?= $m->id ?>" <?= old('mentor_id') == $m->id ? 'selected' : '' ?>>
                                            <?= $m->name ?? '-' ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Start Date</b></span>
                            </div>
                            <div class="col">
                                <input type="date" name="start_date" class="form-control-custom border-primary text-white" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>TIme</b></span>
                            </div>
                            <div class="col">
                                <input type="time" name="time" class="form-control-custom border-primary text-white" value="12:00">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Duration</b></span>
                            </div>
                            <div class="col">
                                <input id="duration" type="time" name="duration" class="form-control-custom border-primary text-white" value="01:00" step="60">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Save to</b></span>
                            </div>
                            <div class="col">
                                <select class="form-control-custom border-primary text-white" name="course_id" id="">
                                    <option value="">Course 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 invisible" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Save to</b></span>
                            </div>
                            <div class="col">
                                <small style="color: #B48B3D;">"Save to" is the location where recorded live videos are stored.</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mx-4">
                        <button type="submit" class="btn btn-primary text-uppercase"><b>Save Schedule</b></button>
                    </div>
                    </form>
                </div>
                <hr style="border: 2px solid #B48B3D;">
            </div>

            <div class="col-lg-12 dash-table-referralmember mt-5">
                <div class="mt-2">
                    <table id="tbl_live" class="table table-striped" style="width:100%">
                        <thead class="thead_freemember">
                            <tr>
                                <th>NO</th>
                                <th>TITLE</th>
                                <th>DATE</th>
                                <th>MENTOR</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>